<?php

class Schedule {
  private $zermelo_token, $telegram_token, $time_data;

  function __construct($zermelo, $telegram, $times) {
    $this->zermelo_token = $zermelo;
    $this->telegram_token = $telegram;
    $this->time_data = $times;
  }

  function checkTime() {
    if(!in_array(date("H:i"), $this->time_data)) {
      return false;
    }
    return true;
  }

  function sendClassroom() {
    $time = time();   //Calculate the time of the lessons
    $start_lesson = (ceil(time()/300)*300);
    $end_lesson = ($start_lesson)+60;

    $zermeloResult = @file_get_contents('https://gsf.zportal.nl/api/v2/appointments?user=~me&start=' . $start_lesson . '&end=' . $end_lesson . '&access_token=' . $this->zermelo_token, false);
    if(!$zermeloResult){
      return false; //Not authenticated
    }
    $decodedZermeloResult = json_decode($zermeloResult, true);

    foreach($decodedZermeloResult['response']['data'] as $lesson) {
      if($lesson['cancelled'] == false && $lesson['valid'] == true) { //Send the message to Noury
        return file_get_contents('https://api.telegram.org/bot ' . $this->telegram_token . '/sendMessage?chat_id=429246296&text=Hey%20Noury!%20Je%20hebt%20zometeen%20' . $lesson["subjects"][0] . '%20in%20lokaal%20' . $lesson['locations'][0] .'.%20📚⏰');
      }
    }
  }

}
?>
