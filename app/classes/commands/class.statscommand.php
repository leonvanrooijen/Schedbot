<?php

/**
* 
*/
class StatsCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:stats");

		$stats = parent::validate($this->verify_rules, $this->message);

		if(!is_string($stats)) {					
			return false;
		}

		self::proceed();


	}

	protected function proceed()
	{
		$user = new Users($this->chat_id);
		
		$db = new Database;

		$count = $db->performQuery("SELECT id FROM users WHERE status = 3", array(), array());
		$user->sendMessage("Er zijn: <b>" . $count . "</b> actieve gebruikers!", true);
		
		

							
	}

}

