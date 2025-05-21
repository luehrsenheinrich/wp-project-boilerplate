<?php
/**
 * Nav menus tests.
 *
 * @package lhpbp\theme
 */

use function WpMunich\lhpbp\theme\theme;

/**
 * Class Nav_Menus_Test
 */
class Nav_Menus_Test extends WP_UnitTestCase {

	/**
	 * Ensure menu locations are registered.
	 */
	public function test_nav_menu_locations_registered() {
		theme();
		do_action( 'init' );

		$registered = get_registered_nav_menus();
		$this->assertArrayHasKey( 'header', $registered );
		$this->assertArrayHasKey( 'footer', $registered );
	}

	/**
	 * Test that a menu assigned to a location is detected as active.
	 */
	public function test_is_nav_menu_active() {
		$theme = theme();
		do_action( 'init' );

		$menu_id             = wp_create_nav_menu( 'Header Menu' );
		$locations           = get_theme_mod( 'nav_menu_locations', array() );
		$locations['header'] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );

		$this->assertTrue( $theme->nav_menus()->is_nav_menu_active( 'header' ) );
	}
}
