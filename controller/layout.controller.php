<?php

$tabs = array();
$tabs[] = (object) array( 'link' 		=> '',
						  'header' 		=> 'Oversikt',
						  'icon'		=> 'info-button-256',
						  'description'	=> 'Hva er egentlig dette?');

$tabs[] = (object) array( 'link'		=> 'myEvents',
						  'header'		=> 'Mine hendelser',
						  'icon'		=> 'mapmarker-bubble-pink-256',
						  'description' => 'Administrer hendelser');

$tabs[] = (object) array( 'link'		=> 'events',
						  'header'		=> 'Alle hendelser',
						  'icon'		=> 'mapmarker-bubble-green-256',
						  'description' => 'Fra hele UKM-nettverket');

$TWIG['tabs'] = $tabs;

$site_type = get_option('site_type');
if ($site_type == 'kommune' || $site_type == 'fylke') {
	$owner = get_option('pl_id');
} else {
	$owner = 'UKMNorge';
}