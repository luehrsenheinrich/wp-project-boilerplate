<?php
/**
 * Lhplugin\Blocks\Component class
 *
 * @package lhpbpp
 */

namespace WpMunich\lhpbpp\Blocks;
use WpMunich\lhpbpp\Component_Interface;
use function add_action;
use function acf_register_block_type;

/**
 * A class to handle the plugins blocks.
 */
class Component implements Component_Interface {
	/**
	 * Gets the unique identifier for the plugin component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() {
		return 'blocks';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		if ( function_exists( 'acf_register_block_type' ) ) {
			add_action( 'acf/init', array( $this, 'register_acf_block_types' ) );
		}
		add_filter( 'block_categories', array( $this, 'add_block_categories' ), 10, 2 );
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
				'render_template' => apply_filters( 'lh_acf_block_template_path', LHPBPP_PATH . 'blocks/acf/template.php', 'acf-demo-block' ),
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
}
