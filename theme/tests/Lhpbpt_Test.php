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

	/** Pagination identifies its controls and marks the current page. */
	public function test_pagination_markup() {
		$this->factory()->post->create_many( 3 );
		$query = new WP_Query(
			array(
				'post_type'      => 'post',
				'posts_per_page' => 1,
				'paged'          => 2,
			)
		);

		ob_start();
		get_template_part( 'template-parts/loop/pagination', null, array( 'query' => $query ) );
		$markup = ob_get_clean();

		$this->assertStringContainsString( 'aria-label="Pagination"', $markup );
		$this->assertStringContainsString( 'aria-current="page"', $markup );
		$this->assertStringContainsString( '>Previous</span>', $markup );
		$this->assertStringContainsString( '>Next</span>', $markup );
		$this->assertStringContainsString( '>Page 2</span>', $markup );
	}

	/** Editors can compose with approved layout blocks and plugin blocks. */
	public function test_curated_editor_allows_layout_and_plugin_blocks() {
		$allowed = apply_filters( 'allowed_block_types_all', true );
		foreach ( array( 'core/group', 'core/columns', 'core/cover', 'lhpbpp/editorial-note' ) as $name ) {
			$this->assertContains( $name, $allowed );
		}
		$this->assertNotContains( 'core/site-title', $allowed );
	}

	/** Unsynced patterns remain editable, while explicitly locked ones do not. */
	public function test_unsynced_patterns_are_composable() {
		$settings = apply_filters( 'block_editor_settings_all', array() );
		$this->assertTrue( $settings['disableContentOnlyForUnsyncedPatterns'] );
		$this->assertTrue( WP_Block_Patterns_Registry::get_instance()->is_registered( 'lhpbpt/bp-editorial-split' ) );
	}

	/** The theme intentionally keeps PHP templates rather than Site Editor templates. */
	public function test_theme_remains_classic() {
		$this->assertFalse( wp_is_block_theme() );
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
