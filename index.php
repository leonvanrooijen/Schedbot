<?php  

require 'app/init.php';

//Zermelo testing system
$zermelo = new Zermelo;
$zermelo->setToken("eg9jisibj7g92v2siihs8bsjmf");
$zermelo->setTenant("gsf");


//User testing system
$user = new Users("123456");

$user->setTenant("gsf");
$user->setNickname("Noury");
$user->setStatus("1");

$user->save();

//Actionhandler testing system.

$action = new NicknameCommand("Noem mij voortaan Noury");
var_dump($action);


?>