<?php

/**
* The ActionHandler class provides an intergration for all the chat commands
*/
class ActionHandler
{
	
	public static function validate($options, $message)
	{

		$matches = 0;
		$text = "";

		foreach ($options as $option) {
		
			foreach ($arguments as $argument) {

				$arguments = explode('|', $option);
	
				if(strpos($argument, 'contains:')) {
					$argument = str_ireplace("contains:", "", $argument);
	
					if(strpos($message, $argument))
						$matches++;
						$text =. str_replace($argument, "", $message);

	
				}		
	
			}
		}

		if(!isset($matches) || $matches > 1)
			return false;

		return $text;

	}

	protected function activate()
	{
		/*
		*	No code needed, this is activated by the subclass
		*/
	}


	}