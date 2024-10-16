<?php
/**
 * The Nav_Menus component.
 *
 * This file defines the `Nav_Menus` class, responsible for managing the theme's navigation menus
 * and pagination functionality. It registers navigation menus, checks if specific menus are active,
 * displays menus, and generates custom pagination links.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Nav_Menus;

use WpMunich\lhpbp\theme\Theme_Component;

use function esc_html__;
use function get_pagenum_link;
use function has_nav_menu;
use function register_nav_menus;
use function wp_nav_menu;
use function wp_parse_args;

/**
 * Nav_Menus
 *
 * A class that handles theme navigation menu registration, display, and custom pagination generation.
 */
class Nav_Menus extends Theme_Component {

	/**
	 * Associative array of theme navigation menus, keyed by their slug.
	 *
	 * @var array
	 */
	protected $nav_menu_list = array();

	/**
	 * Constructor function to initialize navigation menus.
	 *
	 * Populates the `$nav_menu_list` array with key-value pairs representing the slug and
	 * label of each menu location. Initializes actions and filters for menu registration.
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
	 * Registers the theme navigation menus.
	 *
	 * Associates menu slugs in `$nav_menu_list` with their display names for WordPress, enabling
	 * editors to assign menus to these locations in the Customizer or Menus admin.
	 *
	 * @return void
	 */
	public function action_register_nav_menus() {
		register_nav_menus( $this->nav_menu_list );
	}

	/**
	 * Checks if a navigation menu is active based on its slug.
	 *
	 * @param string $slug The slug of the menu to check.
	 * @return bool True if the specified menu is active, false otherwise.
	 */
	public function is_nav_menu_active( $slug ) {
		if ( ! isset( $this->nav_menu_list[ $slug ] ) ) {
			return false;
		}

		return (bool) has_nav_menu( $slug );
	}

	/**
	 * Displays a navigation menu with custom arguments.
	 *
	 * If a theme location is specified in `$args`, this method renders a menu at that location
	 * using `wp_nav_menu`. Customizes the default CSS classes and container based on the `theme_location`
	 * argument provided.
	 *
	 * @param array $args Optional. Array of arguments. See `wp_nav_menu()` documentation for details.
	 *
	 * @return void
	 */
	public function display_nav_menu( array $args = array() ) {
		if ( ! isset( $args['theme_location'] ) ) {
			return;
		}

		$slug = $args['theme_location'];

		$defaults = array(
			'container'       => 'nav',
			'container_class' => $slug . '-menu ' . $slug . '-menu--main',
			'menu_class'      => 'menu ' . $slug,
		);

		$args = wp_parse_args( $args, $defaults );

		wp_nav_menu( $args );
	}

	/**
	 * Generates an unordered list of pagination links for a paginated query.
	 *
	 * Creates a paginated list of links based on current and total pages, styling the list
	 * with the `page-numbers` class for easy CSS targeting. Useful for custom post queries
	 * with pagination.
	 *
	 * @param  array $args Optional. Array of pagination arguments.
	 *
	 * @return string HTML string containing pagination links.
	 */
	public function paginate_links( array $args = array() ) {
		global $wp_query;
		$args = wp_parse_args(
			$args,
			array(
				'current'   => $wp_query->query_vars['paged'] ? (int) $wp_query->query_vars['paged'] : 1,
				'total'     => isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1,
			)
		);

		$range = $this->generate_range( $args['current'], $args['total'] );

		$html = '<ul class="page-numbers">';
		foreach ( $range as $p ) {
			$list_classnames = classnames(
				array(
					'delta-' . $p['delta'] => $p['delta'],
				)
			);

			$list_class = ! empty( $list_classnames ) ? 'class="' . $list_classnames . '"' : '';

			$html .= sprintf( '<li %s>', $list_class );
			if ( $p['current'] ) {
				$html .= '<span class="page-numbers current">' . $p['page_number'] . '</span>';
			} elseif ( $p['dots'] ) {
				$html .= '<span class="page-numbers dots">...</span>';
			} else {
				$html .= sprintf( '<a href="%s" class="page-numbers" data-page-target="%d">', get_pagenum_link( $p['page_number'] ), $p['page_number'] );
				$html .= $p['page_number'];
				$html .= '</a>';
			}
			$html .= '</li>';
		}
		$html .= '</ul>';

		return $html;
	}

	/**
	 * Generates a range of page numbers to display in pagination.
	 *
	 * Calculates a range of page numbers centered around the current page, allowing for ellipses
	 * to condense long pagination links. Useful for displaying a subset of links for a cleaner pagination UI.
	 *
	 * @param  int $current The current page number.
	 * @param  int $last    The total number of pages.
	 * @param  int $delta   Optional. The width of the pagination range. Default is 1.
	 *
	 * @return array Array of pagination elements, including page numbers and ellipsis indicators.
	 */
	private function generate_range( $current, $last, $delta = 1 ) {
		$left            = intval( $current - $delta );
		$right           = intval( $current + $delta );
		$last            = intval( $last );
		$range           = array();
		$range_with_dots = array();

		for ( $i = 1; $i <= $last; $i++ ) {
			if ( $i === 1 || $i === $last || ( $i >= $left && $i <= $right ) ) {
				$range[] = $i;
			}
		}

		$l = null;
		foreach ( $range as $i ) {
			$delta = ( $i === $last || $i === 1 ) ? false : abs( $i - $current );

			if ( $l && $i - $l !== 1 ) {
				$range_with_dots[] = array(
					'page_number' => null,
					'current'     => false,
					'dots'        => true,
					'delta'       => 0,
				);
			}

			$range_with_dots[] = array(
				'page_number' => $i,
				'current'     => $i === $current,
				'dots'        => false,
				'delta'       => $delta,
			);

			$l = $i;
		}

		return $range_with_dots;
	}
}
