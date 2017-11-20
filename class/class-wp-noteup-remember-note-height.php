<?php
/**
 * Errors.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.3.0
 */

/**
 * Place to keep all the error messages.
 *
 * @author Aubrey Portwood
 * @since  1.3.0
 */
class WP_NoteUp_Remember_Note_Height {

	/**
	 * Construct.
	 *
	 * @author Aubrey Portwood
	 * @since  1.3.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * When we load the right screen.
	 *
	 * @author Aubrey Portwood
	 * @since  1.3.0
	 *
	 * @param  WP_Screen $current_screen Current screen.
	 * @return void                      Early bail if we're not on the right screen.
	 */
	public function scripts( $current_screen ) {
		global $wp_noteup_instances;

		if ( ! in_array( get_current_screen()->post_type, $wp_noteup_instances['WP_NoteUp_CMB2']->object_types(), true ) ) {
			return;
		}

		// Remember the note height JS/AJAX.
		wp_enqueue_script( 'wp-noteup-remember-note-height', plugins_url( 'js/remember-note-height.js', $wp_noteup_instances['WP_NoteUp_Plugin']->plugin_file ), array( 'jquery', 'wp-noteup-js' ), time(), true );
	}
}
