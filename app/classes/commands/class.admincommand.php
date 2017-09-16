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
		$this->verify_rules = array("contains:/admin ");

		$admin = parent::validate($this->verify_rules, $this->message);

		if(!is_string($admin)) {
			return false;
		}

		self::proceed($admin);


	}

	protected function proceed($admin)
	{
		$userMe = new Users($this->chat_id);
		$victim = new Users(getUserInfo($admin));
		$db = new Database;
		
		if(empty($admin)){
			$userMe->sendMessage("<b>Voer een gebruiker in!</b>", true);
			return false;
		}

		switch ($victim->getAdmin()) {
			case 0:
				$victim->setAdmin(1);
				$victim->save();
				$victim->sendMessage("U bent gepromoveerd tot administrator!");
				$userMe->sendMessage($admin . " is nu een admin. :)");
				break;

			case 1:
				$victim->setAdmin(0);
				$victim->save();
				$victim->sendMessage("Uw administratieve functie is afgepakt!");
				$userMe->sendMessage($admin . " is nu geen admin meer.");
				break;
			
		}
	
	}
}

