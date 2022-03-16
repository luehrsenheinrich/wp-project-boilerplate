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

if ( ! defined( 'LHPBPP_VERSION' ) ) {
	define( 'LHPBPP_VERSION', '0.0.1' );
}
if ( ! defined( 'LHPBPP_SLUG' ) ) {
	define( 'LHPBPP_SLUG', '<%= pkg.slug %>' );
}

if ( ! defined( 'LHPBPP_URL' ) ) {
	define( 'LHPBPP_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'LHPBPP_PATH' ) ) {
	define( 'LHPBPP_PATH', plugin_dir_path( __FILE__ ) );
}

// Load the autoloader.
require LHPBPP_PATH . 'vendor/autoload.php';

// Load the `wp_lhpbpp()` entry point function.
require LHPBPP_PATH . 'inc/functions.php';

if ( wp_get_environment_type() === 'development' ) {
	require LHPBPP_PATH . 'inc/test.php';
}

// Initialize the plugin.
call_user_func( 'WpMunich\lhpbpp\wp_lhpbpp' );
