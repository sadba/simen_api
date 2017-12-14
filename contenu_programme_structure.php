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
$id_programmes = $_GET['id_programme'];
$result=array();
$result = $db->select("SELECT d.id_discipline as id,d.code_discipline as code,d.libelle_discipline as libelle, cp.coefficient, cp.credit_horaire
                      from epeda_programmes_contenu_structure as cp
                      INNER JOIN epeda_programmes_contenu as cs ON cs.id_contenu=cp.id_contenu AND cs.id_programme='$id_programmes'
                      INNER JOIN param_discipline as d ON d.id_discipline=cp.id_discipline
                      WHERE cp.code_str='$code_str'");


$result1=array();
$result1 = $db->select("SELECT o.id_option as id, o.code_option as code, o.libelle_option as libelle, cp.coefficient, cp.credit_horaire from epeda_programmes_contenu_structure as cp
                      INNER JOIN epeda_programmes_contenu as cs ON cs.id_contenu=cp.id_contenu AND cs.id_programme='$id_programmes'
                      INNER JOIN epeda_option as o ON o.id_option=cp.id_option
                      WHERE cp.code_str='$code_str'");
if($result)
{
    foreach ($result as $value)
    {

        $discipline[] = array(
            "id" 					=>$value['id'],
            "libelle"				=>$value['libelle'],
            "code"			        =>$value['code'],
            "coefficient"			=>$value['coefficient'],
            "credit_horaire"	    =>$value['credit_horaire']
        );
    }

    foreach ($result1 as $values)
    {

        $option[] = array(
            "id" 					=>$values['id'],
            "libelle"				=>$values['libelle'],
            "code"			        =>$values['code'],
            "coefficient"			=>$values['coefficient'],
            "credit_horaire"	    =>$values['credit_horaire']
        );
    }

    $json = array(
        "code" => "0","message"=>"success",
        "contenu_discipline" => $discipline,
        "contenu_options" => $option
        );


}
else
{
    $json = array("code" => "1", "msg" => "Pas de donnees dans cet etablissement");
}
$db->close();

/* Output header */
header('Content-type: application/json');
echo json_encode($json);