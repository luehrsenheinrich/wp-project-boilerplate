<?php
/**
 * The main file of the plugin.
 *
 * @package lhpbp
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
