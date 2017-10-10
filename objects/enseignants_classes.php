<?php
class enseignants_classes{

    // database connection and table name
    private $conn;
    private $table_name = "epeda_enseignants_discipline_classe";

    // object properties
    public $code_classe;
    public $id_ens;
    public $id_discipline;
    public $code_str;
    public $code_annee;


    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function postEnseignant(){

        $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";

    // prepare query statement
    $ans_stmt = $this->conn->prepare($ans);

    // bind id of product to be updated
    // $ans_stmt->bindParam(1, "1");

    // execute query
    $ans_stmt->execute();

    // get retrieved row
    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);


        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                code_classe=:code_classe,
                id_ens=:id_ens,
                id_discipline=:id_discipline,
                code_str=:code_str,
                code_annee=:code_annee";
      // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":code_classe", $this->code_classe);
    $stmt->bindParam(":id_ens", $this->id_ens);
    $stmt->bindParam(":id_discipline", $this->id_discipline);
    $stmt->bindParam(":code_str", $this->code_str);
    $stmt->bindParam(":code_annee", $row['annee_cours']);
 
    
   
    // execute query
    if($stmt->execute()){
        return true;

    }else{
        return false;
    }
    }
}