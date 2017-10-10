<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');

$cycle = $_GET["code_cycle"];

$result=array();
$result = $db->select("SELECT * FROM param_type_serie where etat_serie='1'
                      AND code_type_serie IN (select code_type_serie from param_cycle_serie where code_cycle='$cycle')");



if($result)
{




    $json = array("code" => "0","message"=>"success",
        "series" => $result);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste.");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);