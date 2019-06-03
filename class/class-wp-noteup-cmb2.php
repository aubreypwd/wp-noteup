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
	 * Construct
	 *
	 * @author Aubrey Portwood <aubrey@webdevstudios.com>
	 * @since  1.3.0
	 */
	public function __construct() {
		add_action( 'wp_ajax_wp_noteup_save', [ $this, 'ajax_save' ] );
	}

	/**
	 * Save autosave.
	 *
	 * @author Aubrey Portwood <code@aubreypwd.com>
	 * @since  1.3.0
	 */
	public function ajax_save() {
		check_admin_referer( 'wp_noteup_save', 'nonce' );

		$post_id = filter_input( INPUT_POST, 'post', FILTER_SANITIZE_NUMBER_INT );
		$content = wp_kses_post( filter_input( INPUT_POST, 'content' ) );

		if ( ! $post_id ) {
			wp_send_json_error( 'No Post ID.' );
		}

		wp_send_json_success( [
			'post'   => $post_id,
			'update' => update_post_meta( $post_id, 'wp-noteup', $content ),
		] );
	}

	/**
	 * Is CMB2 loaded?
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.0
	 *
	 * @since  1.3.0 We are now loading this via the vendor folder.
	 *
	 * @return boolean If CMB2 was loaded or not.
	 */
	public function include_cmb2() {
		if ( ! class_exists( 'CMB2' ) ) {

			// Load the vendor since composer isn't :/.
			return $this->cmb2_loaded = require_once dirname( __FILE__ ) . '/../lib/cmb2/init.php';
		}

		return $this->cmb2_loaded = false;
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
		global $wp_noteup_instances;

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
			'id'           => 'wp-noteup-cmb2',
			'title'        => esc_html( $name ),
			'object_types' => $this->object_types(),
			'context'      => 'normal',
			'show_names'   => false, // Show field names on the left.
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
			'name'    => $name,
			'id'      => 'wp-noteup',
			'type'    => 'wysiwyg',
			'options' => array(
				'wpautop'       => true,
				'media_buttons' => true,
				'textarea_rows' => 8,
				'teeny'         => true,
				'dfw'           => true,
				'tinymce'       => array(
					'paste_remove_styles'          => true,
					'paste_remove_spans'           => true,
					'paste_strip_class_attributes' => true,
					'wpeditimage_disable_captions' => true,
					'content_css'                  => false,
					'toolbar1'                     => 'bold,italic,bullist,link,unlink',
					'height'                       => $wp_noteup_instances['WP_NoteUp_Remember_Note_Height']->get_height(),
				),
				'quicktags'     => false,
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
	public function object_types() {
		$defaults = array(
			'post',
			'page',
		);

		$user_cpts = wp_noteup( 'Post_Type_Settings' )->get_option();

		if ( ! is_array( $user_cpts ) ) {
			$user_cpts = $defaults;
		}

		return array_merge( $defaults, $user_cpts );
	}
}
