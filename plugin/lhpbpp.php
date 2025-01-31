<?php
/**
 * Plugin Name: WordPress Project Boilerplate
 * Plugin URI: https://www.luehrsen-heinrich.de
 * Description: A base boilerplate for Luehrsen // Heinrich WordPress projects.
 * Author: Luehrsen // Heinrich
 * Author URI: https://www.luehrsen-heinrich.de
 * Version: 0.0.18
 * Text Domain: lhpbpp
 * Domain Path: /languages
 *
 * @package lhpbp\plugin
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;
use function WpMunich\lhpbp\plugin\plugin;
use function WpMunich\lhpbp\plugin\plugin_requirements_are_met;

// Exit if accessed directly.
if ( ! defined( 'WPINC' ) ) {
	exit( 1 );
}

/**
 * Define the plugin's main file path constant.
 *
 * This constant provides a reference to the main plugin file, used for determining the
 * plugin directory and for other relative paths within the plugin.
 */
define( 'LHPBPP_FILE', __FILE__ );

/**
 * Load the Composer autoloader.
 *
 * This ensures that all required dependencies and third-party libraries are properly loaded.
 */
require_once plugin_dir_path( LHPBPP_FILE ) . 'vendor/autoload.php';

/**
 * Load the core plugin functions.
 *
 * These functions initialize the main components and logic of the plugin.
 */
require_once plugin_dir_path( LHPBPP_FILE ) . 'inc/functions.php';

/**
 * Initialize the plugin.
 *
 * Calls the main function to bootstrap the plugin's components.
 */
if ( ! function_exists( 'WpMunich\lhpbp\plugin\plugin' ) ) {
	wp_die( esc_html__( 'Critical error: The main plugin function is missing.', 'lhpbpp' ) );
}
call_user_func( 'WpMunich\lhpbp\plugin\plugin' );

/**
 * Initialize the plugin update checker.
 *
 * Ensures the plugin can check for and receive updates if all requirements are met.
 */
if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) && function_exists( 'WpMunich\lhpbp\plugin\plugin_requirements_are_met' ) && plugin_requirements_are_met() ) {
	PucFactory::buildUpdateChecker(
		'https://www.luehrsen-heinrich.de/updates/?action=get_metadata&slug=' . plugin()->get_plugin_slug(),
		LHPBPP_FILE, // Full path to the main plugin file (used for update tracking).
		plugin()->get_plugin_slug()
	);
}
