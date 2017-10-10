<?php  

/**
* User class to create and update user information
*/
class Users
{
	
	private $chat_id, $nickname, $rank = 1, $status = "0", $zermelo_tenant, $zermelo_token, $formal = 1, $admin = 0, $comment, $chatMessage;
	
	private $userExists = false;

	function __construct($chat_id)
	{
		$this->chat_id = $chat_id;

		$db = new Database;
		$result = $db->getResult("SELECT * FROM users WHERE chat_id = :chat_id", array(":chat_id"), array($chat_id));

		if ($result) {
			$this->userExists = true;
			$this->nickname = $result[0]["nickname"];
			$this->rank = $result[0]["rank"];
			$this->status = $result[0]["status"];
			$this->zermelo_tenant = $result[0]["zermelo_tenant"];
			$this->zermelo_token = $result[0]["zermelo_token"];
			$this->formal = $result[0]["formal"];
			$this->comment = $result[0]["comment"];
			$this->admin = $result[0]["admin"];

		}
	}

	public function setNickname($nickname)
	{
		$this->nickname = $nickname;
	}

	public function setChatMessage($chatMessage)
	{
		$this->chatMessage = $chatMessage;
	}	

	public function setRank($rank)
	{
		$this->rank = $rank;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setTenant($zermelo_tenant)
	{
		$this->zermelo_tenant = $zermelo_tenant;
	}

	public function setClientToken($zermelo_token)
	{
		$this->zermelo_token = $zermelo_token;
	}

	public function setFormal($formal)
	{
		$this->formal = $formal;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	public function setAdmin($admin)
	{
		$this->admin = $admin;
	}

	public function getNickname()
	{
		return $this->nickname;
	}

	public function getRank()
	{
		return $this->rank;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getTenant()
	{
		return $this->zermelo_tenant;
	}

	public function getClientToken()
	{
		return $this->zermelo_token;
	}

	public function getFormal()
	{
		return $this->formal;
	}

	public function getChatId()
	{
		return $this->chat_id;
	}

	public function getComment()
	{
		return $this->comment;
	}

	public function getAdmin()
	{
		return $this->admin;
	}

	public function getChatMessage()
	{
		return $this->chatMessage;
	}		

	public function save()
	{

		switch ($this->status) {
			case '2':
			case '3':
				if(!isset($this->zermelo_tenant))
				return false;
				break;

			case '3':
				if(!isset($this->zermelo_token))
				return false;
				break;
		}

		$db = new Database;

		if($this->userExists) {
			
			$db->performQuery("UPDATE users SET
				nickname = :nickname,
				rank = :rank,
				status = :status,
				zermelo_tenant = :zermelo_tenant,
				zermelo_token = :zermelo_token,
				formal = :formal,
				comment = :comment, 
				admin = :admin WHERE  chat_id = :chat_id",
				array(":nickname", ":rank", ":status", ":zermelo_tenant", ":zermelo_token", ":formal", ":comment", ":admin", ":chat_id"),
				array($this->nickname, $this->rank, $this->status,
				$this->zermelo_tenant, $this->zermelo_token, $this->formal, $this->comment, $this->admin, $this->chat_id));
			return true;
		}

		
		$db->performQuery("INSERT INTO users
			(chat_id, nickname, rank, status, zermelo_tenant, zermelo_token, formal, comment, admin) VALUES
			(:chat_id, :nickname, :rank, :status, :zermelo_tenant, :zermelo_token, :formal, :comment, :admin)",
			array(":chat_id", ":nickname", ":rank", ":status", ":zermelo_tenant", ":zermelo_token", ":formal", ":comment", ":admin"),
			array($this->chat_id, $this->nickname, $this->rank, $this->status, $this->zermelo_tenant, $this->zermelo_token, $this->formal, $this->comment, $this->admin));
		return true;
	}

	public function sendMessage($notification, $isHtml = false)
	{ 
		$message = new Telegram(config('telegram_token'));
		$message->sendMessage($this->chat_id, $notification, $isHtml);
	}
}


?>