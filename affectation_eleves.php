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

include_once 'objects/eleves.php';

$database = new Database();
$db = $database->getConnection();

$eleves = new eleves($db);


// get posted data
$data = json_decode(file_get_contents("php://input"));

$equipements =$data->affectationeleves;

$ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";


$ans_stmt = $db->prepare($ans);
$ans_stmt->execute();
$row = $ans_stmt->fetch(PDO::FETCH_ASSOC);


    foreach ($equipements as $value) {


        $eleves->id_eleve = $value->id;
        $eleves->ien_eleves = $value->ien;
        $eleves->code_str = $value->code_str;
        $eleves->code_classe = $value->code_classe;
        $eleves->code_section = $value->id_niveau;
        $eleves->code_annee = $row['annee_cours'];
        $sad = $eleves->affectationEleves();


    }
    if($sad){

        $data = array('code' => '0',
            'message' => 'Affectation classe effectuer avec succes');

        echo json_encode($data);
    }

// if unable to create the batiment, tell the user
    else{
        $data = array('code' => '1',
            'message' => 'Erreur affectation');
        echo json_encode($data);
    }


