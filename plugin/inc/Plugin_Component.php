<?php
/**
 * Abstract base class for plugin components.
 *
 * This file defines the `Plugin_Component` class, which serves as an abstract base class
 * for all plugin components. It extends the core `Component` class, enabling a unified
 * structure and shared functionality across all components within the plugin.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin;

/**
 * Plugin_Component
 *
 * An abstract base class for defining plugin components. All plugin components should extend
 * this class, which provides a common structure and inherited functionality from the core
 * `Component` class, ensuring consistency across the plugin.
 *
 * @abstract
 */
abstract class Plugin_Component extends Abstracts\Component {}
