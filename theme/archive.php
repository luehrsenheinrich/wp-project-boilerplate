<?php
/**
 * The archive template file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

get_header();
lh_theme()->styles()->print( 'lhpbpt-archive' );
?>

<div id="content" class="content-area">
	<?php get_template_part( 'template-parts/loop/loop', 'home' ); ?>
</div><!-- #content -->

<?php
get_footer();
