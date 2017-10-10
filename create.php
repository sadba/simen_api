<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once 'config/database.php';

// instantiate batiment object
include_once 'objects/enseignants_classes.php';

$database = new Database();
$db = $database->getConnection();

$enseignants_classes = new enseignants_classes($db);



// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$enseignants_classes->code_classe = $data->id_classe_pedagogique;
$enseignants_classes->id_ens = $data->id_enseignant;
$enseignants_classes->id_discipline = $data->id_discipline;
$enseignants_classes->code_str = $data->code_str;


if($enseignants_classes->postEnseignant()){

    $data = array('code' => '0',
                  'message' => 'Affectation enseignant effectuer avec succes');

     echo json_encode($data);
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
                  'message' => 'Impossible deffectuer cette affectation');

     echo json_encode($data);
}
    

