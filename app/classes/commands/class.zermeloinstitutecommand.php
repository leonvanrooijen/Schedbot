<?php

/**
* 
*/
class ZermeloInstituteCommand extends ActionHandler
{
	private $chat_id, $institute, $verify_rules;
	
	function __construct($chat_id, $institute)
	{

		$this->chat_id = $chat_id;
		$this->institute = $institute;

		if(empty($institute)) 
			return false;

		self::proceed($institute);


	}

	protected function proceed($institute)
	{
		$user = new Users($this->chat_id);
		$zermelo = new Zermelo;

		if ($zermelo->checkTenant(strtolower($institute))) {

			$user->setTenant(strtolower($institute));
			$user->setStatus("2");
			$user->save();

			$user->sendMessage("Top! Je school is ingesteld. Wat is je koppelcode? Tip: dezelfde code om de app te koppelen!");

			return true;
		}

		$user->sendMessage("Onjuiste school.");
		return false;
		
	}
}

