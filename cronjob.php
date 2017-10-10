<?php
require 'app/init.php';
date_default_timezone_set('UTC');
set_time_limit(0);

$now = time();

/*
 * Op bepaalde tijdstippen wordt er een actie uitgevoerd.
*/

foreach (getUsers() as $user) {

  $receiver = new Users($user["chat_id"]);
  $schedule = new Schedule($user["chat_id"], (floor($now/60)*60+480));
  
  $subjects = "";
  $i = 0;

  $prefix = ["Hey " . $receiver->getNickname() . ", je hebt zometeen ",
            "Beste docent, u geeft zometeen "];

  $suffix = ["%vak% in lokaal %lokaal%",    //Formaliteit 0
            "%vak% aan %klas% in %lokaal%"]; //Formaliteit 1

  foreach ($schedule->get() as $appointment) {

    if($appointment["cancelled"] == 0 && $appointment["valid"] == 1) {

      switch ($i) {
        case 0:
          $subject = $suffix[$receiver->getFormal()] . " ";
          break;

        case $vakkenaantal - 1:
          $subject = "of " . $suffix[$receiver->getFormal()] . ".";
          break;

        default:
          $subject = ", " . $suffix[$receiver->getFormal()] . " ";
          break;
        }

        $subjects .= str_replace(
          array("%vak%", "%lokaal%", "%klas%"),
          array($appointment["subject"], $appointment["location"], $appointment["classgroup"]), $subject);

      $i++;
    }
  }

  if($i > 0)
    $receiver->sendMessage($prefix[$receiver->getFormal()] . $subjects . " 📚⏰");

}

date_default_timezone_set('Europe/Amsterdam');
switch (date("G:i")) {

  case '2:00':
    clearSchedules();
    
    foreach (getUsers() as $user) {
    
      $receiver = new Users($user["chat_id"]);

      $schedule = new Zermelo($receiver->getTenant());
      $schedule->setToken($receiver->getClientToken());
      $schedule->setTimestamps((floor($now/60)*60), ((floor($now/60)*60)+86400));
      $appointments = $schedule->fetch();

      foreach ($appointments as $appointment) {

        echo '<pre>';
        print_r($appointment);

        $action = new Schedule($user["chat_id"], $appointment["start"]);
        $action->setLastUpdated($now);
        $action->setLocation(implode(", ", $appointment["locations"]));
        $action->setSubject(implode(", ", $appointment["subjects"]));
        $action->setTeacher(implode(", ", $appointment["teachers"]));
        $action->setClassGroup(implode(", ", $appointment["groups"]));

        $action->setCancelled($appointment["cancelled"]);
        $action->setValid($appointment["valid"]);
        $action->add();
      }

    }

    break;

  }

?>
