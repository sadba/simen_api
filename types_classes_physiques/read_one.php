<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/types_classes_physiques.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$type_classes_physiques = new Type_Classes_Physiques($db);

// set ID property of batiment to be edited
$type_classes_physiques->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of batiment to be edited
$type_classes_physiques->readOne();

// create array
$type_classes_physiques_arr = array(
    "id_type_classe_physique" => $type_classes_physiques->id_type_classe_physique,
    "libelle_type_classe_physique" => $type_classes_physiques->libelle_type_classe_physique,
    "etat_type_classe_physique" => $type_classes_physiques->etat_type_classe_physique

);

if ($type_classes_physiques_arr['id_type_classe_physique'] != null) {

  $data = array(
  // (object)array(
      'records' => $type_classes_physiques_arr,
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
