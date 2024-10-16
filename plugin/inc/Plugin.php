<?php
/**
 * The main Plugin class.
 *
 * This class serves as the primary structure for the plugin, initializing core components
 * and providing essential plugin information, such as version, directory paths, and URL.
 * It also supports access to various components via dependency injection.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin;

use function get_plugin_data;
use function plugin_dir_url;

/**
 * Plugin
 *
 * The main plugin class responsible for initializing plugin features and providing access
 * to components and basic plugin data. This class acts as a container for key components,
 * ensuring they are available throughout the plugin.
 */
class Plugin {

	/**
	 * Constructor.
	 *
	 * Initializes the plugin by injecting core components.
	 *
	 * @param ACF\ACF       $acf ACF component.
	 * @param Blocks\Blocks $blocks Blocks component.
	 * @param i18n\I18N     $i18n Internationalization (i18n) component.
	 * @param REST\REST     $rest REST API component.
	 * @param SVG\SVG       $svg SVG component.
	 */
	public function __construct(
		private ACF\ACF $acf,
		private Blocks\Blocks $blocks,
		private i18n\I18N $i18n,
		private REST\REST $rest,
		private SVG\SVG $svg
	) {
	}

	/**
	 * Access the SVG component.
	 *
	 * @return SVG\SVG The SVG component.
	 */
	public function svg() {
		return $this->svg;
	}

	/**
	 * Get the current plugin version.
	 *
	 * Retrieves the plugin version from the plugin's main file, making the file header
	 * the single source of truth. This avoids updating version information in multiple locations.
	 *
	 * @return string The plugin version.
	 */
	public function get_plugin_version() {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		// Retrieve plugin data from the main plugin file.
		$plugin_data = get_plugin_data( LHPBPP_FILE );

		return $plugin_data['Version'] ?? '0.0.1';
	}

	/**
	 * Get the path to the main plugin file.
	 *
	 * @return string The full path to the main plugin file.
	 */
	public function get_plugin_file() {
		return LHPBPP_FILE;
	}

	/**
	 * Get the plugin directory path.
	 *
	 * Returns the full directory path where the plugin is located.
	 *
	 * @return string The plugin directory path.
	 */
	public function get_plugin_path() {
		return plugin_dir_path( $this->get_plugin_file() );
	}

	/**
	 * Get the URL to the plugin directory.
	 *
	 * @return string The URL to the plugin directory.
	 */
	public function get_plugin_url() {
		return plugin_dir_url( $this->get_plugin_file() );
	}

	/**
	 * Get the plugin slug.
	 *
	 * Provides a unique identifier for the plugin, used in various settings and hooks.
	 *
	 * @return string The plugin slug.
	 */
	public function get_plugin_slug() {
		return 'lhpbpp';
	}

	/**
	 * Access the Dependency Injection (DI) container.
	 *
	 * The DI container allows the plugin to manage dependencies and provide components
	 * as needed throughout the plugin.
	 *
	 * @return \DI\Container The DI container.
	 */
	public function container() {
		return plugin_container();
	}
}
