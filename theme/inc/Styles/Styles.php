<?php
/**
 * The Styles component.
 *
 * This file defines the `Styles` class, responsible for managing the loading and registration
 * of CSS files in the theme. It ensures that stylesheets are appropriately enqueued, preloaded,
 * and cached, and provides support for editor styles.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Styles;

use WpMunich\lhpbp\theme\Theme_Component;

use function WpMunich\lhpbp\theme\theme;
use function _doing_it_wrong;
use function add_action;
use function add_editor_style;
use function apply_filters;
use function esc_html;
use function get_theme_file_uri;
use function remove_action;
use function wp_enqueue_style;
use function wp_print_styles;
use function wp_register_style;
use function wp_style_add_data;
use function wp_styles;

/**
 * Styles
 *
 * A class that handles enqueuing, preloading, and printing of CSS files for the theme, as well as
 * managing editor styles and removing unnecessary assets like WordPress emojis.
 */
class Styles extends Theme_Component {

	/**
	 * Associative array of CSS files for the theme.
	 *
	 * @var mixed
	 */
	protected $css_files = false;

	/**
	 * {@inheritdoc}
	 */
	protected function add_actions() {
		add_action( 'wp_enqueue_scripts', array( $this, 'action_enqueue_styles' ) );
		add_action( 'wp_head', array( $this, 'action_preload_styles' ) );
		add_action( 'wp_footer', array( $this, 'action_print_preloaded_styles' ) );
		add_action( 'after_setup_theme', array( $this, 'action_add_editor_styles' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_block_editor_assets' ) );

		/** Remove WP Emoji */
		add_action( 'init', array( $this, 'remove_wp_emoji' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	protected function add_filters() {}

	/**
	 * Retrieves all CSS files for the theme.
	 *
	 * This method constructs an associative array of CSS files for the theme, storing them in
	 * `$this->css_files`. Each CSS file can have additional properties, such as global status
	 * and preload callback.
	 *
	 * @return array Associative array of CSS file handles and data pairs.
	 */
	protected function get_css_files(): array {
		if ( is_array( $this->css_files ) ) {
			return $this->css_files;
		}

		$css_files = array(
			'lhpbpt-vars' => array(
				'file'   => 'vars.min.css',
				'global' => true,
			),
			'lhpbpt-base' => array(
				'file'   => 'base.min.css',
				'global' => true,
			),
			'lhpbpt-font-fira-sans' => array(
				'file'   => 'font-fira-sans.min.css',
				'global' => true,
			),
			'lhpbpt-blocks' => array(
				'file'             => 'blocks.min.css',
				'preload_callback' => '__return_true',
			),
			'lhpbpt-footer' => array(
				'file'             => 'footer.min.css',
				'preload_callback' => '__return_true',
			),
			'lhpbpt-loop' => array(
				'file' => 'loop.min.css',
			),
			'lhpbpt-archive' => array(
				'file'             => 'archive.min.css',
				'preload_callback' => 'is_archive',
			),
		);

		/**
		 * Filters default CSS files.
		 *
		 * Allows other functions to modify or add to the theme's default CSS files.
		 *
		 * @param array $css_files Associative array of CSS files, as $handle => $data pairs.
		 */
		$css_files = apply_filters( 'lh_theme_css_files', $css_files );

		$this->css_files = array();
		foreach ( $css_files as $handle => $data ) {
			if ( is_string( $data ) ) {
				$data = array( 'file' => $data );
			}

			if ( empty( $data['file'] ) ) {
				continue;
			}

			$this->css_files[ $handle ] = array_merge(
				array(
					'global'           => false,
					'preload_callback' => null,
					'media'            => 'all',
					'enqueued'         => false,
					'preloaded'        => false,
				),
				$data
			);
		}

		return $this->css_files;
	}

	/**
	 * Determines if preloading stylesheets is enabled.
	 *
	 * By default, preloading is enabled unless the page is served in AMP. This helps with
	 * performance, but can be customized via the `lh_theme_preloading_styles_enabled` filter.
	 *
	 * @return bool True if preloading is enabled, false otherwise.
	 */
	protected function preloading_styles_enabled() {
		$preloading_styles_enabled = true;

		/**
		 * Filters whether to enable preloading of stylesheets.
		 *
		 * @param bool $preloading_styles_enabled Whether preloading is enabled.
		 */
		return apply_filters( 'lh_theme_preloading_styles_enabled', $preloading_styles_enabled );
	}

	/**
	 * Prints specific stylesheets directly in the page.
	 *
	 * This method prints `<link>` tags for specified stylesheets if they have not been globally
	 * enqueued. Only stylesheets needed for the current content are printed, improving performance.
	 *
	 * @param string ...$handles One or more stylesheet handles.
	 */
	public function print( string ...$handles ) {
		if ( ! $this->preloading_styles_enabled() ) {
			return;
		}

		$css_files = $this->get_css_files();

		$handles = array_filter(
			$handles,
			function ( $handle ) use ( $css_files ) {
				$is_valid = isset( $css_files[ $handle ] ) && ! $css_files[ $handle ]['global'];

				if ( ! $is_valid ) {
					// translators: %s is the stylesheet handle.
					_doing_it_wrong( __CLASS__ . '::print()', esc_html( sprintf( __( 'Invalid theme stylesheet handle: %s', 'lhpbpt' ), $handle ) ), 'lhpbpt' );
				}

				return $is_valid;
			}
		);

		if ( empty( $handles ) ) {
			return;
		}

		wp_print_styles( $handles );

		// Mark the printed styles as enqueued.
		foreach ( $handles as $handle ) {
			$this->css_files[ $handle ]['enqueued'] = true;
		}
	}

	/**
	 * Enqueues or registers theme stylesheets.
	 *
	 * Global stylesheets are enqueued immediately. Other stylesheets are only registered
	 * unless preloading is disabled, in which case they are enqueued conditionally.
	 */
	public function action_enqueue_styles() {
		$css_uri = get_theme_file_uri( '/dist/css/' );

		$preloading_styles_enabled = $this->preloading_styles_enabled();

		$css_files = $this->get_css_files();
		foreach ( $css_files as $handle => $data ) {
			$src = $css_uri . $data['file'];

			if ( $data['global'] || ( ! $preloading_styles_enabled && is_callable( $data['preload_callback'] ) && call_user_func( $data['preload_callback'] ) ) ) {
				wp_enqueue_style( $handle, $src, array(), theme()->get_theme_version(), $data['media'] );
				$this->css_files[ $handle ]['enqueued'] = true;
			} else {
				wp_register_style( $handle, $src, array(), theme()->get_theme_version(), $data['media'] );
			}

			wp_style_add_data( $handle, 'precache', true );
		}
	}

	/**
	 * Preloads specific stylesheets in the header.
	 *
	 * This method preloads stylesheets for templates based on defined callback functions.
	 * It outputs `<link rel="preload">` tags for each stylesheet that meets the preload criteria.
	 */
	public function action_preload_styles() {
		if ( ! $this->preloading_styles_enabled() ) {
			return;
		}

		$wp_styles = wp_styles();

		$css_files = $this->get_css_files();
		foreach ( $css_files as $handle => $data ) {
			if ( ! isset( $wp_styles->registered[ $handle ] ) || ! is_callable( $data['preload_callback'] ) || ! call_user_func( $data['preload_callback'] ) ) {
				continue;
			}

			$preload_uri = $wp_styles->registered[ $handle ]->src . '?ver=' . $wp_styles->registered[ $handle ]->ver;

			echo '<link rel="preload" id="' . esc_attr( $handle ) . '-preload" href="' . esc_url( $preload_uri ) . '" as="style">';
			echo "\n";

			$this->css_files[ $handle ]['preloaded'] = true;
		}
	}

	/**
	 * Enqueues preloaded stylesheets in the footer if not already enqueued.
	 */
	public function action_print_preloaded_styles() {
		$css_uri = get_theme_file_uri( '/dist/css/' );

		$css_files = $this->get_css_files();
		foreach ( $css_files as $handle => $data ) {
			$src = $css_uri . $data['file'];

			if ( ! $data['global'] && $data['preloaded'] && ! $data['enqueued'] ) {
				wp_enqueue_style( $handle, $src, array(), theme()->get_theme_version(), $data['media'] );
			}
		}
	}

	/**
	 * Enqueues styles for the WordPress block editor.
	 */
	public function action_add_editor_styles() {
		add_editor_style( 'dist/css/font-fira-sans.min.css' );
		add_editor_style( 'dist/css/editor-styles.min.css' );
	}

	/**
	 * Enqueues block editor assets.
	 */
	public function enqueue_block_editor_assets() {
		wp_enqueue_style( 'lhpbpt-editor-vars', get_theme_file_uri( '/dist/css/vars.min.css' ), array(), theme()->get_theme_version() );
	}

	/**
	 * Removes WP Emoji styles and scripts.
	 *
	 * @return void
	 */
	public function remove_wp_emoji() {
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
	}
}
