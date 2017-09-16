<?php  

/**
* This class handles activation tokens
token, formal, expires, chat_id
*/
class ActivationTokens
{
	private $formal, $expires, $chat_id;
	private $token, $exists;

	function __construct($token)
	{
		$this->token = $token;
		$db = new Database;
		$result = $db->getResult("SELECT * FROM activation_tokens WHERE token = :token"
			, array(":token"), array($this->token));

		if ($result)
			$this->exists = true;
		
	}

	public function getToken()
	{
		$db = new Database;
		$result = $db->getResult("SELECT token FROM activation_tokens WHERE ");
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

	public function getFormal()
	{
		return $this->formal;
	}

	public function getExpire()
	{
		return $this->expires;
	}

	public function getChatId()
	{
		return $this->chat_id;
	}

	public function save()
	{
		$db = new Database;
		$db->performQuery("UPDATE activation_tokens
			SET token = :token, formal = :formal, expires = :expires, chat_id = :chat_id
			WHERE token = :oldtoken",
			array(":token",":formal",":expires",":chat_id", ":oldtoken"),
			array($this->token));
	}

	public function check()
	{
		return $this->exists;
	}


}

?>