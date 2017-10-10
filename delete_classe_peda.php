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
$classes_peda->code_classe = $_GET['id'];



if($classes_peda->delete()){

    $data = array('code' => '0',
        'message' => 'Suppression effectuer avec succes');

    echo json_encode($data);
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
        'message' => 'Impossible de supprimer');

    echo json_encode($data);
}


