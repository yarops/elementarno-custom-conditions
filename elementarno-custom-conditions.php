<?php
/**
 * Plugin Name: Elementor Custom Conditions
 * Plugin URI: https://example.com
 * Description: Adds custom display conditions for Elementor, including Page Template condition.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * Text Domain: elementarno-custom-conditions
 * Domain Path: /languages
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load Composer autoloader.
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main Plugin Class.
 */
final class Elementarno_Custom_Conditions {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor version required.
	 *
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

	/**
	 * Minimum PHP version required.
	 *
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '7.4';

	/**
	 * Plugin instance.
	 *
	 * @var Elementarno_Custom_Conditions
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return Elementarno_Custom_Conditions
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Initialize the plugin.
	 *
	 * @return void
	 */
	public function init() {
		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor' ) );
			return;
		}

		// Check for required Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		// Check if Elementor Pro is installed and activated.
		if ( ! function_exists( 'elementor_pro_load_plugin' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_elementor_pro' ) );
			return;
		}

		// Register custom conditions.
		add_action( 'elementor/theme/register_conditions', array( $this, 'register_conditions' ) );
	}

	/**
	 * Register custom conditions.
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager $conditions_manager Conditions manager instance.
	 * @return void
	 */
	public function register_conditions( $conditions_manager ) {
		// Check if base class exists.
		if ( ! class_exists( '\ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base' ) ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				error_log( 'Elementarno: Condition_Base class not found' );
			}
			return;
		}

		// Get the 'general' group.
		$general_group = $conditions_manager->get_condition( 'general' );

		if ( ! $general_group ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				error_log( 'Elementarno: General group not found' );
			}
			return;
		}

		// Register Page Template condition.
		$page_template_condition = new \Elementarno\Conditions\PageTemplate();
		$conditions_manager->get_condition( 'general' )->register_sub_condition( $page_template_condition );

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'Elementarno: Page Template condition registered successfully' );
		}
	}

	/**
	 * Admin notice for missing Elementor.
	 *
	 * @return void
	 */
	public function admin_notice_missing_elementor() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementarno-custom-conditions' ),
			'<strong>' . esc_html__( 'Elementor Custom Conditions', 'elementarno-custom-conditions' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementarno-custom-conditions' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice for missing Elementor Pro.
	 *
	 * @return void
	 */
	public function admin_notice_missing_elementor_pro() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor Pro */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementarno-custom-conditions' ),
			'<strong>' . esc_html__( 'Elementor Custom Conditions', 'elementarno-custom-conditions' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor Pro', 'elementarno-custom-conditions' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice for minimum Elementor version.
	 *
	 * @return void
	 */
	public function admin_notice_minimum_elementor_version() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementarno-custom-conditions' ),
			'<strong>' . esc_html__( 'Elementor Custom Conditions', 'elementarno-custom-conditions' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementarno-custom-conditions' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice for minimum PHP version.
	 *
	 * @return void
	 */
	public function admin_notice_minimum_php_version() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['activate'] ) ) {
			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementarno-custom-conditions' ),
			'<strong>' . esc_html__( 'Elementor Custom Conditions', 'elementarno-custom-conditions' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementarno-custom-conditions' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

Elementarno_Custom_Conditions::instance();
