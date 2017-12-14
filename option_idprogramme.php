<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');
$code_str = $_GET["code_str"];
$id = $_GET["id_programme"];

$result=array();
$result = $db->select("SELECT o.code_option as code, o.libelle_option as options, o.id_option as id
                      FROM epeda_option as o
                      INNER JOIN epeda_programmes as p ON p.code_section = o.code_section
                      AND p.code_type_serie = o.code_type_serie
                      AND p.id_programme = '$id'
                      WHERE o.code_str = '$code_str'");




if($result)
{


    $json = array("code" => "0","message"=>"success",
        "disciplines" => $result);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste des disciplines");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);