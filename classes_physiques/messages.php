<?php

class Message{
	public function Param_message($message)
	{
		$data = array(
      'code' => '0',
      'message' => "$message"
  );
    echo json_encode($data);
	}


	public function message_equipement(){

		self::Param_message("Supprimer d'abord Equipement");
	}

	public function messages_salles(){
		self::Param_message("Supprimer d'abord les salles liees aux classes pedagogiques");

	}
}