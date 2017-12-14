<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');
$result=array();
$ia = $_GET['ia'];
$type = $_GET['type'];
if (isset($_GET['ia']) && isset($type)) {
    $result = $db->select("SELECT id_atlas as id, libelle_atlas as libelle_structure,
              long_atlas as longitude, lat_atlas as latitude
              FROM atlas WHERE id_hierarchie_atlas = '$type' AND
              id_parent_atlas = '$ia'");


    if ($result) {


        $data = array('code' => '0',
            'message' => 'succes',
            'Structures' => $result);

        echo json_encode($data);

    } else {
        $data = array('code' => '1',
            'message' => 'Impossible de lire la liste');

        echo json_encode($data);
    }
}
$db->close();


