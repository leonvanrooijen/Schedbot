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


function checkLockdown()
{
	$db = new Database;
	$lockdownStatus = $db->getResult("SELECT value FROM settings WHERE setting = :setting",
		array(":setting"), array("lockdown"));

	if ($lockdownStatus[0]["value"] == 1) {
		return true;
	}

	return false;
}

function getUserInfo($name)
{
	$db = new Database;
	$userInfo = $db->getResult("SELECT chat_id FROM users WHERE comment = :name", 
		array(":name"), 
		array($name));
	return $userInfo[0]["chat_id"];
}


?>