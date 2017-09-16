<?php

/**
* 
*/
class LockdownCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:/alert");

		$alert = parent::validate($this->verify_rules, $this->message);

		if(!is_string($alert)) {
			return false;
		}

		self::proceed($alert);


	}

	protected function proceed($alert)
	{
		$user = new Users($this->chat_id);
		$db = new Database;
		
		if(empty($alert)){
			$user->sendMessage("<b>Voer een bericht in!</b>", true);
			return false;
		}

		$results = $db->getResult("SELECT chat_id FROM users WHERE status >= :status", array(":status"), array(3));
		
		foreach ($results as $result) {
			$receiver = new Users($result["chat_id"]);
			$receiver->sendMessage("<b>Systeemmelding:</b> " . $alert, true);
		}
	}
}

