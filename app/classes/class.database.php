<?php
class Database {
	public $conn;
	private $hostname, $username, $password, $database;
	function __construct() {
		$this->hostname = 'host';
		$this->username = 'naam';
		$this->password = 'ww';
		$this->database = 'db';

		try {
    	$this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->database, $this->username, $this->password);
    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
		catch(PDOException $e)
    {
    	 die("<h1>Verbinding met de database is mislukt</h1><br>Foutmelding:" . $e->getMessage());
    }
	}

	function performQuery($query_contents, $bindingnames, $bindingvalues) {
		$query = $this->conn->prepare($query_contents);

		$number = 0;
		foreach($bindingnames as $bindingname) {
				$query->bindParam($bindingname, $bindingvalues[$number]);
			$number++;
		}
		$query->execute();
		return $query->rowCount();
	}

	function getResult($query_contents, $bindingnames, $bindingvalues) {
		$query = $this->conn->prepare($query_contents);

		$number = 0;
		foreach($bindingnames as $bindingname) {
				$query->bindParam($bindingname, $bindingvalues[$number]);
			$number++;
		}
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

}
