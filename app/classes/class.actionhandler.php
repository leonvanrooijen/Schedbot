<?php

/**
* The ActionHandler class provides an intergration for all the chat commands
*/
class ActionHandler
{
	
	public static function validate($options, $message)
	{

		$originalMessage = $message;
		$matches = 0;

		foreach ($options as $option) {
			
			$arguments = explode('|', $option);

			foreach ($arguments as $argument) {

				if(strpos($argument, 'contains:') == 0) {
					$argument = str_ireplace("contains:", "", $argument);
					
					if(strpos($message, $argument))
						$matches++;
						$message = str_ireplace($argument, "", $message);
	
				}		
	
			}
		}

		if($originalMessage == $message)
			return false;

		return $message;

	}


	}