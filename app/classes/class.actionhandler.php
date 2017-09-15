<?php

/**
* The ActionHandler class provides an intergration for all the chat commands
*/
class ActionHandler
{
	
	public static function validate($options, $message)
	{

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

		if(!isset($matches) || $matches > 1)
			return false;

		return $message;

	}

	protected function activate()
	{
		/*
		*	No code needed, this is activated by the subclass
		*/
	}


	}