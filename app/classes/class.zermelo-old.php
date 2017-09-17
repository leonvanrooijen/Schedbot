<?php  


/**
* This class handles Zermelo requests
*/
class Zermelo
{
	
	private $tenant, $token;

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function setTenant($tenant)
	{
		$this->tenant = $tenant;
	}

	public function checkTenant($tenant)
	{
		if (strrpos($tenant, "."))
			return false;

		$site = file_get_contents("https://" . $tenant . ".zportal.nl");

		if (!$site) 
			return false;

		if (strrpos(strtolower($site), "verkeerd"))
			return false;

		return true;

	}

	public function createToken($tenant, $code)
	{

		$data = array('grant_type' => 'authorization_code', 'code' => $code);

		$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => 'POST',
        		'content' => http_build_query($data)
    		)
		);

		$result = file_get_contents(
				"https://" . $tenant . ".zportal.nl/api/v3/oauth/token",
				 false,
				 stream_context_create($options));
		
		if (!$result) {
			return false;
		}else{
			return json_decode($result, true)['access_token'];
		}

	}

	public function getAppointment($start, $end)
	{
		$url = "https://" . $this->tenant . ".zportal.nl/api/v3/appointments?user=~me&start=" . (string) $start . "&end=" . (string) $end . "&access_token=" . $this->token;

		$decodedResult = json_decode(file_get_contents($url, false), true);

		$results = array("count" => count($decodedResult["response"]["data"]));

		foreach ($decodedResult["response"]["data"] as $appointment) {
			array_push($results, [
				"start" => $appointment["start"], 
				"end" => $appointment["end"], 
				"subjects" => $appointment["subjects"],
				"teachers" => $appointment["teachers"],
				"locations" => $appointment["locations"],
				"groups" => $appointment["groups"],
				"valid" => $appointment["valid"],
				"cancelled" => $appointment["cancelled"]
				]);
		}

		return $results;
	}

	public function getLenghtLessons()
	{
		$startSchool = strtotime("today 08:30");
		$today = $this->getAppointment($startSchool, $startSchool + 28800);
		return $today[0]["end"] - $today[0]["start"];
	}
}

?>