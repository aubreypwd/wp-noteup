<?php
/*
Plugin Name: WP NoteUp
Plugin URI: https://wordpress.org/plugins/wp-noteup/
Description: WP NoteUp allows you to take simple notes when you're editing your Posts or Pages.
Author: Aubrey Portwood
Version: 1.1.3
Author URI: http://aubreypwd.com/
Text Domain: wp-noteup
*/

// Make sure we aren't colliding with another function (rare?).
if ( ! function_exists( 'wp_noteup_init' ) && ! function_exists( 'wp_noteup' ) && ! isset( $wp_noteup_instances ) ) {

	/**
	 * A cheater way to access other instances.
	 * @var array
	 */
	$wp_noteup_instances = array();

	/**
	 * Creates our WP_NoteUp instances.
	 *
	 * Stores into an array that can be accessed later because
	 * I hate extends.
	 *
	 * @return void
	 */
	function wp_noteup_init() {
		global $wp_noteup_instances;

		require_once( 'class/class-wp-noteup-plugin.php' );
		$wp_noteup_instances['WP_NoteUp_Plugin']     = new WP_NoteUp_Plugin();

		require_once( 'class/class-wp-noteup-cmb2.php' );
		$wp_noteup_instances['WP_NoteUp_CMB2']       = new WP_NoteUp_CMB2();

		require_once( 'class/class-wp-noteup-wp-error.php' );
		$wp_noteup_instances['WP_NoteUp_WP_Error'] = new WP_NoteUp_WP_Error();

		require_once( 'class/class-wp-noteup-core.php' );
		$wp_noteup_instances['WP_NoteUp_Core']       = new WP_NoteUp_Core();
	}

	/**
	 * Shorthand function for accessing class instances.
	 *
	 * @param  string $instance The name of the instance w/out WP_NoteUp_
	 *
	 * @return object           The instance.
	 */
	function wp_noteup( $instance ) {
		global $wp_noteup_instances;

		if ( isset( $wp_noteup_instances[ "WP_NoteUp_{$instance}" ] ) ) {
			return $wp_noteup_instances[ "WP_NoteUp_{$instance}" ];
		}
	}

	wp_noteup_init();

} else {
	wp_die( __( 'Sorry but we can\'t activate WP NoteUp because it appears to be colliding with another theme or plugin.', 'wp-noteup' ) );
}
