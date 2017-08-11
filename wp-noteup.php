<?php
/**
 * Plugin Name: WP NoteUp
 * Plugin URI: https://wordpress.org/plugins/wp-noteup/
 * Description: WP NoteUp allows you to take simple notes when you're editing your posts or pages.
 * Version: 1.2
 * Author: Aubrey Portwood
 * Author URI: http://aubreypwd.com/
 * Text Domain: wp-noteup
 *
 * @package aubreypwd\WP_Noteup
 */

// Make sure we aren't colliding with another function (rare?).
if ( ! function_exists( 'wp_noteup_init' ) && ! function_exists( 'wp_noteup' ) && ! isset( $wp_noteup_instances ) ) {

	/**
	 * A cheater way to access other instances.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @var array
	 */
	$wp_noteup_instances = array();

	/**
	 * Creates our WP_NoteUp instances.
	 *
	 * Stores into an array that can be accessed later because
	 * I hate extends.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @return void
	 */
	function wp_noteup_init() {

		// Where we store instances.
		global $wp_noteup_instances;

		// Required files.
		require_once( 'class/class-wp-noteup-plugin.php' );
		require_once( 'class/class-wp-noteup-cmb2.php' );
		require_once( 'class/class-wp-noteup-wp-error.php' );
		require_once( 'class/class-wp-noteup-core.php' );

		// Instances.
		$wp_noteup_instances['WP_NoteUp_Plugin']     = new WP_NoteUp_Plugin();
		$wp_noteup_instances['WP_NoteUp_CMB2']       = new WP_NoteUp_CMB2();
		$wp_noteup_instances['WP_NoteUp_WP_Error']   = new WP_NoteUp_WP_Error();
		$wp_noteup_instances['WP_NoteUp_Core']       = new WP_NoteUp_Core();
	}

	/**
	 * Shorthand function for accessing class instances.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @param string $instance The name of the instance w/out WP_NoteUp.
	 *
	 * @return object          The instance.
	 */
	function wp_noteup( $instance ) {
		global $wp_noteup_instances;

		if ( isset( $wp_noteup_instances[ "WP_NoteUp_{$instance}" ] ) ) {
			return $wp_noteup_instances[ "WP_NoteUp_{$instance}" ];
		}
	}

	// Init!
	wp_noteup_init();

} else {

	// The function exists, not sure why!
	wp_die( esc_html__( "Sorry but we can't activate WP NoteUp because it appears to be colliding with another theme or plugin.", 'wp-noteup' ) );

} // End if().
