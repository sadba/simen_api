<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate batiment object
include_once '../objects/classes_physiques.php';
include_once '../objects/equipements_classes_physiques.php';

$database = new Database();
$db = $database->getConnection();

$classes_physiques = new Classes_Physiques($db);
$Mequipements = new Equipement_Classes_Physiques($db);


// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$classes_physiques->id_batiments = $data->id_batiment;
$classes_physiques->id_type_classe_physique = $data->id_type_classe_physique;
$classes_physiques->libelle_classe_physique = $data->libelle;
$classes_physiques->longueur_classe_physique = $data->longueur;
$classes_physiques->largeur_classe_physique = $data->largeur;
$classes_physiques->capacite_classe_physique = $data->capacite;
$classes_physiques->etat_classe_physique = 1;


$equipements =$data->equipement;
//var_dump($classes_physiques->create());

if($classes_physiques->create()){

	$id_classe_physique = $db->lastInsertID();

	foreach ($equipements as $value) {
  		
  	
    $classes_physiques->id_type_equipement = $value->id;
    $classes_physiques->id_classe_physique = $id_classe_physique;
    $classes_physiques->nombre_element = $value->quantite;
	$sad = $classes_physiques->createEquip();
    

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

