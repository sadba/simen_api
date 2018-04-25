<?php 
	

	




 function verif_cle($code)
{	
	// $niv	 	= substr($code, 0, 1);
	// $type 		= substr($code, 9, 1);
	
	
	////Verification niveau & type
	if(valid_niv_type($code))
	{
		$niv_type 		= substr($code, 0, 1).substr($code, 9, 1);
		$cle			= substr($code, 1, 1);
		$alea2			= $niv_type.substr($code, 2, 7);
			

		//Recuperation des valeur paire du chiffre généré
		//$t_pos 	= array();
		$t_pile = array();
		$somme 	= 0; //Contiendra la sommes des positions paires et impaires
		$j 		= 0; ///Increment pour le tableau $t_secret[]

		$t_secret = secret();

		for($i=0; $i<9; $i++)
		{
			if($i % 2 != 0 and $j<4) ///Traitement des positions imppaires
			{
				if(($t_secret[$j] * substr($alea2, $i, 1)) == 0)  ///Si produit = 0 alors on effecte 9
				{
					$t_pile[] 	= 9;
					$somme		= $somme + 9;
				}elseif($t_secret[$j] * substr($alea2, $i, 1) > 9) //Si produit supp 9 alors somme des chiffres
				{
					$supp9 		= $t_secret[$j] * substr($alea2, $i, 1); 
					$t_pile[] 	= substr($supp9, 0, 1) + substr($supp9, 1, 1);
					$somme		= $somme + substr($supp9, 0, 1) + substr($supp9, 1, 1);
				}
				else
				{
					$t_pile[] 	= $t_secret[$j] * substr($alea2, $i, 1);
					$somme		= $somme +  ($t_secret[$j] * substr($alea2, $i, 1));
				}
				$j++;
				
			}else ///Traitement des positions paires + position 0
			{
				$t_pile[] 	= substr($alea2, $i, 1);
				$somme		= $somme + substr($alea2, $i, 1);
			}
		}
		
		//Calcul de la clé en modulo 10
		$cle_cal = $somme % 10;
		///Si clé du code diff clé calculée alors code invalide
		if($cle_cal != $cle)
		{
			return false;
		}else
		{
			return true;
		}
		
	}else
	{
		return false;
	}
}

function valid_niv_type($code)
{
	$t_combine = array('1-0', '2-0', '3-1', '3-2');
	$niveau	= substr($code, 0, 1);
	$type = substr($code, 9, 1);

	if(in_array("$niveau-$type", $t_combine))
	{
		return true;
	}else
	{
		return false;
	}
	
}

function secret(){
	return array(5,9,7,5);	
}

function code_exists($code)
{

	$host = "192.168.2.142";
	$db = "planete";
	$user = "simen_planete";
	$pwd = "passer@123";

	try
	{
	 $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch(Exception $e)
	{
	echo 'Erreur : '.$e->getMessage();
	exit();
	} 


$sql = "SELECT * FROM cod_structure WHERE CODE_ADMINISTRATIF = ?";

$query = $pdo->prepare($sql);

$query->execute(array($code));
//$exce=$query;
if($query->rowCount() > 0)
{
return true;
}else
{
return false;
}
}