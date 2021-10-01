<?php

require_once("phpBB3/vendor/symfony/event-dispatcher/eventdispatcher.php");

class DataListener{
	
	public function onFooAction(Event $event){
		echo $event->$data;
		echo $event->$data;
	}
	
}
?>
