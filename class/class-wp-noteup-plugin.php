<?php

class WP_NoteUp_Plugin {
	public $WP_NoteUp_Plugin; // Set at least one var for testing proper extends.

	public $plugin_file;
	public $version;
	public $plugin_headers;
	public $plugin_dir;

	function __construct() {
		// Plugin information.
		$this->set_plugin_file( dirname( __FILE__ ) . '/../wp-noteup.php' );
		$this->set_plugin_info();

		// Set the name and version based on headers.
		$this->version = $this->get_plugin_info( 'Version' );

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
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
