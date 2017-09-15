<?php  

/**
* User class to create and update user information
*/
class Users
{
	
	private $chat_id, $nickname, $rank = 1, $status = "0", $zermelo_tenant, $zermelo_token, $formal = 1;
	
	private $userExists = false;

	function __construct($chat_id)
	{
		$this->chat_id = $chat_id;

		$db = new Database;
		$result = $db->getResult("SELECT * FROM users WHERE chat_id = :chat_id", array(":chat_id"), array($chat_id));

		if ($result) {
			$this->userExists = true;
			$this->nickname = $result["nickname"];
			$this->rank = $result["rank"];
			$this->status = $result["status"];
			$this->zermelo_tenant = $result["zermelo_tenant"];
			$this->zermelo_token = $result["zermelo_token"];
			$this->formal = $result["formal"];

		}
		$this->userExists = false;
	}

	public function setNickname($nickname)
	{
		$this->nickname = $nickname;
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

	public function save()
	{

		switch ($this->status) {
			case '1':
			case '2':
			case '3'
				if(!isset($this->zermelo_tenant))
				return false
				break;

			case '2':
			case '3':
				if(!isset($this->zermelo_token))
				return false
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
				formal = :formal",
				array(":nickname", ":rank", ":status", ":zermelo_tenant", ":zermelo_token", ":formal"),
				array($this->nickname, $this->rank, $this->status,
				$this->zermelo_tenant, $this->zermelo_token, $this->formal));
			return true;
		}

		
		$db->performQuery("INSERT INTO users
			(nickname, rank, status, zermelo_tenant, zermelo_token, formal) VALUES
			(:nickname, :rank, :status, :zermelo_tenant, :zermelo_token, :formal)",
			array(":nickname", ":rank", ":status", ":zermelo_tenant", ":zermelo_token", ":formal"),
			array($this->nickname, $this->rank, $this->status, $this->zermelo_tenant, $this->zermelo_token, $this->formal));
		return true;
	}
}


?>