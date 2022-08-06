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
	 * Sanitize color alpha.
	 *
	 * @since 1.0.0
	 *
	 * @param int                  $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return int Sanitized value; otherwise, the setting default.
	 */
	public static function color_alpha( $input, $setting ) {
		$color_obj = \ariColor::newColor( $input );

		return $color_obj->toCSS( 'rgba' );
	}

	/**
	 * Sanitize dimension.
	 *
	 * @since 1.0.0
	 *
	 * @param string               $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return string Sanitized content.
	 */
	public static function dimension( $input, $setting ) {
		$is_valid        = false;
		$is_number_valid = false;
		$is_unit_valid   = false;

		$number = null;

		// Check number.
		$is_number = preg_match( '(\d+)', $input, $matches );

		if ( $is_number ) {
			$number = floatval( reset( $matches ) );
		}

		$atts = $setting->manager->get_control( $setting->id )->input_attrs;
		$min  = ( isset( $atts['min'] ) ? $atts['min'] : $input );
		$max  = ( isset( $atts['max'] ) ? $atts['max'] : $input );

		if ( $min <= $number && $number <= $max ) {
			$is_number_valid = true;
		}

		// Check units.
		$units = array( 'px', '%', 'em', 'rem', 'vh', 'vw' );

		$pattern = '/\d+/i';

		$unit = preg_replace( $pattern, '', $input );

		if ( in_array( $unit, $units, true ) ) {
			$is_unit_valid = true;
		}

		$is_valid = $is_number_valid && $is_unit_valid;

		return ( $is_valid ? $input : $setting->default );
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
	public static function integer( $input, $setting ) {
		$input = intval( $input );

		return ( $input ? $input : $setting->default );
	}

	/**
	 * Sanitize number.
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
	 * Sanitize select multiple.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	public static function select_multiple( $input, $setting ) {
		$new_values = array();

		$choices = $setting->manager->get_control( $setting->id )->choices;

		if ( is_array( $input ) && ! empty( $input ) ) {
			foreach ( $input as $item => $val ) {
				if ( array_key_exists( $val, $choices ) ) {
					$new_values[] = $val;
				}
			}
		}

		return $new_values;
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
