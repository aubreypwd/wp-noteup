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
		global $wp_noteup_instances;

		$this->wp_noteup_instances = $wp_noteup_instances;

		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'wp_ajax_wp_noteup_remember_height', [ $this, 'remember' ] );
	}

	/**
	 * Remember the height.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.3.0
	 */
	public function remember() {
		$height = filter_input( INPUT_POST, 'height', FILTER_SANITIZE_STRING );

		if ( ! strstr( $height, 'px' ) ) {
			wp_send_json_error();
		}

		update_user_meta( get_current_user_id(), 'wp_noteup_editor_height', $this->sanitize_height( $height ) );

		wp_send_json_success();
	}

	/**
	 * Get the remembered height.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.3.0
	 *
	 * @return int The height.
	 */
	public function get_height() {
		$height = get_user_meta( get_current_user_id(), 'wp_noteup_editor_height', true );

		if ( ! $height ) {
			$height = 250;
		}

		return $height;
	}

	/**
	 * Sanitize the height from AJAX.
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.3.0
	 *
	 * @param  string $height Height e.g. 200px.
	 * @return int            Height e.g. 200.
	 */
	private function sanitize_height( $height ) {
		return absint( str_replace( 'px', '', $height ) );
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
		if ( ! $this->is_editable_screen() ) {
			return;
		}

		wp_enqueue_script( 'wp-noteup-remember-note-height', plugins_url( 'js/remember-note-height.js', $this->wp_noteup_instances['WP_NoteUp_Plugin']->plugin_file ), array( 'jquery' ), time(), true );
		wp_localize_script( 'wp-noteup-remember-note-height', 'wpNoteUpRememberHeight', [
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		] );
	}

	private function is_editable_screen() {
		return in_array( get_current_screen()->post_type, $this->wp_noteup_instances['WP_NoteUp_CMB2']->object_types(), true );
	}
}
