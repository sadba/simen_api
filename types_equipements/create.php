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
include_once '../objects/types_equipements.php';

$database = new Database();
$db = $database->getConnection();

$types_equipements = new types_equipements($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$types_equipements->libelle_type_equipement = $data->libelle_type_equipement;
$types_equipements->etat_type_equipement = $data->etat_type_equipement;

// create the batiment
if($types_equipements->create()){
    echo '{';
        echo '"message": "Type Equipement was created."';
    echo '}';
}

// if unable to create the batiment, tell the user
else{
    echo '{';
        echo '"message": "Unable to create batiment."';
    echo '}';
}
?>
