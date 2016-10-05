<?php

require_once(__DIR__.'/../class/EventManager.php');

$events = array();
$api_key = 'test';
$secretFinder = new SecretFinder();
$eventManager = new EventManager($api_key, $secretFinder->getSecret($api_key));

// STORE
if(isset($_POST['name'])) {
	$data = $_POST;
	$data['date_start'] = $_POST['date_start'].' '.$_POST['time_start'];
	$data['date_stop'] = $_POST['date_stop'].' '.$_POST['time_stop'];
	$data['owner'] = $owner;
	$saveResult = $eventManager->saveEvent($data);
	if($saveResult->success == true) {
		$TWIG['message'] = new stdClass();
		$TWIG['message']->success = true;
		$TWIG['message']->body = 'Lagret hendelsen "'.$data['name'].'".';
	}
	else {
		$TWIG['message'] = $saveResult;
	}
}

$events = $eventManager->fetchEvents($owner);
#var_dump($events);
if($events->success == true) {
	$TWIG['events'] = $events->data;
}
else {
	$TWIG['message'] = $events;
}
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$TWIG['editEvent'] = $eventManager->loadEventFromEvents($id, $events);
}
