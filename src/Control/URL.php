<?php
/**
 * URL control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Text;

/**
 * URL control class.
 *
 * @since 1.0.0
 */
class URL extends Text {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-url';

	/**
	 * Input type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $input_type = 'url';
}
