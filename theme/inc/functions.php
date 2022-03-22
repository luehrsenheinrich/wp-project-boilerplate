<?php
/**
 * The `wp_lhpbpt()` function.
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt;

/**
 * Provides access to all available template tags of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Theme The main theme component.
 */
function wp_lhpbpt() {
	static $theme = null;
	if ( null === $theme ) {
		$builder   = new \DI\ContainerBuilder();
		$container = $builder->build();

		$theme = $container->get( Theme::class );
	}
	return $theme;
}
