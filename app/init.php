<?php  
/* Showing errors */
error_reporting(E_ALL);
ini_set('display_errors', 'On');


/*
 * Initialize all the requested classes and the configuration
*/
require 'app/configuration/system.conf.php';
spl_autoload_register(function ($class) {

	if(strpos(strtolower($class), "command") !== false) {
		
		require $_SERVER["DOCUMENT_ROOT"] . "/app/classes/commands/class." . strtolower($class) . ".php";
	} else {
    	require $_SERVER["DOCUMENT_ROOT"] . "/app/classes/class." . strtolower($class) . ".php";
	}
});

?>