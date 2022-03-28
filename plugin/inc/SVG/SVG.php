<?php
/**
 * Gbplugin\SVG\Component class
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp\SVG;
use WpMunich\lhpbpp\Component;
use function add_action;
use function WpMunich\lhpbpp\lh_plugin;

use \WP_Error;

/**
 * The Component
 */
class SVG extends Component {

	/**
	 * A storage type for icons we have already used.
	 *
	 * @var array
	 */
	private $images = array();

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {}

	/**
	 * Get an SVG from the theme or plugin folder.
	 *
	 * @param string $path The SVG path to be loaded.
	 * @param array  $args An array of arguments for the SVG class.
	 *
	 * @return string The SVG code.
	 */
	public function get_svg( $path = null, $args = array() ) {
		$final_path = get_template_directory() . $path;

		switch ( $path ) {
			case ( file_exists( get_template_directory() . $path ) ):
				$final_path = get_template_directory() . $path;
				break;
			case ( file_exists( lh_plugin()->get_plugin_path() . $path ) ):
				$final_path = lh_plugin()->get_plugin_path() . $path;
				break;
			default:
				return false;
				break;
		}

		if ( ! file_exists( $final_path ) ) {
			return false;
		}

		if ( mime_content_type( $final_path ) !== 'image/svg' ) {
			return false;
		}

		$args['svg_path'] = $final_path;

		$icons[ $path ] = new WPM_Svg_Image( $args );

		return $icons[ $path ]->render();
	}

	/**
	 * Get an SVG icon for use in WP Admin Menus.
	 *
	 * @param  string $path The relative path of the image to the plugin / theme root.
	 *
	 * @return string       The base64 encoded svg.
	 */
	public function get_admin_menu_icon( $path ) {
		$args = array(
			'return_type' => 'base64',
			'attributes'  => array(
				'fill'   => '#a0a5aa',
				'width'  => '20',
				'height' => '20',
			),
		);

		return $this->get_svg( $path, $args );
	}
}
