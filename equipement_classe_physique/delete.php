<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objects/equipements_classes_physiques.php';

$database = new Database();
$db = $database->getConnection();

$equipements_classes_physiques = new Equipement_Classes_Physiques($db);


$data = json_decode(file_get_contents("php://input"));

$equipements_classes_physiques->id = $data->id;

if($equipements_classes_physiques->delete()){
    $data = array(
      'code' => '1',
      'message' => 'Success'
  );

 echo json_encode($data);
}
else{
    $data = array(
      'code' => '0',
      'message' => 'Unsuccessful'
  );
}
?>
