<?php
/**
 * The `lh_theme()` function.
 *
 * @package lhpbpt
 */

namespace WpMunich\lhpbpt;

/**
 * Provides access to the business logic of the theme.
 *
 * When called for the first time, the function will initialize the theme.
 *
 * @return Theme The main theme component.
 */
function lh_theme() {
	static $theme = null;
	if ( null === $theme ) {
		$builder   = new \DI\ContainerBuilder();
		$container = $builder->build();

		$theme = $container->get( Theme::class );
	}
	return $theme;
}
