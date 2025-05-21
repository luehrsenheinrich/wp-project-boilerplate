<?php
/**
 * Navigation menu registration tests.
 *
 * @package lhpbp\theme
 */

use function WpMunich\lhpbp\theme\theme;

/**
 * Class Nav_Menus_Test
 */
class Nav_Menus_Test extends WP_UnitTestCase {

	/**
	 * Confirm the header and footer menu locations are registered.
	 */
	public function test_nav_menu_locations_registered() {
		$this->assertTrue( has_nav_menu( 'header' ) );
		$this->assertTrue( has_nav_menu( 'footer' ) );
	}

	/**
	 * Verify the Nav_Menus component reports active menus correctly.
	 */
	public function test_is_nav_menu_active() {
		$nav_menus = theme()->nav_menus();
		$this->assertTrue( $nav_menus->is_nav_menu_active( 'header' ) );
		$this->assertTrue( $nav_menus->is_nav_menu_active( 'footer' ) );
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
