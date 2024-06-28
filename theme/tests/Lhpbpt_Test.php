<?php
/**
 * The basic tests for the theme.
 *
 * @package lhpbp\theme
 */

use function WpMunich\lhpbp\theme\theme;

/**
 * Class LHTheme_Basic_Test
 */
class Lhpbpt_Test extends WP_UnitTestCase {

	/**
	 * Test if the theme exists.
	 */
	public function test_theme_exists() {
		$this->assertTrue( function_exists( 'WpMunich\lhpbp\theme\theme' ) );
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
