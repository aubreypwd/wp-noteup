<?php

/*
Plugin Name: WP NoteUp
Plugin URI:
Description:
Author: Aubrey Portwood
Version: 1.0-dev
Author URI:
Text Domain: wp-noteup
*/

if ( ! function_exists( 'wp_noteup_init' ) ) {
	/**
	 * Creates our WP_NoteUp instance.
	 * @return void
	 */
	function wp_noteup_init() {
		require_once( 'class/wp-noteup.php' );

		$wp_noteup = new WP_NoteUp();

		// Make sure the plugin file is always this file.
		$wp_noteup->set_plugin_file( __FILE__ );
	}
} else {
	wp_die( __( 'Sorry but we can\'t activate WP NoteUp because it appears to be colliding with another theme or plugin.', 'wp-noteup' ) );
}

add_action( 'init', 'wp_noteup_init' );
