<?php
/**
 * LHPBPT\Nav_Menus\Component class
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt\Nav_Menus;
use WpMunich\lhpbpt\Component;
use function add_action;
use function register_nav_menus;
use function esc_html__;
use function has_nav_menu;
use function wp_nav_menu;

/**
 * Class for managing navigation menus.
 */
class Nav_Menus extends Component {
	/**
	 * Associative array of theme navigations, keyed by their slug.
	 *
	 * @var array
	 */
	protected $nav_menu_list = array();

	/**
	 * Constructor function to populate theme vars.
	 */
	public function __construct() {
		$this->add_actions();
		$this->add_filters();

		$this->nav_menu_list = array(
			'header' => esc_html__( 'Header', 'lhpbpt' ),
			'footer' => esc_html__( 'Footer', 'lhpbpt' ),
		);
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {}

	/**
	 * Registers the navigation menus.
	 */
	public function action_register_nav_menus() {
		register_nav_menus( $this->nav_menu_list );
	}

	/**
	 * Checks whether the primary navigation menu is active.
	 *
	 * @param string $slug The slug if the menu.
	 * @return bool True if the primary navigation menu is active, false otherwise.
	 */
	public function is_nav_menu_active( $slug ) {
		if ( ! isset( $this->nav_menu_list[ $slug ] ) ) {
			return false;
		}

		return (bool) has_nav_menu( $slug );
	}

	/**
	 * Displays the primary navigation menu.
	 *
	 * @param array $args Optional. Array of arguments. See `wp_nav_menu()` documentation for a list of supported
	 *                    arguments.
	 */
	public function display_nav_menu( array $args = array() ) {
		// Return if no theme location is defined.
		if ( ! isset( $args['theme_location'] ) ) {
			return;
		}

		// Get the navs slug.
		$slug = $args['theme_location'];

		// Define defaults.
		$defaults = array(
			'container'       => 'nav',
			'container_class' => $slug . '-menu ' . $slug . '-menu--main',
			'menu_class'      => 'menu ' . $slug,
		);

		// Merge args with defaults.
		$args = wp_parse_args( $args, $defaults );

		// Output the nav.
		wp_nav_menu( $args );
	}
}
