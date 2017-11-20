/**
 * Helps remember the height of a note on a post.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.3
 */

/* globals jQuery */
if ( window.hasOwnProperty( 'wpNoteUp' ) ) {

	/*
	 * Main Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.3 https://github.com/aubreypwd/wp-noteup/issues/49
	 */
	window.wpNoteUp.rememberNoteHeight = ( function( $, pub ) {

		function remember() {
			debugger;
		}

		function init() {
			// var $resizers = $( '.mce-flow-layout-item' );

			// console.log( $resizers );

			// $resizers.on( 'click', remember );
		}

		$( document ).ready( init );

		// Send back our public object.
		return pub;
	} ( jQuery, {} ) );
}
