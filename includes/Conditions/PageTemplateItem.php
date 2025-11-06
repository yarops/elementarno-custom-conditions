<?php
/**
 * Page Template Item Sub-Condition.
 *
 * @package Elementarno_Custom_Conditions
 */

namespace Elementarno\Conditions;

use ElementorPro\Modules\ThemeBuilder\Conditions\Condition_Base;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Page Template Item sub-condition class.
 */
class PageTemplateItem extends Condition_Base {

	/**
	 * Template ID.
	 *
	 * @var string
	 */
	private $template_id;

	/**
	 * Template label.
	 *
	 * @var string
	 */
	private $template_label;

	/**
	 * Constructor.
	 *
	 * @param array $data Condition data.
	 */
	public function __construct( $data ) {
		$this->template_id    = isset( $data['template_id'] ) ? $data['template_id'] : '';
		$this->template_label = isset( $data['template_label'] ) ? $data['template_label'] : '';

		// Call parent constructor without data to avoid "id" key requirement.
		parent::__construct( array() );
	}

	/**
	 * Get condition type.
	 *
	 * @return string
	 */
	public static function get_type() {
		return 'page_template_item';
	}

	/**
	 * Get condition name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->template_id;
	}

	/**
	 * Get condition label.
	 *
	 * @return string
	 */
	public function get_label() {
		return $this->template_label;
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
	 * Check if condition matches.
	 *
	 * @param array $args Arguments to check.
	 * @return bool
	 */
	public function check( $args ) {
		// Get current page template.
		$current_template = get_page_template_slug();

		// If no template is set, it's the default template.
		if ( empty( $current_template ) ) {
			$current_template = 'default';
		}

		if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
			// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			error_log( 'PageTemplateItem check(): Comparing template_id=' . $this->template_id . ' with current=' . $current_template );
		}

		// Check if current template matches this template ID.
		$res = $this->template_id === $current_template;
		return $res;
	}
}
