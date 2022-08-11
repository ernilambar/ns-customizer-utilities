<?php
/**
 * Utils
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Helper;

/**
 * Utils class.
 *
 * @since 1.0.0
 */
class Utils {

	/**
	 * Convert hex color to rgb.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hex Hex color value.
	 * @param bool   $alpha Whether to include alpha value.
	 * @return string Color value in rgb or rgba.
	 */
	public static function color_hex_to_rgb( $hex, $alpha = false ) {
		$hex    = ltrim( $hex, '#' );
		$length = strlen( $hex );

		$rgb['r'] = hexdec( 6 === $length ? substr( $hex, 0, 2 ) : ( 3 === $length ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
		$rgb['g'] = hexdec( 6 === $length ? substr( $hex, 2, 2 ) : ( 3 === $length ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
		$rgb['b'] = hexdec( 6 === $length ? substr( $hex, 4, 2 ) : ( 3 === $length ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );

		if ( $alpha ) {
			$rgb['a'] = $alpha;
		}

		return implode( array_keys( $rgb ) ) . '(' . implode( ', ', $rgb ) . ')';
	}

	/**
	 * Check whether given value is rgba color.
	 *
	 * @since 1.0.0
	 *
	 * @param string $color Color value.
	 * @return bool True if valid rgba.
	 */
	public static function is_rgba_color( $color ) {
		$pattern = '/^(rgba\(((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*,\s*){2}((\d{1,2}|1\d\d|2([0-4]\d|5[0-5]))\s*)(,\s*(0|0\.\d+|1))\))$/';

		$match = preg_match( $pattern, $color );

		return ( 1 === $match ) ? true : false;
	}
}
