<?php

$tabs = array();
$tabs[] = (object) array( 'link' 		=> 'oversikt',
						  'header' 		=> 'Oversikt',
						  'icon'		=> 'info-button-256',
						  'description'	=> 'Hva er egentlig dette?');

$tabs[] = (object) array( 'link'		=> 'myEvents',
						  'header'		=> 'Mine hendelser',
						  'icon'		=> 'mapmarker-bubble-pink-256',
						  'description' => 'Administrer hendelser');

$tabs[] = (object) array( 'link'		=> 'events',
						  'header'		=> 'Andre hendelser',
						  'icon'		=> 'mapmarker-bubble-green-256',
						  'description' => 'Fra hele UKM-nettverket');

$TWIG['tabs'] = $tabs;