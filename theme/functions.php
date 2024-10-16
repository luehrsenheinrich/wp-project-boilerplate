<?php
/**
 * Theme functions and definitions.
 *
 * This file is the primary entry point for the theme's functionality. It includes
 * necessary files, loads autoloaders, initializes theme components, and sets up
 * the plugin update checker if all requirements are met.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lhpbp\theme
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

use function WpMunich\lhpbp\theme\theme;
use function WpMunich\lhpbp\theme\theme_requirements_are_met;

// Load the Composer autoloader for third-party dependencies.
require get_template_directory() . '/vendor/autoload.php';

// Load the `theme()` function, which serves as the entry point for the theme's components.
require get_template_directory() . '/inc/functions.php';

// Initialize the theme by calling the main entry point function.
call_user_func( 'WpMunich\lhpbp\theme\theme' );

// Initialize the plugin update checker if all theme requirements are met.
if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) && theme_requirements_are_met() ) {
	PucFactory::buildUpdateChecker(
		'https://www.luehrsen-heinrich.de/updates/?action=get_metadata&slug=' . theme()->get_theme_slug(),
		__FILE__, // Full path to the main theme file (functions.php).
		theme()->get_theme_slug()
	);
}
