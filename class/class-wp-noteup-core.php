<?php

class WP_NoteUp_Core {
	function __construct() {
		$this->cmb2();
	}

	function cmb2() {
		if ( wp_noteup( 'CMB2' )->include_cmb2() ) {
			add_action( 'cmb2_init', array( wp_noteup( 'CMB2' ), 'cmb2' ) );
		} else {
			return wp_noteup( 'Error' )->get_error( 'cmb2_not_loaded' );
		}
	}
}
