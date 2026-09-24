<?php
/**
 * Dynamic editorial note. The theme owns its visual treatment.
 *
 * @var array $attributes Block attributes.
 * @var string $content Saved block content.
 *
 * @package lhpbp\plugin
 */

$note_content = $attributes['content'] ?? '';
if ( '' === trim( wp_strip_all_tags( $note_content ) ) ) {
	return;
}
?>
<aside <?php echo get_block_wrapper_attributes( array( 'class' => 'lhpbpp-editorial-note' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> >
	<div class="lhpbpp-editorial-note__content"><?php echo wp_kses_post( $note_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
</aside>
