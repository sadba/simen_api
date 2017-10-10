<?php
class Batiment{

    // database connection and table name
    private $conn;
    private $table_name = "ephy_batiments";

    // object properties
    public $id_batiments;
    public $id_type_batiments;
    public $code_batiments;
    public $libelle_batiments;
    public $code_str;
    public $lat_batiments;
    public $long_batiments;
    public $etat_batiments;

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

include '../codification.php';

  $code_bat = CodificationBatimant($this->code_str, $this->id_type_batiments);

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                id_type_batiments=:id_type_batiments,
                code_batiments=:code_batiments, libelle_batiments=:libelle_batiments,
                 code_str=:code_str, lat_batiments=:lat_batiments, long_batiments=:long_batiments, etat_batiments=:etat_batiments";

    // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":id_type_batiments", $this->id_type_batiments);
    $stmt->bindParam(":code_batiments", $code_bat);
    $stmt->bindParam(":libelle_batiments", $this->libelle_batiments);
    $stmt->bindParam(":code_str", $this->code_str);
    $stmt->bindParam(":lat_batiments", $this->lat_batiments);
    $stmt->bindParam(":long_batiments", $this->long_batiments);
    $stmt->bindParam(":etat_batiments", $this->etat_batiments);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}


function readOne(){



    // query to read single record
    $query = "SELECT * FROM " . $this->table_name . "  WHERE  id_batiments = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);



    // set values to object properties
    $this->id_batiments = $row['id_batiments'];
    $this->id_type_batiments = $row['id_type_batiments'];
    $this->code_batiments = $row['code_batiments'];
    $this->libelle_batiments = $row['libelle_batiments'];
    $this->code_str = $row['code_str'];
    $this->lat_batiments = $row['lat_batiments'];
    $this->long_batiments = $row['long_batiments'];
    $this->etat_batiments = $row['etat_batiments'];
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
    $tab_sane[] = $this->id_batiments;
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

function readEtab(){

    $code_str = $_GET['code_str'];
    // select all query
    $query = "SELECT id_batiments, id_type_batiments, code_batiments, libelle_batiments, COALESCE(lat_batiments,'') lat_batiments, COALESCE(long_batiments,'') long_batiments, etat_batiments FROM " . $this->table_name . " WHERE code_str = ?";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute([$code_str]);

    return $stmt;
}
// 




}
