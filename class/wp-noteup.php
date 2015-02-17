<?php

class WP_NoteUp {
	private $plugin_file;
	private $text_domain;
	private $version;
	private $plugin_headers;

	function __construct() {

		// Set the name and version based on headers.
		$this->text_domain = $this->get_plugin_info( 'Text Domain' );
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
		$this->plugin_headers = get_file_data( dirname( __FILE__ ) .'/../wp-noteup.php', array(
			'Plugin Name' => 'Plugin Name',
			'Plugin URI' => 'Plugin URI',
			'Version' => 'Version',
			'Description' => 'Description',
			'Author' => 'Author',
			'Author URI' => 'Author URI',
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

	function set_plugin_file( $file ) {
		$this->plugin_file = $file;
	}

	/**
	 * Enqueue all the scripts.
	 *
	 * @return void
	 */
	function enqueue_scripts() {
		wp_enqueue_script( 'wp-noteup-js', plugins_url( 'js/wp-noteup.js', $this->plugin_file ), array( 'jquery' ), $this->plugin_data['version'], false );
	}

	/**
	 * Enqueue all the styles.
	 *
	 * @return void
	 */
	function enqueue_styles() {
		wp_enqueue_style( 'wp-noteup-css', plugins_url( 'css/wp-noteup.css', $this->plugin_file ), array(), $this->plugin_data['version'], 'all' );
	}
}
