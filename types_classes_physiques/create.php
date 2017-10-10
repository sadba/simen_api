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
include_once '../objects/types_classes_physiques.php';

$database = new Database();
$db = $database->getConnection();

$type_classes_physiques = new Type_Classes_Physiques($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$type_classes_physiques->libelle_type_classe_physique = $data->libelle_type_classe_physique;
$type_classes_physiques->etat_type_classe_physique = $data->etat_type_classe_physique;

// create the batiment
if($type_classes_physiques->create()){
    echo '{';
        echo '"message": "Type_Classe physique was created."';
    echo '}';
}

// if unable to create the batiment, tell the user
else{
    echo '{';
        echo '"message": "Unable to create batiment."';
    echo '}';
}
?>
