<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');

	$code_str = $_GET["code_str"];
$ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";

$ans_stmt = array();
// prepare query statement
$ans_stmt = $db->query($ans);
$rowans = $ans_stmt -> fetch_assoc();

// bind id of product to be updated
// $ans_stmt->bindParam(1, "1");

// execute query
        $result=array();
		$result = $db->select("SELECT DISTINCT e.ien_ens as ien, e.prenom_ens as prenom, e.nom_ens as nom,e.tel_ens as tel,
        e.corps_ens as corps,
        e.grade_ens as grade, sp.code_specialite, sp.nom_specialite as specialite, e.matricule_ens as matricule,
        s.date_prise_service as date_priservice, s.date_os as date_affectation, f.libelle_type_personnel as fonction,
        e.date_nais as date_naissance, e.lieu_nais as lieu_naissance, e.diplome_aca as libelle_diplome_academique,
        e.diplome_prof as libelle_diplome_professionnel,
        COALESCE(e.date_entree_enseignement, '') as date_entree_etablissement,
        COALESCE(e.date_entree_fonction, '') as date_entree_fonctionpublique
        from epeda_personnel_etablissement as e, epad_enseignants_structure as s, param_annee_scolaire as a, param_type_personnel
        as f, param_specialite as sp where e.id_ens=s.id_ens and sp.code_specialite=e.code_specialite
        AND s.annee_entree_str= '".$rowans['annee_cours']."' AND s.annee_sortie_str>a.annee_cours and a.etat_en_cours='1'
        and f.id_type_personnel=s.id_type_personnel and s.code_str= '$code_str' and s.etat_prise = '0'
        ");




if($result)
{

		
        
		
		$json = array("code" => "0","message"=>"success",
					  "enseignants" => $result);
		



}else 
{
	$json = array("code" => "1", "msg" => "impossible d'avoir la liste des enseignants
		.");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);