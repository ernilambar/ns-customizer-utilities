<?php
/**
 * Sanitize
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Helper;

/**
 * Sanitize class.
 *
 * @since 1.0.0
 */
class Sanitize {

	/**
	 * Sanitize checkbox.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	public static function checkbox( $checked ) {
		return ( ( isset( $checked ) && true === $checked ) ? true : false );
	}

	/**
	 * Sanitize color.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized value; otherwise, the setting default.
	 */
	public static function color( $input, $setting ) {
		$input = sanitize_hex_color( $input );

		return ( ! is_null( $input ) ? $input : $setting->default );
	}

	/**
	 * Sanitize email.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized value; otherwise, the setting default.
	 */
	public static function email( $input, $setting ) {
		$input = sanitize_email( $input );

		return ( ! is_null( $input ) ? $input : $setting->default );
	}

	/**
	 * Sanitize integer.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input Number to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized number; otherwise, the setting default.
	 */
	public static function number( $input, $setting ) {
		$input = absint( $input );

		return ( $input ? $input : $setting->default );
	}

	/**
	 * Sanitize range.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input Number to check within the numeric range defined by the setting.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int|string Sanitized number.
	 */
	public static function range( $input, $setting ) {
		$input = floatval( $input );

		$atts = $setting->manager->get_control( $setting->id )->input_attrs;

		$min = ( isset( $atts['min'] ) ? $atts['min'] : $input );
		$max = ( isset( $atts['max'] ) ? $atts['max'] : $input );

		return ( $min <= $input && $input <= $max ? $input : $setting->default );
	}

	/**
	 * Sanitize select.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	public static function select( $input, $setting ) {
		$input = sanitize_text_field( $input );

		$choices = $setting->manager->get_control( $setting->id )->choices;

		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	/**
	 * Sanitize sortable.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	public static function sortable( $input, $setting ) {
		$new_value = array();

		$choices = $setting->manager->get_control( $setting->id )->choices;

		if ( is_array( $input ) && ! empty( $input ) ) {
			foreach ( $input as $item ) {
				if ( array_key_exists( $item, $choices ) ) {
					$new_value[] = $item;
				}
			}
		}

		return $new_value;
	}

	/**
	 * Sanitize toggle.
	 *
	 * @since 1.0.0
	 *
	 * @param bool $checked Whether the toggle in on.
	 * @return bool Whether the toggle is on.
	 */
	public static function toggle( $checked ) {
		return ( ( isset( $checked ) && 'on' === $checked ) ? 'on' : 'off' );
	}

	/**
	 * Sanitize URL.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized value; otherwise, the setting default.
	 */
	public static function url( $input, $setting ) {
		$input = esc_url_raw( $input );

		return ( ! is_null( $input ) ? $input : $setting->default );
	}
}
