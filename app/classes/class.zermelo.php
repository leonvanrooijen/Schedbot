<?php  


/**
* This class handles Zermelo requests
*/
class Zermelo
{
	
	private $token;

	public function setUser($token)
	{
		$this->token = $token;
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
}

?>