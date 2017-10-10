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
		e.ien_ens as ien, e.prenom_ens as prenom,e.tel_ens as tel,
		e.nom_ens as nom, e.corps_ens as corps, e.grade_ens as grade, 
		sp.code_specialite, sp.nom_specialite as specialite,
		e.matricule_ens as matricule, s.date_prise_service as date_priseservice,
		s.date_os as date_affectation, f.libelle_type_personnel as fonction

		from epeda_personnel_etablissement as e,
		epad_enseignants_structure as s, param_annee_scolaire as a,
		param_type_personnel as f, param_specialite as sp

	WHERE e.id_ens=s.id_ens and sp.code_specialite=e.code_specialite 
	AND s.annee_entree_str<=a.annee_cours AND s.annee_sortie_str>a.annee_cours 
	and a.etat_en_cours='1' and f.id_type_personnel=s.id_type_personnel 
	and e.ien_ens='$ien' and 	s.etat_affectation='1'");
if($result)
{
        
		

        
        $nbre=count($result);
        // var_dump($result);
        // exit();
        
        $k=0;



        foreach ($result as $value) 
        {
        	$code_specialite = $value['code_specialite'];
			//var_dump($id_classe_physique);
			//exit();

			$disciplines=array();
			//Determiner le  materiel pour chaque classe
			$disciplines = $db->select("
						SELECT d.id_discipline as id, d.libelle_discipline as libelle from param_discipline as d, param_specialite_discipline as sd where sd.id_discipline=d.id_discipline and sd.code_specialite=$code_specialite");


        	$classes = array("code"          		=>"0",
							"message"				=>"Success",
        					"ien" 					=>$value['ien'],
        					"prenom"				=>$value['prenom'],
							"nom"					=>$value['nom'],
							"tel"					=>$value['tel'],
        					"corps"					=>$value['corps'],
        					"grade"					=>$value['grade'],
        					"specialite"			=>$value['specialite'],
        					"matricule"				=>$value['matricule'],
        					"date_prise_service"	=>$value['date_priseservice'],
        					"date affectation"		=>$value['date_affectation'],
        					"fonction"				=>$value['fonction'],
        					"disciplines"			=>$disciplines
						);
        }

	$json = $classes;
		
		
}
else
{
	$json = array("code" => "1", "msg" => "Pas enseignant avec cet ien");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);