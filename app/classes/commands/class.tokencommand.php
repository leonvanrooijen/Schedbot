<?php

/**
* 
*/
class TokenCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:Noem me voortaan ",
	  								"contains:Noem mij voortaan ",
	  								"contains:Noem me ",
									"contains:Noem mij ");

		$name = parent::validate($this->verify_rules, $this->message);

		if(!$name) 
			return false;

		self::proceed($name);


	}

	protected function proceed($name)
	{
		$user = new Users($this->chat_id);
		$user->setNickname($name);
		$user->save();
	}
}

