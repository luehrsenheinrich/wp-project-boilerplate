<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lhpbpt
 */

require get_template_directory() . '/vendor/autoload.php';

// Load the `wp_lhpbpt()` entry point function.
require get_template_directory() . '/inc/functions.php';

// Initialize the theme.
call_user_func( 'WpMunich\lhpbpt\lh_theme' );
