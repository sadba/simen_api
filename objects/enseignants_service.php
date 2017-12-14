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
    public $id_option;
    public $code_option;
    public $code_type_serie;
    public $libelle_option;
    public $etat_option;
    public $id_option_discipline;
    public $annee_config;
    public $annee_archive;
    public $id_discipline;
    public $id_contenu;
    public $id_contenu_str;
    public $coefficient;
    public $credit_horaire;
    public $etat_contenu_str;
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

        if($stmt1->execute()){
            return true;

        }else{
            return false;
        }
    }

    public function sad(){



        $query = "INSERT INTO epeda_option
                SET
                code_section = :code_section,
                code_type_serie = :code_type_serie,
                libelle_option = :libelle_option,
                code_option = :code_option,
                code_str = :code_str,
                etat_option = :etat_option";

        $stmt = $this->conn->prepare($query);



        // bind values
        $stmt->bindParam(":code_section", $this->code_section);
        $stmt->bindParam(":code_type_serie", $this->code_type_serie);
        $stmt->bindParam(":libelle_option", $this->libelle_option);
        $stmt->bindParam(":code_option", $this->code_option);
        $stmt->bindParam(":code_str", $this->code_str);
        $stmt->bindParam(":etat_option", $this->etat_option);

        if($stmt->execute()){
            return true;

        }else{
            return false;
        }

    }

    public function postDiscipline(){

                $query1 = "INSERT INTO
                epeda_option_discipline
            SET
                id_option_discipline = :id_option_discipline,
                id_discipline = :id_discipline,
                id_option = :id_option,
                annee_config = :annee_config,
                annee_archive = :annee_archive


                ";

                $stmt1 = $this->conn->prepare($query1);

                $stmt1->bindParam(":id_option_discipline", $this->id_option_discipline);
                $stmt1->bindParam(":id_discipline", $this->id_discipline);
                $stmt1->bindParam(":id_option", $this->id_option);
                $stmt1->bindParam(":annee_config", $this->annee_config);
                $stmt1->bindParam(":annee_archive", $this->annee_archive);


        if($stmt1->execute()){
            return true;

        }else{
            return false;
        }
            }


    public function postDisprogramme(){

        $query = "INSERT INTO epeda_programmes_contenu_structure
                SET

                id_contenu = '".$this->id_contenu."',
                code_str = '".$this->code_str."',
                id_discipline = '".$this->id_discipline."',
                coefficient = '".$this->coefficient."',
                credit_horaire='".$this->credit_horaire."',
                code_annee='".$this->code_annee."',
                etat_contenu_str='".$this->etat_contenu_str."'";

        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;

        }else{
            return false;
        }

    }


    public function postOption(){

        $query = "INSERT INTO epeda_programmes_contenu_structure
                SET

                id_contenu = '".$this->id_contenu."',
                code_str = '".$this->code_str."',
                id_option = '".$this->id_option."',
                coefficient = '".$this->coefficient."',
                credit_horaire='".$this->credit_horaire."',
                code_annee='".$this->code_annee."',
                etat_contenu_str='".$this->etat_contenu_str."'";

        $stmt = $this->conn->prepare($query);

        if($stmt->execute()){
            return true;

        }else{
            return false;
        }

    }

}