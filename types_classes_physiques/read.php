<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/types_classes_physiques.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$type_classes_physiques = new Type_Classes_Physiques($db);

// query products
$stmt = $type_classes_physiques->read();
// check if more than 0 record found
if($stmt->rowCount()>0)
{
    $result = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        array_push($result,(object)$row);
    }

    $data = array('code' => '0',
                  'message' => 'success',
                  'records' => $result);
}
else{

    $data = array('code' => '1',
                  'message' => 'pas de tyes de batiments');
}


echo json_encode($data);