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
		$this->verify_rules = array("contains:/lockdown");

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

		$lockdown = $db->getResult("SELECT value FROM settings WHERE setting = :setting",
		array(":setting"), array("lockdown"));

		if($lockdown && $lockdown[0]["value"] == "0")
		{
		
			if(empty($alert)){
				$user->sendMessage("<b>Voer een bericht in!</b>", true);
				return false;
			}

			$db->performQuery("UPDATE settings SET value = :value WHERE setting = :setting",
			array(":value", ":setting"),
			array("1", "lockdown"));
			$user->sendMessage("Lockdownmodus aangezet");

			$receivers = $db->getResult("SELECT chat_id FROM users WHERE status >= :status", array(":status"), array(0));
			foreach ($receivers as $receiver) {
				$receiver = new Users($receiver["chat_id"]);
				$receiver->sendMessage("<b>Lockdownmodus staan nu aan.</b> Dit betekent dat het volledige systeem is uitgeschakeld. Je kunt dus <b>geen</b> commando's meer uitvoeren. Ook krijg je jouw rooster niet meer doorgestuurd. De opgegeven reden hiervoor is:" . $alert, true);
			}

			return true;
		}

		$db->performQuery("UPDATE settings SET value = :value WHERE setting = :setting",
		array(":value", ":setting"),
		array("0", "lockdown"));

		$user->sendMessage("Lockdownmodus uitgezet");

		$receivers = $db->getResult("SELECT chat_id FROM users WHERE status >= :status", array(":status"), array(0));
		foreach ($receivers as $receiver) {
			$receiver = new Users($receiver["chat_id"]);
			$receiver->sendMessage("<b>Lockdownmodus staan nu uit.</b> Je krijgt weer roosternotificaties en je kunt weer commando's uitvoeren.", true);
		}

		return true;

	}
	
}

