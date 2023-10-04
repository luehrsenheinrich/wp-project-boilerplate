<?php
/**
 * The implementation of the abstract component class for plugin components.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin;

/**
 * Abstract class for a plugin component.
 */
abstract class Plugin_Component extends Abstracts\Component {
	/**
	 * {@inheritDoc}
	 */
	protected function container() {
		return plugin_container();
	}
}
