<?php
/**
 * The file that provides access to the plugin object.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin;

/**
 * Provides access to all available functions of the plugin.
 *
 * When called for the first time, the function will initialize the plugin.
 *
 * @return Plugin The main plugin component.
 */
function lh_plugin() {
	static $plugin = null;

	if ( null === $plugin ) {
		/**
		 * The main plugin component.
		 *
		 * @var Plugin $plugin
		 */
		$plugin = lh_plugin_container()->get( Plugin::class );
	}

	return $plugin;
}

/**
 * Provides access to the plugin's DI container.
 *
 * @link https://github.com/PHP-DI/PHP-DI
 * @return \DI\Container The plugin's DI container.
 */
function lh_plugin_container() {
	static $container = null;

	if ( null === $container ) {
		$builder   = new \DI\ContainerBuilder();
		$container = $builder->build();
	}

	return $container;
}
