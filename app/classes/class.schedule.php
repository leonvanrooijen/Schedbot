<?php  

/**
* handles messages to user about schedule.
*/
class Schedule
{
	private $chat_id, $lesson_time;
	private $last_updated, $location, $subject, $teacher, $classgroup, $cancelled, $valid;
	
	function __construct($chat_id, $lesson_time)
	{
		$this->chat_id = $chat_id;
		$this->lesson_time = $lesson_time;
	}

	public function get()
	{
		$db = new Database;

		$actions = $db->getResult("SELECT * FROM actions WHERE chat_id = :chat_id 
			AND lesson_time = :lesson_time",
			array(":chat_id", "lesson_time"),
			array($this->chat_id, $this->lesson_time));

		return $actions;
	}

	public function add()
	{
		$db = new Database;

		$db->performQuery("INSERT INTO actions
			(chat_id, lesson_time, last_updated, location, subject, teacher, classgroup, cancelled, valid)
			VALUES 
			(:chat_id, :lesson_time, :last_updated, 
			:location, :subject, :teacher, 
			:classgroup, :cancelled, :valid)",

			array(":chat_id", ":lesson_time", ":last_updated", 
				":location", ":subject", ":teacher", 
				":classgroup", ":cancelled", ":valid"),

			array($this->chat_id, $this->lesson_time, 
				$this->last_updated, $this->location, 
				$this->subject, $this->teacher, 
				$this->classgroup, $this->cancelled, $this->valid));
	}

	public function delete()
	{
		$db = new Database;

		$db->performQuery("DELETE FROM actions 
			WHERE lesson_time = :lesson_time AND chat_id = :chat_id", 
			array(":lesson_time", ":chat_id"),
			array($this->lesson_time, $this->chat_id));

	}

	public function getLastUpdated()
	{
		return $this->last_updated;
	}

	public function getLocation()
	{
		return $this->location;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	public function getTeacher()
	{
		return $this->teacher;
	}

	public function getClassGroup()
	{
		return $this->classgroup;
	}

	public function getCancelled()
	{
		return $this->cancelled;
	}

	public function getValid()
	{
		return $this->valid;
	}

	public function setLastUpdated($last_updated)
	{
		$this->last_updated = $last_updated;
	}

	public function setLocation($location)
	{
		$this->location = $location;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function setTeacher($teacher)
	{
		$this->teacher = $teacher;
	}

	public function setClassgroup($classgroup)
	{
		$this->classgroup = $classgroup;
	}

	public function setCancelled($cancelled)
	{
		$this->cancelled = $cancelled;
	}

	public function setValid($valid)
	{
		$this->valid = $valid;
	}
}

?>