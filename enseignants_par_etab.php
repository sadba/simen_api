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
        $result=array();
		$result = $db->select("SELECT DISTINCT e.id_ens,s.code_str,
		e.ien_ens as ien, e.prenom_ens as prenom,
		e.nom_ens as nom, e.corps_ens as corps, e.grade_ens as grade,e.tel_ens as tel,
		sp.code_specialite, sp.nom_specialite as specialite,e.sexe_ens as genre,
		e.matricule_ens as matricule, s.date_prise_service as date_priseservice,
		s.date_os as date_affectation, f.libelle_type_personnel as fonction, s.etat_affectation as etat


		from epeda_personnel_etablissement as e,
		epad_enseignants_structure as s, param_annee_scolaire as a,
		param_type_personnel as f, param_specialite as sp


	WHERE e.id_ens=s.id_ens and sp.code_specialite=e.code_specialite AND s.code_str = $code_str AND
	s.annee_entree_str<=a.annee_cours AND s.annee_sortie_str>a.annee_cours and a.etat_en_cours='1'
	and a.etat_en_cours='1' and f.id_type_personnel=s.id_type_personnel AND s.etat_prise = '1'
	");
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
        	$code_specialite = $value['code_specialite'];
        	$idens= $value['id_ens'];
        	$code_str= $value['code_str'];
			//var_dump($id_classe_physique);
			//exit();

			$disciplines=array();
			//Determiner le  materiel pour chaque classe
			$disciplines = $db->select("
						SELECT d.id_discipline as id, d.libelle_discipline as libelle from param_discipline as d, param_specialite_discipline as sd where sd.id_discipline=d.id_discipline and sd.code_specialite=$code_specialite");

			$etab=array();
			//Determiner le  materiel pour chaque classe
			$etab = $db->select("SELECT DISTINCT s.code_str, s.libelle_structure, es.annee_entree_str, COALESCE(es.date_sortie, '')  as date_sortie FROM structure as s, epad_enseignants_structure as es where es.id_ens=$idens AND s.code_str = es.code_str");

			$clas=array();
			//Determiner le  materiel pour chaque classe
			$clas= $db->select("SELECT c.code_classe as id_classe_pedagogique, c.libelle_classe as libelle_classe_pedagogique , d.libelle_discipline FROM `epeda_enseignants_discipline_classe` as ecd, epeda_classe_pedagogique as c, param_annee_scolaire as a, param_discipline as d WHERE ecd.id_ens=$idens AND ecd.code_classe=c.code_classe AND ecd.code_annee=a.annee_cours and a.etat_en_cours='1' and d.id_discipline=ecd.id_discipline and ecd.code_str=$code_str");	



        	$classes[] = array(
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
        					"genre"				=>$value['genre'],
        					"etat"				=>$value['etat'],
        					"disciplines"			=>$disciplines,
        					"etablissements"		=>$etab,
        					"classes"				=>$clas
						);
        }

        $json["enseignants"] = $classes;
		
		
}
else
{
	$json = array("code" => "1", "msg" => "Cet enseignant n'existe pas");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);