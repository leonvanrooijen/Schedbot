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

	public function createToken($tenant, $code)
	{
		$url = "https://" . $tenant . ".zportal.nl/api/v2/oauth/token";

		$data = array('grant_type' => 'authorization_code', 'code' => $code);

		$options = array(
    		'http' => array(
        		'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        		'method'  => 'POST',
        		'content' => http_build_query($data)
    		)
		);

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		
		if (!$result) {
			return false;
		}else{
			return json_decode($result, true)['access_token'];
		}

	}

	public function getAppointment($start, $end)
	{
		$url = "https://" . $this->tenant . ".zportal.nl/api/v2/appointments?user=~me&start=" . $start . "&end=" . $end . "&access_token=" . $this->token;

		$zermeloResult = file_get_contents($url, false);

		$decodedResult = json_decode($zermeloResult, true);

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
}

?>