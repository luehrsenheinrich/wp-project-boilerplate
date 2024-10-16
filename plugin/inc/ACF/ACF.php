<?php
/**
 * The ACF component.
 *
 * This file defines the `ACF` class, which handles logic related to Advanced Custom Fields (ACF)
 * in the plugin. This includes setting up options pages, managing JSON save/load points, and
 * configuring ACF-specific settings based on the environment.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\ACF;

use WpMunich\lhpbp\plugin\Plugin_Component;

use function WpMunich\lhpbp\plugin\plugin;
use function acf_add_options_page;
use function add_action;
use function add_filter;
use function wp_get_environment_type;

/**
 * ACF
 *
 * A class to handle ACF-related functionality in the plugin. This class manages the creation
 * of ACF options pages, JSON save/load paths, and environment-specific settings for ACF.
 */
class ACF extends Plugin_Component {

	/**
	 * Validated and finalized settings for the ACF options page.
	 *
	 * @see https://www.advancedcustomfields.com/resources/acf_add_options_page/
	 *
	 * @var array
	 */
	protected $option_page = array();

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		add_action( 'acf/init', array( $this, 'add_options_page' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {
		if ( wp_get_environment_type() === 'development' && defined( 'LH_CURRENTLY_EDITING' ) && LH_CURRENTLY_EDITING === 'lhpbp' ) {
			add_filter( 'acf/settings/save_json', array( $this, 'acf_json_save_point' ) );
		}

		add_filter( 'acf/settings/load_json', array( $this, 'acf_json_load_point' ) );
	}

	/**
	 * Set the JSON save path for ACF.
	 *
	 * This method configures the directory where ACF JSON data is saved, allowing for
	 * custom save points in development environments. This feature is helpful for version
	 * control of ACF fields.
	 *
	 * @param  string $path The default save path.
	 *
	 * @return string The modified save path for ACF JSON data.
	 */
	public function acf_json_save_point( $path ) {
		$path = plugin()->get_plugin_path() . 'acf-json';
		return $path;
	}

	/**
	 * Add a custom JSON load path for ACF.
	 *
	 * This method adds the specified directory to the list of locations from which
	 * ACF JSON data can be loaded. This setup enables shared ACF configurations across
	 * different environments.
	 *
	 * @param  array $paths An array of paths.
	 *
	 * @return array The modified array of JSON load paths.
	 */
	public function acf_json_load_point( $paths ) {
		$paths[] = plugin()->get_plugin_path() . 'acf-json';

		return $paths;
	}

	/**
	 * Add an ACF options page for theme settings.
	 *
	 * This method creates a custom options page for managing theme-specific settings
	 * via ACF. It sets up page attributes like title, menu slug, icon, and user
	 * capability requirements.
	 */
	public function add_options_page() {
		if ( ! function_exists( 'acf_add_options_page' ) ) {
			return;
		}

		$this->option_page = acf_add_options_page(
			array(
				'page_title' => __( 'L//H Settings', 'lhpbpp' ),
				'menu_title' => __( 'L//H Settings', 'lhpbpp' ),
				'menu_slug'  => 'lhpbpp-plugin-general-settings',
				'icon_url'   => plugin()->svg()->get_admin_menu_icon( 'img/icons/slashes.svg' ),
				'capability' => 'edit_posts',
				'redirect'   => false,
			)
		);
	}
}
