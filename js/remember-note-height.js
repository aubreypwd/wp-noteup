/**
 * Helps remember the height of a note on a post.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.3
 */

/* globals jQuery */
if ( window.hasOwnProperty( 'wpNoteUpRememberHeight' ) ) {

	/*
	 * Main Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.3 https://github.com/aubreypwd/wp-noteup/issues/49
	 */
	window.wpNoteUp.rememberNoteHeight = ( function( $, pub ) {
		var often = 2000;

		/**
		 * Remember the height of the element.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @param  {Object} $el Element.
		 */
		function remember( $el ) {
			$.ajax( {
				method: 'post',
				url: pub.ajaxUrl,

				// Send this data.
				data: {
					action: 'wp_noteup_remember_height',
					height: $el.css( 'height' ),
					post: $( '#post_ID' ).val()
				}
			} );
		}

		/**
		 * Track the Element
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @param  {Object} $el Element.
		 */
		function track( $el ) {
			var style = '';

			setInterval( function() {
				if ( '' !== style && $el.attr( 'style' ) !== style ) {
					remember( $el );
				}

				style = $el.attr( 'style' );
			}, often );
		}

		/**
		 * Find Height Element
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 */
		function find() {
			var breakInterval = false;

			var interval = setInterval( function() {
				if ( breakInterval ) {
					clearInterval( interval );
				}

				var $el = $( '#wp_noteup_ifr' );

				if ( ! $el.length ) {
					return;
				}

				track( $el );
			}, often );
		}

		$( document ).ready( find );

		// Send back our public object.
		return pub;
	} ( jQuery, window.wpNoteUpRememberHeight ) );
}
