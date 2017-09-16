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
<<<<<<< HEAD
$user->setTenant("gsf");
$user->setClientToken("324323");
$user->setNickname("gast");
$user->setStatus("3");
$user->save();
=======

>>>>>>> 8a75df5af00608c8598666df1f1770699ca59303

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


