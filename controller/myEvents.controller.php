<?php

require_once(__DIR__.'/../class/EventManager.php');

$events = array();
$owner = 'UKMNorge';
$api_key = 'test';
$api_secret = 'pah';
$eventManager = new EventManager($api_key, $api_secret);

// STORE
if(isset($_POST['name'])) {
	$data = $_POST;
	$data['owner'] = $owner;
	$saveResult = $eventManager->saveEvent($data);
	if($saveResult == true) {
		$TWIG['message'] = new stdClass();
		$TWIG['message']->success = true;
		$TWIG['message']->body = 'Lagret hendelsen "'.$data['name'].'".';
	}
	else {
		$TWIG['message'] = $saveResult;
	}
}

$events = $eventManager->fetchEvents($owner);
if($events->success == true) {
	$TWIG['events'] = $events->data;
}
if(isset($_GET['edit'])) {
	$id = $_GET['edit'];
	$TWIG['editEvent'] = loadEventFromEvents($id, $events);
}

function loadEventFromEvents($id, $events) {
	foreach($events->data as $event) {
		if($event->id == $id)
			return $event;
	}
}

