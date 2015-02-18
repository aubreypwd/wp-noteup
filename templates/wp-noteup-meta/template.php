<?php

	// Ensure this field gets saved.
	wp_nonce_field( 'wp-noteup-textarea', 'wp-noteup-textarea-nonce' );

	// The post
	global $post;
?>
<div class="wp-noteup wp-noteup-wrapper">
	<textarea class="wp-noteup wp-noteup-textarea wp-noteup-textarea-hidden" name="wp-noteup-textarea"><?php echo $this->get_noteup( 'post', $post ); ?></textarea>
	<div class="wp-noteup wp-noteup-markup "><?php echo $this->get_noteup( 'post', $post ); ?></div>
</div>
