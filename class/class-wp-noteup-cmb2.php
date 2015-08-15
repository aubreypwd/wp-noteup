<?php

class WP_NoteUp_CMB2 {
	public $WP_NoteUp_CMB2; // Set at least one var for testing proper extends.
	public $cmb2_loaded = false;

	function __construct() {
		$this->include_cmb2(); // Include the plugin files.
	}

	/**
	 * Includes the plugin files.
	 */
	private function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			if ( require_once( dirname( __FILE__) . '/../cmb2/init.php' ) ) {
				$this->cmb2_loaded = true;
			}
		} else {
			$this->cmb2_loaded = true;
		}
	}
}
