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
$result = $db->select("SELECT op.id_option as id,op.code_option as code,op.libelle_option as libelle, s.libelle_section as niveau, ts.libelle_serie as serie FROM epeda_option as op, param_section as s,
 param_type_serie as ts WHERE op.code_section = s.code_section AND op.code_type_serie = ts.code_type_serie");




if($result)
{


    $json = array("code" => "0","message"=>"success",
        "options" => $result);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste des disciplines");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);