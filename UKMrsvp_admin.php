<?php
/* 
Plugin Name: UKM RSVP-admin
Plugin URI: http://www.github.com/UKMNorge/UKMrsvp-admin
Description: Administrering av helårsverktøyet RSVP fra Wordpress.
Author: UKM Norge / A Hustad
Version: 1.0 
Author URI: http://www.github.com/AsgeirSH
*/

## HOOK MENU AND SCRIPTS
if(is_admin()) {
	require_once('UKM/inc/twig-js.inc.php');
	add_action('UKM_admin_menu', 'UKMrsvp_menu');
	add_action('wp_enqueue_scripts', 'UKMrsvp_scripts_and_styles' );
}


## CREATE A MENU
function UKMrsvp_menu() {
	global $UKMN;

	#add_menu_page('monstring', 'RSVP', 'RSVP', 'editor', 'UKMrsvp', 'UKMrsvp', 'http://ico.ukm.no/mapmarker-bubble-pink-32.png',20);
	$page = UKM_add_menu_page('resources', 'RSVP', 'RSVP', 'superadmin', 'UKMrsvp', 'UKMrsvp', 'http://ico.ukm.no/mapmarker-bubble-pink-19.png', 45);
	/*UKMrsvp&action=myEvents*/
	$subpage = UKM_add_submenu_page('UKMrsvp', 'Mine hendelser', 'Mine hendelser', 'editor', 'UKMrsvp_myEvents', 'UKMrsvp');
	$subpage = UKM_add_submenu_page('UKMrsvp', 'Alle hendelser', 'Alle hendelser', 'editor', 'UKMrsvp_events', 'UKMrsvp');
	#UKM_add_menu_page('norge','Lokalaviser', 'Lokalaviser', 'editor', 'UKMpr','UKMpr', 'http://ico.ukm.no/contact-menu.png', 11);
	#add_action( 'admin_print_styles-' . $page, 'UKMrsvp_scripts_and_styles' );
	UKM_add_scripts_and_styles('UKMrsvp', 'UKMrsvp_scripts_and_styles');
}

function UKMrsvp_scripts_and_styles() {
	wp_enqueue_script('TwigJS');

	wp_enqueue_script('WPbootstrap3_js');
	wp_enqueue_style('WPbootstrap3_css');
	wp_enqueue_media();
}

function UKMrsvp() {
	$TWIG = array();
	require_once('controller/layout.controller.php');

	#var_dump(strpos($_GET['page'], 'UKMrsvp_'));
	if(false === strpos($_GET['page'], 'UKMrsvp_')) {
		$VIEW = 'oversikt';
	} 
	else {
		$VIEW = substr($_GET['page'], 8);
	}

	#var_dump($VIEW);
	#$VIEW = isset( $_GET['action'] ) ? $_GET['action'] : 'oversikt';
	$TWIG['tab_active'] = $VIEW;
	require_once('controller/'. $VIEW .'.controller.php');
	
	echo TWIG($VIEW .'.html.twig', $TWIG, dirname(__FILE__), true);
	echo TWIGjs( dirname(__FILE__) );

}