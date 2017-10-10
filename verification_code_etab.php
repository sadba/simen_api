<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection


// instantiate batiment object
include_once 'objects/verif_code.php';




// get posted data
$data = json_decode(file_get_contents("php://input"));

// set batiment property values
$code_str = $data->code_str;



    

if(verif_cle($code_str) == true){
	if (code_exists($code_str) == true) {
		$data = array('code' => '0',
                  'message' => 'Le code existe');

		echo json_encode($data);
     
	}
	else{
		$data = array('code' => '1',
                  'message' => 'Le code existe pas dans la base');
		echo json_encode($data);
	}
    
}
// if unable to create the batiment, tell the user
else{
    $data = array('code' => '1',
                  'message' => 'code invalide');

     echo json_encode($data);
}
    

