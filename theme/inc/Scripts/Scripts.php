<?php
/**
 * LHPBPT\Scripts\Component class
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
 * A class to enqueue the needed scripts..
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
	 * Enqueue needed scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'lhpbpt-script', get_template_directory_uri() . '/dist/js/script.min.js', array(), theme()->get_theme_version(), true );

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
	 * Enqueue admin scripts.
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'lhpbpt-admin-script', get_template_directory_uri() . '/admin/dist/js/script.min.js', array(), theme()->get_theme_version(), true );
	}
}
