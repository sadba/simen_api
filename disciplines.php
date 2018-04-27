<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');


$result=array();
$result = $db->select("SELECT id_discipline as id, libelle_discipline as libelle FROM param_discipline");




if($result)
{


    $json = $result;




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste des disciplines");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);