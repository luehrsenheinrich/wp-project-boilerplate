<?php
/**
 * Provides access to the main plugin object.
 *
 * This file defines the `plugin()` function, which serves as the entry point for accessing the
 * primary plugin instance and its functions. It includes checks to ensure that all plugin
 * requirements are met before initializing. Additionally, it provides access to the Dependency
 * Injection (DI) container and displays admin notices if requirements are missing.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin;

use DI\ContainerBuilder;
use DI\Container;

/**
 * Access the main plugin instance.
 *
 * This function returns the main plugin component, initializing it on the first call if all
 * requirements are met. It checks if the plugin is already initialized to avoid duplicate
 * instantiations.
 *
 * @return Plugin|null The main plugin component, or null if requirements are not met.
 */
function plugin() {
	static $plugin = null;

	if ( ! plugin_requirements_are_met() ) {
		return null; // Prevent fatal error while allowing WordPress backend access.
	}

	if ( null === $plugin ) {
		/**
		 * The main plugin component.
		 *
		 * @var Plugin $plugin
		 */
		$plugin = plugin_container()->get( Plugin::class );
	}

	return $plugin;
}

/**
 * Access the plugin's Dependency Injection (DI) container.
 *
 * This function provides access to the DI container, allowing for centralized management of
 * services and dependencies within the plugin.
 *
 * @link https://github.com/PHP-DI/PHP-DI
 * @return Container The plugin's DI container.
 */
function plugin_container() {
	static $container = null;

	if ( null === $container ) {
		$builder   = new ContainerBuilder();
		$container = $builder->build();
	}

	return $container;
}

/**
 * Check if the plugin's requirements are met.
 *
 * Verifies that all necessary dependencies and functions are available. This prevents errors
 * that could arise if required components are missing.
 *
 * @return bool True if all requirements are met, false otherwise.
 */
function plugin_requirements_are_met() {
	$requirements = array(
		'function_exists' => array(
			'\WpMunich\lhpbp\plugin\plugin',
		),
		'class_exists' => array(
			'DI\\ContainerBuilder',
		),
	);

	foreach ( $requirements as $check => $items ) {
		foreach ( $items as $item ) {
			if ( ! call_user_func( $check, $item ) ) {
				return false;
			}
		}
	}

	return true;
}

/**
 * Display an admin notice if the plugin's requirements are not met.
 *
 * This function hooks into WordPress to display an admin notice if required dependencies
 * are missing, guiding users to install or activate necessary components.
 */
function plugin_requirements_notice__error() {
	if ( plugin_requirements_are_met() ) {
		return;
	}

	?>
	<div class="notice notice-error">
		<p>
			<?php
			printf(
				/* translators: %s: Plugin name. */
				esc_html__( 'The requirements for the %s plugin are not met. Please install all requirements.', 'lhpbp' ),
				'<strong>' . esc_html__( 'LHPBP Plugin', 'lhpbp' ) . '</strong>'
			);
			?>
		</p>
	</div>
	<?php
}
add_action( 'admin_notices', '\WpMunich\lhpbp\plugin\plugin_requirements_notice__error' );
