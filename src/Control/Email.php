<?php
/**
 * Email control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

/**
 * Email control class.
 *
 * @since 1.0.0
 */
class Email extends Text {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-email';

	/**
	 * Input type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $input_type = 'email';
}
