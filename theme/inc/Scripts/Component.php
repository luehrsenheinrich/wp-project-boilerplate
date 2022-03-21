<?php
/**
 * LHPBPT\Scripts\Component class
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt\Scripts;
use WpMunich\lhpbpt\Component_Interface;
use function add_action;

/**
 * A class to enqueue the needed scripts..
 */
class Component implements Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() {
		return 'script';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue needed scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'lhpbpt-script', get_template_directory_uri() . '/dist/js/script.min.js', array(), LHPBPT_VERSION, true );

		$translation_array = array(
			'themeUrl' => get_template_directory_uri(),
			'restUrl'  => get_rest_url(),
		);
		wp_localize_script( 'lhpbpt-script', 'lhpbpt', $translation_array );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
