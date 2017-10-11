<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once 'config/database.php';


include_once 'objects/authentification.php';

$database = new Database();
$db = $database->getConnection();

$login = new authentification($db);



// get posted data
$data = json_decode(file_get_contents("php://input"));


// set batiment property values

$login->username = $data->username;
$login->password= $data->password;


$login->login();