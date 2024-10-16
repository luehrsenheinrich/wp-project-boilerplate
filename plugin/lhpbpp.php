<?php
/**
 * The main file of the plugin.
 *
 * This file defines the main plugin metadata, initializes the plugin, loads necessary files,
 * and sets up an automatic update checker. It serves as the primary entry point for the plugin's
 * functionality within WordPress.
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
	 * This constant provides a reference to the main plugin file, used for determining the
	 * plugin directory and for other relative paths within the plugin.
	 *
	 * @var string
	 */
	define( 'LHPBPP_FILE', __FILE__ );
}

// Load the Composer autoloader to include third-party dependencies.
require plugin_dir_path( LHPBPP_FILE ) . 'vendor/autoload.php';

// Load the main `wp_lhpbpp()` entry point function, which initializes the plugin's components.
require plugin_dir_path( LHPBPP_FILE ) . 'inc/functions.php';

// Initialize the plugin by calling the main entry point function.
call_user_func( 'WpMunich\lhpbp\plugin\plugin' );

// Initialize the plugin update checker if all plugin requirements are met.
if ( class_exists( 'YahnisElsts\PluginUpdateChecker\v5\PucFactory' ) && plugin_requirements_are_met() ) {
	PucFactory::buildUpdateChecker(
		'https://www.luehrsen-heinrich.de/updates/?action=get_metadata&slug=' . plugin()->get_plugin_slug(),
		__FILE__, // Full path to the main plugin file (used for update tracking).
		plugin()->get_plugin_slug()
	);
}
