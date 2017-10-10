<?php  

class CreateTokenCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:createtoken ");

		$token = parent::validate($this->verify_rules, $this->message);

		if(!$token) 
			return false;

		self::proceed($token);


	}

	protected function proceed($token)
	{

		$user = new Users($this->chat_id);
		
		$arguments = explode(" ", $token);

		print_r($arguments);

		if (count($arguments) !== 2) {
			$user->sendMessage("Je moet formeel en de naam allebei invullen!");
			return false;
		}

		$activationToken = sprintf("%06d", mt_rand(1, 999999));

		$handler = new ActivationTokens($activationToken);

		if ($handler->exists())
			new CreateTokenCommand($user->getChatId(), $userInput["message"]["text"]);
		

		$handler->setFormal($arguments[0]);
		$handler->setComment($arguments[1]);
		$handler->setExpire(time() + 3600*48);
		$handler->save();

		$user->sendMessage("Gelukt, de nieuwe token is: <b>sb" . $activationToken . "</b> Deze code is 48 uur geldig.", true);

		return true;
		
	}
}

?>