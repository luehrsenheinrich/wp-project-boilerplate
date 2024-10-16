<?php
/**
 * The abstract base class for a component.
 *
 * This file defines the `Component` class, which provides the core structure for all plugin
 * and theme components. Components encapsulate the logic, actions, filters, and helper functions
 * needed for specific features within the plugin or theme.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\Abstracts;

use function WpMunich\lhpbp\plugin\plugin_container;

/**
 * Component
 *
 * An abstract class that defines the structure and behavior for components within the plugin
 * or theme. Components extending this class should implement `add_actions()` and `add_filters()`
 * methods to define their WordPress-specific hooks.
 *
 * @abstract
 */
abstract class Component {

	/**
	 * Constructor.
	 *
	 * Initializes the component by calling the `add_actions()` and `add_filters()` methods,
	 * which child classes must implement. This constructor ensures each component sets up
	 * its actions and filters when instantiated.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * Register WordPress actions for the component.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
	 * @return void
	 */
	abstract protected function add_actions();

	/**
	 * Register WordPress filters for the component.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference
	 * @return void
	 */
	abstract protected function add_filters();

	/**
	 * Get the parent class of the component instance.
	 *
	 * @return string|false The name of the parent class, or false if no parent.
	 */
	public function get_parent() {
		return get_parent_class( $this );
	}

	/**
	 * Access the Dependency Injection (DI) container.
	 *
	 * The DI container provides access to shared services and instances used throughout
	 * the plugin or theme, promoting reusability and modularity.
	 *
	 * @return \DI\Container The DI container.
	 */
	protected function container() {
		return plugin_container();
	}
}
