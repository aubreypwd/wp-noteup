<?php

class WP_NoteUp extends WP_NoteUp_Base {

	public $templates;
	public $pro;

	function __construct() {

		// Setup shared base.
		parent::__construct();

		// Attach Templates.
		$this->templates = new WP_NoteUp_Templates();

		// Pro version.
		if ( class_exists( 'WP_NoteUp_Pro' ) ) {
			$this->$pro = new WP_NoteUp_Pro();
		}

		// Hooks
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_init', array( $this, 'setup_noteups' ) );
	}

	function setup_noteups() {

		// Get the post types.
		$post_types = get_post_types( array(
			'_builtin' => true,
			'show_ui' => true
		), 'names' );

		// Exclude these.
		$exclude = array(
			'attachment'
		);

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
		wp_enqueue_script( 'heartbeat' );
		wp_enqueue_script( 'wp-noteup-js', plugins_url( 'js/wp-noteup.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'wp-noteup-autosize', plugins_url( 'js/jquery.autosize.min.js', $this->plugin_file ), array( 'jquery' ), $this->version, false );
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
