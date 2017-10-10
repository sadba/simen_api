<?php
class classes_peda{

    // database connection and table name
    private $conn;
    private $table_name = "epeda_classe_pedagogique";

    // object properties
    public $code_classe;
    public $code_type_serie;
    public $code_section;
    public $libelle_classe;
    public $annee_entree;
    public $annee_fin = '9999';
    public $id_classe_physique;




    

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function delete()
{
    //$args = func_get_args();

   // $this->classepedagogique->code_classe = $args[0];
   // echo json_encode($this->classepedagogique->delete(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    $id_classe = $this->code_classe;

    $anss= "Select * from param_annee_scolaire where etat_en_cours='1'";

    $ans_stmt=$this->conn->prepare($anss);

    $ans_stmt->execute();

    $row=$ans_stmt->fetch(PDO::FETCH_ASSOC);
    $ans=$row['annee_cours'];
    $sql = $this->conn->prepare("SELECT * FROM epeda_classe_pedagogique  as f
			WHERE  f.code_classe ='$id_classe'
			");
    $sql->execute();


    $ty=$ans_stmt->fetch(PDO::FETCH_ASSOC);

    if(($ty['annee_entree']==$ans) && ($ty['annee_fin']=='9999'))
    {
        $sql1 = $this->conn->prepare("SELECT * FROM epeda_classe_eleve where code_classe='$id_classe'");

        $sql1->execute();


        if($sql1->rowCount() == true)
        {
            $data = array('code' => '1',
                'message' => 'la classe contient des eleves');

            echo json_encode($data);
        }
        else
        {
            $sql1= $this->conn->prepare("DELETE * from epeda_classe_sallefixe WHERE code_classe='$id_classe'");


            if ($sql1->execute()) {


                $sql2=$this->conn->prepare("DELETE * from epeda_classe_pedagogique WHERE code_classe='$id_classe'");

                if ($sql2->execute()) {

                    $data = array('code' => '0',
                        'message' => 'La classe est supprimer');

                    echo json_encode($data);
                }
                else
                {
                    $data = array('code' => '0',
                        'message' => 'Impossible de supprimer');

                    echo json_encode($data);
                }
            }
        }
    }
    elseif(($ty['annee_entree']!=$ans) && ($ty['annee_fin']=='9999'))
    {
        $sql3=$this->conn->prepare("UPDATE epeda_classe_pedagogique SET annee_fin='$ans' WHERE code_classe='$id_classe'");

        if ($sql3->execute()) {


            $sql4=$this->conn->prepare("UPDATE epeda_classe_sallefixe SET  sal_annee_archive='$ans' WHERE code_classe='$id_classe' AND sal_annee_archive='9999'");

            if ($sql4->execute()) {

                $data = array('code' => '0',
                    'message' => 'Impossible de supprimer');

                echo json_encode($data);
            }
            else
            {
                $data = array('code' => '0',
                    'message' => 'Impossible de supprimer');

                echo json_encode($data);
            }
        }

    }

}

    function save()
    {
        $id_classe_peda = $this->code_classe;
        $id_serie = $this-code_type_serie;
        $id_niveau = $this->code_section;
        $libelle = $this->libelle_classe;
        $id_salle = $this->id_classe_physique;
    // Recupere l'annee encours
    $ans= "Select * from param_annee_scolaire where etat_en_cours='1'";

    $ans_stmt=$this->conn->prepare($ans);

    $ans_stmt->execute();

    $row=$ans_stmt->fetch(PDO::FETCH_ASSOC);

    $tyr= $this->conn->prepare("SELECT * FROM  epeda_classe_pedagogique where code_classe='$id_classe_peda'");
    $sqlcla1=$tyr->execute();

    $rowh=$tyr->fetch(PDO::FETCH_ASSOC);

    if(($rowh['annee_entree']==$row['anne_cours']) && ( $rowh['annee_fin']=='9999'))
    {

        $arch=$this->conn->prepare("UPDATE epeda_classe_pedagogique SET
        code_type_serie='$id_serie',
        code_section='$id_niveau',
        libelle_classe='$libelle'
       WHERE code_classe='$id_classe_peda'");
        $arch->execute();

        $sql = $this->conn->prepare("SELECT * FROM epeda_classe_sallefixe where code_classe='$id_classe_peda' and sal_annee_config<='".$row['anne_cours']."'");
        $sql1=$sql->execute();
        if($sql1->rowCount()==true)
        {
            // verifier si la classe physique n'est pas postee
            if($id_salle== '')
            {
                //On met a jour annee_archive par l'annee en cours

                $arch=$this->conn->prepare("UPDATE epeda_classe_sallefixe SET sal_annee_archive='".$row['anne_cours']."' WHERE code_classe='$id_classe_peda' AND sal_annee_archive='9999'");
                $arch->execute();

            }
            else
            {
                // Verifie si la classe pedagogique possede une salle fixe
                //$effet=$this->Classe_fixe->get_db_table_by_code_classe($this->input->post('code_classe'));
                $verif = $this->conn->prepare("SELECT * FROM epeda_classe_sallefixe where code_classe='$id_classe_peda'");
                $query = $verif->execute();
                $effet=$query->fetch(PDO::FETCH_ASSOC);
                if(($effet['sal_annee_config']==$row['anne_cours']) && ($effet['sal_annee_archive']==9999))
                {
                    // Si oui

                    $rt = $this->conn->prepare("UPDATE epeda_classe_sallefixe SET id_classe_physique=? WHERE code_classe='$id_classe_peda'  AND sal_annee_archive='9999'");
                    $rt->execute();
                }
                elseif(($effet['sal_annee_config']==$row['anne_cours']) && ($effet['sal_annee_archive']==$row['anne_cours']))
                {

                    $rt = $this->conn->prepare("UPDATE epeda_classe_sallefixe SET sal_annee_archive='9999' WHERE code_classe='$id_classe_peda'  AND sal_annee_config='".$row['anne_cours']."'");
                    $rt->execute();
                }
                else
                {
                    $sql = $this->conn->prepare("SELECT * FROM epeda_classe_sallefixe where code_classe='$id_classe_peda' and sal_annee_config<='9999'");

                    if($sql->execute())
                    {
                        $rt = $this->conn->prepare("UPDATE epeda_classe_sallefixe SET sal_annee_archive='9999' WHERE code_classe='$id_classe_peda'  AND sal_annee_config='".$row['anne_cours']."'");
                        if($rt->execute())
                        {
                            $rtin = $this->conn->prepare("INSERT INTO  epeda_classe_sallefixe SET
                                    id_classe_sallefixe = null,
                                    code_classe='$id_classe_peda',
                                    id_classe_physique = '$id_salle',
                                    sal_annee_config = '".$row['anne_cours']."',
                                    sal_annee_archive ='9999'
                                     ");
                            $rtin->execute();
                        }

                    }
                    else
                    {
                        $rtin = $this->conn->prepare("INSERT INTO  epeda_classe_sallefixe SET
                                    id_classe_sallefixe = null,
                                    code_classe='$id_classe_peda',
                                    id_classe_physique = '$id_salle',
                                    sal_annee_config = '".$row['anne_cours']."',
                                    sal_annee_archive ='9999'
                                     ");
                        $rtin->execute();
                    }


                }

            }
        }
        else
        {
            if($id_salle == '')
            {

            }
            else
            {
                $rtin = $this->conn->prepare("INSERT INTO  epeda_classe_sallefixe SET
                                    id_classe_sallefixe = null,
                                    code_classe='$id_classe_peda',
                                    id_classe_physique = '$id_salle',
                                    sal_annee_config = '".$row['anne_cours']."',
                                    sal_annee_archive ='9999'
                                     ");
                $rtin->execute();
            }
        }
    }
    elseif(($rowh['annee_entree'] != $row['anne_cours']) && ( $rowh['annee_fin']=='9999'))
    {
       
        $rt = $this->conn->prepare("UPDATE epeda_classe_pedagogique SET annee_fin='9999' WHERE code_classe='$id_classe_peda'");
        if($rt->execute())
        {
            
            $arch = $this->conn->prepare("UPDATE epeda_classe_pedagogique SET
        code_type_serie='$id_serie',
        code_section='$id_niveau',
        libelle_classe='$libelle'
       WHERE code_classe='$id_classe_peda'");
            $arch->execute();
            $code=$this->conn->lastInsertId();
            if($id_salle!= '')
            {
                $sql = $this->conn->prepare("SELECT * FROM epeda_classe_sallefixe where code_classe='$id_classe_peda' and sal_annee_config<='".$row['anne_cours']."'");
                //$sql1=$sql->execute();
                if($sql->rowCount()==true)
                {
                    $rt = $this->conn->prepare("UPDATE epeda_classe_sallefixe SET sal_annee_archive='9999' WHERE code_classe='$id_classe_peda'");
                }

                if($rt->execute())
                {
                    $rtin = $this->conn->prepare("INSERT INTO  epeda_classe_sallefixe SET
                                    id_classe_sallefixe = null,
                                    code_classe='$code',
                                    id_classe_physique = '$id_salle',
                                    sal_annee_config = '".$row['anne_cours']."',
                                    sal_annee_archive ='9999'
                                     ");
                    $rtin->execute();
                }
            }

        }
    }

    return true;



}

    public function postClasse(){

        $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";

    // prepare query statement
    $ans_stmt = $this->conn->prepare($ans);

    // bind id of product to be updated
    // $ans_stmt->bindParam(1, "1");

    // execute query
    $ans_stmt->execute();

    // get retrieved row
    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);

    $ens = "SELECT libelle_classe FROM " . $this->table_name . "  WHERE  code_str = '".$this->code_str."' AND 
            libelle_classe = '".$this->libelle_classe."' AND code_section = '".$this->code_section."'";

    // prepare query statement
    $ens_stmt = $this->conn->prepare($ens);

    // bind id of product to be updated
    // $ans_stmt->bindParam(1, "1");

    // execute query
    $ens_stmt->execute();

    // get retrieved row
    $rowens = $ens_stmt->rowCount();

    if ($rowens == true) {
        return false;
    } else {
        $query = "INSERT INTO  
                " . $this->table_name . "
            SET
                code_type_serie=:code_type_serie,
                code_section =:code_section,
                code_str=:code_str,
                libelle_classe=:libelle_classe,
                annee_entree=:annee_entree,
                annee_fin=:annee_fin
                ";
      // prepare query
    $stmt = $this->conn->prepare($query);



    // bind value

    $stmt->bindParam(":code_type_serie", $this->code_type_serie);
    $stmt->bindParam(":code_section", $this->code_section);
    $stmt->bindParam(":code_str", $this->code_str);
    $stmt->bindParam(":libelle_classe", $this->libelle_classe);
    $stmt->bindParam(":annee_entree", $row['annee_cours']);
    $stmt->bindParam(":annee_fin", $this->annee_fin);

       // var_dump($stmt);
    //die();

    // execute query
    if($stmt->execute()){
        if($this->id_classe_physique!='')
        {
            $id = $this->conn->lastInsertId();
            $query1 = "INSERT INTO
                epeda_classe_sallefixe
            SET
                id_classe_physique=:id_classe_physique,
                code_classe =:code_classe,
                sal_annee_config=:sal_annee_config,
                sal_annee_archive=:sal_annee_archive
                ";
            // prepare query
            $stmt1 = $this->conn->prepare($query1);



            // bind values
            $stmt1->bindParam(":id_classe_physique", $this->id_classe_physique);
            $stmt1->bindParam(":code_classe", $id);
            $stmt1->bindParam(":sal_annee_config", $row['annee_cours']);
            $stmt1->bindParam(":sal_annee_archive", $this->annee_fin);

            $stmt1->execute();
            if ($stmt1->execute()) {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }

    }
    else{
        return false;
    }
    }
}


    public function deleteClasse(){

    $ans = "SELECT * FROM param_annee_scolaire  WHERE  etat_en_cours = '1'";
    $ans_stmt = $this->conn->prepare($ans);
    $ans_stmt->execute();

    $row = $ans_stmt->fetch(PDO::FETCH_ASSOC);



    }
}
