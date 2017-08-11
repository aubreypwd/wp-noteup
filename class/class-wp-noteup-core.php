<?php
/**
 * Core.
 *
 * @package aubreypwd\WP_Noteup
 * @since  1.1
 */

/**
 * WP Noteup Core class.
 *
 * @author Aubrey Portwood
 * @since  1.0
 */
class WP_NoteUp_Core {

	/**
	 * Construct.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0
	 */
	function __construct() {

		// Load CMB2.
		$this->cmb2();
	}

	/**
	 * Load CMB2.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @return object|boolean True if we loaded CMB2, WP_Error object if we get an error.
	 */
	function cmb2() {
		if ( wp_noteup( 'CMB2' )->include_cmb2() ) {
			add_action( 'cmb2_init', array( wp_noteup( 'CMB2' ), 'cmb2' ) );
		} else {
			return wp_noteup( 'Error' )->get_error( 'cmb2_not_loaded' );
		}

		return true;
	}
}
