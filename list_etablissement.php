<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');
$code_cycle = $_GET['code_cycle'];
$result=array();
if (isset($_GET['ia'])) {
	$sad = $_GET['ia'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND e.systeme_etab = '$code_cycle' AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND aia.id_atlas = '$sad'
ORDER BY e.libelle_etab");

} else if (isset($_GET['ief'])) {
	$sad = $_GET['ief'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND e.systeme_etab = '$code_cycle' AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND ab.id_atlas = '$sad'
ORDER BY e.libelle_etab");

} else if (isset($_GET['commune'])) {
	$sad = $_GET['commune'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND e.systeme_etab = '$code_cycle' AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND a.id_atlas = '$sad'
ORDER BY e.libelle_etab");
} else {
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND e.systeme_etab = '$code_cycle' AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'
ORDER BY e.libelle_etab");
} 
		
if($result)
{
        
		
		$data = array('code' => '0',
                  'message' => 'prise de service effectuer avec succes',
                  'Etablissements' => $result);

     	echo json_encode($data);
		
}
else
{
	$data = array('code' => '1',
                  'message' => 'Impossible de lire la liste');

     echo json_encode($data);
}
$db->close();


