<?php
/**
 * The basic tests for the plugin.
 *
 * @package lhpbp\plugin
 */

/**
 * Class Lhpbpp_Test
 */
class Lhpbpp_Test extends WP_UnitTestCase {

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

	/**
	 * Workaround to allow the tests to run on PHPUnit 10.
	 *
	 * @link https://core.trac.wordpress.org/ticket/59486
	 */
	public function expectDeprecated(): void {
		return;
	}
}
