<?php
/**
 * The I18N component.
 *
 * This file defines the `I18N` class, responsible for managing the theme's internationalization
 * (i18n) by loading text domains. This setup ensures that theme strings can be translated
 * into multiple languages, enhancing accessibility and usability for a global audience.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\i18n;

use WpMunich\lhpbp\theme\Theme_Component;

use function add_action;
use function load_theme_textdomain;

/**
 * I18N
 *
 * A class that handles the loading of text domains for translation purposes in WordPress.
 * By setting up the appropriate theme text domain, this class enables all translatable
 * strings within the theme to be localized according to user language preferences.
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
	 * Loads the theme's text domain for translation.
	 *
	 * This method registers the text domain `lhpbpt` for the theme, pointing to the `/languages`
	 * directory for translation files. The text domain must match the theme's unique identifier
	 * and allows WordPress to recognize and apply translations based on user preferences.
	 *
	 * @return void
	 */
	public function load_text_domain() {
		load_theme_textdomain( 'lhpbpt', get_template_directory() . '/languages' );
	}
}
