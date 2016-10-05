<?php
require_once(__DIR__.'/../class/EventManager.php');
$api_key = 'test';
$secretFinder = new SecretFinder();
$eventManager = new EventManager($api_key, $secretFinder->getSecret($api_key));

$events = $eventManager->fetchEvents($owner);

$ids = array();
foreach($events->data as $event) {
	$ids[] = $event->id;
}

if($events->success == false) {
	$TWIG['message'] = $events;
}
elseif(!in_array($_GET['id'], $ids)) {
	$TWIG['ingentilgang'] = true;
}
else {
	$TWIG['event'] = $eventManager->loadEventFromEvents($_GET['id'], $events);

	$attending = $eventManager->findAttending($_GET['id'], $owner);
	$waiting = $eventManager->findWaiting($_GET['id'], $owner);
	$notcoming = $eventManager->findNotComing($_GET['id'], $owner);

	if($attending->success == true)
		$TWIG['participants']['attending'] = buildStatusArray($attending->data);
	else
		$TWIG['message'] = $attending;

	if($waiting->success == true)
		$TWIG['participants']['waiting'] = buildStatusArray($waiting->data);
	else
		$TWIG['message'] = $waiting;

	if($notcoming->success == true)
		$TWIG['participants']['notcoming'] = buildStatusArray($notcoming->data);
	else
		$TWIG['message'] = $notcoming;
}

function buildStatusArray($data) {
	$people = array();
	$numbers = array();
	foreach($data as $d) {
		$people[] = $d;
		$numbers[] = $d->phone;
	}
	return array('people' => $people, 'numbers' => $numbers);
}