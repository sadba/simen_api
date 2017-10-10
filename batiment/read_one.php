<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/batiment.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$batiment = new batiment($db);

// set ID property of batiment to be edited
$batiment->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of batiment to be edited
$batiment->readOne();

// create array
$batiment_arr = array(
    "id_batiments" =>  $batiment->id_batiments,
    "id_type_batiments" => $batiment->id_type_batiments,
    "code_batiments" => $batiment->code_batiments,
    "libelle_batiments" => $batiment->libelle_batiments,
    "code_str" => $batiment->code_str,
    "lat_batiments" => $batiment->lat_batiments,
    "long_batiments" => $batiment->long_batiments,
    "etat_batiments" => $batiment->etat_batiments

);

if ($batiment_arr['id_batiments'] != null) {

  $data = array(
  // (object)array(
      'records' => $batiment_arr,
  // ),
  // (object)array(
      'code' => '0',
      'message' => 'Success'
  // ),
  );

  // make it json format
  print_r(json_encode($data));
} else {
  echo json_encode(
      array("code"  => "1",
          "message" => "Unsuccessful")
  );
}


?>
