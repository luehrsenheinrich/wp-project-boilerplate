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
 * Version: 0.0.5
 * Text Domain: lhpbpp
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
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

// If we are in the development environment, load some test functions.
if ( wp_get_environment_type() === 'development' ) {
	require plugin_dir_path( LHPBPP_FILE ) . 'inc/test.php';
}

// Initialize the plugin.
call_user_func( 'WpMunich\lhpbpp\lh_plugin' );
