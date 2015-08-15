<?php

/**
 * CMB2 Functionality
 *
 * The very first addon; extends Core. The rest should
 * extend the last addon.
 */
class WP_NoteUp_CMB2 extends WP_NoteUp_Core {
	public $WP_NoteUp_CMB2; // Set at least one var for testing proper extends.

	function __construct() {
		parent::__construct();

		$this->include_cmb2(); // Include the plugin files.
	}

	/**
	 * Includes the plugin files.
	 */
	private function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			require_once( dirname( __FILE__) . '/../cmb2/init.php' );
		}
	}
}
