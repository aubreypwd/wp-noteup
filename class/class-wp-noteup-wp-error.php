<?php
/**
 * Errors.
 *
 * @package aubreypwd\WP_Noteup
 * @since  1.1.0
 */

/**
 * Place to keep all the error messages.
 *
 * @author Aubrey Portwood
 * @since  1.1.0
 */
class WP_NoteUp_WP_Error {

	/**
	 * The errors.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @var object WP_Error object.
	 */
	private $errors;

	/**
	 * Construct.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 */
	function __construct() {
		$this->errors = array(
			'cmb2_not_loaded' => new WP_Error( '1', __( 'Our CMB2 library failed to load.', 'wp-noteup' ) ),
		);
	}

	/**
	 * Gets the error message by slug so we present the right error code.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @param  string $error_slug   The slug of the error.
	 *
	 * @return WP_Error             The WP_Error for that slug.
	 */
	function get_error( $error_slug ) {
		return $this->errors[ $error_slug ];
	}
}
