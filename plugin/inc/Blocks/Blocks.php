<?php
/**
 * Lhplugin\Blocks\Component class
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp\Blocks;
use WpMunich\lhpbpp\Component;
use function add_action;
use function acf_register_block_type;
use function WpMunich\lhpbpp\lh_plugin;

/**
 * A class to handle the plugins blocks.
 */
class Blocks extends Component {

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		if ( function_exists( 'acf_register_block_type' ) ) {
			add_action( 'acf/init', array( $this, 'register_acf_block_types' ) );
		}

		add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {
		add_filter( 'block_categories_all', array( $this, 'add_block_categories' ), 10, 2 );
	}

	/**
	 * Register ACF driven blocks.
	 *
	 * @return void
	 */
	public function register_acf_block_types() {
		acf_register_block_type(
			array(
				'name'            => 'acf-demo-block',
				'title'           => __( 'Demo Block', 'lhpbpp' ),
				'description'     => __( 'A demo block to show that everything is working.', 'lhpbpp' ),
				'category'        => 'lhpbpp-blocks',
				'icon'            => 'screenoptions',
				'keywords'        => array( __( 'ACF', 'lhpbpp' ), __( 'Demo', 'lhpbpp' ), __( 'Block', 'lhpbpp' ) ),
				'render_template' => apply_filters( 'lh_acf_block_template_path', lh_plugin()->get_plugin_path() . 'blocks/acf/template.php', 'acf-demo-block' ),
				'mode'            => 'auto',
				'supports'        => array(
					'align' => array( 'wide', 'full' ),
					'mode'  => 'auto',
				),
			)
		);
	}

	/**
	 * Register the plugins custom block category.
	 *
	 * @param array   $categories The block categories.
	 * @param WP_Post $post     The current post that is edited.
	 */
	public function add_block_categories( $categories, $post ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'lhpbpp-blocks',
					'title' => __( 'Luehrsen // Heinrich', 'lhpbpp' ),
				),
			)
		);
	}

	/**
	 * Enqueue the block scripts and styles.
	 */
	public function enqueue_block_editor_assets() {
		$screen = get_current_screen();

		$assets = wp_json_file_decode( lh_plugin()->get_plugin_path() . '/admin/dist/assets.json', array( 'associative' => true ) );

		if ( ! in_array( $screen->id, array( 'widgets' ), true ) ) {
			$block_helper_assets = $assets['js/blocks-helper.min.js'] ?? array();
			wp_enqueue_script(
				'lhpbpp-blocks-helper',
				lh_plugin()->get_plugin_url() . '/admin/dist/js/blocks-helper.min.js',
				array_merge( array(), $block_helper_assets['dependencies'] ),
				$block_helper_assets['version'],
				true
			);

		}
	}
}
