<?php
/*
 * Initialize our system
*/
require 'app/init.php';

$userInput = json_decode(file_get_contents('php://input'), true);

$user = new Users($userInput["message"]["chat"]["id"]);

if ($user->getAdmin() == 1 && $user->getRank() == 1) {
	//user is admin :)
	$user->sendMessage($userInput["message"]["text"]);
	die();
}


if(!checkLockdown()){
	switch ($user->getStatus()) { 
	case '0': //Activatiecode dient te worden ingevoerd
		new StartCommand($user->getChatId(), $userInput["message"]["text"]);

		//Check if activation token is right
		new TokenCommand($user->getChatId(), $userInput["message"]["text"]);
		break;
	
	case '1':
	//new ZermeloInstituteCommand //submit de zermelo institute
		new ZermeloInstituteCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

	case '2':
	//new ZermeloTokenCommand //submit de zermelo token EN wissel deze om naar een API key, store de api key
		new ZermeloTokenCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

	case '3':
		new NicknameCommand($user->getChatId(), $userInput["message"]["text"]);
		new HelpCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

	}
}

if (checkLockdown() && $user->getRank() == 1) {
	$user->sendMessage("<b>Lockdownmodus is actief</b>. Je kunt geen acties uitvoeren.", true);
}



switch ($user->getRank()) {
	case '2':
		//moderator
		break;
	
	case '3':
		//admin
		new StatsCommand($user->getChatId(), $userInput["message"]["text"]);
		new AlertCommand($user->getChatId(), $userInput["message"]["text"]);
		new LockdownCommand($user->getChatId(), $userInput["message"]["text"]);
		new AdminCommand($user->getChatId(), $userInput["message"]["text"]);
		break;
}


