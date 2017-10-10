<?php

/**
* 
*/
class NicknameCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:Noem me voortaan ",
	  								"contains:Noem mij voortaan ",
	  								"contains:Noem me ",
									"contains:Noem mij ",
									"contains:Mijn naam is ",
									"contains:Ik heet ",
									"contains:Ik ben ",
									"contains:M'n naam is ",
									"contains:Mn naam is ",
									"contains:Spreek me aan met ",
									"contains:Spreek mij aan met ",
									"contains:Me naam is ");


		$name = parent::validate($this->verify_rules, $this->message);

		if(!is_string($name)) {
			return false;
		}

		self::proceed($name);


	}

	protected function proceed($name)
	{
		$user = new Users($this->chat_id);
		$user->setNickname($name);
		$user->save();

		switch (rand(1, 4)) {
			case 1:
				$user->sendMessage("Ik heb je nickname aangepast naar '" . $name . "'.");
				break;
			
			case 2:
				$user->sendMessage("Oké, ik noem je vanaf nu '" . $name . "'.");
				break;

			case 3:
				$user->sendMessage("Vanaf nu noem ik je '" . $name . "'.");
				break;	

			case 4:
				$user->sendMessage("'" . $name . "' is jouw nieuwe nickname!");
				break;								
		}
	}
}

