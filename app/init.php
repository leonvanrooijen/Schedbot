<?php  
/* Showing errors */
error_reporting(E_ALL);
ini_set('display_errors', 'On');


/*
 * Initialize all the requested classes and the configuration
*/
require 'app/configuration/system.conf.php';
spl_autoload_register(function ($class) {
    require $_SERVER["DOCUMENT_ROOT"] . "/app/classes/class." . strtolower($class) . ".php";
});

?>