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

$uid = $user_id;
$project_name = (isset($_POST['project_name']) ?  $_POST['project_name'] : '');
$project_category = (isset($_POST['project_category']) ?  $_POST['project_category'] : '');
$client_type = (isset($_POST['client_type']) ?  $_POST['client_type'] : '');
$priority = (isset($_POST['priority']) ?  $_POST['priority'] : '');
$status = (isset($_POST['status']) ?  $_POST['status'] : '');
$reason = (isset($_POST['reason']) ?  $_POST['reason'] : '');


$query = "INSERT INTO project_main
                SET
                    catagory_id = :catagory_id,
                    client_type_id = :client_type_id,
                    priority_id = :priority_id,
                    project_status_id = :project_status_id,
                    project_name = :project_name,
                    close_reason = :close_reason,
                    create_id = :create_id,
                    created_at = now()";
    
        // prepare the query
        $stmt = $db->prepare($query);
    
        // sanitize
        $project_name=htmlspecialchars(strip_tags($project_name));
        $close_reason=htmlspecialchars(strip_tags($close_reason));
       
        // bind the values
        $stmt->bindParam(':catagory_id', $project_category);
        $stmt->bindParam(':client_type_id', $client_type);
        $stmt->bindParam(':priority_id', $priority);
        $stmt->bindParam(':project_status_id', $status);
        $stmt->bindParam(':project_name', $project_name);
        $stmt->bindParam(':close_reason', $close_reason);
        $stmt->bindParam(':create_id', $user_id);

        // execute the query, also check if query was successful
        try {
            // execute the query, also check if query was successful
            if ($stmt->execute()) {
                $last_id = $this->conn->lastInsertId();
            }
            else
            {
                $arr = $stmt->errorInfo();
                error_log($arr[2]);
            }
        }
        catch (Exception $e)
        {
            error_log($e->getMessage());
        }


        return $last_id;
