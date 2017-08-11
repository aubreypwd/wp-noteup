<?php
/**
 * Noteup CMB2 Setup.
 *
 * @package aubreypwd\WP_Noteup
 * @since  1.1
 */

/**
 * Noteup CMB2 Setup.
 *
 * @author Aubrey Portwood
 * @since  1.1
 */
class WP_NoteUp_CMB2 {

	/**
	 * Is CMB2 already loaded?
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @var boolean
	 */
	public $cmb2_loaded = false;

	/**
	 * CMB2 instance.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 *
	 * @var    object CMB2_Boxes
	 */
	public $cmb2;

	/**
	 * Includes the plugin files.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 */
	public function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {
			if ( require_once( dirname( __FILE__ ) . '/../cmb2/init.php' ) ) {
				$this->cmb2_loaded = true;
				return $this->cmb2_loaded;
			}
		} else {
			$this->cmb2_loaded = true;
			return $this->cmb2_loaded;
		}
	}

	/**
	 * Setup the CMB2 box.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1
	 */
	public function cmb2() {
		$this->cmb2 = new_cmb2_box( apply_filters( 'wp_noteup_cmb2', array(
			'id'            => 'wp-noteup-cmb2',
			'title'         => 'NoteUp',
			'object_types'  => array( 'post', 'page' ), // Post.
			'context'       => 'normal',
			'show_names'    => false, // Show field names on the left.
		) ) );

		$this->cmb2->add_field( apply_filters( 'wp_noteup_cmb2_field', array(
			'name' => __( 'NoteUp', 'wp-noteup' ),
			'id'   => 'wp-noteup',
			'type' => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => 8,
				'teeny'         => true,
				'dfw'           => true,
				'tinymce' => array(
					'paste_remove_styles'          => true,
					'paste_remove_spans'           => true,
					'paste_strip_class_attributes' => true,
					'wpeditimage_disable_captions' => true,
					'content_css'                  => false,
					'toolbar1'                     => 'bold,italic,bullist,link,unlink',
				),
				'quicktags' => false,
			),
		) ) );
	}
}
