<?php
/**
 * This file contains the abstract component class.
 * It is used to define the basic structure of a component, which we use to
 * extend the plugin and the accompanying theme. A component is a class that
 * contains all the logic for a specific feature of the plugin or theme. It combines
 * actions and filters, the logic and helper functions.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\Abstracts;

/**
 * Abstract class for a component.
 */
abstract class Component {
	/**
	 * Constructor.
	 * Used to initialize the component and add the needed actions and filters.
	 *
	 * @return void
	 */
	public function __construct() {
		do_action( 'qm/start', get_class( $this ) . ' initialized' );
		do_action( 'qm/stop', get_class( $this ) . ' initialized' );
		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * Add the needed WordPress actions for the component.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
	 */
	abstract protected function add_actions();

	/**
	 * Add the needed WordPress filters for the component.
	 *
	 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference
	 */
	abstract protected function add_filters();

	/**
	 * Get the parent class.
	 *
	 * @return Object The parent class.
	 */
	public function get_parent() {
		return get_parent_class( $this );
	}

	/**
	 * Get the DI container.
	 *
	 * @return \DI\Container The DI container.
	 */
	abstract protected function container();
}
