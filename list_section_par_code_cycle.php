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
		$result = $db->select("SELECT ps.code_section as id, ps.libelle_section as libelle,pc.code_cycle as id_cycle, pc.nom_cycle as libelle_cycle FROM param_cycle as pc,param_section as ps WHERE ps.code_cycle = pc.code_cycle AND ps.code_cycle=$code_cycle");




if($result)
{

		
        
		
		$json = array("code" => "0","message"=>"success",
					  "sections" => $result);
		



}else 
{
	$json = array("code" => "1", "msg" => "unable to get list");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);