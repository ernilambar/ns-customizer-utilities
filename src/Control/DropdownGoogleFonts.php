<?php
/**
 * Dropdown Google Fonts control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;
use Nilambar\CustomizerUtils\Helper\GoogleFonts;

/**
 * Dropdown Google Fonts control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class DropdownGoogleFonts extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-google-fonts';

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


	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']           = $this->type . '-' . $this->id;
		$data['value']        = $this->value();
		$data['link']         = $this->get_link();
		$data['choices']      = $this->choices;
		$data['defaultValue'] = $this->setting->default;

		return $data;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'nscu-customize-controls' );
		wp_enqueue_script( 'nscu-customize-controls' );
	}

	/**
	 * Render JS template.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
			<# if ( ! data.choices ) {
				return;
			} #>
			<# if ( data.label ) { #>
				<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<select {{{ data.link }}} name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}" <# if ( true == data.multiple ) { #>multiple<# } #>>
				<# _.each( data.choices, function( label, choice ) { #>

					<option value="{{ choice }}" <# if ( choice === data.value ) { #> selected="selected" <# } #>>{{{ label }}}</option>

				<# } ) #>
			</select>
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
