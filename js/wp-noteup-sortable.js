/* globals jQuery */

if ( ! window.hasOwnProperty( 'WPNoteUpSortable' ) ) {

	/*
	 * Main Module.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.4 https://github.com/aubreypwd/wp-noteup/issues/49
	 */
	window.WPNoteUpSortable = ( function( $, pub ) {

		/**
		 * Did we fix the sortable issue?
		 *
		 * @author Aubrey Portwood
		 * @since  1.1.4
		 *
		 * @type {Boolean} Defaults to false.
		 */
		var sortableSetup = false;

		/**
		 * Fix sortable issue.
		 *
		 * Because CMB2 TinyMCE content is lost when the postbox
		 * is moved around, we want to ensure that moving our
		 * metabox is disabled.
		 *
		 * @author Aubrey Portwood
		 * @since  1.1.4
		 */
		function fixSortableIssue() {

			// When we hover over our metabox...
			$( '#wp-noteup-cmb2' ).on( 'mouseenter mouseleave click', function() {

				if ( true === sortableSetup ) {

					// We already fixed the sortable, don't do it anymore.
					return;
				}

				// Where our metabox should be.
				var $normalSortables = $( '#normal-sortables' );

				// Get the current options so we retain postbox.js settings.
				var options = $normalSortables.sortable( 'option' );

				// Change the items to exclude our metabox, .postbox:not().
				options.items = options.items + ':not(#wp-noteup-cmb2)';

				// Destroy the old sortable.
				$normalSortables.sortable( 'destroy' );

				// Sort again with out options.
				$normalSortables.sortable( options );

				// Don't do this again.
				sortableSetup = true;
			} );
		}

		/**
		 * Initialization.
		 *
		 * @author Aubrey Portwood
		 * @since  1.4
		 */
		function init() {

			// Fix sortable when page finishes loading.
			$( document ).ready( fixSortableIssue );
		}

		// On load, init!
		init();

		// Send back our public object.
		return pub;
	} )( jQuery, {} );
}
