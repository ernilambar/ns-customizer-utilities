<?php
/**
 * Number control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Text;

/**
 * Number control class.
 *
 * @since 1.0.0
 */
class Number extends Text {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-number';

	/**
	 * Input type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $input_type = 'number';
}
