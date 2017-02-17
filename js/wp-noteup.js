/* globals jQuery */

if ( ! window.hasOwnProperty( 'WPNoteUp' ) ) {

	/*
	 * Main Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.4
	 */
	window.WPNoteUp = ( function( $, pub ) {

		/**
		 * Fix autosize issue.
		 *
		 * @author Aubrey Portwood
		 * @since  1.1.4
		 */
		function autoAutosize() {

			// Make sure that the textarea always auto-sizes.
			var $textarea = $( '.wp-noteup-textarea' );

			if ( $textarea.hasOwnProperty( 'autosize' ) ) {

				// Only when we can autosize.
				$textarea.autosize();
			}
		}

		/**
		 * Initialization.
		 *
		 * @author Aubrey Portwood
		 * @since  1.4
		 */
		function init() {

			// Page loaded.
			$( document ).ready( autoAutosize );
		}

		// On load, init!
		init();

		// Send back our public object.
		return pub;
	} )( jQuery, {} );
}
