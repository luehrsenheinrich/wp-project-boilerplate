<?php
/**
 * The Strip_Editor component.
 *
 * This file defines the `Strip_Editor` class, which aims to reduce complexity in the WordPress block editor.
 * Together with a set of JavaScript functions and the `theme.json` configuration, this component removes
 * unnecessary blocks and settings, providing a simplified editor experience.
 *
 * @see https://fullsiteediting.com/lessons/remove-settings-in-theme-json/
 * @see https://developer.wordpress.org/block-editor/how-to-guides/themes/global-settings-and-styles/
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Strip_Editor;

use WpMunich\lhpbp\theme\Theme_Component;

/**
 * Strip_Editor
 *
 * A class that simplifies the WordPress block editor by removing unnecessary blocks, settings,
 * and options, giving a cleaner and more user-friendly editing experience.
 *
 * Responsibilities:
 * - Manages the removal of certain editor blocks and settings as configured in theme.json.
 * - Works with JavaScript functions to handle dynamic editor modifications.
 * - Optimizes the editor interface to reduce clutter and improve usability.
 */
class Strip_Editor extends Theme_Component {

	/**
	 * An array of core blocks we allow.
	 *
	 * @var array
	 */
	private $allowed_blocks = array(
		'core/block',
		'core/code',
		'core/embed',
		'core/freeform',
		'core/gallery',
		'core/group',
		'core/heading',
		'core/html',
		'core/image',
		'core/list-item',
		'core/list',
		'core/missing',
		'core/more',
		'core/paragraph',
		'core/quote',
	);

	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {
		add_action( 'init', array( $this, 'remove_theme_support' ), 9 );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {
		add_filter( 'block_type_metadata', array( $this, 'filter_block_type_metadata' ) );
		add_filter( 'block_type_metadata_settings', array( $this, 'filter_block_type_metadata_settings' ), 10, 2 );
		add_filter( 'allowed_block_types_all', array( $this, 'allowed_block_types_all' ) );

		/**
		 * Sets the inline CSS size limit to zero, preventing large styles from being inlined.
		 *
		 * By hooking into the `styles_inline_size_limit` filter and setting it to zero,
		 * this restricts WordPress from moving any CSS to inline when the style size exceeds zero bytes.
		 * As a result, all styles, regardless of size, are kept in their enqueued external stylesheets
		 * rather than being output inline within the page's HTML.
		 *
		 * This approach helps keep the HTML output minimal and potentially improves caching efficiency.
		 */
		add_filter( 'styles_inline_size_limit', '__return_zero' );
	}

	/**
	 * Removes theme support for selected core editor components.
	 *
	 * This method disables several WordPress block editor features to streamline
	 * the editing experience by removing components that may be unnecessary
	 * or redundant within the context of the theme.
	 */
	public function remove_theme_support() {
		/**
		 * Remove the core-defined block patterns.
		 *
		 * Disables the set of default block patterns provided by WordPress core.
		 * This prevents users from selecting these patterns, allowing the theme
		 * to focus on its own curated set of block patterns (if any) and avoiding
		 * potential design conflicts.
		 */
		remove_theme_support( 'core-block-patterns' );

		/**
		 * Remove access to block template parts.
		 *
		 * Disables the use of block templates in the editor, which are otherwise
		 * available in themes supporting full site editing (FSE). By removing this,
		 * the theme operates more like a traditional WordPress theme, preventing the
		 * editor from loading or suggesting FSE block templates and focusing on
		 * classic theme structure.
		 */
		remove_theme_support( 'block-templates' );

		/**
		 * Disable querying of the block directory for unregistered blocks.
		 *
		 * Prevents the editor from automatically querying the block directory
		 * to suggest or install new blocks when a block is not found. This helps
		 * avoid unnecessary asset loading and maintains control over the blocks
		 * available to editors.
		 */
		remove_action( 'enqueue_block_editor_assets', 'wp_enqueue_editor_block_directory_assets' );
	}

	/**
	 * Filters block type metadata to customize editor output.
	 *
	 * This method processes metadata for individual block types, allowing for
	 * modifications that remove or adjust unwanted attributes or features
	 * within the editor.
	 *
	 * @param array $metadata Metadata for the currently processed block type.
	 *
	 * @return array Filtered metadata.
	 *
	 * @since 1.0.0
	 */
	public function filter_block_type_metadata( $metadata ) {

		/**
		 * Define block types that should support wide alignment.
		 *
		 * Currently, only the 'core/paragraph' block type is given support for
		 * wide alignment. Additional block types can be added to this array as needed.
		 *
		 * @var string[] $wide_alignment_blocks Array of block types supporting wide alignment.
		 */
		$wide_alignment_blocks = array( 'core/paragraph' );

		/**
		 * Add wide alignment option to defined blocks.
		 *
		 * Checks if the current block's metadata is among the blocks specified in
		 * `$wide_alignment_blocks`. If true, the 'wide' alignment is added to the block's
		 * `supports` attribute. This ensures that only designated blocks can use the
		 * wide alignment setting, which provides a broader presentation option.
		 */
		if ( in_array( $metadata['name'], $wide_alignment_blocks, true ) ) {
			if ( isset( $metadata['supports']['align'] ) && is_array( $metadata['supports']['align'] ) ) {
				$metadata['supports']['align'][] = 'wide';
			} else {
				$metadata['supports']['align'] = array( 'wide' );
			}
		}

		return $metadata;
	}

	/**
	 * Filters block type metadata settings to customize editor output.
	 *
	 * This method processes settings and metadata for individual block types,
	 * enabling customization of block behaviors and visibility within the editor.
	 *
	 * @param array $settings Settings for the currently processed block type, allowing
	 *                        control over various block attributes and behaviors.
	 * @param array $metadata Metadata for the currently processed block type, providing
	 *                        information on the block's registration details and attributes.
	 *
	 * @return array Filtered settings.
	 */
	public function filter_block_type_metadata_settings( $settings, $metadata ) {
		return $settings;
	}

	/**
	 * Filters the allowed block types to limit the selection within the editor.
	 *
	 * This method restricts the editor to only show core block types that are explicitly
	 * allowed by the theme, as defined in the `$this->allowed_blocks` property.
	 * Blocks added by plugins or non-core blocks are permitted without restriction.
	 *
	 * @param array $allowed_block_types An array of block types allowed in the editor.
	 *
	 * @return array The filtered list of allowed core block types, excluding any not
	 *               defined in `$this->allowed_blocks`.
	 */
	public function allowed_block_types_all( $allowed_block_types ) {

		// Get all registered blocks from the block registry.
		$blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();

		// Loop through each registered block to filter by allowed core blocks.
		foreach ( $blocks as $block ) {
			// Allow blocks that are not core (e.g., plugin-added blocks).
			if ( strpos( $block->name, 'core/' ) !== 0 ) {
				continue;
			}

			// Remove core blocks that are not in the `$this->allowed_blocks` list.
			if ( ! in_array( $block->name, $this->allowed_blocks, true ) ) {
				unset( $blocks[ $block->name ] );
			}
		}

		// Return the list of allowed block names as an array.
		return array_keys( $blocks );
	}

	/**
	 * Enqueues JavaScript assets for the block editor.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_block_editor_assets() {
		// Retrieve assets from the JSON file.
		$assets = wp_json_file_decode( get_theme_file_path( '/admin/dist/assets.json' ), array( 'associative' => true ) );

		// Get block editor script details.
		$block_assets = $assets['js/strip_editor.js'] ?? array();

		// Enqueue the script with dependencies and version from the assets file.
		wp_enqueue_script(
			'lhpbpt-strip_editor',
			get_theme_file_uri( 'admin/dist/js/strip_editor.min.js' ),
			array_merge( array(), $block_assets['dependencies'] ?? array() ),
			$block_assets['version'],
			true
		);
	}
}
