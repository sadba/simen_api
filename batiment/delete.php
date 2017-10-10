<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objects/batiment.php';

$database = new Database();
$db = $database->getConnection();

$batiment = new batiment($db);


$data = json_decode(file_get_contents("php://input"));

$batiment->id = $data->id;

if($batiment->delete()){
    $data = array(
      'code' => '1',
      'message' => 'Success'
  );

 echo json_encode($data);
}
else{
    echo '{';
        echo '"message": "Impossible de supprimer ce batiment"';
    echo '}';
}
?>
