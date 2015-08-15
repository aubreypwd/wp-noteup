<?php

/**
 * This will become the next addon.
 */
class WP_NoteUp_Next_Addon extends WP_NoteUp_CMB2 {
	public $WP_NoteUp_Next_Addon; // Set at least one var for testing proper extends.

	function __construct() {
		parent::__construct();

		// wp_die( var_dump( $this ) );
	}
}
