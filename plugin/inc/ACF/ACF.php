<?php
/**
 * LHPBPP\ACF\Component class
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
 * A class to handle acf related logic.
 */
class ACF extends Plugin_Component {
	/**
	 * Validated and final page settings.
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
	 * Add the json save point for acf.
	 *
	 * @param  string $path Save path.
	 *
	 * @return string       Save path.
	 */
	public function acf_json_save_point( $path ) {
		$path = plugin()->get_plugin_path() . 'acf-json';
		return $path;
	}

	/**
	 * Add the json load point for acf.
	 *
	 * @param  array $paths An array of paths.
	 *
	 * @return array        An array of paths.
	 */
	public function acf_json_load_point( $paths ) {
		$paths[] = plugin()->get_plugin_path() . 'acf-json';

		return $paths;
	}

	/**
	 * Add a theme options page.
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
