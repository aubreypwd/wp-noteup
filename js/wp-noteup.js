/* globals jQuery */

if ( ! window.hasOwnProperty( 'WPNoteUp' ) ) {

	/*
	 * Shared Functionality Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.4
	 */
	window.WPNoteUp = ( function( $, pub ) {

		/**
		 * Modules.
		 *
		 * @author Aubrey Portwood
		 * @since  1.1.4
		 *
		 * When individual modules are loaded, their public functions are stacked here.
		 *
		 * @type {Array}
		 */
		pub.modules = [];

		// Send back our public object.
		return pub;
	} )( jQuery, {} );
}
