<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate batiment object
include_once '../objects/classes_physiques.php';

$database = new Database();
$db = $database->getConnection();

$classes_physiques = new Classes_Physiques($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$classes_physiques->id_equipement_classe_physique = $data->id_equipement_classe_physique;
$classes_physiques->id_type_equipement = $data->id_type_equipement;
$classes_physiques->id_classe_physique = $data->id_classe_physique;
$classes_physiques->nombre_element = $data->nombre_element;


// create the batiment
if($classes_physiques->create()){
    $data = array('code' => '0',
                  'message' => 'Equipements classes physiques creer');
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
                  'message' => 'Impossible de creer un equipement');
}
?>
