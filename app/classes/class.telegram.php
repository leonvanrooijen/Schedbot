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

	public function sendMessage($chat_id, $message, $html = false)
	{
        if ($html == "html") {
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . rawurlencode($message) . "&html=html");
        }else{
        	return file_get_contents("https://api.telegram.org/bot" . $this->token . "/sendMessage?chat_id=" . $chat_id . "&text=" . rawurlencode($message));
        }

		
	}
}

?>