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
function plugin() {
	static $plugin = null;

	/**
	 * Check if the requirements for the current plugin are met.
	 * If the requirements are not met, we might get severe errors. Therefore, we
	 * return null and do not initialize the plugin.
	 */
	if ( ! plugin_requirements_are_met() ) {
		return null;
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
 * Provides access to the plugin's DI container.
 *
 * @link https://github.com/PHP-DI/PHP-DI
 * @return \DI\Container The plugin's DI container.
 */
function plugin_container() {
	static $container = null;

	if ( null === $container ) {
		$builder   = new \DI\ContainerBuilder();
		$container = $builder->build();
	}

	return $container;
}

/**
 * Check if the requirements for the current plugin are met.
 *
 * @return bool True if requirements are met, false otherwise.
 */
function plugin_requirements_are_met() {
	/**
	 * Advanced Custom Fields Pro is required.
	 */
	if ( ! function_exists( '\acf_add_options_page' ) ) {
		return false;
	}

	return true;
}

/**
 * Display an admin notice if the requirements are not met.
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
