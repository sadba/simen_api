<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/types_equipements.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$types_equipements = new Type_Equipements($db);

// set ID property of batiment to be edited
$types_equipements->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of batiment to be edited
$types_equipements->readOne();

// create array
$types_equipements_arr = array(
    "id_type_equipement" => $types_equipements->id_type_equipement,
    "libelle_type_equipement" => $types_equipements->libelle_type_equipement,
    "etat_type_equipement" => $types_equipements->etat_type_equipement

);

if ($types_equipements_arr['id_type_equipement'] != null) {

  $data = array(
  // (object)array(
      'records' => $types_equipements_arr,
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
      array("message" => "Unsuccessful",
            "code"    => "0")
  );
}


?>
