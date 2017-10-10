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
include_once 'objects/classes_peda.php';

$database = new Database();
$db = $database->getConnection();

$classes_peda = new classes_peda($db);



// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$classes_peda->code_type_serie = $data->id_serie;
$classes_peda->code_section = $data->id_niveau;
$classes_peda->code_str = $data->code_str;
$classes_peda->libelle_classe = $data->libelle;
$classes_peda->id_classe_physique = $data->id_classe_physique;
$classes_peda->annee_fin = 9999;


    

if($classes_peda->postClasse()){

    $data = array('code' => '0',
                  'message' => 'classe peda creer avec succes');

     echo json_encode($data);
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
                  'message' => 'Impossible de creer classes peda');

     echo json_encode($data);
}
    

