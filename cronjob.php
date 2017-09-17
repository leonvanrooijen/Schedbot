<?php
require 'app/init.php';
date_default_timezone_set('Europe/Amsterdam');

/*
 * Op bepaalde tijdstippen wordt er een actie uitgevoerd.
*/
//voor alle actieve users
foreach (getUsers() as $user) {
  //maak user en rooster op
  $receiver = new Users($user["chat_id"]);
  echo $receiver->getNickname() . "(" . (floor(time()/60)*60+480) ."): ";
  $schedule = new Schedule($user["chat_id"], (floor(time()/60)*60+480));
  

  $message = "Hey " . $receiver->getNickname() . ", je hebt zometeen ";
  $vakken = "";
  $i = 0;
  $vakkenaantal = count($schedule->get());

  foreach ($schedule->get() as $appointment) {

    switch ($i) {
      case 0:
        $vakken .= $appointment["subject"] . " in lokaal " . $appointment["location"];
        break;

      case $vakkenaantal - 1:
        $vakken .= " of " . $appointment["subject"] . " in lokaal " . $appointment["location"];
        break;

      default:
        $vakken .= ", " . $appointment["subject"] . " in lokaal " . $appointment["location"];
        break;
    }


    $i++;

  }

  if($i > 0)
    $receiver->sendMessage($message . $vakken . ".");

}


switch (time("G:i")) {

  case '0:00':
    clearSchedules();
    
    foreach (getUsers() as $user) {
    
      $receiver = new Users($user["chat_id"]);

      $schedule = new Zermelo($receiver->getTenant());
      $schedule->setToken($receiver->getClientToken());
      $schedule->setTimestamps((floor(time()/60)*60), ((floor(time()/60)*60)+86400));
      $appointments = $schedule->fetch();

      foreach ($appointments as $appointment) {

        echo '<pre>';
        print_r($appointment);

        $action = new Schedule($user["chat_id"], $appointment["start"]);
        $action->setLastUpdated(time());
        $action->setLocation($appointment["locations"][0]);
        $action->setSubject($appointment["subjects"][0]);
        $action->setTeacher($appointment["teachers"][0]);
        $action->setClassGroup($appointment["groups"][0]);

        $action->setCancelled($appointment["cancelled"]);
        $action->setValid($appointment["valid"]);
        $action->add();
      }


    /*

      $appointment = $zermelo->getAppointment(time(), time() + 86400);
      
      $action = new action($person["chat_id"], $appointment[0]["start"]);
      
      echo '<pre>';
      print_r($appointment);

      $action->setLastUpdated(time());
      $action->setLocation($appointment[0]["locations"][0]);
      $action->setSubject($appointment[0]["subjects"][0]);
      $action->setTeacher($appointment[0]["teachers"][0]);
      $action->setGroup($appointment[0]["groups"][0]);
      $action->setCancelled($appointment[0]["cancelled"]);
      $action->setValid($appointment[0]["valid"]);

      $action->add();*/
    }
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
