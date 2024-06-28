<?php
/**
 * Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lhpbp\theme
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

use function WpMunich\lhpbp\theme\theme;
use function WpMunich\lhpbp\theme\theme_requirements_are_met;

// Get the autoloader.
require get_template_directory() . '/vendor/autoload.php';

// Load the `theme()` entry point function.
require get_template_directory() . '/inc/functions.php';

// Initialize the theme.
call_user_func( 'WpMunich\lhpbp\theme\theme' );

// Initialize the plugin update checker.
if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) && theme_requirements_are_met() ) {
	PucFactory::buildUpdateChecker(
		'https://www.luehrsen-heinrich.de/updates/?action=get_metadata&slug=' . theme()->get_theme_slug(),
		__FILE__, // Full path to the main plugin file or functions.php.
		theme()->get_theme_slug()
	);
}
