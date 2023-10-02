<?php
/**
 * The `lh_theme()` function.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

/**
 * Provides access to the business logic of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Theme The main theme component.
 */
function lh_theme() {
	static $theme = null;

	/**
	 * Check if the requirements for the current theme are met.
	 * If the requirements are not met, we might get severe errors. Therefore, we
	 * return null and do not initialize the theme.
	 */
	if ( ! theme_requirements_are_met() ) {
		return null;
	}

	if ( null === $theme ) {
		$theme = lh_theme_container()->get( Theme::class );
	}

	return $theme;
}

/**
 * Provides access to the themes DI container.
 *
 * @link https://github.com/PHP-DI/PHP-DI
 * @return \DI\Container The plugin's DI container.
 */
function lh_theme_container() {
	static $container = null;

	if ( null === $container ) {
		$builder   = new \DI\ContainerBuilder();
		$container = $builder->build();
	}

	return $container;
}

/**
 * Check if the requirements for the current theme are met.
 *
 * @return bool True if requirements are met, false otherwise.
 */
function theme_requirements_are_met() {
	/**
	 * The accompanying plugin is required.
	 */
	if ( ! function_exists( '\WpMunich\lhpbp\plugin\lh_plugin' ) || \WpMunich\lhpbp\plugin\lh_plugin() === null ) {
		return false;
	}

	/**
	 * The Advanced Custom Fields plugin is required.
	 */
	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}

	return true;
}

/**
 * Display a template if the requirements are not met.
 */
function requirements_template() {
	if ( ! theme_requirements_are_met() ) {
		wp_die( 'The requirements for this theme are not met.' );
	}
}
add_action( 'template_redirect', '\WpMunich\lhpbp\theme\requirements_template' );

/**
 * Display an admin notice if the requirements are not met.
 */
function theme_requirements_notice__error() {
	if ( theme_requirements_are_met() ) {
		return;
	}

	$class   = 'notice notice-error';
	$message = 'The requirements for this theme are not met.';

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
add_action( 'admin_notices', '\WpMunich\lhpbp\theme\theme_requirements_notice__error' );

/**
 * Render an array of html attributes into a string.
 *
 * @param array $attributes The attributes to render.
 *
 * @return string The rendered attributes.
 */
function render_attributes( array $attributes ) {
	$rendered_attributes = '';

	foreach ( $attributes as $name => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		$rendered_attributes .= sprintf( '%s="%s" ', esc_attr( $name ), esc_attr( $value ) );
	}

	return trim( $rendered_attributes );
}
