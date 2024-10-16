<?php
/**
 * The I18N component.
 *
 * This file defines the `I18N` class, which handles internationalization (i18n) for the plugin.
 * It manages the loading of the plugin's text domain to make strings translatable, ensuring
 * compatibility with multiple languages.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\i18n;

use WpMunich\lhpbp\plugin\Plugin_Component;

use function WpMunich\lhpbp\plugin\plugin;
use function add_action;
use function load_plugin_textdomain;

/**
 * I18N
 *
 * A class to handle the plugin's internationalization (i18n) functionality, including loading
 * text domains for translations. This class ensures that all translatable strings in the plugin
 * can be localized based on the active WordPress language.
 */
class I18N extends Plugin_Component {

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		add_action( 'init', array( $this, 'load_plugin_textdomain' ), 1 );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * Registers the plugin's text domain, enabling the loading of language files from
	 * the specified directory. This ensures that all plugin strings are translatable
	 * and can be localized based on the site's language settings.
	 */
	public function load_plugin_textdomain() {
		// Determine the relative path to the languages directory.
		$dir  = str_replace( WP_PLUGIN_DIR, '', plugin()->get_plugin_path() );
		$path = $dir . '/languages/';

		load_plugin_textdomain(
			'lhpbpp',
			false,
			$path
		);
	}
}
