<?php

/*
Plugin Name: WP NoteUp
Plugin URI: https://github.com/aubreypwd/wp-noteup
Description: WP NoteUp allows you to take simple notes when you're editing your Posts or Pages.
Author: Aubrey Portwood
Version: 1.0
Author URI: http://aubreypwd.com/
Text Domain: wp-noteup
*/

// Make sure we aren't colliding with another function (rare?).
if ( ! function_exists( 'wp_noteup_init' ) ) {

	/**
	 * Creates our WP_NoteUp instance.
	 *
	 * @return void
	 */
	function wp_noteup_init() {

		// INIT
		require_once( 'class/class-wp-noteup-plugin.php' );

		$wp_noteup_core = new WP_NoteUp_Plugin(); // Plugin functions like versions, etc.
	}
} else {
	wp_die( __( 'Sorry but we can\'t activate WP NoteUp because it appears to be colliding with another theme or plugin.', 'wp-noteup' ) );
}

add_action( 'init', 'wp_noteup_init' );
