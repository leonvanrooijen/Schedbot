<?php
require 'app/init.php';
date_default_timezone_set('Europe/Amsterdam');

/*
 * Op bepaalde tijdstippen wordt er een actie uitgevoerd.
*/

switch (date("G:i")) {

	case '0:00':
		//Database clean-up, get all the schedules
		//Check if notification needs to be send
		break;
}



/*

1. Elke minuut checkt de cronjob (8 min van tevoren), de database op actions. Als er een cronjob is met timestamp = now dan uitvoeren
2. wanneer uitvoeren: haal de eerstvolgende les op (huidige timestamp + 24 uur)
3. Maak een action aan met de eerstvolgende les
4. Om 0:00 -> database clean-up -> fetch eerstvolgende lessen van mensen -> maak een action

*/













/*
  Run the cronjob:
    1. Check if the authentication matches (just a simple authentication)
    2. Check if the time is right, if so go to step 4
    3. Fetch the schedule from Zermelo's API
    4. Send the right classroom to the user using the Telegram API.

$schedule = new Schedule($config['auth_data']['zermelo_token'], $config['auth_data']['telegram_token'], $config['application_info']['time_data']);
if(!$schedule->checkTime()) {
  /*$time_error = new Response("error", "invalid time");
  The time isn't right but we won't return an error.
  
 // die();
}
$schedule->sendClassroom();*/


?>
