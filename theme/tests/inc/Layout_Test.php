<?php
/**
 * Core layout integration tests.
 *
 * @package lhpbp\theme
 */

use function WpMunich\lhpbp\theme\theme;

/** Verify the PHP wrapper and shared Core layout adapter. */
class Layout_Test extends WP_UnitTestCase {

	/** Match the existing PHPUnit 10 compatibility workaround in Lhpbpt_Test. */
	public function expectDeprecated(): void {
		return;
	}

	/** Theme defaults use the same Core-generated rule in both canvases. */
	public function test_group_defaults_are_shared_without_changing_attributes() {
		$padding  = wp_get_global_styles( array( 'spacing', 'padding' ), array( 'block_name' => 'core/group' ) );
		$expected = wp_get_layout_style( '.wp-block-group:where(.is-layout-constrained)', array( 'type' => 'constrained' ), false, null, false, '0', array( 'padding' => $padding ) );
		$settings = theme()->styles()->add_group_layout_defaults_to_editor( array() );
		$this->assertNotEmpty( $expected );
		$this->assertSame( $expected, $settings['styles'][0]['css'] );

		theme()->styles()->action_enqueue_styles();
		$this->assertContains( $expected, wp_styles()->get_data( 'lhpbpt-base', 'after' ) );

		$content = '<!-- wp:group {"layout":{"type":"constrained"}} --><div class="wp-block-group"><!-- wp:paragraph --><p>Default surface</p><!-- /wp:paragraph --></div><!-- /wp:group -->';
		do_blocks( $content );
		$this->assertArrayNotHasKey( 'style', parse_blocks( $content )[0]['attrs'] );
	}

	/** Legacy values remain registered, and are available when a document uses them. */
	public function test_spacing_choices_preserve_document_legacy_values() {
		$settings = array( '__experimentalFeatures' => wp_get_global_settings() );
		$context  = new WP_Block_Editor_Context(
			array( 'post' => $this->factory()->post->create_and_get( array( 'post_content' => '<!-- wp:group {"style":{"spacing":{"padding":{"left":"var:preset|spacing|small","right":"var(--wp--preset--spacing--50)"}}}} /-->' ) ) )
		);
		$fresh    = apply_filters( 'block_editor_settings_all', $settings, new WP_Block_Editor_Context() );
		$legacy   = apply_filters( 'block_editor_settings_all', $settings, $context );
		$this->assertCount( 8, $fresh['__experimentalFeatures']['spacing']['spacingSizes']['theme'] );
		$this->assertSame( array( 'XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL' ), array_column( $fresh['__experimentalFeatures']['spacing']['spacingSizes']['theme'], 'name' ) );
		$this->assertContains( 'small', array_column( $legacy['__experimentalFeatures']['spacing']['spacingSizes']['theme'], 'slug' ) );
		$this->assertContains( '50', array_column( $legacy['__experimentalFeatures']['spacing']['spacingSizes']['default'], 'slug' ) );
		$this->assertStringContainsString( '--wp--preset--spacing--small:', wp_get_global_stylesheet() );
		$this->assertStringContainsString( '--wp--preset--spacing--50:', wp_get_global_stylesheet() );
	}

	/** Classic PHP templates execute content once and preserve native next-page links. */
	public function test_content_wrapper_and_native_pagination() {
		$id = $this->factory()->post->create( array( 'post_content' => '<p>First page</p><!--nextpage--><p>Second page</p>' ) );
		$this->go_to( get_permalink( $id ) );
		the_post();
		$calls   = 0;
		$counter = static function ( $content ) use ( &$calls ) {
			++$calls;
			return $content;
		};
		add_filter( 'the_content', $counter );
		ob_start();
		get_template_part( 'template-parts/loop/item' );
		$markup = ob_get_clean();
		remove_filter( 'the_content', $counter );
		$this->assertSame( 1, $calls );
		$this->assertStringContainsString( 'entry-content is-layout-constrained has-global-padding', $markup );
		$this->assertStringContainsString( 'First page', $markup );
		$this->assertStringNotContainsString( 'Second page', $markup );
		$this->assertStringContainsString( 'post-page-numbers', $markup );
	}
}
