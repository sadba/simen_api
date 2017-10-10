<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/batiment.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare batiment object
$batiment = new batiment($db);

// get id of batiment to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of batiment to be edited
$batiment->id_batiments = $data->id_batiments;

// set batiment property values
$batiment->id_type_batiments = $data->id_type_batiments;
$batiment->libelle_batiments = $data->libelle_batiments;
$batiment->code_str = $data->code_str;
$batiment->lat_batiments = $data->lat_batiments;
$batiment->long_batiments = $data->long_batiments;
$batiment->etat_batiments = $data->etat_batiments;


if($batiment->getlibelle()){
    $data = array('code' => '1',
        'message' => 'Impossible de modifier batiment, le nom est deja utiliser');
} else {
    if($batiment->update()){
        $data = array('code' => '0',
            'message' => 'batiment a ete bien mis a jour');
    }

// if unable to update the batiment, tell the user
    else{
        $data = array('code' => '1',
            'message' => 'Impossible de modifier batiment');
    }
}
// update the batiment


echo json_encode($data);
?>
