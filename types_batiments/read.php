<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/type_batiments.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$type_batiment = new Type_Batiment($db);

// query products
$stmt = $type_batiment->read();
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
                  'message' => 'pas de types batiments');
}


echo json_encode($data);