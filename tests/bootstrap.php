<?php
/**
 * PHPUnit bootstrap file for plugin and theme tests.
 */

// Load PHPUnit Polyfills.
require dirname( __DIR__ ) . '/plugin/vendor/yoast/phpunit-polyfills/phpunitpolyfills-autoload.php';

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
    $_tests_dir = rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';
}

// Forward custom PHPUnit Polyfills configuration to PHPUnit bootstrap file.
$_phpunit_polyfills_path = getenv( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' );
if ( false !== $_phpunit_polyfills_path ) {
    define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $_phpunit_polyfills_path );
}

if ( ! file_exists( "{$_tests_dir}/includes/functions.php" ) ) {
    echo "Could not find {$_tests_dir}/includes/functions.php, have you run bin/install-wp-tests.sh ?" . PHP_EOL;
    exit( 1 );
}

// Give access to tests_add_filter() function.
require_once "{$_tests_dir}/includes/functions.php";

/**
 * Manually load the plugin and theme being tested.
 */
function _manually_load_plugins() {
    activate_plugin( 'plugin/lhpbpp.php' );
    activate_plugin( 'lhbasicsp/lhbasicsp.php' );
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugins' );

function _manually_load_theme() {
    switch_theme( 'lhpbpt' );
    require WP_CONTENT_DIR . '/themes/theme/inc/functions.php';
    call_user_func( 'WpMunich\\lhpbp\\theme\\theme' );
}
tests_add_filter( 'after_setup_theme', '_manually_load_theme' );

// Start up the WP testing environment.
require "{$_tests_dir}/includes/bootstrap.php";
