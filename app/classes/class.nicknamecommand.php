<?php

/**
* 
*/
class NicknameCommand extends ActionHandler
{
	private $message, $verify_rules;
	
	function __construct($message)
	{

		$this->message = $message;
		$this->verify_rules = array("contains:Noem me voortaan ",
	  								"contains:Noem mij voortaan ",
	  								"contains:Noem me ",
									"contains:Noem mij ");

		if(!parent::validate($this->verify_rules, strtolower($this->message))) 
		{
			echo 'haha het werkt niet!!!';
		}

		echo parent::validate($this->verify_rules, $this->message);

	}
}


///^[a-z ,.'-]+$/i