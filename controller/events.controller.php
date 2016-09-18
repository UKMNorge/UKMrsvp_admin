<?php

$events = array();

require_once('UKM/curl.class.php');
$settings = array();
$settings['API_KEY'] = 'test';

$time_start = microtime(true);
$curl = new UKMCURL();
// THIS DOESNT WORK
$curl->timeout(5);
$curl->post($settings);
// Curl har ikke HOST :/
$events = $curl->process('http://rsvp.ukm.dev/web/app_dev.php/api/v1/events/all/');
$time_end = microtime(true);
// Logg this:
#echo '<br>CURL tok '.round(($time_end - $time_start), 2).' sekunder å fullføre.';

#echo '<pre>';
#var_dump($events);
#echo '<br>Curl:<br>';
#var_dump($curl);
#echo '</pre>';
if(is_object($events) && $events->success == true) {
	$TWIG['events'] = $events->data;
	foreach($events->data as $event) {
		#var_dump($event->date_start);
	}
}
else {
	// TOOD: Message for feil.
	#$TWIG['message'] = 
}