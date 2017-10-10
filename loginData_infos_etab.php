<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');
		
		$ien = $_GET["ien"];
        $result=array();
		$result = $db->select("SELECT DISTINCT
		e.ien_ens as ien, CONCAT(e.prenom_ens, ' ', e.nom_ens) as nom_complet, e.prenom_ens as prenom, st.code_str,
		e.nom_ens as nom, st.libelle_structure as libelle, pc.nom_cycle as libelle_cycle, pc.code_cycle as code_cycle, st.statut_str as statut_etablissement


		from epeda_personnel_etablissement as e,
		epad_enseignants_structure as s, param_annee_scolaire as a,
		param_type_personnel as f, param_specialite as sp, structure as st, 		 param_cycle_structure as pcs, param_cycle as pc


	WHERE e.id_ens=s.id_ens and sp.code_specialite=e.code_specialite AND st.code_str = s.code_str AND pcs.code_cycle = pc.code_cycle AND pcs.code_str = st.code_str
	AND s.annee_entree_str<=a.annee_cours AND s.annee_sortie_str>a.annee_cours 
	and a.etat_en_cours='1' and f.id_type_personnel=s.id_type_personnel AND s.etat_affectation='1'
	and e.ien_ens='$ien'");




if($result)
{

		foreach ($result as  $value) {
			
			$classes = array(
        					
        					"code" 					=> "0",
        					"message"				=> "success",
        					"ien" 					=>$value['ien'],
        					"nom_complet" 					=>$value['nom_complet'],
        					"libelle" 					=>$value['libelle'],
							"code_str" 					=>$value['code_str'],
        					"libelle_cycle" 					=>$value['libelle_cycle'],
        					"code_cycle" 					=>$value['code_cycle'],
        					"statut_etablissement" 					=>$value['statut_etablissement'],
						);
		}
        
		
		$json = $classes;
		



}else 
{
	$json = array("code" => "1", "msg" => "Ien non reconnu");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);