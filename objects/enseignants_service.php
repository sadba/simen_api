<?php
class enseignants_service{

    // database connection and table name
    private $conn;
    private $table_name = "epad_enseignants_structure";

    // object properties
    public $id_enseignant_structure;
    public $date_prise_service;
    public $code_str;
    public $code_annee;
    public $numero_os;
    public $ien;
    public $date_os;
    public $etat_prise = '1';

    public $code_me;



    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function postService(){

        $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";

    // prepare query statement
    $ans_stmt = $this->conn->prepare($ans);

    // bind id of product to be updated
    // $ans_stmt->bindParam(1, "1");

    // execute query
    $ans_stmt->execute();

    // get retrieved row
    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);

    $ens = "SELECT id_ens FROM epeda_personnel_etablissement  WHERE  ien_ens = '".$this->ien."'";

    // prepare query statement
    $ens_stmt = $this->conn->prepare($ens);

    // bind id of product to be updated
    // $ans_stmt->bindParam(1, "1");

    // execute query
    $ens_stmt->execute();

    // get retrieved row
    $rowens = $ens_stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($row['annee_cours']);
        //die();
        $query = "UPDATE 
                " . $this->table_name . "
            SET
                date_prise_service=:date_prise_service,
                etat_prise=:etat_prise
                WHERE code_str=:code_str AND id_ens=:id_ens AND annee_entree_str=:annee_entree_str";
      // prepare query
    $stmt = $this->conn->prepare($query);



    // bind values
    $stmt->bindParam(":date_prise_service", $this->date_prise_service);
    $stmt->bindParam(":etat_prise", $this->etat_prise);
    $stmt->bindParam(":code_str", $this->code_str);
    $stmt->bindParam(":id_ens", $rowens['id_ens']);
    $stmt->bindParam(":annee_entree_str", $row['annee_cours']);
 
    //var_dump($this->date_prise_service);
    //die();

    // execute query
    if($stmt->execute()){
        return true;

    }else{
        return false;
    }
    }


    function postAffectation(){


        $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";


        $ans_stmt = $this->conn->prepare($ans);
        $ans_stmt->execute();
        $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);

        $ens = "INSERT into epeda_enseignants_discipline_classe SET
                id_me = NULL,
                code_classe='".$this->code_classe."',
                code_me = '".$this->code_me."',
                id_ens='".$this->id_ens."',
                id_discipline='".$this->id_discipline."',
                code_str='".$this->code_str."',
                code_annee='".$row['annee_cours']."'
                ";

        $stmt1 = $this->conn->prepare($ens);





        // bind values

        /*$ens_stmt->bindParam(":code_classe", $this->code_classe);
        $ens_stmt->bindParam(":id_ens", $this->id_ens);
        $ens_stmt->bindParam(":code_me", $this->code_me);
        $ens_stmt->bindParam(":id_discipline", $this->id_discipline);
        $ens_stmt->bindParam(":code_str", $this->code_str);
        $ens_stmt->bindParam(":code_annee", $row['annee_cours']);
        echo $row['annee_cours']."-".$this->code_classe."-".$this->id_ens."-".$this->id_discipline."-".$this->code_str;
        //die();*/

        if($stmt1->execute()){
            return true;

        }else{
            return false;
        }
    }

    function postOption(){

    }

}