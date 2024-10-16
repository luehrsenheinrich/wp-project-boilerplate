<?php
/**
 * The theme initialization functions and helpers.
 *
 * This file provides the main `theme()` function to initialize the theme, along with helper functions
 * for verifying theme requirements, rendering attributes, and displaying notices when requirements
 * are not met.
 *
 * @package lhpbp\theme
 */

namespace WpMunich\lhpbp\theme;

use function WpMunich\lhpbp\plugin\plugin_container;

/**
 * Initializes and provides access to the main Theme instance.
 *
 * This function checks if all theme requirements are met before initializing the main theme component.
 * It initializes the theme on its first call and provides access to the theme's business logic.
 *
 * @return Theme|null The main Theme component if requirements are met, null otherwise.
 */
function theme() {
	static $theme = null;

	// Check if the theme requirements are satisfied.
	if ( ! theme_requirements_are_met() ) {
		return null;
	}

	// Initialize the theme only once.
	if ( null === $theme ) {
		$theme = plugin_container()->get( Theme::class );
	}

	return $theme;
}

/**
 * Validates that the theme requirements are met.
 *
 * Currently, the only requirement is the accompanying plugin. If the plugin is not active,
 * theme functionality may be limited or unavailable. This function ensures compatibility
 * between the theme and its required plugin.
 *
 * @return bool True if all requirements are met, false otherwise.
 */
function theme_requirements_are_met() {
	// Confirm the accompanying plugin is active.
	if ( ! function_exists( '\WpMunich\lhpbp\plugin\plugin' ) || \WpMunich\lhpbp\plugin\plugin() === null ) {
		return false;
	}

	return true;
}

/**
 * Displays an error template if theme requirements are not met.
 *
 * This function interrupts the page load to display an error message, notifying the user
 * that required components for the theme are missing or inactive. It halts further processing
 * and prompts the user to activate the required plugin.
 */
function requirements_template() {
	if ( ! theme_requirements_are_met() ) {
		wp_die( 'The requirements for this theme are not met. Please install and activate the accompanying plugin.' );
	}
}
add_action( 'template_redirect', '\WpMunich\lhpbp\theme\requirements_template' );

/**
 * Displays an admin notice if theme requirements are not met.
 *
 * If the theme requirements are not met, this function displays an admin notice
 * with an error message, guiding the user to activate the necessary plugin for
 * full theme functionality.
 */
function theme_requirements_notice__error() {
	if ( theme_requirements_are_met() ) {
		return;
	}

	$class   = 'notice notice-error';
	$message = 'The requirements for this theme are not met. Please install and activate the accompanying plugin.';

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
add_action( 'admin_notices', '\WpMunich\lhpbp\theme\theme_requirements_notice__error' );

/**
 * Renders an array of HTML attributes into a formatted string.
 *
 * This helper function takes an associative array of attributes and their values
 * and converts them into a valid HTML attribute string, which can then be added
 * to HTML elements. Only attributes with non-empty values are rendered.
 *
 * @param array $attributes Associative array of attribute names and values.
 *
 * @return string The rendered attribute string, ready for inclusion in an HTML tag.
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
