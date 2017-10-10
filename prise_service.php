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
include_once 'objects/enseignants_service.php';

$database = new Database();
$db = $database->getConnection();

$enseignants_service = new enseignants_service($db);



// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$enseignants_service->ien = $data->ien;
$enseignants_service->date_prise_service = $data->date_priseservice;
$enseignants_service->code_str = $data->code_str;

    // var_dump($data->ien);
    // die();

if($enseignants_service->postService()){

    $data = array('code' => '0',
                  'message' => 'prise de service effectuer avec succes');

     echo json_encode($data);
}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
                  'message' => 'Unable to make prise de service');

     echo json_encode($data);
}
    

