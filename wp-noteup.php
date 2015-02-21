<?php

/*
Plugin Name: WP NoteUp
Plugin URI: https://github.com/aubreypwd/wp-noteup
Description: WP NoteUp allows you to take simple notes when you're editing your Posts or Pages.
Author: Aubrey Portwood
Version: 1.1-dev
Author URI: http://aubreypwd.com/
Text Domain: wp-noteup
*/

/**
 * Creates our WP_NoteUp instance.
 *
 * @return void
 */
function wp_noteup_init() {

	// The classes.
	require_once( 'class/wp-noteup-core.php' );
	require_once( 'class/wp-noteup.php' );
	require_once( 'class/wp-noteup-templates.php' );

	// Instances.
	$wp_noteup_base = new WP_NoteUp_Core();
	$wp_noteup = new WP_NoteUp();
}

add_action( 'init', 'wp_noteup_init' );
