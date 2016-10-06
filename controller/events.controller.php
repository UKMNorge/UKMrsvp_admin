<?php

$events = array();

require_once('UKM/curl.class.php');
require_once(__DIR__ .'/../class/Signer.php');

$api_key = 'ukmno_rsvp';
$secretFinder = new SecretFinder();
$signer = new Signer($api_key, $secretFinder->getSecret($api_key));

$settings = array();
$settings['time'] = time();
$settings['SIGNED_REQUEST'] = $signer->sign($settings['time']);
$settings['API_KEY'] = $api_key;


#var_dump($settings);
$time_start = microtime(true);
$curl = new UKMCURL();
// THIS DOESNT WORK
$curl->timeout(5);
$curl->post($settings);
// Curl har ikke HOST :/
$events = $curl->process('http://rsvp.ukm.dev/web/app_dev.php/api/events/all/');
$time_end = microtime(true);
// Logg this:
#echo '<br>CURL tok '.round(($time_end - $time_start), 2).' sekunder å fullføre.';

/*echo '<pre>';
var_dump($events);
echo '</pre>';
*/#echo '<br>Curl:<br>';
#var_dump($curl);
#echo '</pre>';
if(!is_object($events)) {
	$TWIG['message'] = new stdClass();
	$TWIG['message']->level = 'danger';
	$TWIG['message']->message = 'RSVP returnerte en feilstatus! Kontakt support.';
}
if($events->success == true) {
	$TWIG['events'] = $events->data;
	foreach($events->data as $event) {
		#var_dump($event->date_start);
	}
}
elseif($events->success == false) {
	$TWIG['message'] = new stdClass();
	$TWIG['message']->success = false;
	$TWIG['message']->body = 'RSVP returnerte følgende feil: '.$events->errors[0];
}
else {
	// TOOD: Message for feil.
	#$TWIG['message'] = 
}