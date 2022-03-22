<?php
/**
 * LHPBPP\Plugin class
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp;
use InvalidArgumentException;

/**
 * Main class for the plugin.
 *
 * This class takes care of initializing plugin features and available template tags.
 */
class Plugin {

	/**
	 * ACF component.
	 *
	 * @var ACF\ACF;
	 */
	protected $acf;

	/**
	 * Blocks component.
	 *
	 * @var Blocks\Blocks;
	 */
	protected $blocks;

	/**
	 * I18N component.
	 *
	 * @var i18n\I18N;
	 */
	protected $i18n;

	/**
	 * SVG component.
	 *
	 * @var SVG\SVG;
	 */
	protected $svg;

	/**
	 * Constructor.
	 *
	 * @param ACF\ACF       $acf ACF component.
	 * @param Blocks\Blocks $blocks Blocks component.
	 * @param i18n\I18N     $i18n I18N component.
	 * @param SVG\SVG       $svg SVG component.
	 */
	public function __construct(
		ACF\ACF $acf,
		Blocks\Blocks $blocks,
		i18n\I18N $i18n,
		SVG\SVG $svg
	) {
		$this->acf    = $acf;
		$this->blocks = $blocks;
		$this->i18n   = $i18n;
		$this->svg    = $svg;
	}

	/**
	 * Get the SVG component.
	 *
	 * @return SVG\SVG The SVG component.
	 */
	public function svg() {
		return $this->svg;
	}
}
