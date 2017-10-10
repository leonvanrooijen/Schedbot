<?php
/*
 * Initialize our system
*/
require 'app/init.php';

$request = json_decode(file_get_contents('php://input'), true);

$user = new Users($request["message"]["chat"]["id"]);
$user->setChatMessage($request["message"]["text"]);

if ($user->getAdmin() == 1 && $user->getRank() == 1) {
	//user is admin :)
	$user->sendMessage($userInput["message"]["text"]);
	die();
}


if(!checkLockdown()){
	switch ($user->getStatus()) { 
	case '0': //Activatiecode dient te worden ingevoerd
		new StartCommand($user->getChatId(), $user->getChatMessage());

		//Check if activation token is right
		new TokenCommand($user->getChatId(), $user->getChatMessage());
		break;
	
	case '1':
	//new ZermeloInstituteCommand //submit de zermelo institute
		new ZermeloInstituteCommand($user->getChatId(), $user->getChatMessage());
		break;

	case '2':
	//new ZermeloTokenCommand //submit de zermelo token EN wissel deze om naar een API key, store de api key
		new ZermeloTokenCommand($user->getChatId(), $user->getChatMessage());
		break;

	case '3':
		new NicknameCommand($user->getChatId(), $user->getChatMessage());
		new HelpCommand($user->getChatId(), $user->getChatMessage());
		break;

	}
}

if (checkLockdown() && $user->getRank() == 1) {
	$user->sendMessage("<b>Lockdownmodus is actief</b>. Je kunt geen acties uitvoeren.", true);
}



switch ($user->getRank()) {
	case '2':
		new StatsCommand($user->getChatId(), $user->getChatMessage());
		new CreateTokenCommand($user->getChatId(), $user->getChatMessage());
		break;
	
	case '3':
		//admin
		new StatsCommand($user->getChatId(), $user->getChatMessage());
		new AlertCommand($user->getChatId(), $user->getChatMessage());
		new LockdownCommand($user->getChatId(), $user->getChatMessage());
		new AdminCommand($user->getChatId(), $user->getChatMessage());
		new CreateTokenCommand($user->getChatId(), $user->getChatMessage());
		new FlushCommand($user->getChatId(), $user->getChatMessage());
		break;
}


