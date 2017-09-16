<?php

/**
* 
*/
class StartCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:start");

		$start = parent::validate($this->verify_rules, $this->message);

		if(!is_string($start)) {					
			return false;
		}

		self::proceed();


	}

	protected function proceed()
	{
		$user = new Users($this->chat_id);
		$user->sendMessage(
			"<b>Informatie over SchedBOT</b> Beste gebruiker, SchedBOT is een BOT die jou op de hoogte houdt van je rooster. Om te beginnen wil ik graag een activatiecode, deze is aan te vragen bij een administrator.", true);						
	}

}

