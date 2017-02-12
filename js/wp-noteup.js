/* globals jQuery */

if ( ! window.hasOwnProperty( 'WPNoteUp' ) ) {

	/*
	 * Main Module.
	 *
	 * This is where shared JS functionality and
	 * properties can be accessed.
	 */
	window.WPNoteUp = ( function( $, pub ) {

		/**
		 * Initialization.
		 *
		 * @author Aubrey Portwood
		 * @since  1.4
		 */
		function init() {

			// Make sure that the textarea always auto-sizes.
			var $textarea = $( '.wp-noteup-textarea' );

			console.log( $textarea );

			if ( $textarea.hasOwnProperty( 'autosize' ) ) {

				// Only when we can autosize.
				$textarea.autosize();

				console.log( 'autosize' );
			}
		}

		// On load.
		init();

		// Send back our public object.
		return pub;
	} )( jQuery, {} );
}
