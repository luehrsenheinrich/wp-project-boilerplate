<?php
/**
 * LHPBPT\Theme class
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

/**
 * Main class for the theme.
 * This is the main container for all theme components. It is used to access
 * the components and to provide some basic information about the theme.
 */
class Theme {
	/**
	 * Constructor.
	 *
	 * @param Block_Patterns\Block_Patterns $block_patterns Block_Patterns component.
	 * @param i18n\I18N                     $i18n I18N component.
	 * @param Lazysizes\Lazysizes           $lazysizes Lazysizes component.
	 * @param Nav_Menus\Nav_Menus           $nav_menus Nav_Menus component.
	 * @param Scripts\Scripts               $scripts Scripts component.
	 * @param Styles\Styles                 $styles Styles component.
	 * @param Theme_Supports\Theme_Supports $theme_supports Theme_Supports component.
	 * @param Strip_Editor\Strip_Editor     $strip_editor Strip_Editor component.
	 */
	public function __construct(
		private Block_Patterns\Block_Patterns $block_patterns,
		private i18n\I18N $i18n,
		private Lazysizes\Lazysizes $lazysizes,
		private Nav_Menus\Nav_Menus $nav_menus,
		private Scripts\Scripts $scripts,
		private Styles\Styles $styles,
		private Theme_Supports\Theme_Supports $theme_supports,
		private Strip_Editor\Strip_Editor $strip_editor
	) {
	}

	/**
	 * Get the Nav Menus component.
	 *
	 * @return Nav_Menus\Nav_Menus Nav Menus component.
	 */
	public function nav_menus() {
		return $this->nav_menus;
	}

	/**
	 * Get the Scripts component.
	 *
	 * @return Scripts\Scripts Scripts component.
	 */
	public function scripts() {
		return $this->scripts;
	}

	/**
	 * Get the Styles component.
	 *
	 * @return Styles\Styles Styles component.
	 */
	public function styles() {
		return $this->styles;
	}

	/**
	 * Get the current theme slug.
	 *
	 * @return string Theme slug.
	 */
	public function get_theme_slug() {
		return 'lhpbpt';
	}

	/**
	 * Get the current theme version.
	 *
	 * @return string Theme version.
	 */
	public function get_theme_version() {
		return wp_get_theme()->get( 'Version' );
	}
}
