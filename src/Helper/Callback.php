<?php
/**
 * Callback
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Helper;

/**
 * Callback class.
 *
 * @since 1.0.0
 */
class Callback {

	/**
	 * Callback function for active_callback.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Control $control Control object.
	 * @return bool Whether control should be displayed or not.
	 */
	public static function active( $control ) {
		$group_status = false;

		$current_control = $control->id;

		$logics = (array) $control->manager->get_control( $current_control )->conditional_logic;

		if ( empty( $logics ) ) {
			return $group_status;
		}

		foreach ( $logics[0] as $logic ) {
			$logic = wp_parse_args(
				$logic,
				array(
					'field'   => '',
					'compare' => '==',
					'value'   => '',
				)
			);

			if ( empty( $logic['field'] ) || empty( $logic['compare'] ) ) {
				continue;
			}

			$field_value = $control->manager->get_setting( $logic['field'] )->value();

			switch ( $logic['compare'] ) {
				case '==':
					$group_status = ( $field_value === $logic['value'] );
					break;

				case '!=':
					$group_status = ( $field_value !== $logic['value'] );
					break;

				case 'in':
					$group_status = ( in_array( $field_value, $logic['value'], true ) );
					break;

				case 'not in':
					$group_status = ( ! in_array( $field_value, $logic['value'], true ) );
					break;

				default:
					break;
			}

			if ( false === $group_status ) {
				break;
			}
		}

		return $group_status;
	}
}
