<?php  

/**
* This class handles activation tokens
token, formal, expires, chat_id
*/
class ActivationTokens
{
	private $formal, $expires, $chat_id;
	private $token;

	function __construct($token)
	{
		$this->token = $token;
	}

	public function setFormal($formal)
	{
		$this->formal = $formal;
	}

	public function setExpire($expires)
	{
		$this->expires = $expires;
	}

	public function setChatId($chat_id)
	{
		$this->chat_id = $chat_id;
	}

	
}

?>