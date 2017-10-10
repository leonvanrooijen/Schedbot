<?php  

class FlushCommand extends ActionHandler
{
	private $chat_id, $message, $verify_rules;
	
	function __construct($chat_id, $message)
	{

		$this->chat_id = $chat_id;
		$this->message = $message;
		$this->verify_rules = array("contains:/flush");

		$flush = parent::validate($this->verify_rules, $this->message);
		if(!is_string($flush)) 
			return false;

		self::proceed();


	}

	protected function proceed()
	{
	    clearSchedules();
	    
	    foreach (getUsers() as $user) {
	    
	      $receiver = new Users($user["chat_id"]);

	      $schedule = new Zermelo($receiver->getTenant());
	      $schedule->setToken($receiver->getClientToken());
	      $schedule->setTimestamps((floor(time()/60)*60), ((floor(time()/60)*60)+86400));
	      $appointments = $schedule->fetch();

	      foreach ($appointments as $appointment) {

	        $action = new Schedule($user["chat_id"], $appointment["start"]);
	        $action->setLastUpdated(time());
	        $action->setLocation(implode(", ", $appointment["locations"]));
	        $action->setSubject(implode(", ", $appointment["subjects"]));
	        $action->setTeacher(implode(", ", $appointment["teachers"]));
	        $action->setClassGroup(implode(", ", $appointment["groups"]));

	        $action->setCancelled($appointment["cancelled"]);
	        $action->setValid($appointment["valid"]);
	        $action->add();
	      }
	    }
			

		$user = new Users($this->chat_id);
		$user->sendMessage("System flushed");
	}
}

?>