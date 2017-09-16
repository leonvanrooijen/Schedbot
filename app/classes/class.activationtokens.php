<?php  

/**
* This class handles activation tokens
token, formal, expires, chat_id
*/
class ActivationTokens
{
	private $formal, $expires, $chat_id;
	private $token, $exists = false;

	function __construct($token)
	{
		$this->token = $token;
		$db = new Database;


		/*$user = new Users("-246486526");
		$user->sendMessage("test");*/

		$tokens = $db->getResult("SELECT * FROM activation_tokens WHERE token = :token",
			array(":token"), array($this->token));


		if ($tokens){
			$this->exists = true;
			$this->formal = $tokens[0]["formal"];
			$this->expires = $tokens[0]["expires"];
			$this->chat_id = $tokens[0]["chat_id"];
		}


		
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

	public function getToken()
	{
		return $this->token;
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

		if ($this->exists) {
			$db->performQuery("UPDATE activation_tokens
				SET formal = :formal, expires = :expires, chat_id = :chat_id
				WHERE token = :token",
				array(":formal",":expires",":chat_id", ":token"),
				array($this->formal, $this->expires, $this->chat_id, $this->token));

			return true;
		}

		
		$db->performQuery("INSERT INTO activation_tokens
			(token, formal, expires)
			VALUES (:token, :formal, :expires)",
			array(":token", ":formal", ":expires"),
			array($this->token, $this->formal, $this->expires)
			);
		
		return true;
	}

	public function check()
	{
		if($this->expires > time() && $this->exists)
			return true;

		return false;
	}


}

?>