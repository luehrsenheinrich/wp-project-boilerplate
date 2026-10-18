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
theme()->styles()->print( 'lhpbpt-archive' );
?>

<main id="content" class="content-area">
	<?php get_template_part( 'template-parts/loop/loop', 'home' ); ?>
</main><!-- #content -->

<?php
get_footer();
