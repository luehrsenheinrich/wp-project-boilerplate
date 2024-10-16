<?php
/**
 * The main Theme class.
 *
 * This file defines the `Theme` class, which serves as the primary container for all theme components.
 * It provides access to core components and basic theme information, such as the theme slug and version.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

/**
 * Theme
 *
 * The main class for managing the theme's components and information. This class organizes and
 * provides access to individual theme components, allowing them to be accessed from a single,
 * cohesive structure. Additionally, it supplies basic theme details like the theme slug and version.
 */
class Theme {

	/**
	 * Constructor.
	 *
	 * Initializes the main theme components upon instantiation.
	 *
	 * @param Block_Patterns\Block_Patterns $block_patterns The Block Patterns component.
	 * @param i18n\I18N                     $i18n The Internationalization (i18n) component.
	 * @param Nav_Menus\Nav_Menus           $nav_menus The Navigation Menus component.
	 * @param Scripts\Scripts               $scripts The Scripts component.
	 * @param Styles\Styles                 $styles The Styles component.
	 * @param Theme_Supports\Theme_Supports $theme_supports The Theme Supports component.
	 * @param Strip_Editor\Strip_Editor     $strip_editor The Strip Editor component.
	 */
	public function __construct(
		private Block_Patterns\Block_Patterns $block_patterns,
		private i18n\I18N $i18n,
		private Nav_Menus\Nav_Menus $nav_menus,
		private Scripts\Scripts $scripts,
		private Styles\Styles $styles,
		private Theme_Supports\Theme_Supports $theme_supports,
		private Strip_Editor\Strip_Editor $strip_editor
	) {
	}

	/**
	 * Access the Nav Menus component.
	 *
	 * @return Nav_Menus\Nav_Menus The Nav Menus component.
	 */
	public function nav_menus() {
		return $this->nav_menus;
	}

	/**
	 * Access the Scripts component.
	 *
	 * @return Scripts\Scripts The Scripts component.
	 */
	public function scripts() {
		return $this->scripts;
	}

	/**
	 * Access the Styles component.
	 *
	 * @return Styles\Styles The Styles component.
	 */
	public function styles() {
		return $this->styles;
	}

	/**
	 * Retrieve the theme's slug.
	 *
	 * The slug is a unique identifier used for theme-specific settings and localization.
	 *
	 * @return string The theme slug.
	 */
	public function get_theme_slug() {
		return 'lhpbpt';
	}

	/**
	 * Retrieve the current theme version.
	 *
	 * This method gets the theme's version number from the theme's metadata. Useful for cache-busting
	 * or version control in assets.
	 *
	 * @return string The theme version.
	 */
	public function get_theme_version() {
		return wp_get_theme()->get( 'Version' );
	}
}
