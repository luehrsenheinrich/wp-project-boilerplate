<?php
/**
 * LHPBPP\Component_Interface interface
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp;

/**
 * Interface for a plugin component.
 */
interface Component_Interface {
	/**
	 * Gets the unique identifier for the plugin component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug();

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize();
}
