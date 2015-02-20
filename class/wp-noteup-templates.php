<?php

class WP_NoteUp_Templates extends WP_NoteUp_Core {

	/**
	 * Current template loaded.
	 *
	 * @var string
	 */
	public $current_template;

	function __construct() {
		parent::__construct();
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
	 *     add_meta_box( 'wp-noteup-meta', __( 'NoteUp', $this->text_domain ), array( $this->templates, 'meta_box_template' ), $post_type, 'side', 'default', 'wp-noteup-meta' );
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
		require( "$this->plugin_dir/templates/$template/template.php" );
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
		require( "$this->plugin_dir/templates/$this->current_template/parts/$part.php" );
	}
}
