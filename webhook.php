<?php
/*
 * Initialize our system
*/
require 'app/init.php';

$userInput = json_decode(file_get_contents('php://input'), true);

/*$userInput["message"]["text"]
$userInput["message"]["chat"]["id"]
$message = new Telegram($config["auth_data"]["telegram_token"]);
$message->sendMessage("-246486526", "Heb je een vraag?! Ik ben je slaaf niet!");
$qh->myName(); 
}
*/

$user = new Users($userInput["message"]["chat"]["id"]);



switch ($user->getStatus()) {
	case '0': //Activatiecode dient te worden ingevoerd
		new StartCommand($user->getChatId(), $userInput["message"]["text"]);
		break;
	
	case '1':
		
		break;

	case '2':
		
		break;

	case '3':
		new NicknameCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

}

switch ($user->getRank()) {
	case 2:
	case 3:
		//moderator
		break;
	
	case 3:
		//admin
		new AlertCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

	default:
		//user
		break;
}


