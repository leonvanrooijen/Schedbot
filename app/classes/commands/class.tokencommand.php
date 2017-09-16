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
		$this->verify_rules = array("contains:sb");

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

			if(!empty($activationToken->getChatId()))
			{
				$user->sendMessage("Deze activatiecode is al verzilverd.");
				return false;
			}



			$activationToken->setChatId($this->chat_id);
			$activationToken->save();

			$user->setFormal($activationToken->getFormal());
			$user->setStatus("1");
			$user->setNickname("naamloos");
			$user->save();

			$user->sendMessage("Perfect! Je activatiecode is succesvol verzilverd. Wat is de afkorting van jouw school op zermelo? Bijvoorbeeld: gsf (tip: afkorting.zportal.nl)");

			return true;
		}

		$user->sendMessage("Onjuiste activatiecode.");
		return false;
		
	}
}

