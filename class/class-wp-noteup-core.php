<?php

class WP_NoteUp_Core {
	function __construct() {
		if ( ! wp_noteup( 'CMB2' )->cmb2_loaded ) {
			return wp_noteup( 'Error' )->get_error( 'cmb2_not_loaded' );
		}
	}
}
