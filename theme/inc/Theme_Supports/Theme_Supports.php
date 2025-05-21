<?php
/**
 * The Theme_Supports component.
 *
 * This file defines the `Theme_Supports` class, which is responsible for adding various
 * WordPress theme support features, enhancing the theme's compatibility with core WordPress
 * functionalities.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme\Theme_Supports;

use WpMunich\lhpbp\theme\Theme_Component;

use function add_action;
use function add_theme_support;

/**
 * Theme_Supports
 *
 * A class that enables WordPress core theme support features to enhance theme functionality.
 * These supports include features like automatic feed links, post thumbnails, responsive embeds,
 * and editor styles.
 */
class Theme_Supports extends Theme_Component {

	/**
	 * {@inheritdoc}
	 */
	public function add_actions() {
		add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );
	}

	/**
	 * {@inheritdoc}
	 */
	public function add_filters() {}

	/**
	 * Adds support for various WordPress features.
	 *
	 * This method enables several core WordPress functionalities that improve the theme's
	 * flexibility and integration with WordPress features.
	 *
	 * @return void
	 */
	public function add_theme_supports() {

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * This allows the theme to designate a "featured image" for posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Enable responsive embeds for a better mobile experience.
		add_theme_support( 'responsive-embeds' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * allowing WordPress to provide it dynamically based on context.
		 */
		add_theme_support( 'title-tag' );

		// Add support for editor styles to apply theme styling in the editor.
		add_theme_support( 'editor-styles' );

		/*
		 * Overwrite default image sizes.
		 *
		 * Adjust WordPress core defaults for "thumbnail" and "medium" sizes to
		 * match the Luehrsen // Heinrich project requirements.
		 */
		set_post_thumbnail_size( 300, 300, true );
		update_option( 'thumbnail_size_w', 300 );
		update_option( 'thumbnail_size_h', 300 );
		update_option( 'thumbnail_crop', 1 );
		update_option( 'medium_size_w', 600 );
		update_option( 'medium_size_h', 600 );
	}
}
