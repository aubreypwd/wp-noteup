<?php

class WP_NoteUp extends WP_NoteUp_Plugin {
	function __construct() {
		parent::__construct( array( 'requesting_subclass' => get_class( $this ), ) );

		$this->add_cmb2();
	}

	public function add_cmb2() {
		require_once( 'class-wp-noteup-cmb2.php' );
		$this->wp_noteup_cmb2 = new WP_NoteUp_CMB2(); // CMB2 Stuff
	}
}
