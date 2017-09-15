<?php  

require 'app/init.php';

$token = "eg9jisibj7g92v2siihs8bsjmf";

//initiate zermelo connection
$zermelo = new Zermelo;
$zermelo->setToken($token);
$zermelo->setTenant("gsf");

//initiate database connection

$user = new Users("123456");

$user->setTenant("gsf");
$user->setNickname("Noury");
$user->setStatus("1");

$user->save();


?>