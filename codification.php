<?php

include_once 'config/database.php';

// instantiate database and product object

function codeAleatoire($car)
{
    $string = "";
    $chaine = "2643789ABDCEFGHJKMNPRTUVW";
    srand((double)microtime()*1000000);
    for($i=0; $i<$car; $i++)
    {
        $string .= $chaine[rand()%strlen($chaine)];
    }
    return $string;
}

function CodificationBatimant($code,$type) {
    $database = new Database();
    $conn = $database->getConnection();

  //$conn = new PDO('mysql:host=localhost;dbname=planete', 'root', 'root');
  $string=$type.codeAleatoire(2);

  $query = "SELECT * FROM batiments WHERE code_batiments = '$string'";

  // prepare query statement
  $stmt = $conn->prepare($query);

  // execute query
  $stmt->execute();
    //verfication existance du code dans la base
    if($stmt->rowCount() == TRUE)
    {
        CodificationBatimant($code,$type);
    }
    else
    {
        return $string;
    }

}


function CodificationClassephy($code_str,$codebatiment) {
    //$conn = new PDO('mysql:host=localhost;dbname=planete', 'root', 'root');
    $database = new Database();
    $conn = $database->getConnection();
    $string=$codebatiment.codeAleatoire(2);

    $query = "SELECT * FROM ephy_classe_physique WHERE code_classe_physique = '$string'";

    // prepare query statement
    $stmt = $conn->prepare($query);

    // execute query
    $stmt->execute();
      //verfication existance du code dans la base

    //verfication existance du code dans la base
    if($stmt->rowCount() == TRUE)
    {
        CodificationClassephy($code_str,$codebatiment);
    }
    else
    {
        return $string;
    }

}

