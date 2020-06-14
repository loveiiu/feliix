<?php
error_reporting(E_ERROR | E_PARSE);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$jwt = (isset($_COOKIE['jwt']) ?  $_COOKIE['jwt'] : null);
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
if ( !isset( $jwt ) ) {
    http_response_code(401);

    echo json_encode(array("message" => "Access denied."));
    die();
}
else
{
    try {
        // decode jwt
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        $user_id = $decoded->data->id;
    }
        // if decode fails, it means jwt is invalid
    catch (Exception $e){

        http_response_code(401);

        echo json_encode(array("message" => "Access denied."));
        die();
    }
}

include_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$is_manager = (isset($_POST['is_manager']) ?  $_POST['is_manager'] : '');

$timeStart = (isset($_POST['timeStart']) ?  $_POST['timeStart'] : '');
$amStart = (isset($_POST['amStart']) ?  $_POST['amStart'] : '');

$timeEnd = (isset($_POST['timeEnd']) ?  $_POST['timeEnd'] : '');
$amEnd = (isset($_POST['amEnd']) ?  $_POST['amEnd'] : '');

$merged_results = array();

if($timeStart == '' && $timeEnd == '')
{
    http_response_code(401);
    echo json_encode(array("message" => "Apply Date not valid."));
    die();
}

// leave credit!

$al_credit = 0;
$sl_credit = 0;

$query = "SELECT is_manager, annual_leave, sick_leave from user where id = " . $user_id ;

$stmt = $db->prepare( $query );
$stmt->execute();

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $al_credit = $row['annual_leave'];
    $sl_credit = $row['sick_leave'];
}


/* fetch data */
if($sdate2 != "")
    $query = "SELECT SUM(`leave`) le, leave_type, CASE  WHEN approval_id > 0 THEN 'A'  WHEN approval_id = 0 THEN 'P' END approval FROM apply_for_leave WHERE start_date > '" . $sdate1 . "' AND end_date < '" . $edate2 . "' and status = '' and uid = " . $user_id . " group by leave_type,  CASE WHEN approval_id > 0 THEN 'A'  WHEN approval_id = 0 THEN 'P' END";
else
    $query = "SELECT SUM(`leave`) le, leave_type, CASE  WHEN approval_id > 0 THEN 'A'  WHEN approval_id = 0 THEN 'P' END approval FROM apply_for_leave WHERE start_date > '" . $sdate1 . "' AND end_date < '" . $edate1 . "' and status = '' and uid = " . $user_id . " group by leave_type,  CASE WHEN approval_id > 0 THEN 'A'  WHEN approval_id = 0 THEN 'P' END";

$stmt = $db->prepare( $query );
$stmt->execute();



$al_taken = 0;
$al_approval = 0;

$sl_taken = 0;
$sl_approval = 0;

$pl_taken = 0;
$pl_approval = 0;

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $le = $row['le'];
    $leave_type = $row['leave_type'];
    $approval = $row['approval'];

    switch ($leave_type) {
        case "A":
            if($approval == 'A')
                $al_taken += $le;
            else
                $al_approval += $le;
            break;
        case "B":
            if($approval == 'A')
                $sl_taken += $le;
            else
                $sl_approval += $le;
            break;
        case "C":
            if($approval == 'A')
                $pl_taken += $le;
            else
                $pl_approval += $le;
            break;
    }
}

$merged_results[] = array(
    "al_credit" => $al_credit,
    "al_taken" => $al_taken,
    "al_approval" => $al_approval,

    "sl_credit" => $sl_credit,
    "sl_taken" => $sl_taken,
    "sl_approval" => $sl_approval,

    "pl_taken" => $pl_taken,
    "pl_approval" => $pl_approval,
);

echo json_encode($merged_results, JSON_UNESCAPED_SLASHES);