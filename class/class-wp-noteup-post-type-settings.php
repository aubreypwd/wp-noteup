<?php
/**
 * Post Type Settings.
 *
 * @package aubreypwd\WPNoteup
 * @since  1.2.0
 */

/**
 * Post Type Settings.
 *
 * @author Aubrey Portwood
 * @since  1.2.0
 */
class WP_NoteUp_Post_Type_Settings {

	/**
	 * Hooks.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 */
	function __construct() {
		add_action( 'admin_init', array( $this, 'wp_settings' ) );
		add_action( 'admin_init', array( $this, 'save' ) );
	}

	/**
	 * Admin Initialization.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 */
	public function wp_settings() {
		add_settings_section( 'wp_noteup_section', 'WP NoteUp', false, 'general' );
		add_settings_field( 'wp_noteup_post_types', esc_html__( 'Other Post Types', 'wp-noteup' ), array( $this, 'html' ), 'general', 'wp_noteup_section' );
	}

	/**
	 * Save the Post Types.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @return void Early bail if it's not time to.
	 */
	public function save() {

		// @codingStandardsIgnoreLine: Direct access to $_POST okay.
		if ( ! isset( $_POST['option_page'] ) ) {
			return;
		}

		// @codingStandardsIgnoreLine: Direct access to $_POST okay.
		if ( ! isset( $_POST['action'] ) || 'update' !== $_POST['action'] ) {
			return;
		}

		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		// @codingStandardsIgnoreLine: Direct access to $_POST okay.
		if ( ! isset( $_POST['wp_noteup_post_types'] ) || ! is_array( $_POST['wp_noteup_post_types'] ) ) {
			delete_option( 'wp_noteup_post_types' );
				return;
		}

		// @codingStandardsIgnoreLine: Direct access to $_POST okay.
		$sent_post_types = array_map( array( $this, 'sanitize' ), $_POST['wp_noteup_post_types'] );

		// Get the existing post types.
		$registered_post_types = $this->get_cpts();

		foreach ( $sent_post_types as $cpt => $val ) {
			if ( ! post_type_exists( $cpt ) ) {

				// This CPT doesn't exist, remove it!
				unset( $sent_post_types[ $cpt ] );
			}
		}

		// Save to the database.
		update_option( 'wp_noteup_post_types', array_keys( $sent_post_types ) );
	}

	/**
	 * Sanitize the sent data.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @param  mixed $sent_post_types  The potential data.
	 * @return array                   An array of post types.
	 */
	private function sanitize( $sent_post_types ) {
		if ( ! is_array( $sent_post_types ) ) {
			return array();
		}

		$sanitized = array();
		foreach ( $sent_post_types as $cpt => $value ) {
			if ( ! is_string( $cpt ) ) {
				continue;
			}

			$sanitized[ $cpt ] = true;
		}

		return $sanitized;
	}

	/**
	 * The post type settings.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @return void Early bail if there are no other CPT's.
	 */
	public function html() {

		// No CPT's to choose from.
		if ( empty( $this->get_cpts() ) ) {
			?>
			<p class="description"><?php esc_html_e( 'No other post types. This is already enabled on posts and pages by default.', 'wp-noteup' ); ?></p>
			<?php

			// Bail.
			return;
		}

		?>
		<ul>
			<?php foreach ( $this->get_cpts() as $cpt ) : ?>
				<li><input type="checkbox" name="wp_noteup_post_types[<?php echo esc_attr( $cpt ); ?>]"<?php $this->is_checked( $cpt ); ?> /> <?php echo esc_html( $this->get_cpt_name( $cpt ) ); ?></li>
			<?php endforeach; ?>
		</ul>
		<p class="description"><?php esc_html_e( 'Enables notes on other post types.', 'wp-noteup' ); ?></p>
		<?php
	}

	/**
	 * Get a WP option that should be an array.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @return array          The option ensured it's an array.
	 */
	public function get_option() {
		$option = get_option( 'wp_noteup_post_types', array() );

		if ( ! is_array( $option ) ) {
			$option = array();
		}

		return $option;
	}

	/**
	 * Echo out 'checked' if the CPT is already in the options.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @param  string  $cpt The CPT name.
	 */
	private function is_checked( $cpt ) {
		if ( $this->checked( $cpt ) ) {
			?>checked<?php
		}
	}

	/**
	 * Is an option already checked (saved in the DB)?
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @param  string $cpt  The CPT name.
	 * @return boolean      True if the CPT is already there, false if not.
	 */
	private function checked( $cpt ) {
		$option = $this->get_option();

		if ( in_array( $cpt, $option, true ) || in_array( $cpt, $option, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the label/name of a CPT.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @param  string $cpt The Post Type name.
	 * @return string      The label.
	 */
	private function get_cpt_name( $cpt ) {
		$object = get_post_type_object( $cpt );

		if ( ! isset( $object->label ) ) {
			return '';
		}

		return $object->label;
	}

	/**
	 * Get CPT's we can hook WP NoteUp to.
	 *
	 * @author Aubrey Portwood
	 * @since  1.2.0
	 *
	 * @return array Post types we can add metaboxes to.
	 */
	public function get_cpts() {
		$post_types = get_post_types();

		$exclude_post_types = array(
			'revision',
			'nav_menu_item',
			'custom_css',
			'customize_changeset',
			'attachment',

			// Always on post and pages.
			'post',
			'page',
		);

		foreach ( $exclude_post_types as $post_type ) {
			if ( isset( $post_types[ $post_type ] ) ) {
				unset( $post_types[ $post_type ] );
			}
		}

		return $post_types;
	}
}
