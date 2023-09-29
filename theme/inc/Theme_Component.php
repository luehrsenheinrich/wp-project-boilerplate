<?php
/**
 * The implementation of the abstract component class for theme components.
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt;
use WpMunich\lhpbpp\Abstracts\Component;

/**
 * Abstract class for a theme component.
 */
abstract class Theme_Component extends Component {

	/**
	 * {@inheritDoc}
	 */
	protected function container() {
		return lh_theme_container();
	}
}
