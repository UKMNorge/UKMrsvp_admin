<?php

require_once(__DIR__.'/../class/EventManager.php');

$api_key = 'ukmno_rsvp';
$secretFinder = new SecretFinder();
$eventManager = new EventManager($api_key, $secretFinder->getSecret($api_key));

$participants = $eventManager->findParticipants($_GET['id'], $owner);