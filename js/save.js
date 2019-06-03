/**
 * Saving Notes via AJAX.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.3.0
 */

/* globals jQuery, tinyMCE, WPNoteUpSave */
if ( window.hasOwnProperty( 'WPNoteUpSave' ) ) {

	/*
	 * Saving Notes via AJAX.
	 *
	 * @author Aubrey Portwood
	 * @since  1.3.0 https://github.com/aubreypwd/wp-noteup/issues/49
	 */
	window.WPNoteUpSave = ( function( $, pub ) {

		/**
		 * Private methods.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @type {Object}
		 */
		var prv = {};

		/**
		 * Data of the last save.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @type {String}
		 */
		prv.lastSave = '';

		/**
		 * Ajax handler.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @type {Object} When defined, will be jQuery $.ajax object.
		 */
		prv.ajaxHandler = 'undefined';

		/**
		 * Save every X seconds.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @type {Number}
		 */
		pub.tick = 5000;

		/**
		 * Cached editor.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @type {String}|{Object} Becomes the tinyMCE object when we find it.
		 */
		prv.editorCache = 'unfound';

		/**
		 * Get our editor.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @param  {Boolean} cached Send false to get a fresh element.
		 * @return {Object}         Our TinyMCE editor.
		 */
		prv.editor = function( cached ) {
			if ( false !== cached && 'object' === typeof prv.editorCache ) {
				return prv.editorCache;
			}

			// TinyMCE is there...
			if ( window.hasOwnProperty( 'tinyMCE' ) ) {
				for ( var editor in tinyMCE.editors ) {

					// Our editor...
					if ( 'wp_noteup' === tinyMCE.editors[ editor ].id ) {

						// Cache the editor and return it.
						return prv.editorCache = tinyMCE.editors[ editor ];
					}
				}
			}

			return {

				/**
				 * Make sure getContent calls come back with something empty.
				 *
				 * @author Aubrey Portwood <code@aubreypwd.com
				 * @since  1.3.0
				 *
				 * @return {String} Empty string.
				 */
				getContent: function() {
					return '';
				}
			};
		};

		/**
		 * Save the content.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 *
		 * @param  {String} content Content from the editor.
		 */
		prv.save = function( content ) {
			if ( 'string' !== typeof content ) {

				// Make sure we have content.
				content = prv.editor().getContent();
			}

			if ( prv.lastSave === content ) {

				// No difference (set in below success).
				return;
			}

			// Pass the new updates to the backend.
			$.ajax( {
				method: 'post',
				url: pub.ajaxUrl,

				// Send this data.
				data: {
					action: 'wp_noteup_save',
					nonce: pub.nonce,
					content: content,
					post: jQuery( '#post_ID' ).val()
				},

				/**
				 * Success
				 *
				 * @author Aubrey Portwood <code@aubreypwd.com
				 * @since  1.3.0
				 */
				success: function() {

					// Remember the last save, so if it gets passed here again we don't do an AJAX request for the same stuff.
					prv.lastSave = content;
				},

				/**
				 * Failure
				 *
				 * @author Aubrey Portwood <code@aubreypwd.com
				 * @since  1.3.0
				 *
				 * @param  {Object} jqXHR  XHR.
				 * @param  {Number} status E.g. 200.
				 * @param  {Object} error  Error.
				 */
				error: function( jqXHR, status, error ) {

					// Tell the user this lame error message.
					alert( pub.l10n.ajaxError );

					// Log some data to look at.
					window.console.error( jqXHR, status, error );
				}
			} );
		};

		/**
		 * Watch our editor for changes.
		 *
		 * @author Aubrey Portwood <code@aubreypwd.com
		 * @since  1.3.0
		 */
		prv.listen = function() {

			// tinyMCE is there...
			if ( window.hasOwnProperty( 'tinyMCE' ) ) {

				// When editors get added...
				tinyMCE.on( 'AddEditor', function( event ) {

					// It's our editor...
					if ( 'wp_noteup' === event.editor.id ) {

						// Wait until there is a change.
						event.editor.on( 'keyup onchange', function() {
							setInterval( function() {

								// Every so often send saves.
								prv.save( event.editor.getContent() );
							}, pub.tick );
						} );
					}
				} );
			}
		};

		// Watch the editor.
		$( prv.listen );

		// Send back our public object.
		return pub;

	} ( jQuery, WPNoteUpSave ) );
}
