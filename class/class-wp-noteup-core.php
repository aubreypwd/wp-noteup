<?php

class WP_NoteUp_Core {
	function __construct() {
		wp_die( "---" . wp_noteup_instance( 'WP_NoteUp_CMB2' ) );

		if ( wp_noteup_instance( 'WP_NoteUp_CMB2' )->cmb2_loaded ) {
			wp_die( 'cmb2 loaded' );
		}
	}
}
