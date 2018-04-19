<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();

$code_str = $_GET["code_str"];
$db->query('SET CHARACTER SET utf8');
		$code_annee='';
		$anned=$db->query("select a.annee_cours from param_annee_scolaire as a where a.etat_en_cours='1'");
		foreach ($anned as $value ){
			$code_annee=$value['annee_cours'];
			}
        $result=array();
		$result = $db->select("SELECT DISTINCT cp.code_classe as id, cp.libelle_classe as libelle, sec.libelle_section as niveau, s.libelle_serie as serie, COALESCE(f.id_classe_physique, '') as salle_fixe, COALESCE(f.libelle_classe_physique, '') as libelle_salle_fixe FROM epeda_classe_pedagogique as cp
			INNER JOIN param_type_serie as s ON s.code_type_serie=cp.code_type_serie 
			INNER JOIN param_section as sec ON sec.code_section=cp.code_section 
			LEFT JOIN epeda_classe_sallefixe as sp ON sp.code_classe=cp.code_classe AND sp.sal_annee_config<=$code_annee AND sp.sal_annee_archive>$code_annee
			 LEFT JOIN ephy_classe_physique as f ON f.id_classe_physique=sp.id_classe_physique where cp.code_str=$code_str");




if($result)
{

		
        
		
		$json = $result;
		



}else 
{
	$json = array("code" => "1", "msg" => "Impossible davoir les classes peda");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);