<?php
/**
 * Plugin Name: Elementor Hello World
 * Description: Elementor sample plugin.
 * Plugin URI:  https://elementor.com/
 * Version:     1.0.0
 * Author:      Author Name
 * Author URI:  https://elementor.com/
 * Text Domain: hello-world
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function hello_world_load() {
	// Load localization file
	load_plugin_textdomain( 'hello-world' );

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'hello_world_fail_load' );
		return;
	}

	// Check version required
	$elementor_version_required = '1.0.0';
	if ( ! version_compare( ELEMENTOR_VERSION, $elementor_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'hello_world_fail_load_out_of_date' );
		return;
	}

	// Require the main plugin file
	require( __DIR__ . '/plugin.php' );
}

// Load the plugin after Elementor (and other plugins) are loaded
add_action( 'plugins_loaded', 'hello_world_load' );
