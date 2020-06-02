<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$jwt = (isset($_COOKIE['jwt']) ?  $_COOKIE['jwt'] : null);
include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

$method = $_SERVER['REQUEST_METHOD'];


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
          if(!$decoded->data->is_admin)
          {
            http_response_code(401);
     
            echo json_encode(array("message" => "Access denied."));
            die();
          }
      }
      // if decode fails, it means jwt is invalid
      catch (Exception $e){
      
          http_response_code(401);
     
        echo json_encode(array("message" => "Access denied."));
        die();
      }
}

      header('Access-Control-Allow-Origin: *');  

      include_once '../config/database.php';
      include_once '../objects/user.php';



      $database = new Database();
      $db = $database->getConnection();

      switch ($method) {
          case 'GET':
            $id = (isset($_GET['id']) ?  $_GET['id'] : "");
            $page = (isset($_GET['page']) ?  $_GET['page'] : "");
            $size = (isset($_GET['size']) ?  $_GET['size'] : "");
            $keyword = (isset($_GET['keyword']) ?  $_GET['keyword'] : "");

            $sql = "SELECT 0 as is_checked, user.id, username, email, user.status, COALESCE(is_admin, '0') is_admin, need_punch, COALESCE(department, '') department, apartment_id, title_id, COALESCE(title, '') title FROM user LEFT JOIN user_department ON user.apartment_id = user_department.id LEFT JOIN user_title ON user.title_id = user_title.id where user.status <> -1 ".($id ? " and id=$id" : '');

            if(!empty($_GET['page'])) {
                $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
                if(false === $page) {
                    $page = 1;
                }
            }

            $sql = $sql . " ORDER BY username ";

            if(!empty($_GET['size'])) {
                $size = filter_input(INPUT_GET, 'size', FILTER_VALIDATE_INT);
                if(false === $size) {
                    $size = 10;
                }

                $offset = ($page - 1) * $size;

                $sql = $sql . " LIMIT " . $offset . "," . $size;
            }

            $merged_results = array();

            $stmt = $db->prepare( $sql );
            $stmt->execute();


            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $merged_results[] = $row;
            }

            echo json_encode($merged_results, JSON_UNESCAPED_SLASHES);

            break;

        case 'POST':
            // get database connection
            $database = new Database();
            $db = $database->getConnection();
             
            // instantiate product object
            $user = new User($db);

            $username = stripslashes(isset($_POST["username"]) ? $_POST["username"] : "" );
            $email = stripslashes(isset($_POST["email"]) ? $_POST["email"] : "" );
            $password = stripslashes(isset($_POST["password"]) ? $_POST["password"] : "" );
            $status = stripslashes(isset($_POST["status"]) ? ($_POST["status"] == "1" ? 1 : 0)  : 0 );

            $is_admin = stripslashes(isset($_POST["is_admin"]) ? ($_POST["is_admin"] == "1" ? "1" : "") : "" );
            $need_punch = stripslashes(isset($_POST["need_punch"]) ? ($_POST["need_punch"] == "1" ? 1 : 0)  : 0);
            $apartment_id = stripslashes(isset($_POST["apartment_id"]) ? $_POST["apartment_id"] : "" );
            $title_id = stripslashes(isset($_POST["title_id"]) ? $_POST["title_id"] : "" );

            $crud = $_POST["crud"];
            $id = $_POST["id"];

            switch ($crud) 
            {
              case 'insert':
            /* Bind parameters. Types: s = string, i = integer, d = double,  b = blob */
                $user->username = $username;
                $user->email = $email;
                $user->password = $password;
                $user->status = $status;
                $user->is_admin = $is_admin;
                $user->title_id = $title_id;
                  $user->need_punch = $need_punch;
                  $user->apartment_id = $apartment_id;

                $user->create();

                break;

            case "update":
                $user->username = $username;
                $user->email = $email;
                    $user->status = $status;
                    $user->is_admin = $is_admin;
                $user->title_id = $title_id;
                $user->need_punch = $need_punch;
                $user->apartment_id = $apartment_id;
                    $user->id = $id;

                    $user->updateStatus();

                break;

            case 'del':
                $ids = explode(",", $id);
                foreach($ids as $item) {
                    $user->id = trim($item);
                    $user->delete();
                }

                $out['message'] = "Member Deleted Successfully";
                
                break;
            }

            break;
      }



?>