<?php

require_once("phpBB3/vendor/symfony/event-dispatcher/event.php");

class dataPlacedEvent extends Event{
	public const NAME = 'data.placed';
	protected $userdata;
	public function __construct($data){
		$this->userdata = $data;
	}
	public function getData()
    {
        return $this->userdata;
    }
}
?>
