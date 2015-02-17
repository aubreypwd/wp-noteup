<?php

class WP_NoteUp {
	private $plugin_file;
	private $text_domain;
	private $version;
	private $plugin_headers;

	function __construct() {

		// Get the file data.
		$this->plugin_headers = get_file_data( dirname( __FILE__ ) .'/../wp-noteup.php', array(
			'name'        => 'Plugin Name',
			'plugin_uri'  => 'Plugin URI',
			'version'     => 'Version',
			'description' => 'Description',
			'author'      => 'Author',
			'author-uri'  => 'Author URI',
			'text-domain' => 'Text Domain',
			'domain-path' => 'Domain Path',
		), 'plugin' );

		// Set the name and version based on headers.
		$this->text_domain = $this->plugin_headers['text-domain'];
		$this->version = $this->plugin_headers['version'];

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	function set_plugin_file( $file ) {
		$this->plugin_file = $file;
	}

	function enqueue_scripts() {
		wp_enqueue_script( 'wp-noteup-js', plugins_url( 'js/wp-noteup.js', $this->plugin_file ), array( 'jquery' ), $this->plugin_data['version'], false );
	}

	function enqueue_styles() {
		wp_enqueue_style( 'wp-noteup-css', plugins_url( 'css/wp-noteup.css', $this->plugin_file ), array(), $this->plugin_data['version'], 'all' );
	}
}
