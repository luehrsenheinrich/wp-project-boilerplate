<?php
/**
 * The template for the pagination within the loop.
 *
 * @var array $args Template arguments, including an optional WP_Query and CSS classes.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

$args = wp_parse_args(
	$args,
	array(
		'query'      => $GLOBALS['wp_query'],
		'classNames' => '',
	)
);

// Normalize pagination values before using them for links and visible text.
$total   = max( 1, (int) $args['query']->max_num_pages );
$current = max( 1, (int) $args['query']->get( 'paged' ) );

$classnames = classNames(
	$args['classNames'],
	'loop-pagination',
);

if ( $total > 1 ) : ?>
<nav class="<?php echo esc_attr( $classnames ); ?>" aria-label="<?php echo esc_attr__( 'Pagination', 'lhpbpt' ); ?>">
	<?php if ( $current > 1 ) : ?>
		<div class="prev">
			<a href="<?php echo esc_url( get_pagenum_link( $current - 1 ) ); ?>" data-page-target="<?php echo esc_attr( $current - 1 ); ?>" class="prev-link">
				<span class="screen-reader-text"><?php esc_html_e( 'Previous', 'lhpbpt' ); ?></span>
				<?php get_template_part( 'template-parts/icon', null, array( 'pointer' => 'chevron--left' ) ); ?>
			</a>
		</div>
	<?php endif; ?>
	<?php
	/*
		* NUMBERS Mobile.
		*/
	?>
	<div class="page-numbers page-numbers-mobile">
		<span class="has-primary-color"><?php esc_html_e( 'Page', 'lhpbpt' ); ?> <?php echo esc_html( $current ); ?></span> <span class="has-gray-color">/ <?php echo esc_html( $total ); ?></span>
	</div>
	<?php
		echo wp_kses_post(
			theme()->nav_menus()->paginate_links(
				array(
					'total'   => $total,
					'current' => $current,
				)
			)
		);
	?>
	<?php if ( $current < $total ) : ?>
		<div class="next">
			<a href="<?php echo esc_url( get_pagenum_link( $current + 1 ) ); ?>" data-page-target="<?php echo esc_attr( $current + 1 ); ?>" class="next-link">
				<span class="screen-reader-text"><?php esc_html_e( 'Next', 'lhpbpt' ); ?></span>
				<?php get_template_part( 'template-parts/icon', null, array( 'pointer' => 'chevron--right' ) ); ?>
			</a>
		</div>
	<?php endif; ?>
</nav>
<?php endif; ?>
