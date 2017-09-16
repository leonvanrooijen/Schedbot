<?php  

require 'app/init.php';

//Zermelo testing system
$zermelo = new Zermelo;
$zermelo->setToken("eg9jisibj7g92v2siihs8bsjmf");
$zermelo->setTenant("gsf");


//User testing system
$user = new Users("123456");

$user->setTenant("gsdf");
$user->setNickname("Noury");
$user->setStatus("1");

$user->save();

//Actionhandler testing system.



?>