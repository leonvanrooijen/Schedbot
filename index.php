<?php  

echo "Je hebt hier niks te zoeken!<br>";
require 'app/init.php';
$token = "eg9jisibj7g92v2siihs8bsjmf";
$zermelo = new Zermelo;
$zermelo->setToken($token);
$zermelo->setTenant("gsf");
echo "<pre>";
echo $zermelo->getLenghtLessons();

echo config("application_info/title");

?>