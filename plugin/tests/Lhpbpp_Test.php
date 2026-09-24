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

	/** The reference block is registered from its metadata. */
	public function test_editorial_note_is_registered() {
		$block = WP_Block_Type_Registry::get_instance()->get_registered( 'lhpbpp/editorial-note' );
		$this->assertNotNull( $block );
		$this->assertSame( 'lhpbpp-blocks', $block->editor_script_handles[0] );
	}

	/** Plugin rendering is available independently of the active theme. */
	public function test_editorial_note_renders_safe_content() {
		$markup = serialize_block(
			array(
				'blockName'    => 'lhpbpp/editorial-note',
				'attrs'        => array( 'content' => '<strong>Editor context</strong><script>alert(1)</script>' ),
				'innerBlocks'  => array(),
				'innerHTML'    => '',
				'innerContent' => array(),
			)
		);
		$output = do_blocks( $markup );
		$this->assertStringContainsString( '<strong>Editor context</strong>', $output );
		$this->assertStringNotContainsString( '<script>', $output );
		$this->assertStringContainsString( 'lhpbpp-editorial-note', $output );
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
