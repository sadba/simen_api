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
if (isset($_GET['ia'])) {
	$sad = $_GET['ia'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND aia.id_atlas = '$sad'
ORDER BY e.libelle_etab");
	$file = "xml/liste_etablissement_ia.xml";

} else if (isset($_GET['ief'])) {
	$sad = $_GET['ief'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND ab.id_atlas = '$sad'
ORDER BY e.libelle_etab");
	$file = "xml/liste_etablissement_ief.xml";

} else if (isset($_GET['commune'])) {
	$sad = $_GET['commune'];
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'  AND a.id_atlas = '$sad'
ORDER BY e.libelle_etab");
	$file = "xml/liste_etablissement_commune.xml";
} else {
	$result = $db->select("SELECT e.code_etab as id, e.libelle_etab as libelle, e.long_etab as longitude, e.lat_etab as latitude, e.statut_etab as statut, e.systeme_etab as cycle, aia.id_atlas as id_ia, aia.libelle_atlas as IA, ab.id_atlas as id_ief, ab.libelle_atlas as IEF, a.id_atlas as id_commune, a.libelle_atlas as libelle_commune
FROM `etablissement` as e, atlas as a, atlas as ab ,atlas as aia WHERE e.id_atlas = a.id_atlas AND a.id_hierarchie_atlas = '4' AND a.id_parent_atlas = ab.id_atlas AND ab.id_hierarchie_atlas = '3' AND ab.id_parent_atlas = aia.id_atlas  AND aia.id_hierarchie_atlas = '2'
ORDER BY e.libelle_etab");
	$file = "xml/liste_etablissement.xml";
} 
		
if($result)
{
	if(file_exists($file))
	{
		unlink($file);
	}

		$xml = '<markers>';
		foreach ($result as $value) {
			
			$xml. = "<marker id_etab='".$value->id."'  libelle_etab='".$value->libelle."'/>";
		}
		$xml.= '</markers>';
       file_put_contents($file, $xml);
		
}
else
{
	$data = array('code' => '1',
                  'message' => 'Impossible de lire la liste');

     echo json_encode($data);
}
$db->close();

/* Output header */
header('Content-type: application/json');
