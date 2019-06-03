<?php
/**
 * Base.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.1.0
 */

/**
 * Base plugin class.
 *
 * @author Aubrey Portwood
 * @since  1.0.0
 */
class WP_NoteUp_Plugin {

	/**
	 * The plugin file.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @var string
	 */
	public $plugin_file;

	/**
	 * The plugin version (from the plugin header).
	 *
	 * @author Aubrey Portwood
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version;

	/**
	 * The plugin header info.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 * @var array
	 */
	public $plugin_headers;

	/**
	 * The plugin directory.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @var string.
	 */
	public $plugin_dir;

	/**
	 * Construct.
	 *
	 * @author Aubrey Portwood
	 * @since 1.0.0
	 */
	public function __construct() {
		// Plugin information.
		$this->set_plugin_file( dirname( __FILE__ ) . '/../wp-noteup.php' );
		$this->set_plugin_info();

		// Set the name and version based on headers.
		$this->version = $this->get_plugin_info( 'Version' );

		// Hooks.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Set the plugin header info.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 */
	public function set_plugin_info() {
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
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @param  string $key The value of the plugin header.
	 *
	 * @return array       The plugin headers.
	 */
	public function get_plugin_info( $key ) {
		return $this->plugin_headers[ $key ];
	}

	/**
	 * Set the plugin file and plugin directory.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @param string $file Usually __FILE__.
	 */
	public function set_plugin_file( $file ) {
		$this->plugin_file = $file;
		$this->plugin_dir  = dirname( $file );
	}

	/**
	 * Get the value from $_REQUEST and apply filters to it.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @param string $key    The key in $_REQUEST[$key].
	 * @param array  $filter The filter to run in the format of array( $instance, 'callback' ).
	 *
	 * @return mixed|false The value after all the filters are run, or false if it doesn't exist in $_REQUEST.
	 */
	public function get_request( $key, $filter = 'wp_noteup_get_request' ) {
		if ( $key && isset( $_REQUEST[ $key ] ) ) { // @codingStandardsIgnoreLine: No Nonce required.

			// The value to save.
			$original_value = sanitize_text_field( $_REQUEST[ $key ] ); // @codingStandardsIgnoreLine: No Nonce required.

			// The value to save, we'll filter it later.
			$value = $original_value;

			/**
			 * Filter the value.
			 *
			 * @author Aubrey Portwood
			 * @since  1.0.0
			 *
			 * @var string
			 */
			$value = apply_filters( $filter, $value );

			if ( ! is_string( $value ) ) {

				// The filter broke the value, so return the original.
				return $original_value;
			}

			return $value;
		} else {
			return false;
		}
	}

	/**
	 * Get the value of the noteup.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 *
	 * @param mixed $post Any data needed to be passed, usually $post.
	 *
	 * @return string The value of the noteup.
	 */
	public function get_noteup( $post ) {

		// The value of the note.
		$original_value = get_post_meta( $post->ID, 'wp-noteup', true );

		/**
		 * Filter the noteup data.
		 *
		 * @author Aubrey Portwood
		 * @since 1.0.0
		 *
		 * @var  string The data (note).
		 */
		$value = apply_filters( 'wp_noteup_get_noteup', $value );

		if ( ! is_string( $value ) ) {

			// Filter broke the value, use original.
			return $original_value;
		}

		return $value;
	}

	/**
	 * Enqueue all the scripts.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 */
	public function enqueue_scripts() {
		$this->enqueue_only_on_post_edit_screen();
	}

	/**
	 * Enqueue scripts only on the edit screen.
	 *
	 * Only enqueued on the post screen.
	 *
	 * @author Aubrey Portwood
	 * @since  1.1.4
	 */
	private function enqueue_only_on_post_edit_screen() {

		// The current screen in the admin.
		$screen = get_current_screen();
		if ( is_a( $screen, 'WP_Screen' ) && 'post' === $screen->base ) {

			wp_enqueue_script( 'jquery' );

			// Fix sortable issue.
			wp_enqueue_script( 'wp-noteup-js-sortable', plugins_url( 'js/wp-noteup-sortable.js', $this->plugin_file ), array( 'jquery' ), $this->version, true );

			// Save our data over AJAX.
			wp_enqueue_script( 'wp-noteup-js-save', plugins_url( 'js/wp-noteup-save.js', $this->plugin_file ), array( 'jquery' ), $this->version, true );
			wp_localize_script( 'wp-noteup-js-save', 'WPNoteUpSave', array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'wp_noteup_save' ),
				'l10n'    => array(
					'ajaxError' => esc_html( __( 'Sorry, there was an error and your notes may not have been saved.', 'wp-noteup' ) ),
				),
			) );
		}

		// Fix sortable issue.
		wp_enqueue_script( 'wp-noteup-js-sortable', plugins_url( 'js/wp-noteup-sortable.js', $this->plugin_file ), array( 'jquery', 'wp-noteup-js' ), $this->version, true );
	}

	/**
	 * Enqueue all the styles.
	 *
	 * @author Aubrey Portwood
	 * @since  1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-noteup-css', plugins_url( 'css/wp-noteup.css', $this->plugin_file ), array(), $this->version, 'all' );
	}
}
