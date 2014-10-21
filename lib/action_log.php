<?php
class ActionLog{
	private $userid;
	private $action;

	public function __construct($userid, $action) {
		$this -> userid = $userid;
		$this -> action = $action;
		$this -> add_log();
	}

	public function add_log() {
		$sql = "INSERT INTO `action_log` (`user_id`, `action`) VALUES ('".$this->userid."', '".$this->action."')";
		mysql_query($sql) or die(mysql_error());
	}
}