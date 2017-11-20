/**
 * Main JS.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.1.4
 */

/* globals jQuery */

if ( ! window.hasOwnProperty( 'wpNoteUp' ) ) { // Yeah, it's disabled, read below if you must.

	/*
	 * Shared Functionality Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.4
	 */
	window.wpNoteUp = ( function( $, pub ) {

		/**
		 * Nothing here yet.
		 *
		 * There used to be something here, but then we didn't need
		 * it anymore. So, what we did, was just left this here just
		 * in case we need it again.
		 */

		// Send back our public object.
		return pub;
	} ( jQuery, {} ) );
}
