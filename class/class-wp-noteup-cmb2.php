<?php

class WP_NoteUp_CMB2 extends WP_NoteUp_Core {
	function __construct() {
		parent::__construct();

		$this->include_cmb2();
	}

	private function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			require_once( dirname( __FILE__) . '/../cmb2/init.php' );
		}
	}
}
