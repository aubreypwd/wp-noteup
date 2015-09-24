<?php

class WP_NoteUp_CMB2 {
	public $cmb2_loaded = false;
	public $cmb2;

	/**
	 * Includes the plugin files.
	 */
	public function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			if ( require_once( dirname( __FILE__) . '/../cmb2/init.php' ) ) {
				return $this->cmb2_loaded = true;
			}
		} else {
			return $this->cmb2_loaded = true;
		}
	}

	/**
	 * Setup the CMB2 box.
	 */
	public function cmb2() {
		$this->cmb2 = new_cmb2_box( apply_filters( 'wp_noteup_cmb2', array(
			'id'            => 'wp-noteup-cmb2',
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
			'name'    => __( 'NoteUp', 'wp-noteup' ),
			'id'      => 'wp-noteup',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop' => true, // use wpautop?
				'media_buttons' => true, // show insert/upload button(s)
				'textarea_rows' => 8,
				// 'editor_css' => '', // intended for extra styles for both visual and HTML editors buttons, needs to include the `<style>` tags, can use "scoped".
				// 'editor_class' => 'wp-noteup-tiny-mce', // add extra class(es) to the editor textarea
				'teeny' => true, // output the minimal editor config used in Press This
				'dfw' => true, // replace the default fullscreen with DFW (needs specific css)
				'tinymce' => array(
					// 'remove_linebreaks'            => false,
					// 'gecko_spellcheck'             => false,
					// 'keep_styles'                  => true,
					// 'accessibility_focus'          => true,
					// 'tabfocus_elements'            => 'major-publishing-actions',
					// 'media_strict'                 => false,
					'paste_remove_styles'          => true,
					'paste_remove_spans'           => true,
					'paste_strip_class_attributes' => true,
					// 'paste_text_use_dialog'        => true,
					'wpeditimage_disable_captions' => true,
					// 'plugins'                      => 'tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen',
					'content_css'                  => false,
					// 'wpautop'                      => true,
					// 'apply_source_formatting'      => false,
					// 'block_formats'                => "Paragraph = p; Heading 3 = h3; Heading 4 = h4",
					'toolbar1'                     => 'bold,italic,bullist,link,unlink',
					// 'toolbar2'                     => 'formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help ',
					// 'toolbar3'                     => '',
					// 'toolbar4'                     => '',
				), // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
				'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			),
		) ) );
	}
}
