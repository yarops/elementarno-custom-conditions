<?php
/**
 * Page Template Condition.
 *
 * @package Elementarno_Custom_Conditions
 */

namespace Elementarno\Conditions;

use ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager;
use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page Template condition class.
 */
class PageTemplate extends Condition_Base {

	/**
	 * Get condition name.
	 *
	 * @return string
	 */
	public static function get_type() {
		return 'page_template';
	}

	/**
	 * Get condition priority.
	 *
	 * @return int
	 */
	public static function get_priority() {
		return 60;
	}

	/**
	 * Get condition label.
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Page Template', 'elementarno-custom-conditions' );
	}

	/**
	 * Get condition name (alias for get_type).
	 *
	 * @return string
	 */
	public function get_name() {
		return self::get_type();
	}

	/**
	 * Check if condition matches.
	 *
	 * This method is not used when sub-conditions are registered.
	 * The check is performed by the sub-condition items.
	 *
	 * @param array $args Arguments to check.
	 * @return bool
	 */
	public function check( $args ) {
		// When sub-conditions are used, this method is not called.
		// The check happens in PageTemplateItem::check().
		return true;
	}

	/**
	 * Get label for "all" option.
	 *
	 * @return string
	 */
	public function get_all_label() {
		return esc_html__( 'All Page Templates', 'elementarno-custom-conditions' );
	}

	/**
	 * Register sub conditions.
	 *
	 * @return void
	 */
	public function register_sub_conditions() {
		$templates = $this->get_page_templates();

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'PageTemplate register_sub_conditions() called. Templates found: ' . count( $templates ) );
		}

		foreach ( $templates as $template_id => $template_name ) {
			$this->register_sub_condition(
				new PageTemplateItem(
					array(
						'template_id'    => $template_id,
						'template_label' => $template_name,
					)
				)
			);
		}
	}

	/**
	 * Register controls for condition.
	 *
	 * This method adds controls to the condition interface in Elementor.
	 *
	 * @return void
	 */
	protected function register_controls() {
		// No additional controls needed for parent condition.
		// Sub-conditions are registered via register_sub_conditions().
	}

	/**
	 * Get available page templates.
	 *
	 * @return array<string, string>
	 */
	protected function get_page_templates() {
		$templates = array();

		// Add default template option.
		$templates['default'] = esc_html__( 'Default Template', 'elementarno-custom-conditions' );

		// Get templates from current theme.
		$theme_templates = wp_get_theme()->get_page_templates();

		if ( ! empty( $theme_templates ) ) {
			foreach ( $theme_templates as $template_file => $template_name ) {
				$templates[ $template_file ] = $template_name;
			}
		}

		// Allow themes and plugins to add custom templates.
		$templates = apply_filters( 'elementarno_page_templates', $templates );

		return $templates;
	}
}
