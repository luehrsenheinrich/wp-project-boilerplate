<?php
/**
 * The block template for the 'lh/separator' block.
 *
 * @param array    $attributes The block attributes.
 * @param string   $content The block content.
 * @param WP_Block $block The block type.
 *
 * @package lhpbp\plugin
 */

use function WpMunich\lhpbp\plugin\plugin;

$attr = wp_parse_args(
	$attributes,
	array(
		'icon' => '',
	)
);

$icon = plugin()->svg()->get_svg(
	$attr['icon'],
	array(
		'attributes' => array(
			'width'  => '24',
			'height' => '24',
		),
	)
);

?>

<div <?php echo get_block_wrapper_attributes(); ?>>
	<?php if ( $icon ) : ?>
		<div class="icon">
			<?php echo $icon; ?>
		</div>
	<?php endif; ?>
	<p><?php _e( 'This is a demo block.', 'lhpbpp' ); ?></p>
</div>
