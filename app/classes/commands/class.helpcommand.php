<?php

/**
* 
*/
class HelpCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:help",
									"contains:hulp"
									);

		$help = parent::validate($this->verify_rules, $this->message);

		if(!is_string($help)) {					
			return false;
		}

		self::proceed();


	}

	protected function proceed()
	{
		$user = new Users($this->chat_id);
		
		switch ($user->getRank()) {
			case '1':
				$user->sendMessage(
					"<b>Hoe werkt SchedBot?</b>\nSchedBot stuurt je een berichtje vlak voordat je naar de volgende les moet. Daarnaast krijg je berichten die aangeven welke boeken je mee moet nemen. De bot reageert op gewone zinnen. Als jij iets aan de bot vraagt zal hij gewoon antwoorden.\n\nEen voorbeeld vraag is:\nNoem mij Koning
					",
					true);	
				break;
			
			case '2':
				$user->sendMessage(
					"<b>Hoe werkt SchedBot?</b>\nGast, je bent een moderator. je weet echt wel hoe dit werkt. :)
					",
					true);
				break;

			case '3':
				$user->sendMessage(
					"<b>Hoe werkt SchedBot?</b>\nGozer, je bent een admin. je weet echt wel hoe dit werkt. :)
					",
					true);
				break;
		}

							
	}

}

