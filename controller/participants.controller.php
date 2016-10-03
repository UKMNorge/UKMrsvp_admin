<?php

require_once(__DIR__.'/../class/EventManager.php');

$api_key = 'test';
$api_secret = 'pah';
$eventManager = new EventManager($api_key, $api_secret);

$participants = $eventManager->findParticipants($_GET['id'], $owner);