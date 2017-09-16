<?php

/**
* 
*/
class AdminCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:/admin");

		$admin = parent::validate($this->verify_rules, $this->message);

		if(!is_string($admin)) {
			return false;
		}

		self::proceed($admin);


	}

	protected function proceed($admin)
	{
		$user = new Users($this->chat_id);
		$db = new Database;
		
		if(empty($admin)){
			$user->sendMessage("<b>Voer een gebruiker in!</b>", true);
			return false;
		}

		if ($user->getAdmin == 1){
			
			$user->sendMessage($admin . " is nu geen admin meer.");
		}

		if ($user->getAdmin == 0) {
			$results = $db->performQuery("UPDATE users SET admin = 1 users WHERE nickname = :nickname", array(":nickname"), array($admin));
			$user->sendMessage($admin . " is nu een admin. :)");
		}

		
		
	}
}

