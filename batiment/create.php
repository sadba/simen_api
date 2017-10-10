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
include_once '../objects/batiment.php';

$database = new Database();
$db = $database->getConnection();

$batiment = new Batiment($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$batiment->id_type_batiments = $data->id_type_batiments;
$batiment->code_batiments = $data->code_batiments;
$batiment->libelle_batiments = $data->libelle_batiments;
$batiment->code_str = $data->code_str;
$batiment->lat_batiments = $data->lat_batiments;
$batiment->long_batiments = $data->long_batiments;
$batiment->etat_batiments = $data->etat_batiments;




// create the batiment
if($batiment->create()){
    $data = array('code' => '0',
                    'message' => 'success');
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
        'message' => 'Impossible de creer un batiment');
}


echo json_encode($data);
