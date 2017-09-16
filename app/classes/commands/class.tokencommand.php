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

		$token = parent::validate($this->verify_rules, $this->message);

		if(!$token) 
			return false;

		self::proceed($token);


	}

	protected function proceed($token)
	{
		$user = new Users($this->chat_id);
		$activationToken = new ActivationTokens($token);
		if ($activationToken->check()) {
			$activationToken->setChatId($this->chat_id);
			$user->setFormal($activationToken->getFormal());
			$user->save();
			return true;
		}

		return false;
		
	}
}

