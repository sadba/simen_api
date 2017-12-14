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

// set batiment property values
$eleves->id_eleve       = $data->id_eleve;
$eleves->ien_eleves     = $data->ien;
$eleves->code_str       = $data->code_str;
$statut                 = $data->statut;
$eleves->numero_recu        = $data->numrecu;
$eleves->date_inscription   = $data->date_inscription;

$ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";


$ans_stmt = $db->prepare($ans);
$ans_stmt->execute();
$row = $ans_stmt->fetch(PDO::FETCH_ASSOC);
$eleves->code_annee = $row['annee_cours'];
if($statut == "inscrit"){
    $eleves->statut_inscription = "Inscrit";

    if($eleves->inscriptionEleves())
    {


    $data = array('code' => '0',
        'message' => 'Inscrit avec success');

    echo json_encode($data);
        }
        else{
            $data = array('code' => '1',
                'message' => 'Erreur lors de la creation');
            echo json_encode($data);
        }


}
else if($statut == "reinscrit") {
    if($eleves->reinscriptionEleves())
    {

        $eleves->statut_inscription = "Reinscrit";
        $data = array('code' => '0',
            'message' => 'Reinscrit avec success');

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
    else
    {
        $data = array('code' => '1',
            'message' => 'Impossible de creer classes physiques');
        echo json_encode($data);
    }






