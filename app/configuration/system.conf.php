<?php
/*
####################################################
#       Announcement system - configuration        #
####################################################
*/

function config($key) {


	$config = array(

		'title'     => 'SchedBot',
		'url'       => 'https://beta.mengelberg.eu',

		'timezone'  => 'Europe/Amsterdam',
		'time_data' => array("08:25", "09:15", "10:05", "11:15", "12:05", "13:25", "14:15", "15:05", "15:55"),

		'telegram_token' => '418800539:AAEL8EIbOfvIDTHbMLiib7LgJ7nk6PGFibs',

		'database_hostname' => 'web0097.zxcs.nl',
		'database_username' => 'u534p4710_schedbot',
		'database_password' => 'Z4KR0z4SP',

		'database_name' => 'u534p4710_schedbot'
	      );

	if(array_key_exists($key, $config)) {
		return true;
	}

	throw new Exception("The coresponding key wasn\'t found in our system.", 1);
}

?>
