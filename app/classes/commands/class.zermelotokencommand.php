<?php

/**
* 
*/
class ZermeloTokenCommand extends ActionHandler
{
	private $chat_id, $token, $verify_rules;
	
	function __construct($chat_id, $token)
	{

		$this->chat_id = $chat_id;
		$this->token = $token;

		if(empty($token)) 
			return false;

		self::proceed($token);


	}

	protected function proceed($token)
	{
		$user = new Users($this->chat_id);
		$zermelo = new Zermelo;

		$token = str_replace(" ", "", $token);

		if ($authCode = $zermelo->createToken($user->getTenant(), $token)) {
			
			$user->setClientToken($authCode);
			$user->setStatus("3");
			$user->save();

			$user->sendMessage("Top, nu ben je er helemaal klaar voor! Je ontvangt vanaf nu notificaties over je rooster. Typ help voor meer informatie.");

			return true;

		}

		$user->sendMessage("Onjuiste koppelcode.");
		return false;
		
	}
}

