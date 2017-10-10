<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/classes_physiques.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$classes_physiques = new Classes_Physiques($db);

// set ID property of batiment to be edited
$classes_physiques->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of batiment to be edited
$classes_physiques->readOne();

// create array
$classes_physiques_arr = array(
  "id_classe_physique" => $classes_physiques->id_classe_physique,
  "id_batiments" => $classes_physiques->id_batiments,
  "id_type_classe_physique" => $classes_physiques->id_type_classe_physique,
  "code_classe_physique" => $classes_physiques->code_classe_physique,
  "libelle_classe_physique" => $classes_physiques->libelle_classe_physique,
  "longueur_classe_physique" => $classes_physiques->longueur_classe_physique,
  "largeur_classe_physique" => $classes_physiques->largeur_classe_physique,
  "capacite_classe_physique" => $classes_physiques->capacite_classe_physique,
  "etat_classe_physique" => $classes_physiques->etat_classe_physique

);

if ($classes_physiques_arr['id_classe_physique'] != null) {

  $data = array(
  // (object)array(
      'code' => '1',
      'message' => 'Success',
      'id' => $classes_physiques_arr['id_classe_physique'],
      'id_batiments' => $classes_physiques_arr['id_batiments'],
      'id_type_classe_physique' => $classes_physiques_arr['id_type_classe_physique'],
      'code' => $classes_physiques_arr['code_classe_physique'],
      'libelle' => $classes_physiques_arr['libelle_classe_physique'],
      'longueur' => $classes_physiques_arr['longueur_classe_physique'],
      'largeur' => $classes_physiques_arr['largeur_classe_physique'],
      'capacite' => $classes_physiques_arr['capacite_classe_physique'],
      'etat' => $classes_physiques_arr['etat_classe_physique'],

  // ),
  // (object)array(

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
