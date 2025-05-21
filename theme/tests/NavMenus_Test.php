<?php
/**
 * Navigation menu registration tests.
 *
 * @package lhpbp\theme
 */

/**
 * Class NavMenus_Test
 */
class NavMenus_Test extends WP_UnitTestCase {

	/**
	 * Confirm the header and footer menus are registered.
	 */
	public function test_header_and_footer_menus_registered() {
		$this->assertTrue( has_nav_menu( 'header' ) );
		$this->assertTrue( has_nav_menu( 'footer' ) );
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
