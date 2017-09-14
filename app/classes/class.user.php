<?php  

/**
* User class to create and update user information
*/
class User
{
	
	private $chat_id, $nickname, $rank, $status, $zermelo_tenant, $zermelo_token, $formal;
	
	private $userExists;

	function __construct($chat_id)
	{
		$this->chat_id = $chat_id;
		$db = new Database;

		$result = $db->getResult("SELECT * FROM users WHERE chat_id = :chat_id", array(":chat_id"), array($chat_id));

		if ($result) {
			//user already exists
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
		if (!$this->userExists) {
			//if user doesn't exist

			switch (variable) {
				case '1':
					# code...
					break;
				
				case '2':
					# code...
					break;

				case '3':
					# code...
					break;

				case '4':
					# code...
					break;

				default:
					if (isset($this->chat_id)) {
						$db->performQuery("INSERT INTO users (chat_id) VALUES (:chat_id)", array(":chat_id"), array($this->chat_id));
					}
					return false;
					break;
			}
		}
	}
}


?>