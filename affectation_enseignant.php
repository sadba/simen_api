<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once 'config/database.php';


include_once 'objects/enseignants_service.php';

$database = new Database();
$db = $database->getConnection();

$enseignants_service = new enseignants_service($db);



// get posted data
$data = json_decode(file_get_contents("php://input"));


// set batiment property values
$enseignants_service->id_ens = $data->id_enseignant;
$enseignants_service->code_classe = $data->id_classe_pedagogique;
$enseignants_service->id_discipline = $data->id_discipline;
$enseignants_service->code_str= $data->code_str;
$enseignants_service->code_me= '15';


if($enseignants_service->postAffectation()){

    $data = array('code' => '0',
        'message' => 'Classe bien affecter a un enseignant');

    echo json_encode($data);
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
        'message' => 'Impossible de faire laffectation');

    echo json_encode($data);
}


