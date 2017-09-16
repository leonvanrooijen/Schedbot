<?php

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

function getUsers()
{
	$db = new Database;

	$users = $db->getResult("SELECT * FROM users WHERE status = 3", array(), array());

	return $users;
}

function clearSchedules()
{
	$db = new Database;

	$db->performQuery("TRUNCATE TABLE actions", array(), array());
}

?>