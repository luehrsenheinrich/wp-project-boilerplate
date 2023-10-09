<?php
/**
 * The template for displaying the footer
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

theme()->styles()->print( 'lhpbpt-footer' );
?>

<footer>

</footer>

<?php wp_footer(); ?>

</body>
</html>
<?php
do_action( 'qm/stop', 'template_render' );
