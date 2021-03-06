<?php

$tabs = array();

$tabs[] = (object) array( 'link'		=> '',
						  'header'		=> 'Mine hendelser',
						  'icon'		=> 'group-meeting-64',
						  'description' => 'Administrer hendelser');

$tabs[] = (object) array( 'link'		=> 'events',
						  'header'		=> 'Alle hendelser',
						  'icon'		=> 'map-child-64',
						  'description' => 'Fra hele UKM-nettverket');

$tabs[] = (object) array( 'link' 		=> 'hjelp',
						  'header' 		=> 'Hjelp',
						  'icon'		=> 'info-button-256',
						  'description'	=> 'Hva er egentlig dette?');

$TWIG['tabs'] = $tabs;

$site_type = get_option('site_type');
if ($site_type == 'kommune' || $site_type == 'fylke') {
	$owner = get_option('pl_id');
} else {
	$owner = 'UKMNorge';
}