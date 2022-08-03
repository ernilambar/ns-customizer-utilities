<?php
/**
 * Dropdown Google Fonts control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Select;
use Nilambar\CustomizerUtils\Helper\GoogleFonts;

/**
 * Dropdown Google Fonts control class.
 *
 * @since 1.0.0
 */
class DropdownGoogleFonts extends Select {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-dropdown-google-fonts';

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		$this->choices = GoogleFonts::get_fonts_options();

		parent::__construct( $manager, $id, $args );
	}
}
