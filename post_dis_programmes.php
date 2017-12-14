<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once 'config/database.php';

// instantiate batiment object
include_once 'objects/enseignants_service.php';

$database = new Database();
$db = $database->getConnection();


$options = new enseignants_service($db);

$datas=file_get_contents("php://input");
// get posted data
$datass = json_decode($datas);
$dt = $datass->disciplinesprog;
foreach($dt as $data){
// set batiment property values
$options->id_discipline = $data->id;
$options->etat_contenu_str = 1;
$options->code_type_serie = $data->id_serie;
$options->id_option = NULL;
$options->credit_horaire = $data->credit_horaire;
$options->coefficient = $data->coefficient;
$options->code_str = $data->code_str;
$options->id_programme = $data->id_programme;


    $ans = "SELECT epc.id_contenu FROM epeda_programmes_contenu as epc
              INNER  JOIN epeda_programmes as p ON p.id_programme = epc.id_programme AND p.code_type_serie = '".$data->id_serie."'
              WHERE epc.id_programme = '".$data->id_programme."'
              ";


    $ans_stmt = $db->prepare($ans);
    $ans_stmt->execute();
    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);

    $ans1 = "SELECT * FROM param_annee_scolaire where etat_en_cours='1'";


    $ans_stmt1 = $db->prepare($ans1);
    $ans_stmt1->execute();
    $row1 = $ans_stmt1->fetch(PDO::FETCH_ASSOC);

    $options->id_contenu = $row['id_contenu'];
    $options->code_annee = $row1['annee_cours'];


    $options->id_contenu_str = NULL;
    if($options->postDisprogramme()){

        $data = array('code' => '0',
            'message' => 'Disciplines programmes bien inserer');

        echo json_encode($data);
    }

// if unable to create the batiment, tell the user
    else{
        $data = array('code' => '1',
            'message' => 'Impossible dinserer les disciplines');
        echo json_encode($data);
    }
}




