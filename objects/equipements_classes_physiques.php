<?php
class Equipement_Classes_Physiques{

    // database connection and table name
    private $conn;
    private $table_name = "ephy_equipement_classe_physique";

    // object properties
    public $id_equipement_classe_physique;
    public $id_type_equipement;
    public $id_classe_physique;
    public $nombre_element;

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
    $query = "SELECT * FROM " . $this->table_name . "  WHERE  id_equipement_classe_physique = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // set values to object properties
    $this->id_equipement_classe_physique = $row['id_equipement_classe_physique'];
    $this->id_type_equipement = $row['id_type_equipement'];
    $this->id_classe_physique = $row['id_classe_physique'];
    $this->nombre_element = $row['nombre_element'];
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
                id_equipement_classe_physique = ?";




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

function delete_all($id){

    // update query
    $query = "DELETE FROM
                " . $this->table_name . "

            WHERE
                id_classe_physique = ?";




    // prepare query statement


    try
    {
        $this->conn->beginTransaction();
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);

        $this->conn->commit();
        return true;

    } catch (PDOException $e)
    {
      $this->conn->rollBack();
      return false;
    }



}




}
