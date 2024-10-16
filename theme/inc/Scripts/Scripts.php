<?php
/**
 * The Scripts component.
 *
 * This file defines the `Scripts` class, which is responsible for managing
 * the enqueueing of JavaScript files in both the front-end and admin dashboard.
 * It ensures the theme's scripts are properly loaded, localized, and versioned.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Scripts;

use WpMunich\lhpbp\theme\Theme_Component;

use function WpMunich\lhpbp\theme\theme;
use function add_action;
use function comments_open;
use function get_option;
use function get_rest_url;
use function get_template_directory_uri;
use function is_singular;
use function wp_enqueue_script;
use function wp_localize_script;

/**
 * Scripts
 *
 * A class that manages the enqueueing and localization of JavaScript files
 * required by the theme in both front-end and admin areas.
 */
class Scripts extends Theme_Component {

	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {}

	/**
	 * Enqueues the main front-end scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script(
			'lhpbpt-script',
			get_template_directory_uri() . '/dist/js/script.min.js',
			array(),
			theme()->get_theme_version(),
			true
		);

		$translation_array = array(
			'themeUrl' => get_template_directory_uri(),
			'restUrl'  => get_rest_url(),
		);
		wp_localize_script( 'lhpbpt-script', 'lhpbpt', $translation_array );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueues scripts for the admin dashboard.
	 *
	 * This method enqueues a separate JavaScript file intended specifically
	 * for use in the WordPress admin area.
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script(
			'lhpbpt-admin-script',
			get_template_directory_uri() . '/admin/dist/js/script.min.js',
			array(),
			theme()->get_theme_version(),
			true
		);
	}
}
