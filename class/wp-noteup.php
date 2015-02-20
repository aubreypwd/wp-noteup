<?php

class WP_NoteUp extends WP_NoteUp_Core {

	/**
	 * Will hold the template instance.
	 *
	 * @var Class
	 */
	public $templates;

	function __construct() {

		// Setup shared base.
		parent::__construct();

		// Attach Templates.
		$this->templates = new WP_NoteUp_Templates();

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_init', array( $this, 'setup_noteups' ) );
		add_action( 'save_post', array( $this, 'save_post_noteup' ) );
	}

	/**
	 * Saves the NoteUp to the post's meta.
	 *
	 * @param string $post_id The ID of the post.
	 *
	 * @return void
	 */
	function save_post_noteup( $post_id ) {

		// Ensure we're getting the data for the right context.
		if ( ! wp_verify_nonce( $this->get_request( 'wp-noteup-textarea-nonce' ), 'wp-noteup-textarea' ) ) {
			return;
		}

		// Get the noteup
		$wp_noteup = $this->get_request( 'wp-noteup-textarea', array( $this, 'sanitize_wp_noteup_textarea' ) );

		// Save.
		update_post_meta( $post_id, 'wp-noteup', $wp_noteup );
	}

	/**
	 * Makes sure our NoteUp text does not have anything funky in it.
	 *
	 * @param string $value The NoteUp text.
	 *
	 * @return string The value if it meets all the tests. Exits if not.
	 */
	function sanitize_wp_noteup_textarea( $value ) {
		if( ! is_string( $value ) ) {
			wp_die( __( 'Sorry, but the data came back in a format we didn\'t understand, so we quit.', $this->text_domain ) );
		} else {
			return $value;
		}
	}

	/**
	 * Creates all our NoteUp's.
	 *
	 * @return void
	 */
	function setup_noteups() {

		/**
		 * Get all the post types.
		 *
		 * By default only the default post types are used. To include all post
		 * types, use...
		 *
		 *     function include_my_post_types( $post_type_args ) {
		 *         // Will allow all custom post types.
		 *         return '';
		 *     }
		 *
		 *     add_filter( 'wp_noteup_setup_noteups_post_types', 'include_my_post_types' );
		 *
		 * If you wish, you will then have to filter out unwanted post types using
		 * the `wp_noteup_setup_noteups_exclude` filter.
		 *
		 * @var [type]
		 */
		$post_types = get_post_types( apply_filters( 'wp_noteup_setup_noteups_post_types', array(
			'_builtin' => true,
			'show_ui' => true
		) ), 'names' );

		/**
		 * Post types to be excluded from having NoteUp's.
		 *
		 * You can modify what post types do or don't get included by using a filter like so:
		 *
		 *     function exclude_my_post_types( $post_types ) {
		 *         $post_types['my_custom_post_type'] = 'my_custom_post_type';
		 *         return $post_types;
		 *     }
		 *
		 *     add_filter( 'wp_noteup_setup_noteups_exclude', 'exclude_my_post_types' );
		 *
		 * @var array;
		 */
		$exclude = apply_filters( 'wp_noteup_setup_noteups_exclude', array( 'attachment' ) );

		// Add a meta box to each post type.
		foreach ( $post_types as $post_type ) {
			if ( ! in_array( $post_type, $exclude ) ) {
				add_meta_box( 'wp-noteup-meta-box', __( 'NoteUp', $this->text_domain ), array( $this->templates, 'meta_box_template' ), $post_type, 'side', 'default', 'wp-noteup-meta' );
			}
		}
	}

	/**
	 * Enqueue all the scripts.
	 *
	 * @return void
	 */
	function enqueue_scripts() {
		wp_enqueue_script( 'wp-noteup-js', plugins_url( 'js/wp-noteup.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wp-noteup-js-autosize', plugins_url( 'js/jquery.autosize.min.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
	}

	/**
	 * Enqueue all the styles.
	 *
	 * @return void
	 */
	function enqueue_styles() {
		wp_enqueue_style( 'wp-noteup-css', plugins_url( 'css/wp-noteup.css', $this->plugin_file ), array(), $this->version, 'all' );
	}
}
