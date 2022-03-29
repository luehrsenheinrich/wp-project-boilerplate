<?php
/**
 * LHPBPT\Theme class
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt;

/**
 * Main class for the theme.
 *
 * This class takes care of initializing components.
 */
class Theme {

	/**
	 * The i18n component.
	 *
	 * @var i18n\I18N
	 */
	protected $i18n;

	/**
	 * The Nav Menus component.
	 *
	 * @var Nav_Menus\Nav_Menus
	 */
	protected $nav_menus;

	/**
	 * Scripts component.
	 *
	 * @var Scripts\Scripts
	 */
	protected $scripts;

	/**
	 * Styles component.
	 *
	 * @var Styles\Styles
	 */
	protected $styles;

	/**
	 * Theme Supports component.
	 *
	 * @var Theme_Supports\Theme_Supports
	 */
	protected $theme_supports;

	/**
	 * FSE component.
	 *
	 * @var FSE\FSE
	 */
	protected $fse;

	/**
	 * Lazysizes component.
	 *
	 * @var Lazysizes\Lazysizes
	 */
	protected $lazysizes;

	/**
	 * Constructor.
	 *
	 * @param i18n\I18N                     $i18n I18N component.
	 * @param Nav_Menus\Nav_Menus           $nav_menus Nav_Menus component.
	 * @param Scripts\Scripts               $scripts Scripts component.
	 * @param Styles\Styles                 $styles Styles component.
	 * @param Theme_Supports\Theme_Supports $theme_supports Theme_Supports component.
	 * @param FSE\FSE                       $fse FSE component.
	 * @param Lazysizes\Lazysizes           $lazysizes Lazysizes component.
	 */
	public function __construct(
		i18n\I18N $i18n,
		Nav_Menus\Nav_Menus $nav_menus,
		Scripts\Scripts $scripts,
		Styles\Styles $styles,
		Theme_Supports\Theme_Supports $theme_supports,
		FSE\FSE $fse,
		Lazysizes\Lazysizes $lazysizes
	) {
		// Do not display templates, if the requirements are not met.
		add_action( 'template_redirect', array( $this, 'requirements_template' ) );

		// Only initialize components if all the requirements are met.
		if ( $this->requirements_are_met() ) {
			$this->i18n           = $i18n;
			$this->nav_menus      = $nav_menus;
			$this->scripts        = $scripts;
			$this->styles         = $styles;
			$this->theme_supports = $theme_supports;
			$this->fse            = $fse;
			$this->lazysizes      = $lazysizes;
		}
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

	/**
	 * Check if the requirements for the current theme are met.
	 *
	 * @return bool True if requirements are met, false otherwise.
	 */
	private function requirements_are_met() {
		if ( ! function_exists( '\WPMunich\lhpbpp\lh_plugin' ) ) {
			return false;
		}

		if ( ! function_exists( 'get_field' ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Display a template if the requirements are not met.
	 */
	public function requirements_template() {
		if ( ! $this->requirements_are_met() ) {
			wp_die( 'The requirements for this theme are not met.' );
		}
	}
}
