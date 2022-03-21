<?php
/**
 * The main file of the plugin.
 *
 * @package lhpbpp
 *
 * Plugin Name: WordPress Project Boilerplate
 * Plugin URI: https://www.luehrsen-heinrich.de
 * Description: A base boilerplate for Luehrsen // Heinrich WordPress projects.
 * Author: Luehrsen // Heinrich
 * Author URI: https://www.luehrsen-heinrich.de
 * Version: 0.0.1
 * Text Domain: lhpbpp
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Check if we can use the `get_plugin_data()` function.
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
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

// Set a constant for the plugin's public URL.
if ( ! defined( 'LHPBPP_URL' ) ) {
	/**
	 * The URL to the plugin's public folder.
	 *
	 * @var string
	 */
	define( 'LHPBPP_URL', plugin_dir_url( LHPBPP_FILE ) );
}

// Set a constant for the plugin's directory path.
if ( ! defined( 'LHPBPP_PATH' ) ) {
	/**
	 * The path to the plugin's directory.
	 *
	 * @var string
	 */
	define( 'LHPBPP_PATH', plugin_dir_path( LHPBPP_FILE ) );
}

/**
 * The plugin data as an array.
 * We use this to avoid updating plugin data on multiple locations. This makes
 * the file header of the plugin main file the single source of truth.
 */
$plugin_data = get_plugin_data( LHPBPP_FILE );

// Set a constant for the plugin's current version.
if ( ! defined( 'LHPBPP_VERSION' ) ) {
	/**
	 * The plugin version.
	 *
	 * @var string
	 */
	define( 'LHPBPP_VERSION', $plugin_data['Version'] );
}

// Load the autoloader.
require LHPBPP_PATH . 'vendor/autoload.php';

// Load the `wp_lhpbpp()` entry point function.
require LHPBPP_PATH . 'inc/functions.php';

// If we are in the development environment, load some test functions.
if ( wp_get_environment_type() === 'development' ) {
	require LHPBPP_PATH . 'inc/test.php';
}

// Initialize the plugin.
call_user_func( 'WpMunich\lhpbpp\wp_lhpbpp' );
