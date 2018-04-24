<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');
if($_SERVER['REQUEST_METHOD'] == "GET")
{

		$id_type = $_GET["id_type_salle"];
        $result=array();
		$result = $db->select("select id_type_classe_physique, libelle_type_classe_physique from `ephy_type_classe_physique` WHERE id_type_classe_physique = $id_type");
		$json;
		$types_classe_phy=array();
        $nbre=count($result);
        $k=0;
		for ($i=0;$i<$nbre;$i++)
		{
		  $id=$result[$i]['id_type_classe_physique'];
		  //var_dump($id);
		  $equipements=array();
		  //Determiner le  materiel pour chaque classe
		  $equipements = $db->select("select t.id_type_equipement,t.libelle_type_equipement from `ephy_type_equipement` t, `ephy_equip_type_classe_physique` m where t.id_type_equipement=m.id_type_equipement and m.id_type_classe_physique='$id'");

		  $types_classe_phy[$k]=$result[$i];

		  $types_classe_phy[$i]=$equipements;
		  
		  $k++;
		}
		$json=$types_classe_phy;

		
		
	
}
else
{
	$json = array("code" => "1", "msg" => "Request method not accepted");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);