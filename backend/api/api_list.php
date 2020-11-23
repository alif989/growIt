<?php
include_once './config/conc.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$secret_key = "YOUR_SECRET_KEY";
$jwt = null;


// $sql = "SELECT * FROM curr_market";
// $result = $conn->query($sql);
// //  echo '<pre>';
// $row = $result->fetch_assoc();


$sql = "SELECT * FROM curr_market";
$result = $conn->query($sql);
$fArray = array();
if ($result->num_rows > 0) {

  // output data of each row
  while($row = $result->fetch_assoc()) {
    array_push($fArray, $row);;
  }
} else {
  echo "0 results";
}

// print_r($fArray );

//$data = json_decode(file_get_contents("php://input"));



//$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

//$arr = explode(" ", $authHeader);


/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/

//$jwt = $arr[1];

$jwt = $_POST['token'];

if($jwt){

    try {

        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        // Access is granted. Add code of the operation here 

        // $data = array(
        //     "html" => ""
        // );

        echo json_encode(array(
            "message" => "Access granted:",
            "error" => false,
            "data" => $fArray
        ));

    }catch (Exception $e){

    http_response_code(401);

    echo json_encode(array(
        "message" => "Access denied.",
        "error" => $e->getMessage()
    ));
    
}

}