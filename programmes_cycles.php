<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');

$code_cycle = $_GET["code_cycle"];
$result=array();
$result = $db->select("SELECT p.code_programme as code,p.libelle_programme as libelle,p.id_programme as id,p.code_section as id_niveau,
                        p.code_type_serie as id_serie,d.libelle_section as libelle_niveau,ts.libelle_serie as libelle_serie
                         FROM `epeda_programmes` as p
                          INNER JOIN epeda_programmes_contenu as pc ON p.id_programme = pc.id_programme
                          INNER JOIN param_type_serie as ts ON p.code_type_serie = ts.code_type_serie
                          INNER JOIN param_section as d ON p.code_section = d.code_section AND d.code_cycle = '$code_cycle'");




if($result)
{


    $json = array("code" => "0","message"=>"success",
        "programmes" => $result);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste des programmes par cycle");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);