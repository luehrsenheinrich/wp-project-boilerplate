<?php
/**
 * The basic tests for the plugin.
 *
 * @package lhpbp\plugin
 */

use function WpMunich\lhpbp\plugin\plugin;

/**
 * Class Lhpbpp_Basic_Test
 */
class LHPlugin_Basic_Test extends WP_UnitTestCase {

	/**
	 * Test if the plugin exists.
	 */
	public function test_plugin_exists() {
		$this->assertTrue( function_exists( 'WpMunich\lhpbp\plugin\plugin' ) );
	}

	/**
	 * Check if the lhpbpp file constant is defined.
	 */
	public function test_lhpbpp_file_constant() {
		$this->assertTrue( defined( 'LHPBPP_FILE' ) );
	}
}
