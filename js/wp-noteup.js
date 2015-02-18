jQuery( function( $ ) {

	// Make it so the textarea never resizes.
	$( '.wp-noteup-textarea' ).autosize();

	$( 'body' )
		.on( 'click', '.wp-noteup-markup', function(){

			// Hide the HTML and show the textearea.
			$( this ).toggleClass( 'wp-noteup-markup-hidden' );
			$( '.wp-noteup-textarea' )
				.toggleClass( 'wp-noteup-textarea-hidden' )
				.focus();
		} )
		.on( 'blur, focusout', '.wp-noteup-textarea', function() {

			// Hide the textarea and show the HTML.
			$( this ).toggleClass( 'wp-noteup-textarea-hidden' );
			$( '.wp-noteup-markup' ).toggleClass( 'wp-noteup-markup-hidden' );
		} )
		.on( 'keyup', '.wp-noteup-textarea', function(){

			// Update the content of the note with the new content added via the textarea.
			$( '.wp-noteup-markup' ).html( $( this ).val() );
		} );
} );
