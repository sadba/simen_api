<?php
class Classes_Physiques{

    // database connection and table name
    private $conn;
    private $table_name = "ephy_classe_physique";

    // object properties
    public $id_classe_physique;
    public $id_batiments;
    public $id_type_classe_physique;
    public $code_classe_physique;
    public $libelle_classe_physique;
    public $longueur_classe_physique;
    public $largeur_classe_physique;
    public $capacite_classe_physique;
    public $etat_classe_physique;

    public $id_type_equipement;
    public $nombre_element;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
function read(){


    // select all query
    $query = "SELECT id_classe_physique, id_batiments, id_type_classe_physique, code_classe_physique, libelle_classe_physique, COALESCE(longueur_classe_physique,'') longueur_classe_physique, COALESCE(largeur_classe_physique,'') largeur_classe_physique, capacite_classe_physique, etat_classe_physique FROM " . $this->table_name . "";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

function readBat(){

    $id_batiments = $_GET['id_batiments'];
    // select all query
    $query = "SELECT id_classe_physique, id_batiments, id_type_classe_physique, code_classe_physique, libelle_classe_physique, COALESCE(longueur_classe_physique,'') longueur_classe_physique, COALESCE(largeur_classe_physique,'') largeur_classe_physique, capacite_classe_physique, etat_classe_physique FROM " . $this->table_name . " WHERE id_batiments = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute([$id_batiments]);

    return $stmt;
}
    function read_structure(){

        $code_str = $_GET['code_str'];
        // select all quer
        $query = "SELECT s.id_classe_physique as id,
                          s.id_batiments, s.id_type_classe_physique,
                           s.code_classe_physique as code,
                           s.libelle_classe_physique as libelle,
                          s.longueur_classe_physique as longueur,
                          s.largeur_classe_physique as largeur,
                              s.capacite_classe_physique as capacite,
                              s.etat_classe_physique as etat FROM " . $this->table_name . " as s, ephy_batiments as b
                              WHERE b.code_str = '$code_str' AND b.id_batiments = s.id_batiments";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }
// create product
function create(){



include '../codification.php';

$req = "SELECT code_batiments, code_str FROM ephy_batiments  WHERE  id_batiments = ?";

// prepare query statement
$stmtreq = $this->conn->prepare($req);

// bind id of product to be updated
$stmtreq->bindParam(1, $this->id_batiments);

// execute query
$stmtreq->execute();

// get retrieved row
$rowreq = $stmtreq->fetch(PDO::FETCH_ASSOC);



$code_classe_physique = CodificationClassephy($rowreq['code_str'], $rowreq['code_batiments']);

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET


                id_batiments=:id_batiments,
                id_type_classe_physique=:id_type_classe_physique,
                code_classe_physique=:code_classe_physique,
                libelle_classe_physique=:libelle_classe_physique,
                longueur_classe_physique=:longueur_classe_physique,
                largeur_classe_physique=:largeur_classe_physique,
                capacite_classe_physique=:capacite_classe_physique,
                etat_classe_physique=:etat_classe_physique";


    // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":id_batiments", $this->id_batiments);
    $stmt->bindParam(":id_type_classe_physique", $this->id_type_classe_physique);
    $stmt->bindParam(":code_classe_physique", $code_classe_physique);
    $stmt->bindParam(":libelle_classe_physique", $this->libelle_classe_physique);
    $stmt->bindParam(":longueur_classe_physique", $this->longueur_classe_physique);
    $stmt->bindParam(":largeur_classe_physique", $this->largeur_classe_physique);
    $stmt->bindParam(":capacite_classe_physique", $this->capacite_classe_physique);
    $stmt->bindParam(":etat_classe_physique", $this->etat_classe_physique);

    
   
    // execute query
    if($stmt->execute()){
        return true;

    }else{
        return false;
    }
}


function createEquip(){


    // query to insert record
    $query = "INSERT INTO
                ephy_equipement_classe_physique
            SET


                id_type_equipement=:id_type_equipement,
                id_classe_physique=:id_classe_physique,
                nombre_element=:nombre_element";


    // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":id_type_equipement", $this->id_type_equipement);
    $stmt->bindParam(":id_classe_physique", $this->id_classe_physique);
    $stmt->bindParam(":nombre_element", $this->nombre_element);
    
    // execute query
    if($stmt->execute()){
        return true;

    }else{
        return false;
    }
}


function readOne(){



    // query to read single record
    $query = "SELECT * FROM " . $this->table_name . "  WHERE  id_classe_physique = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // set values to object properties
    $this->id_classe_physique = $row['id_classe_physique'];
    $this->id_batiments = $row['id_batiments'];
    $this->id_type_classe_physique = $row['id_type_classe_physique'];
    $this->code_classe_physique = $row['code_classe_physique'];
    $this->libelle_classe_physique = $row['libelle_classe_physique'];
    $this->longueur_classe_physique = $row['longueur_classe_physique'];
    $this->largeur_classe_physique = $row['largeur_classe_physique'];
    $this->capacite_classe_physique = $row['capacite_classe_physique'];
    $this->etat_classe_physique = $row['etat_classe_physique'];
}

// update the product
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                id_type_batiments = ?,
                code_batiments = ?,
                libelle_batiments = ?,
                code_str = ?,
                lat_batiments = ?,
                long_batiments = ?,
                etat_batiments = ?
            WHERE
                id_batiments = ?";



    $tab_sane = array();
    $tab_sane[] =  $this->id_type_batiments;
    $tab_sane[] = $this->code_batiments;
    $tab_sane[] = $this->libelle_batiments;
    $tab_sane[] = $this->code_str;
    $tab_sane[] = $this->lat_batiments;
    $tab_sane[] = $this->long_batiments;
    $tab_sane[] = $this->etat_batiments;
    $tab_sane[] = $_GET['id'];
    // prepare query statement


    try
    {
        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        $stmt->execute($tab_sane);

        $this->conn->commit();
        return true;

    } catch (PDOException $e)
    {
      $this->conn->rollBack();
      return false;
    }



}

function delete(){

    include 'equipements_classes_physiques.php';

    //$ndao = new Equipement_Classes_Physiques();

    //$supp = $ndao->delete_all($_GET['id']);

    $select ="SELECT * FROM epeda_classe_sallefixe WHERE id_classe_physique = ?";

        $sselect = $this->conn->prepare($select);
        $sselect->execute([$_GET['id']]);

    if ($sselect->rowCount() == FALSE) {

           $req1 = "DELETE FROM
               ephy_equipement_classe_physique

            WHERE
                id_classe_physique = ?";

    $query = "DELETE FROM
                ephy_classe_physique

            WHERE
                id_classe_physique = ?";


    try
    {
        $this->conn->beginTransaction();
        $stmt1 = $this->conn->prepare($req1);
        $stmt1->execute([$_GET['id']]);
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$_GET['id']]);


        $this->conn->commit();
        return true;

    } catch (PDOException $e)
    {
      $this->conn->rollBack();
      return false;
    }
        
    }else {

        include("messages.php");
        $tre= new Message();
        return $tre->messages_salles();

    }



   



}




}
