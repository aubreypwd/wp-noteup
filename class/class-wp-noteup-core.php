<?php
/**
 * Core.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.1.0
 */

/**
 * WP Noteup Core class.
 *
 * @author Aubrey Portwood
 * @since  1.0.0
 */
class WP_NoteUp_Core {

	/**
	 * Construct.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 */
	function __construct() {

		// Load CMB2.
		$this->cmb2();
	}

	/**
	 * Load CMB2.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @return object|boolean True if we loaded CMB2, WP_Error object if we get an error.
	 * @throws Exception      If we can't get CMB2 loaded.
	 */
	public function cmb2() {
		if ( wp_noteup( 'CMB2' )->include_cmb2() ) {
			add_action( 'cmb2_init', array( wp_noteup( 'CMB2' ), 'cmb2' ) );
			return true;
		}

		// @codingStandardsIgnoreLine: Throwing string of object.
		throw new Exception( print_r( wp_noteup( 'WP_Error' )->get_error( 'cmb2_not_loaded' ), true ) );
	}
}
