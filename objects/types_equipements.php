<?php
class Type_Equipements{

    // database connection and table name
    private $conn;
    private $table_name = "ephy_type_equipement";

    // object properties
    public $id_type_equipement;
    public $libelle_type_equipement;
    public $etat_type_equipement;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
function read(){

    // select all query
    $query = "SELECT * FROM " . $this->table_name . "";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}
// create product
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET

                libelle_type_equipement=:libelle_type_equipement,
                etat_type_equipement=:etat_type_equipement";

    // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":libelle_type_equipement", $this->libelle_type_equipement);
    $stmt->bindParam(":etat_type_equipement", $this->etat_type_equipement);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}


function readOne(){



    // query to read single record
    $query = "SELECT * FROM " . $this->table_name . "  WHERE  id_type_equipement = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // set values to object properties
    $this->id_type_equipement = $row['id_type_equipement'];
    $this->libelle_type_equipement = $row['libelle_type_equipement'];
    $this->etat_type_equipement = $row['etat_type_equipement'];
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

    // update query
    $query = "DELETE FROM
                " . $this->table_name . "

            WHERE
                id_batiments = ?";




    // prepare query statement


    try
    {
        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$_GET['id']]);

        $this->conn->commit();
        return true;

    } catch (PDOException $e)
    {
      $this->conn->rollBack();
      return false;
    }



}




}
