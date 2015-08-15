<?php

class WP_NoteUp extends WP_NoteUp_Core {
	private $wp_noteup_cmb2;

	function __construct() {
		parent::__construct();

		$this->wp_noteup_cmb2 = new WP_NoteUp_CMB2(); // CMB2 Stuff
	}
}
