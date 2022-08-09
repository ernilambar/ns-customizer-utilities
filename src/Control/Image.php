<?php
/**
 * Image control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Image_Control;

/**
 * Image control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Image extends WP_Customize_Image_Control {
	/**
	 * Conditional logic.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $conditional_logic = array();
}
