<?php

class WP_NoteUp {
	public $plugin_file;
	public $version;
	public $plugin_headers;
	public $plugin_dir;
	public $current_template;

	function __construct() {

		// Plugin information.
		$this->set_plugin_file( dirname( __FILE__ ) . '/../wp-noteup.php' );
		$this->set_plugin_info();

		// Set the name and version based on headers.
		$this->version = $this->get_plugin_info( 'Version' );

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_init', array( $this, 'setup_noteups' ) );
		add_action( 'save_post', array( $this, 'save_post_noteup' ) );
	}

	/**
	 * Set the plugin header info.
	 *
	 * @return void
	 */
	function set_plugin_info() {
		$this->plugin_headers = get_file_data( $this->plugin_file, array(
			'Plugin Name' => 'Plugin Name',
			'Plugin URI'  => 'Plugin URI',
			'Version'     => 'Version',
			'Description' => 'Description',
			'Author'      => 'Author',
			'Author URI'  => 'Author URI',
			'Text Domain' => 'Text Domain',
			'Domain Path' => 'Domain Path',
		), 'plugin' );
	}

	/**
	 * Get a particular header value.
	 *
	 * @param  string $key The value of the plugin header.
	 *
	 * @return void
	 */
	function get_plugin_info( $key ) {
		return $this->plugin_headers[ $key ];
	}

	/**
	 * Set the plugin file and plugin directory.
	 *
	 * @param string $file Usually __FILE__.
	 *
	 * @return void
	 */
	function set_plugin_file( $file ) {
		$this->plugin_file = $file;
		$this->plugin_dir = dirname( $file );
	}

	/**
	 * Get the value from $_REQUEST and apply filters to it.
	 *
	 * @param  string  $key The key in $_REQUEST[$key].
	 * @param  array $filter The filter to run in the format of array( $instance, 'callback' ).
	 *
	 * @return mixed|false The value after all the filters are run, or false if it doesn't exist in $_REQUEST.
	 */
	function get_request( $key, $filter = false ) {
		if ( $key && isset( $_REQUEST[ $key ] ) ) {
			if ( $filter ) {
				add_filter( 'wp_noteup_get_request', $filter );
			}
			$value = $_REQUEST[ $key ];
			$value = apply_filters( 'wp_noteup_get_request', $value );
			return $value;
		} else {
			return false;
		}
	}

	/**
	 * Get the value of the noteup.
	 *
	 * @param string $context The context for what the meta value is.
	 * @param mixed $post Any data needed to be passed, usually $post.
	 *
	 * @return string The value of the noteup.
	 */
	function get_noteup( $post ) {
		return apply_filters( 'wp_noteup_get_noteup', get_post_meta( $post->ID, 'wp-noteup', true ) );
	}

	/**
	 * Wrapper for accepting template call from add_meta_box.
	 *
	 * E.g.
	 *
	 *     add_meta_box( 'wp-noteup-meta', __( 'NoteUp', 'wp-noteup' ), array( $this->templates, 'meta_box_template' ), $post_type, 'side', 'default', 'wp-noteup-meta' );
	 *
	 * @param object $post WordPress Post.
	 * @param array $args Passed args from add_meta_box.
	 *
	 * @return void
	 */
	function meta_box_template( $post, $args ) {
		$this->load_template( $args['args'] );
	}

	/**
	 * Loads /templates/{template}/template.php.
	 *
	 * @param object $post WordPress Post.
	 * @param array $args Passed args from add_meta_box.
	 *
	 * @return void
	 */
	function load_template( $template ) {
		$this->current_template = $template;
		require( "{$this->plugin_dir}/templates/{$template}/template.php" );
	}

	/**
	 * Load a sub-part of the current template.
	 *
	 * E.g.
	 *
	 *     <?php $this->load_part( 'hello' ); ?>
	 *
	 * A current template has to be loaded via `load_template()`.
	 *
	 * Loads /templates/{$current_template}/parts/{part}.php
	 *
	 * @param string $part The filename to load without `.php`.
	 *
	 * @return void
	 */
	function load_part( $part ) {
		require( "{$this->plugin_dir}/templates/{$this->current_template}/parts/{$part}.php" );
	}

	/**
	 * Saves the NoteUp to the post's meta.
	 *
	 * @param string $post_id The ID of the post.
	 *
	 * @return void
	 */
	public function save_post_noteup( $post_id ) {

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
			wp_die( __( 'Sorry, but the data came back in a format we didn\'t understand, so we quit.', 'wp-noteup' ) );
		} else {
			return $value;
		}
	}

	/**
	 * Creates all our NoteUp's.
	 *
	 * @return void
	 */
	public function setup_noteups() {

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
				add_meta_box( 'wp-noteup-meta-box', __( 'NoteUp', 'wp-noteup' ), array( $this, 'meta_box_template' ), $post_type, 'side', 'default', 'wp-noteup-meta' );
			}
		}
	}

	/**
	 * Enqueue all the scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wp-noteup-js', plugins_url( 'js/wp-noteup.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wp-noteup-js-autosize', plugins_url( 'js/jquery.autosize.min.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
	}

	/**
	 * Enqueue all the styles.
	 *
	 * @return void
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-noteup-css', plugins_url( 'css/wp-noteup.css', $this->plugin_file ), array(), $this->version, 'all' );
	}
}
