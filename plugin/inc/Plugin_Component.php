<?php
/**
 * The implementation of the abstract component class for plugin components.
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp;

/**
 * Abstract class for a plugin component.
 */
abstract class Plugin_Component extends Abstracts\Component {
	/**
	 * {@inheritDoc}
	 */
	protected function container() {
		return lh_plugin_container();
	}
}
