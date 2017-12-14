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


// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$options->id_option = NULL;
$options->code_section = $data->id_section;
$options->code_type_serie = $data->id_serie;
$options->code_option = $data->code;
$options->libelle_option = $data->libelle;
$options->code_str = $data->code_str;
$options->etat_option = '1';


$doptions =$data->disciplineids;
//var_dump($options->create());

if($options->sad()){

    $id_option = $db->lastInsertID();

    $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";


    $ans_stmt = $db->prepare($ans);
    $ans_stmt->execute();
    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);


    foreach ($doptions as $value) {


        $options->id_option_discipline = NULL;
        $options->id_discipline = $value->id;
        $options->id_option = $id_option;
        $options->annee_config = $row['annee_cours'];
        $options->annee_archive = '9999';
        $sad = $options->postDiscipline();


    }
    if($sad){

        $data = array('code' => '0',
            'message' => 'Classes physiques et equipements creer');

        echo json_encode($data);
    }

// if unable to create the batiment, tell the user
    else{
        $data = array('code' => '1',
            'message' => 'Creer equipement dabord');
        echo json_encode($data);
    }

}

// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
        'message' => 'Impossible de creer classes physiques');
    echo json_encode($data);
}

