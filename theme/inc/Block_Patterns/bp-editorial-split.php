<?php
/**
 * Editable editorial layout pattern.
 *
 * @package lhpbp\theme
 */

?>
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
	<!-- wp:heading -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'A clear story starts here', 'lhpbpt' ); ?></h2>
	<!-- /wp:heading -->
	<!-- wp:columns -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Lead with the idea your readers need to understand.', 'lhpbpt' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Add context, evidence, or a different perspective in a second column.', 'lhpbpt' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
