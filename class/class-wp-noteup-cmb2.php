<?php
/**
 * Noteup CMB2 Setup.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.1.0
 */

/**
 * Noteup CMB2 Setup.
 *
 * @author Aubrey Portwood
 * @since  1.1.0
 */
class WP_NoteUp_CMB2 {

	/**
	 * Is CMB2 already loaded?
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @var boolean
	 */
	private $cmb2_loaded = false;

	/**
	 * CMB2 instance.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @var    object CMB2_Boxes
	 */
	private $cmb2;

	/**
	 * Includes the plugin files.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @return boolean If CMB2 was loaded or not.
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
	 * @since  1.1.0
	 *
	 * @return void Early bail if filters break the metaboxes we want to add.
	 */
	public function cmb2() {

		// The name of the metabox.
		$name = esc_html__( 'Notes', 'wp-noteup' );

		/**
		 * Filter the CMB2 Metabox fields.
		 *
		 * @author Aubrey Portwood
		 * @since  1.2.0
		 *
		 * @var array
		 */
		$cmb2_args = apply_filters( 'wp_noteup_cmb2', array(
			'id'            => 'wp-noteup-cmb2',
			'title'         => esc_html( $name ),
			'object_types'  => $this->object_types(),
			'context'       => 'normal',
			'show_names'    => false, // Show field names on the left.
		) );

		// Does this have the required keys?
		$has_keys = array_key_exists( 'id', $cmb2_args )
			&& array_key_exists( 'title', $cmb2_args )
			&& array_key_exists( 'object_types', $cmb2_args );

		if ( ! is_array( $cmb2_args ) || ! $has_keys ) {

			// They filtered it and it won't work.
			return;
		}

		// Create the CMB2 metabox.
		$this->cmb2 = new_cmb2_box( $cmb2_args );

		/**
		 * Filter the CMB2 fields.
		 *
		 * @author Aubrey Portwood
		 * @since  1.2.0
		 *
		 * @var array
		 */
		$cmb2_field_args = apply_filters( 'wp_noteup_cmb2_field', array(

			/**
			 * Filter the name of the metabox for Notes.
			 *
			 * @author Aubrey Portwood
			 * @since  1.2.0
			 */
			'name' => $name,
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
		) );

		// Does this have the required keys?
		$has_keys = array_key_exists( 'name', $cmb2_field_args ) &&
			array_key_exists( 'id', $cmb2_field_args ) &&
			array_key_exists( 'type', $cmb2_field_args ) &&
			array_key_exists( 'options', $cmb2_field_args );

		if ( ! is_array( $cmb2_field_args ) || ! $has_keys || 'wysiwyg' !== $cmb2_field_args['type'] ) {

			// Bail here the filter broke something.
			return;
		}

		$this->cmb2->add_field( $cmb2_field_args );
	}

	/**
	 * The object types (post types) to include WP NoteUp on.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @return array The post types.
	 */
	private function object_types() {
		$defaults = array( 'post', 'page' );
		$user_cpts = wp_noteup( 'Post_Type_Settings' )->get_option();

		if ( ! is_array( $user_cpts ) ) {
			$user_cpts = $defaults;
		}

		return array_merge( $defaults, $user_cpts );
	}
}
