<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$jwt = (isset($_COOKIE['jwt']) ?  $_COOKIE['jwt'] : null);
include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
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
          $user_id = $decoded->data->id;
          //if(!$decoded->data->is_admin)
          //{
          //  http_response_code(401);
     
          //  echo json_encode(array("message" => "Access denied."));
          //  die();
          //}
      }
      // if decode fails, it means jwt is invalid
      catch (Exception $e){
      
          http_response_code(401);
     
        echo json_encode(array("message" => "Access denied."));
        die();
      }
}

      header('Access-Control-Allow-Origin: *');  

      include_once 'config/database.php';


      $database = new Database();
      $db = $database->getConnection();

      switch ($method) {
          case 'GET':
            $stage_id = (isset($_GET['stage_id']) ?  $_GET['stage_id'] : 0);
            $page = (isset($_GET['page']) ?  $_GET['page'] : "");
            $size = (isset($_GET['size']) ?  $_GET['size'] : "");
            $type = (isset($_GET['type']) ?  $_GET['type'] : "");

            $sql = "SELECT pm.id, pm.type, pm.message, pm.option, u.username, pm.created_at FROM project_stage_client pm left join user u on u.id = pm.create_id  where stage_id = " . $stage_id . " and type = '" . $type . "' and pm.status <> -1 ";

            if(!empty($_GET['page'])) {
                $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
                if(false === $page) {
                    $page = 1;
                }
            }

            $sql = $sql . " ORDER BY pm.id ";

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
            $uid = $user_id;
            $stage_id = (isset($_POST['stage_id']) ?  $_POST['stage_id'] : 0);
            $type = (isset($_POST['type']) ?  $_POST['type'] : '');
            $message = (isset($_POST['message']) ?  $_POST['message'] : '');
            $option = (isset($_POST['option']) ?  $_POST['option'] : 0);

             
            $query = "INSERT INTO project_stage_client
                SET
                    `stage_id` = :stage_id,
                    `type` = :type,
                    `message` = :message,
                    `option` = :option,
                  
                    `create_id` = :create_id,
                    `created_at` = now()";
    
                // prepare the query
                $stmt = $db->prepare($query);
            
                // bind the values
                $stmt->bindParam(':stage_id', $stage_id);
                $stmt->bindParam(':type', $type);
                $stmt->bindParam(':message', $message);
                $stmt->bindParam(':option', $option);
      
                $stmt->bindParam(':create_id', $user_id);

                $last_id = 0;
                // execute the query, also check if query was successful
                try {
                    // execute the query, also check if query was successful
                    if ($stmt->execute()) {
                        $last_id = $db->lastInsertId();

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


                 $returnArray = array('batch_id' => $last_id);
                $jsonEncodedReturnArray = json_encode($returnArray, JSON_PRETTY_PRINT);

                echo $jsonEncodedReturnArray;
                
                break;

      }



?>
