<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/batiment.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$batiment = new Batiment($db);

// query products
$stmt = $batiment->readEtab();

// check if more than 0 record found
if($stmt->rowCount()>0)
{
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($result,(object)$row);
    }

    $data = $result;
}
else{

    $data = array('code' => '1',
                  'message' => 'pas de batiment dans cet etablissement');
}


echo json_encode($data);