<?php
/**
 * The Block_Patterns component.
 *
 * This file defines the `Block_Patterns` class, responsible for managing custom block patterns
 * and pattern categories within the WordPress block editor. It registers custom categories,
 * unregisters default categories, and provides utility functions to retrieve and register block patterns.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-patterns/
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Block_Patterns;

use WpMunich\lhpbp\theme\Theme_Component;

use function add_action;
use function register_block_pattern;
use function register_block_pattern_category;
use function unregister_block_pattern_category;

/**
 * Block_Patterns
 *
 * A class that manages the block patterns and pattern categories within the WordPress block editor.
 * By defining custom categories and patterns, this component helps structure and simplify the editor
 * with patterns specific to the theme, enhancing the user experience.
 */
class Block_Patterns extends Theme_Component {

	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {
		add_action( 'init', array( $this, 'unregister_core_block_pattern_categories' ) );
		add_action( 'init', array( $this, 'register_block_pattern_categories' ) );
		add_action( 'init', array( $this, 'register_block_patterns' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {}

	/**
	 * Unregisters default core block pattern categories.
	 *
	 * This method removes specific categories of block patterns provided by WordPress core,
	 * aiming to streamline the editor by reducing unnecessary pattern categories.
	 *
	 * @return void
	 */
	public function unregister_core_block_pattern_categories() {
		remove_theme_support( 'core-block-patterns' );

		unregister_block_pattern_category( 'buttons' );
		unregister_block_pattern_category( 'columns' );
		unregister_block_pattern_category( 'gallery' );
		unregister_block_pattern_category( 'header' );
		unregister_block_pattern_category( 'text' );
		unregister_block_pattern_category( 'query' );
	}

	/**
	 * Registers custom pattern categories.
	 *
	 * This method defines custom block pattern categories specific to the theme, making it easier
	 * for editors to find theme-specific patterns. Each category is registered with a unique label
	 * and can be used by patterns associated with this theme.
	 *
	 * @return void
	 */
	public function register_block_pattern_categories() {
		register_block_pattern_category(
			'lhpbpt-pattern',
			array( 'label' => __( 'Lhpbpt Pattern', 'lhpbpt' ) )
		);
	}

	/**
	 * Registers custom block patterns.
	 *
	 * This method registers individual block patterns that the theme provides, linking them with
	 * the custom pattern categories. Block patterns are useful for quickly setting up reusable
	 * content structures in the block editor.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_pattern/
	 * @return void
	 */
	public function register_block_patterns() {
		register_block_pattern(
			'lhpbpt/example-pattern',
			array(
				'title'         => _x( 'Example Pattern', 'pattern title', 'lhpbpt' ),
				'description'   => __( 'A simple example pattern. If you can read this at prod call an admin.', 'lhpbpt' ),
				// phpcs:disable
				'content'       => $this->get_block_pattern_string( get_stylesheet_directory() . '/inc/Block_Patterns/bp-example.php' ),
				// phpcs:enable
				'categories'    => array( 'lhpbpt-pattern' ),
				'keywords'      => array(
					_x( 'Example', 'block pattern keywords', 'lhpbpt' ),
				),
				'viewportWidth' => 1440,
			)
		);
	}

	/**
	 * Retrieves the block pattern content from a PHP file.
	 *
	 * This utility function loads the content of a specified PHP file, intended to be
	 * used as the HTML content for a block pattern. It uses output buffering to capture
	 * the file content as a string.
	 *
	 * @param  string $path The path to the block pattern PHP file.
	 *
	 * @return string The HTML content for the block pattern, or an empty string if the file does not exist.
	 */
	private function get_block_pattern_string( $path = '' ) {
		$block_pattern = '';

		if ( file_exists( $path ) ) {
			ob_start();
			include( $path ); // phpcs:ignore
			$block_pattern = ob_get_contents();
			ob_end_clean();
		}

		return $block_pattern;
	}
}
