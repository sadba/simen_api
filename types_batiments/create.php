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
include_once '../objects/type_batiments.php';

$database = new Database();
$db = $database->getConnection();

$type_batiment = new Type_Batiment($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$type_batiment->libelle_type_batiments = $data->libelle_type_batiments;
$type_batiment->etat_type_batiments = $data->etat_type_batiments;

// create the batiment
if($type_batiment->create()){
    echo '{';
        echo '"message": "Type_Batiment was created."';
    echo '}';
}

// if unable to create the batiment, tell the user
else{
    echo '{';
        echo '"message": "Unable to create batiment."';
    echo '}';
}
?>
