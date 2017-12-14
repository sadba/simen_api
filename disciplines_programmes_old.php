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
$result = $db->select("SELECT DISTINCT p.code_programme as code,p.libelle_programme as libelle,p.id_programme as id,p.code_section as id_niveau,
            p.code_type_serie as id_serie,d.libelle_section as libelle_niveau,ts.libelle_serie as libelle_serie,pcs.code_str as code_str
             FROM `epeda_programmes` as p
             INNER JOIN epeda_programmes_contenu as pc ON p.id_programme = pc.id_programme
             INNER JOIN epeda_programmes_contenu_structure as pcs
             ON pc.id_contenu = pcs.id_contenu AND pcs.code_str = '$code_str'
             INNER JOIN param_type_serie as ts ON p.code_type_serie = ts.code_type_serie INNER JOIN param_section as d
             ON p.code_section = d.code_section");
if($result)
{




    foreach ($result as $value)
    {

        $id_programmes = $value['id'];
        $disciplines=array();

        $disciplines = $db->select("
						SELECT d.id_discipline as id,d.code_discipline as code, d.libelle_discipline as discipline
						FROM
						param_discipline as d
						LEFT JOIN epeda_programmes_contenu_structure as s ON s.id_discipline = d.id_discipline
						INNER JOIN epeda_programmes_contenu as pc ON pc.id_contenu = s.id_contenu AND
						pc.id_programme = '$id_programmes'");

        $options=array();

        $options = $db->select("
						SELECT
						FROM
						epeda_option as o LEFT JOIN epeda_programmes_contenu_structure as pc
						ON o.id_option = pc.id_option
						LEFT JOIN epeda_programmes_contenu as c ON c.id_contenu = pc.id_contenu  AND
						c.id_programme = '$id_programmes'");
        $programmes[] = array(
            "code" 					=>$value['code'],
            "libelle"				=>$value['libelle'],
            "id"			=>$value['id'],
            "id_niveau"				=>$value['id_niveau'],
            "id_serie"	=>$value['id_serie'],
            "libelle_niveau"				=>$value['libelle_niveau'],
            "libelle_serie"				=>$value['libelle_serie'],
            "code_str"				=>$value['code_str'],
            "disciplines"			=>$disciplines,
            "options"               =>$options
        );
    }

    $json = array("code" => "0","message"=>"success",
        "programmes" => $programmes);


}
else
{
    $json = array("code" => "1", "msg" => "Pas de donnees dans cet etablissement");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);