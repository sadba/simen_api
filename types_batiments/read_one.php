<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/type_batiments.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$type_batiment = new Type_Batiment($db);

// set ID property of batiment to be edited
$type_batiment->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of batiment to be edited
$type_batiment->readOne();

// create array
$type_batiment_arr = array(
    "id_type_batiments" => $type_batiment->id_type_batiments,
    "libelle_type_batiments" => $type_batiment->libelle_type_batiments,
    "etat_type_batiments" => $type_batiment->etat_type_batiments

);

if ($type_batiment_arr['id_type_batiments'] != null) {

  $data = array(
  // (object)array(
      'records' => $type_batiment_arr,
  // ),
  // (object)array(
      'code' => '1',
      'message' => 'Success'
  // ),
  );

  // make it json format
  print_r(json_encode($data));
} else {
  echo json_encode(
      array("message" => "Unsuccessful")
  );
}


?>
