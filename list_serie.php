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
			  code_type_serie as id, libelle_serie as libelle
			  FROM
			  param_type_serie");




if($result)
{

		
        
		
		$json = array("code" => "0","message"=>"success",
					  "series" => $result);
		



}else 
{
	$json = array("code" => "1", "msg" => "unable to get serie.");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);