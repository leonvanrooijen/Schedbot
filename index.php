<?php  

require 'app/init.php';

//Zermelo testing system
$r = new Zermelot("gsf");
$r->setToken("e9v31sau8lb43afvsmfb83804c");
$r->setTimestamps(1505685600 + 3600*3*24, 1505772000 + 3600*3*24);
$r->setLastModified(1505462155);
echo "<pre>";
print_r($r->fetch());

?>