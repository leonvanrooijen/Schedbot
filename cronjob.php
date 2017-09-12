<?php
require 'app/init.php';
/*
  Run the cronjob:
    1. Check if the authentication matches (just a simple authentication)
    2. Check if the time is right, if so go to step 4
    3. Fetch the schedule from Zermelo's API
    4. Send the right classroom to the user using the Telegram API.
*/


$schedule = new Schedule($config['auth_data']['zermelo_token'], $config['auth_data']['telegram_token'], $config['application_info']['time_data']);
if(!$schedule->checkTime()) {
  /*$time_error = new Response("error", "invalid time");
  The time isn't right but we won't return an error.
  */
 // die();
}
$schedule->sendClassroom();


?>
