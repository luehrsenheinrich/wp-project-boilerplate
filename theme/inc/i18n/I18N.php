<?php
/**
 * LHPBPT\i18n\Component class
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\i18n;

use WpMunich\lhpbp\theme\Theme_Component;

use function add_action;
use function load_theme_textdomain;

/**
 * A class to handle textdomains and other i18n related logic..
 */
class I18N extends Theme_Component {
	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {
		add_action( 'after_setup_theme', array( $this, 'load_text_domain' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {}

	/**
	 * Load the themes textdomain.
	 *
	 * @return void
	 */
	public function load_text_domain() {
		load_theme_textdomain( 'lhpbpt', get_template_directory() . '/languages' );
	}
}
