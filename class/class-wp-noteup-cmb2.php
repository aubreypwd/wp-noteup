<?php

class WP_NoteUp_CMB2 {
	public $cmb2_loaded = false;
	public $cmb2;

	function __construct() {
		if ( $this->include_cmb2() ) {
			add_action('cmb2_init', array( $this, 'cmb2' ) );
		} else {
			return wp_noteup( 'Error' )->get_error( 'cmb2_not_loaded' );
		}
	}

	/**
	 * Includes the plugin files.
	 */
	private function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			if ( require_once( dirname( __FILE__) . '/../cmb2/init.php' ) ) {
				return $this->cmb2_loaded = true;
			}
		} else {
			return $this->cmb2_loaded = true;
		}
	}

	function cmb2() {
		$this->cmb2 = new_cmb2_box( apply_filters( 'wp_noteup_cmb2', array(
			'id'            => 'wp_noteup_cmb2',
			'title'         => 'NoteUp',
			'object_types'  => array( 'post', 'page', ), // Post
			'context'       => 'side',
			// 'priority'      => 'high',
			'show_names'    => false, // Show field names on the left
			// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // true to keep the metabox closed by default
		) ) );

		$this->cmb2->add_field( apply_filters( 'wp_noteup_cmb2_field', array(
			'name'    => 'Test wysiwyg',
			'id'      => 'wp_noteup',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop' => true, // use wpautop?
				'media_buttons' => false, // show insert/upload button(s)
				'textarea_rows' => 8,
				'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
				'editor_class' => 'wp-noteup-tiny-mce', // add extra class(es) to the editor textarea
				'teeny' => true, // output the minimal editor config used in Press This
				'dfw' => true, // replace the default fullscreen with DFW (needs specific css)
				'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			),
	) ) );
	}
}
