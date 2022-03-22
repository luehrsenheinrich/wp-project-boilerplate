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
	 * The ACF component.
	 *
	 * @var ACF\ACF
	 */
	public $acf;

	/**
	 * The i18n component.
	 *
	 * @var i18n\I18N
	 */
	public $i18n;

	/**
	 * The Nav Menus component.
	 *
	 * @var Nav_Menus\Nav_Menus
	 */
	public $nav_menus;

	/**
	 * Scripts component.
	 *
	 * @var Scripts\Scripts
	 */
	public $scripts;

	/**
	 * Styles component.
	 *
	 * @var Styles\Styles
	 */
	public $styles;

	/**
	 * Constructor.
	 *
	 * @param ACF\ACF             $acf ACF component.
	 * @param i18n\I18N           $i18n I18N component.
	 * @param Nav_Menus\Nav_Menus $nav_menus Nav_Menus component.
	 * @param Scripts\Scripts     $scripts Scripts component.
	 * @param Styles\Styles       $styles Styles component.
	 */
	public function __construct(
		ACF\ACF $acf,
		i18n\I18N $i18n,
		Nav_Menus\Nav_Menus $nav_menus,
		Scripts\Scripts $scripts,
		Styles\Styles $styles
	) {
		$this->acf       = $acf;
		$this->i18n      = $i18n;
		$this->nav_menus = $nav_menus;
		$this->scripts   = $scripts;
		$this->styles    = $styles;
	}
}
