<?php

Class QuestionsHandler {
	private $message;

	public function __construct($message) {
		$this->message = $message;
	}

	public function check() {

		if(in_array(explode(' ', trim(strtolower($this->message)))[0], array("wat", "wanneer", "noem"))) {  
			return true;
		}
		return false;
	}
}

?>

