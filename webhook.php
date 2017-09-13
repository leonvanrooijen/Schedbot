<?php
/*
 * Initialize our system
*/
require 'app/init.php';

$userInput = json_decode(file_get_contents('php://input'), true);


$qh = new QuestionsHandler($userInput["message"]["text"]);
if($qh->check()) {
$message = new Telegram($config["auth_data"]["telegram_token"]);
$message->sendMessage("-246486526", "Heb je een vraag?! Ik ben je slaaf niet!");


$qh->myName(); 

}
