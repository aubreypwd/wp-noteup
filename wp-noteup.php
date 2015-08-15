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
	 * A cheater way to access other instances.
	 * @var array
	 */
	$wp_noteup_instances = array();

	/**
	 * Creates our WP_NoteUp instance.
	 *
	 * @return void
	 */
	function wp_noteup_init() {
		global $wp_noteup_instances;

		// Files (last one on bottom).
		require_once( 'class/class-wp-noteup-plugin.php' );
		require_once( 'class/class-wp-noteup-core.php' );
		require_once( 'class/class-wp-noteup-cmb2.php' );
		require_once( 'class/class-wp-noteup-next-addon.php' );

		// Instances (last one on top).
		$wp_noteup_instances['WP_NoteUp_Next_Addon'] = new WP_NoteUp_Next_Addon();
		$wp_noteup_instances['WP_NoteUp_CMB2'] = new WP_NoteUp_CMB2();
		$wp_noteup_instances['WP_NoteUp_Core'] = new WP_NoteUp_Core();
		$wp_noteup_instances['WP_NoteUp_Plugin'] = new WP_NoteUp_Plugin();
	}

	function wp_noteup_instance( $instance ) {
		global $wp_noteup_instances;

		if ( isset( $wp_noteup_instances[ $instance ] ) ) {
			return $wp_noteup_instances[ $instance ];
		}
	}

} else {
	wp_die( __( 'Sorry but we can\'t activate WP NoteUp because it appears to be colliding with another theme or plugin.', 'wp-noteup' ) );
}

add_action( 'init', 'wp_noteup_init' );
