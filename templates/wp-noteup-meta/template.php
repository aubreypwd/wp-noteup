<?php

	/**
	 * Outputs the textarea where the user can take notes in the post/page metabox.
	 */

	// Ensure this field gets saved.
	wp_nonce_field( 'wp-noteup-textarea', 'wp-noteup-textarea-nonce' );

	// The post.
	global $post;
?>
<div class="wp-noteup wp-noteup-wrapper">
	<textarea class="wp-noteup wp-noteup-textarea" name="wp-noteup-textarea"><?php echo $this->get_noteup( $post ); ?></textarea>
</div>
