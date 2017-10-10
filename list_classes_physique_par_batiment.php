<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');

$id_batiments = $_GET["id_batiments"];
        $result=array();
		$result = $db->select("SELECT
			  cp.id_classe_physique,
			  tcp.libelle_classe_physique,
			  tcp.id_type_classe_physique,
			  cp.capacite_classe_physique,
			  tcp.libelle_type_classe_physique,
			  cp.longueur_classe_physique,
			  cp.largeur_classe_physique
			  FROM
			  ephy_classe_physique cp,
			  ephy_type_classe_physique tcp
			  WHERE tcp.id_type_classe_physique = cp.id_type_classe_physique
			  AND 
			  cp.id_batiments = $id_batiments");
if($result)
{
        
		
		$json = array("code" => "0","message"=>"success");
		$classe_phy=array();
        
        $nbre=count($result);
        // var_dump($result);
        // exit();
        
        $k=0;

        $classes = array();

        foreach ($result as $value) 
        {
        	$id_classe_physique = $value['id_classe_physique'];
			//var_dump($id_classe_physique);
			//exit();

			$equipements=array();
			//Determiner le  materiel pour chaque classe
			$equipements = $db->select("
						SELECT te.id_type_equipement as id, te.libelle_type_equipement as libelle, ecp.nombre_element as quantite
						FROM 
						ephy_type_equipement as te,
						ephy_equipement_classe_physique as ecp,
						ephy_classe_physique as cp 
						WHERE
						te.id_type_equipement = ecp.id_type_equipement
						AND
						cp.id_classe_physique = ecp.id_classe_physique
						AND
						cp.id_classe_physique = $id_classe_physique");


        	$classes[] = array(
        					"id" 					=>$value['id_classe_physique'],
        					"libelle"				=>$value['libelle_classe_physique'],
        					"id_type_salle"			=>$value['id_type_classe_physique'],
        					"capacite"				=>$value['capacite_classe_physique'],
        					"libelle_type_salle"	=>$value['libelle_type_classe_physique'],
        					"longueur"				=>$value['longueur_classe_physique'],
        					"largeur"				=>$value['largeur_classe_physique'],
        					"equipements"			=>$equipements
						);
        }

        $json["classes"] = $classes;
		
		
}
else
{
	$json = array("code" => "1", "msg" => "Ce batiment n'existe pas");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);