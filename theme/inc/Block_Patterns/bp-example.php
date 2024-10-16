<?php
/**
 * Block Pattern: Example Pattern
 *
 * This file defines the HTML structure for the Example Pattern, a simple placeholder block
 * pattern used in the WordPress block editor. It is registered in the `Block_Patterns` component
 * and provides a sample content layout with a paragraph and an image.
 *
 * @package lhpbp\theme
 */

?>

<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide">
	<!-- wp:paragraph -->
	<p>A simple example pattern. If you can read this at prod call an admin.</p>
	<!-- /wp:paragraph -->

	<!-- wp:image {"id":,"sizeSlug":"large","linkDestination":"none", "align":"wide"} -->
	<figure class="wp-block-image alignwide">
		<img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/img/block-patterns/placeholder_000.png" alt="Placeholder Image" class=""/>
	</figure>
	<!-- /wp:image -->
</div>
<!-- /wp:group -->
