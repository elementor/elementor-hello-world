<?php
/**
 * Plugin Name: Elementor Hello World
 * Description: Elementor sample plugin.
 * Plugin URI:  https://elementor.com/
 * Version:     1.2.0
 * Author:      Author Name
 * Author URI:  https://elementor.com/
 * Text Domain: hello-world
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_HELLO_WORLD__FILE__', __FILE__ );

/**
 * Main Elementor Hello World Class
 *
 * The init class that runs the Hello World plugin.
 *
 * @since 1.2.0
 */
final class Elementor_Hello_World {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Elementor_Hello_World The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Hello World Version
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @var string The plugin version.
	 */
	public $version = '1.2.0';

	/**
	 * Minumum Elementor Version
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	public $minimum_elementor_version = '1.8.0';

	/**
	 * Minumum PHP Version
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	public $minimum_php_version = '5.4';

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Elementor_Hello_World An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	/**
	 * Clone
	 *
	 * Disable class cloning.
	 *
	 * @since  1.2.0
	 *
	 * @access protected
	 *
	 * @return void
	 */
	public function __clone() {

		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'hello-world' ), '1.2.0' );

	}

	/**
	 * Wakeup
	 *
	 * Disable unserializing the class.
	 *
	 * @since  1.2.0
	 *
	 * @access protected
	 *
	 * @return void
	 */
	public function __wakeup() {

		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'hello-world' ), '1.2.0' );

	}

	/**
	 * Constructor
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function __construct() {

		$this->includes();
		$this->init_hooks();

		do_action( 'hello_world_loaded' );

	}

	/**
	 * Include Files
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function includes() {

		require_once( __DIR__ . '/plugin.php' );

	}

	/**
	 * Init Hooks
	 *
	 * Hook into actions and filters.
	 *
	 * @since 1.2.0
	 *
	 * @access private
	 */
	private function init_hooks() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function i18n() {

		load_plugin_textdomain( 'hello-world' );

	}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin after Elementor (and other plugins) are loaded.
	 *
	 * @since 1.0.0
	 * @since 1.2.0 The logic moved from a standalone function to this class method.
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			add_action( 'admin_init', [ $this, 'deactivate_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, $this->minimum_elementor_version, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			add_action( 'admin_init', [ $this, 'deactivate_plugin' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, $this->minimum_php_version, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			add_action( 'admin_init', [ $this, 'deactivate_plugin' ] );
			return;
		}

		// Hello World Plugin
		new \HelloWorld\Plugin();

	}

	/**
	 * Deactivate Elementor
	 *
	 * Deactivate this plugin if elementor is not installed and active.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function deactivate_plugin() {

		deactivate_plugins( plugin_basename( __FILE__ ) );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Hello World 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'hello-world' ),
			'<strong>' . esc_html__( 'Hello World', 'hello-world' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'hello-world' ) . '</strong>'
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Hello World 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hello-world' ),
			'<strong>' . esc_html__( 'Hello World', 'hello-world' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'hello-world' ) . '</strong>',
			 $this->minimum_elementor_version
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.2.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Hello World 2: PHP 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hello-world' ),
			'<strong>' . esc_html__( 'Hello World', 'hello-world' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'hello-world' ) . '</strong>',
			 $this->minimum_php_version
		);
		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

}



/**
 * Load Hello World
 *
 * Main instance of Elementor_Hello_World.
 *
 * @since 1.0.0
 * @since 1.2.0 The logic moved from this function to a class method.
 */
function hello_world_load() {

	return Elementor_Hello_World::instance();

}

// Run Hello World
hello_world_load();
