<?php
require_once("phpBB3/phpbb/event/dispatcher.php");
$data = $_POST['one'];
echo $data;
extract($phpbb_dispatcher->trigger_event('core.user_setup', compact($data)));
?>
<!--
//require_once("DataListener.php");
//echo $data;
//$listener = new DataListener();
//$dispatcher->addListener('greg.foo.action', [$listener, 'onFooAction']);
//$event = new dataPlacedEvent($data);
//$dispatcher->dispatch($event, dataPlacedEvent::NAME);
-->