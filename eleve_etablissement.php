<?php
// include database and object files
include_once 'config/DB.php';
$db = new Db();

//$datetime = date('Y-m-d H:i:s', $timestamp);
//echo date("D", strtotime($datetime)) . "\n";
//echo $datetime;
//exit();
$db->query('SET CHARACTER SET utf8');

$ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";

// prepare query statement
$ans_stmt = $db->query($ans);

$row = mysqli_fetch_array($ans_stmt);

$code_str = $_GET["code_str"];


$result=array();
$result = $db->select("SELECT e.id_eleve as id,e.ien_eleves as ien,e.prenom_eleve as prenom,e.nom_eleve as nom,
      e.statut,e.date_naissance as datenaiss,e.lieu_naissance as lieunaiss,
      d.exemption_eps as exemption,d.code_dossier as numdossier,s.code_classe as classe,d.code_section as niveau,
      m.libelle_statut,d.id_dossier, COALESCE(c.libelle_classe, '') libelle_classe
      FROM epeda_dossier_eleve AS d
           INNER JOIN  epeda_eleves AS e
           ON e.id_eleve = d.id_eleve
           INNER JOIN  param_statut_eleve AS m
           ON d.motif_entree = m.code_statut
           LEFT OUTER JOIN epeda_classe_eleve AS s
           ON e.id_eleve = s.id_eleve and s.code_annee='".$row['annee_cours']."'
           LEFT OUTER JOIN epeda_classe_pedagogique AS c
           ON c.code_classe = s.code_classe
       where  d.annee_entree<= '".$row['annee_cours']."' AND d.annee_sortie>'".$row['annee_cours']."'
        and d.code_str='$code_str'");




if($result)
{
    foreach($result as $value){
        if($value['annee_entre'] == $row['annee_cours']){
            $statut = "NON";
        } else {
            $statut = "OUI";
        }

        $eleves[] = array(
            "id" 					=>$value['id'],
            "ien"				=>$value['ien'],
            "prenom"			=>$value['prenom'],
            "nom"				=>$value['nom'],
            "libelle_classe"	=>$value['libelle_classe'],
            "ancien"				=>$statut,
            "datenaiss"				=>$value['datenaiss'],
            "lieunaiss"			=>$value['lieunaiss'],
            "numdossier"        =>$value['numdossier'],
            "excemptioneps"     =>$value['exemption'],
            "niveau"            =>$value['niveau']
        );
    }


    $json = array("code" => "0","message"=>"success",
        "eleves" => $eleves);




}else
{
    $json = array("code" => "1", "msg" => "Impossible davoir la liste des disciplines");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);