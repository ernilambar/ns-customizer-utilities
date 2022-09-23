<?php
/**
 * Select control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Select control class.
 *
 * @since 1.0.0
 */
class Select extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-select';

	/**
	 * Multiple.
	 *
	 * @access public
	 * @var bool
	 */
	public $multiple = false;

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']       = $this->type . '-' . $this->id;
		$data['label']    = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']    = $this->value();
		$data['link']     = $this->get_link();
		$data['choices']  = $this->choices;
		$data['multiple'] = $this->multiple;

		$options = array();

		if ( is_array( $this->choices ) && ! empty( $this->choices ) ) {
			foreach ( $this->choices as $key => $val ) {
				$options[] = "{$key}|||{$val}";
			}
		}

		$data['options'] = $options;

		return $data;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'nscu-controls' );
		wp_enqueue_script( 'nscu-controls' );
	}

	/**
	 * Render JS template.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
		<# if ( data.label ) { #>
			<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>

		<# var optionArr, optionKey, optionVal #>

		<select {{{ data.link }}} name="_customize-{{ data.type }}-{{ data.id }}" id="{{ data.id }}" <# if ( true == data.multiple ) { #>multiple<# } #>>
			<# _.each( data.options, function( option ) { #>

				<# optionArr = option.split( '|||' ) #>
				<# optionKey = optionArr[0] #>
				<# optionVal = optionArr[1] #>

				<option value="{{ optionKey }}" <# if ( optionKey === data.value.toString() ) { #> selected="selected" <# } #>>{{{ optionVal }}}</option>

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
