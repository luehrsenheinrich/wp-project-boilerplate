<?php
/**
 * The main file of the plugin.
 *
 * @package lhpbp\plugin
 *
 * Plugin Name: WordPress Project Boilerplate
 * Plugin URI: https://www.luehrsen-heinrich.de
 * Description: A base boilerplate for Luehrsen // Heinrich WordPress projects.
 * Author: Luehrsen // Heinrich
 * Author URI: https://www.luehrsen-heinrich.de
 * Version: 0.0.18
 * Text Domain: lhpbpp
 * Domain Path: /languages
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

use function WpMunich\lhpbp\plugin\plugin;
use function WpMunich\lhpbp\plugin\plugin_requirements_are_met;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit( 1 );
}

// Set a constant for the plugin's main file.
if ( ! defined( 'LHPBPP_FILE' ) ) {
	/**
	 * The path to the main file of the plugin.
	 *
	 * @var string
	 */
	define( 'LHPBPP_FILE', __FILE__ );
}

// Load the autoloader.
require plugin_dir_path( LHPBPP_FILE ) . 'vendor/autoload.php';

// Load the `wp_lhpbpp()` entry point function.
require plugin_dir_path( LHPBPP_FILE ) . 'inc/functions.php';

// Initialize the plugin.
call_user_func( 'WpMunich\lhpbp\plugin\plugin' );

// Initialize the plugin update checker.
if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) && plugin_requirements_are_met() ) {
	PucFactory::buildUpdateChecker(
		'https://www.luehrsen-heinrich.de/updates/?action=get_metadata&slug=' . plugin()->get_plugin_slug(),
		__FILE__, // Full path to the main plugin file or functions.php.
		plugin()->get_plugin_slug()
	);
}
