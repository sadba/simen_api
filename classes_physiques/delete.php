<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../objects/classes_physiques.php';

$database = new Database();
$db = $database->getConnection();

$classes_physiques = new Classes_Physiques($db);



$data = json_decode(file_get_contents("php://input"));


$classes_physiques->id = $data->id;


if($classes_physiques->delete()){
   
   $data = array(
      'code' => '0',
      'message' => 'Success'
  );

 echo json_encode($data);
}
else{
    
    /*$data = array(
      'code' => '0',
      'message' => 'impossible de supprimer'
  );
    echo json_encode($data);*/
    return $classes_physiques->delete();
}

