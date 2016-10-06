<?php
require_once('UKM/curl.class.php');
require_once(__DIR__ .'/Signer.php');	

class EventManager {

	private $createURL;
	private $updateURL;
	private $ownerURL;
	private $participantsURL;

	public function __construct($api_key, $api_secret) {
		$this->api_key = $api_key;
		$this->api_secret = $api_secret;
		$this->signer = new Signer($this->api_key, $this->api_secret);

		if(UKM_HOSTNAME == 'ukm.dev') {
			$this->createURL = 'http://rsvp.ukm.dev/web/app_dev.php/api/events/new/';
			$this->updateURL = 'http://rsvp.ukm.dev/web/app_dev.php/api/events/edit/';
			$this->ownerURL = 'http://rsvp.ukm.dev/web/app_dev.php/api/events/owner/';
			$this->participantsURL = 'http://rsvp.ukm.dev/web/app_dev.php/api/participants/';
		}
		else {
			$this->createURL = 'http://rsvp.ukm.no/api/events/new/';
			$this->updateURL = 'http://rsvp.ukm.no/api/events/edit/';
			$this->ownerURL = 'http://rsvp.ukm.no/api/events/owner/';
			$this->participantsURL = 'http://rsvp.ukm.no/api/participants/';
		}
	}

	public function saveEvent($data) {
		$result = new stdClass();

		$event_id = $data['event_id'];
		$event_name = $data['name'];
		$event_date_start = $data['date_start'];
		#$event_image = $data['image'];
		$event_date_stop = $data['date_stop'];
		$event_spots = $data['spots'];
		$event_description = $data['description'];

		#var_dump($data);
		if(null == $event_name || null == $event_date_start || null == $event_date_stop || null == $event_spots || null == $event_description) {
			$result->success = false;
			$result->errors[] = 'Noe informasjon mangler!';
			#var_dump($data);
			return $result;
		}

		$data['time'] = time();
		$data['SIGNED_REQUEST'] = $this->signer->sign($data['time']);
		$data['API_KEY'] = $this->api_key;

		$curl = new UKMCURL();
		$curl->post($data);
		if(null != $event_id) {
			$result = $curl->process($this->updateURL);
		}
		else {
			$result = $curl->process($this->createURL);
		}

		return $this->handleResult($result);
	}


	public function fetchEvents($owner) {

		$settings = array();
		$settings['time'] = time();
		$settings['SIGNED_REQUEST'] = $this->signer->sign($settings['time']);
		$settings['API_KEY'] = $this->api_key;
		$settings['owner'] = $owner;

		#var_dump($settings);
		$time_start = microtime(true);
		$curl = new UKMCURL();
		// TIMEOUTS DOESNT WORK
		$curl->timeout(5);
		$curl->post($settings);
		$events = $curl->process($this->ownerURL);
		$time_end = microtime(true);
		
		return $this->handleResult($events);
	}

	public function findParticipants($event_id, $owner) {
		$settings = array();
		$settings['time'] = time();
		$settings['SIGNED_REQUEST'] = $this->signer->sign($settings['time']);
		$settings['API_KEY'] = $this->api_key;
		$settings['event_id'] = $event_id;
		$settings['owner'] = $owner;

		$time_start = microtime(true);
		$curl = new UKMCURL();
		$curl->post($settings);
		$participants = $curl->process($this->participantsURL.'all/');
		return $this->handleResult($participants);
	}

	public function findAttending($event_id, $owner) {
		$settings = array();
		$settings['time'] = time();
		$settings['SIGNED_REQUEST'] = $this->signer->sign($settings['time']);
		$settings['API_KEY'] = $this->api_key;
		$settings['event_id'] = $event_id;
		$settings['owner'] = $owner;

		$time_start = microtime(true);
		$curl = new UKMCURL();
		$curl->post($settings);
		$participants = $curl->process($this->participantsURL.'attending/');
		return $this->handleResult($participants);
	}

	public function findWaiting($event_id, $owner) {
		$settings = array();
		$settings['time'] = time();
		$settings['SIGNED_REQUEST'] = $this->signer->sign($settings['time']);
		$settings['API_KEY'] = $this->api_key;
		$settings['event_id'] = $event_id;
		$settings['owner'] = $owner;

		$time_start = microtime(true);
		$curl = new UKMCURL();
		$curl->post($settings);
		$participants = $curl->process($this->participantsURL.'waiting/');
		return $this->handleResult($participants);
	}

	public function findNotComing($event_id, $owner) {
		$settings = array();
		$settings['time'] = time();
		$settings['SIGNED_REQUEST'] = $this->signer->sign($settings['time']);
		$settings['API_KEY'] = $this->api_key;
		$settings['event_id'] = $event_id;
		$settings['owner'] = $owner;

		$time_start = microtime(true);
		$curl = new UKMCURL();
		$curl->post($settings);
		$participants = $curl->process($this->participantsURL.'notcoming/');
		return $this->handleResult($participants);
	}

	private function handleResult($result) {
		if(!is_object($result)) {
			$message = new stdClass();
			$message->success = false;
			$message->level = 'danger';
			$message->body = 'RSVP returnerte en feilstatus! Kontakt support.';
			return $message;
		}
		elseif($result->success == false) {
			$message = new stdClass();
			$message->success = false;
			$message->level = 'danger';
			$message->body = 'RSVP returnerte følgende feil: '.$result->errors[0];
			return $message;
		}
		else 
			return $result;
	}

	public function loadEventFromEvents($id, $events) {
		foreach($events->data as $event) {
			if($event->id == $id)
				return $event;
		}
	}

}