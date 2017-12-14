<?php
class eleves{

    // database connection and table name
    private $conn;
    private $table_name = "epeda_classe_eleve";
    private $table_name1 = "epeda_dossier_eleve";

    // object properties
    public $code_classe;
    public $code_annee;
    public $code_str;
    public $code_dossier;
    public $annee_entree;
    public $code_section;
    public $motif_entree;
    public $annee_sortie;
    public $distance_etab;
    public $motif_sortie;
    public $exemption_eps;
    public $statut_inscription;
    public $ien_eleves;
    public $id_eleve;
    public $code_statut;
    public $date_inscription;
    public $numero_recu;
    public $date_naissance;
    public $nationalite;
    public $extrait_naissance;
    public $date_extrait;
    public $id_sanguin;
    public $code_classe_eleve;
    public $email_eleve;
    public $id_languemater;
    public $id_orphelin;
    public $id_handicap;
    public $id_maladie;
    public $statut;
    public $date_archive_eleve;





    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function inscriptionEleves(){

        $verif = "SELECT * from epeda_dossier_eleve WHERE id_eleve = '".$this->id_eleve."'
                AND annee_entree = '".$this->code_annee."' AND code_str = '".$this->code_str."'
                AND affectation_classe = '-1'";

        $ens_stmt = $this->conn->prepare($verif);


        if($ens_stmt->execute()){

            $query = "UPDATE
                " . $this->table_name1 . "
            SET
                statut_inscription=:statut_inscription,
                date_inscription=:date_inscription
                WHERE code_str=:code_str AND id_eleve=:id_eleve AND annee_entree=:code_annee";
            // prepare query
            $stmt = $this->conn->prepare($query);



            // bind values
            $stmt->bindParam(":statut_inscription", $this->statut_inscription);
            $stmt->bindParam(":date_inscription", $this->date_inscription);
            $stmt->bindParam(":code_str", $this->code_str);
            $stmt->bindParam(":id_eleve", $this->id_eleve);
            $stmt->bindParam(":code_annee", $this->code_annee);

            //var_dump($this->date_prise_service);
            //die();

            // execute query
            if($stmt->execute()){
                return true;

            }else{
                return false;
            }

        } else {

            $query = "UPDATE
                " . $this->table_name1 . "
            SET
                statut_inscription=:statut_inscription,
                date_inscription=:date_inscription
                WHERE code_str=:code_str AND id_eleve=:id_eleve AND annee_entree=:code_annee";
            // prepare query
            $stmt = $this->conn->prepare($query);



            // bind values
            $stmt->bindParam(":statut_inscription", $this->statut_inscription);
            $stmt->bindParam(":date_inscription", $this->date_inscription);
            $stmt->bindParam(":code_str", $this->code_str);
            $stmt->bindParam(":id_eleve", $this->id_eleve);
            $stmt->bindParam(":code_annee", $this->code_annee);

            //var_dump($this->date_prise_service);
            //die();

            // execute query
            if($stmt->execute()){
                self::reinscriptionEleves();

            }else{
                return false;
            }

        }


    }
    public function reinscriptionEleves(){
        $query = "UPDATE
                " . $this->table_name . "
            SET
                statut_inscription=:statut_inscription,
                date_inscription=:date_inscription,
                numero_recu = :numero_recu
                WHERE code_str=:code_str AND id_eleve=:id_eleve AND code_annee=:code_annee";
        // prepare query
        $stmt = $this->conn->prepare($query);



        // bind values
        $stmt->bindParam(":statut_inscription", $this->statut_inscription);
        $stmt->bindParam(":date_inscription", $this->date_inscription);
        $stmt->bindParam(":code_str", $this->code_str);
        $stmt->bindParam(":numero_recu", $this->numero_recu);
        $stmt->bindParam(":id_eleve", $this->id_eleve);
        $stmt->bindParam(":code_annee", $this->code_annee);

        //var_dump($this->date_prise_service);
        //die();

        // execute query
        if($stmt->execute()){
            return true;

        }else{
            return false;
        }

    }

    public function affectationEleves(){
        $verif = "SELECT * from epeda_dossier_eleve WHERE id_eleve = '".$this->id_eleve."'
                AND annee_entree = '".$this->code_annee."' AND code_str = '".$this->code_str."'
                ";

        $ens_stmt = $this->conn->prepare($verif);


        if($ens_stmt->execute()) {
            $rows = $ens_stmt->fetch(PDO::FETCH_ASSOC);
            $verifclasse = "SELECT * from epeda_classe_eleve WHERE id_eleve = '".$this->id_eleve."'
                AND code_annee = '".$this->code_annee."' ";

            $ens_stmtclasse = $this->conn->prepare($verifclasse);


            if($ens_stmtclasse->execute())
            {
                $query = "UPDATE
                epeda_classe_eleve
            SET


                 code_classe=:code_classe
                 WHERE code_annee=:code_annee AND
                id_eleve=:id_eleve AND
                code_section=:code_section";
                // prepare query
                $stmt = $this->conn->prepare($query);


                // bind values
                $stmt->bindParam(":code_classe", $this->code_classe);
                $stmt->bindParam(":code_annee", $this->code_annee);
                $stmt->bindParam(":id_eleve", $this->id_eleve);
                $stmt->bindParam(":code_section", $this->code_section);


                //var_dump($this->date_prise_service);
                //die();

                // execute query
                if ($stmt->execute()) {
                    return true;

                } else {
                    return false;
                }
            }
            else{
                $query = "INSERT INTO
                epeda_classe_eleve
            SET

                code_annee=:code_annee,
                id_eleve=:id_eleve,
                code_section=:code_section,
                code_classe=:code_classe,
                code_statut=:code_statut,
                statut_inscription=:statut_inscription,
                date_inscription=:date_inscription,
                affectation_classe=:affectation_classe";
                // prepare query
                $stmt = $this->conn->prepare($query);


                // bind values
                $stmt->bindParam(":code_annee", $this->code_annee);
                $stmt->bindParam(":id_eleve", $this->id_eleve);
                $stmt->bindParam(":code_section", $this->code_section);
                $stmt->bindParam(":code_classe", $this->code_classe);
                $stmt->bindParam(":code_statut", $rows['motif_entree']);
                $stmt->bindParam(":statut_inscription", $rows['statut_inscription']);
                $stmt->bindParam(":date_inscription", $rows['date_inscription']);
                $stmt->bindParam(":affectation_classe", $rows['affectation_classe']);

                //var_dump($this->date_prise_service);
                //die();

                // execute query
                if ($stmt->execute()) {
                    return true;

                } else {
                    return false;
                }
            }

        }
        else{
            $query = "UPDATE
                epeda_classe_eleve
            SET


                code_classe=:code_classe
                 WHERE code_annee=:code_annee AND
                id_eleve=:id_eleve AND
                code_section=:code_section";
            // prepare query
            $stmt = $this->conn->prepare($query);


            // bind values
            $stmt->bindParam(":code_classe", $this->code_classe);
            $stmt->bindParam(":code_annee", $this->code_annee);
            $stmt->bindParam(":id_eleve", $this->id_eleve);
            $stmt->bindParam(":code_section", $this->code_section);


            //var_dump($this->date_prise_service);
            //die();

            // execute query
            if ($stmt->execute()) {
                return true;

            } else {
                return false;
            }
        }
    }



}