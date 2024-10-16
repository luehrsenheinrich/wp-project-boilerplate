<?php
/**
 * Abstract base class for theme components.
 *
 * This file defines the `Theme_Component` class, an abstract class that
 * extends the core `Component` class. It provides a foundational structure
 * for theme-specific components, allowing shared functionality to be easily
 * inherited by concrete classes.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

use WpMunich\lhpbp\plugin\Abstracts\Component;

/**
 * Theme_Component
 *
 * An abstract base class for defining theme components. All theme components
 * extend this class to maintain a consistent structure and inherit core
 * component functionality from the `Component` class in the plugin.
 *
 * @abstract
 */
abstract class Theme_Component extends Component {
}
