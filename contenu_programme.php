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
$result = $db->select("SELECT
                      d.id_discipline as id,d.libelle_discipline as libelle,d.code_discipline as code,
                      s.coefficient,s.credit_horaire FROM param_discipline as d, epeda_programmes_contenu_structure as s
                       WHERE d.id_discipline = s.id_discipline");




if($result)
{


    $json = array("code" => "0","message"=>"success",
        "contenu" => $result);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir les contenus de programmes");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);