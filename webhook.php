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
$user->setTenant("gsf");
$user->setClientToken("324323");
$user->setNickname("gast");
$user->save();

switch ($user->getStatus()) {
	case '1': //Activatiecode dient te worden ingevoerd
		
		break;
	
	case '2':
		
		break;

	case '3':
		new NicknameCommand($user->getChatId(), $userInput["message"]["text"]);
		break;

}


