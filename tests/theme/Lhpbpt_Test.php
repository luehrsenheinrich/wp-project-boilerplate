<?php
/**
 * The basic tests for the theme.
 *
 * @package lhpbp\theme
 */

use function WpMunich\lhpbp\theme\theme;
use function WpMunich\lhpbp\theme\theme_requirements_are_met;

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
	 * Test if the theme requirements are met.
	 */
	public function test_theme_requirements_are_met() {
		$this->assertTrue( theme_requirements_are_met() );
	}

	/**
	 * Test theme initialization.
	 */
	public function test_theme_initialization() {
		$theme = theme();

		$this->assertNotNull( $theme, 'Theme should be initialized.' );
		$this->assertInstanceOf( \WpMunich\lhpbp\theme\Theme::class, $theme, 'Theme should be an instance of Theme class.' );
	}

	/**
	 * Test render_attributes helper.
	 */
	public function test_render_attributes() {
		$attributes = array(
			'class'     => 'btn primary',
			'id'        => 'main-btn',
			'data-test' => 'value',
			'empty'     => '',
			'zero'      => '0',
		);

                $result = \WpMunich\lhpbp\theme\render_attributes( $attributes );

		$this->assertStringContainsString( 'class="btn primary"', $result );
		$this->assertStringContainsString( 'id="main-btn"', $result );
		$this->assertStringContainsString( 'data-test="value"', $result );
		$this->assertStringNotContainsString( 'empty=', $result );
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
