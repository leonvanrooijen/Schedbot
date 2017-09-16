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
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . rawurlencode($message) . "&parse_mode=" . $parse_mode);
        }else{
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . rawurlencode($message));
        }

		
	}
}

?>