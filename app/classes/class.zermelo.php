<?php

/*
* Zermelo class to retrieve the schedules
*/
class Zermelo
{
	private $institute, $token, $start, $end, $lastModified = 0;
	
	public function __construct($institute)
	{
		$this->institute = $institute;
	}

	public function setTimestamps($start, $end)
	{
		$this->start = $start;
		$this->end = $end;
	}

	public function setLastModified($lastModified)
	{
		$this->lastModified = $lastModified;
	}

	public function fetch()
	{

		$api_url = "https://" . $this->institute . ".zportal.nl/api/v3/appointments?user=~me&start=" . (string) $this->start . "&end=" . (string) $this->end . "&access_token=" . $this->token;

		if(empty($this->token))
			return false;

		if($this->lastModified !== 0)
		{
			$api_url .= "&lastModified=" . (string) $this->lastModified; 
		}

		$schedule_data = json_decode(file_get_contents($api_url, false), true);

		if(!$schedule_data) {
			return false;
		}

		return self::sort($schedule_data["response"]);

	}

	protected function sort($schedule_data)
	{
		if($schedule_data["totalRows"] == 0)
			return array();

		$timestamps = array();
		$schedules_sorted = array();

		$i = 0;
		foreach($schedule_data["data"] as $appointment) {
			$timestamps[$i] = $appointment["start"];
			$i++;
		}
		
		asort($timestamps);

		$x = 0;
		foreach ($timestamps as $number => $timestamp) {
			$schedules_sorted[$x] = $schedule_data["data"][$number]; 
			$x++;
		}

		return $schedules_sorted;

	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function checkTenant()
	{
		if (strrpos($this->institute, "."))
			return false;

		$site = file_get_contents("https://" . $this->institute . ".zportal.nl");

		if (!$site) 
			return false;

		if (strrpos(strtolower($site), "verkeerd"))
			return false;

		return true;

	}

	public function createToken($code)
	{

		$data = array('grant_type' => 'authorization_code', 'code' => $code);

		$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => 'POST',
        		'content' => http_build_query($data)
    		)
		);

		$token = file_get_contents(
				"https://" . $this->institute . ".zportal.nl/api/v3/oauth/token",
				 false,
				 stream_context_create($options));
		
		if (!$token)
			return false;

		return json_decode($token, true)['access_token'];
		

	}


}