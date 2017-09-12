<?php  


/**
* This class will handle all the connections with the telegram api.
*/
class Telegram 
{
	
	private $token;

	function __construct($token)
	{
		$this->token = $token;
	}

	public function sendMessage($chat_id, $message, $parse_mode = false)
	{
        if ($parse_mode) {
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message . "&parse_mode=" . $parse_mode);
        }else{
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message);
        }

		
	}
}

$telegram = new Telegram("426100951:AAEQ4KppIrxy-4sFAqLOXBeIrYp4zx3zZEY");
$telegram->sendMessage("388542675", "<b>Hoi</b>", "HTML")

?>