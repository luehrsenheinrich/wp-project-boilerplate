<?php
/**
 * The Blocks component.
 *
 * This file defines the `Blocks` class, which handles the registration, categorization,
 * and management of custom blocks within the plugin. This includes enqueuing necessary
 * assets for block editing and providing callback functions for rendering.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\Blocks;

use WpMunich\lhpbp\plugin\Plugin_Component;

use function WpMunich\lhpbp\plugin\plugin;
use function add_action;
use function add_filter;
use function get_current_screen;
use function register_block_type;
use function wp_enqueue_script;
use function wp_json_file_decode;
use function wp_set_script_translations;

/**
 * Blocks
 *
 * A class to handle the plugin's custom blocks. It registers blocks, assigns them to custom
 * categories, enqueues block editor assets, and defines rendering callbacks for block display.
 */
class Blocks extends Plugin_Component {

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		add_action( 'init', array( $this, 'register_blocks' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {
		add_filter( 'block_categories_all', array( $this, 'add_block_categories' ), 10, 2 );
	}

	/**
	 * Register the plugin's custom block category.
	 *
	 * @param array   $categories The existing block categories.
	 * @param WP_Post $post       The current post being edited.
	 *
	 * @return array The updated array of block categories, including the custom category.
	 */
	public function add_block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'lhpbpp-blocks',
					'title' => __( 'Luehrsen // Heinrich', 'lhpbpp' ),
				),
			)
		);
	}

	/**
	 * Enqueue the block editor scripts and styles.
	 *
	 * Enqueues JavaScript and CSS assets required for the block editor, including helper scripts
	 * and translations for the block UI.
	 */
	public function enqueue_block_editor_assets() {
		$screen = get_current_screen();

		// Load asset configuration.
		$assets = wp_json_file_decode( plugin()->get_plugin_path() . '/admin/dist/assets.json', array( 'associative' => true ) );

		// Enqueue block helper script outside the widgets screen.
		if ( ! in_array( $screen->id, array( 'widgets' ), true ) ) {
			$block_helper_assets = $assets['js/blocks-helper.min.js'] ?? array();
			wp_enqueue_script(
				'lhpbpp-blocks-helper',
				plugin()->get_plugin_url() . 'admin/dist/js/blocks-helper.min.js',
				array_merge( array(), $block_helper_assets['dependencies'] ),
				$block_helper_assets['version'],
				true
			);
		}

		$block_assets = $assets['js/blocks.min.js'] ?? array();
		wp_enqueue_script(
			'lhpbpp-blocks',
			plugin()->get_plugin_url() . 'admin/dist/js/blocks.min.js',
			array_merge( array(), $block_assets['dependencies'] ),
			$block_assets['version'],
			true
		);

		wp_enqueue_style(
			'lhpbpp-admin-components',
			plugin()->get_plugin_url() . '/admin/dist/css/components.min.css',
			array(),
			plugin()->get_plugin_version(),
			'all'
		);

		// Load translations for block editor assets.
		$dir  = plugin()->get_plugin_path();
		$path = $dir . '/languages/';

		wp_set_script_translations(
			'lhpbpp-blocks',
			'lhpbpp',
			$path
		);

		wp_set_script_translations(
			'lhpbpp-blocks-helper',
			'lhpbpp',
			$path
		);
	}

	/**
	 * Register custom blocks for the plugin.
	 *
	 * Registers block types from the specified directory, setting a render callback function
	 * for custom rendering of each block.
	 */
	public function register_blocks() {
		$blocks_path = plugin()->get_plugin_path() . 'blocks/';

		$custom_blocks = array(
			'demo',
		);

		foreach ( $custom_blocks as $block ) {
			register_block_type(
				$blocks_path . $block . '/',
				array(
					'render_callback' => array( $this, 'provide_render_callback' ),
				)
			);
		}
	}

	/**
	 * Provide the render callback for custom blocks.
	 *
	 * Captures block-specific HTML output using a buffer and includes the block's template file
	 * based on its name. This allows dynamic block content rendering on the frontend.
	 *
	 * @param array    $attributes The block attributes.
	 * @param string   $content    The block content.
	 * @param WP_Block $block      The block instance.
	 *
	 * @return string The rendered block HTML.
	 */
	public function provide_render_callback( $attributes, $content, $block ) {
		$blocks_path = plugin()->get_plugin_path() . 'blocks/';
		ob_start();

		switch ( $block->name ) {
			case 'lh/demo':
				include $blocks_path . 'demo/template.php';
				break;
		}

		$block_html = ob_get_clean();

		return $block_html;
	}
}
