<?php
/**
 * LHPBPP\i18n\Component class
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp\i18n;
use WpMunich\lhpbpp\Component;
use function add_action;
use function load_plugin_textdomain;

/**
 * A class to handle textdomains and other i18n related logic..
 */
class I18N extends Component {

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {}

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'lhpbpp',
			false,
			LHPBPP_PATH . '/languages/'
		);
	}
}
