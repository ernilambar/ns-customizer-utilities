<?php
/**
 * Code Editor control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Code_Editor_Control;

/**
 * Code Editor control class.
 *
 * @since 1.0.0
 */
class CodeEditor extends WP_Customize_Code_Editor_Control {
	/**
	 * Conditional logic.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $conditional_logic = array();
}
