<?php  

echo "Je hebt hier niks te zoeken!<br>";
require 'app/init.php';
$token = "eg9jisibj7g92v2siihs8bsjmf";
$zermelo = new Zermelo;
$zermelo->setToken($token);
$zermelo->setTenant("gsf");
echo "<pre>";
print_r($zermelo->getAppointment("1505197800", "1505219000"));

?>