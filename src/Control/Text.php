<?php
/**
 * Text control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Text control class.
 *
 * @since 1.0.0
 */
class Text extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-text';

	/**
	 * Input type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $input_type = 'text';

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
		$data['label']        = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']        = $this->value();
		$data['link']         = $this->get_link();
		$data['defaultValue'] = $this->setting->default;
		$data['input_type']   = $this->input_type;

		$attr_string = '';

		if ( is_array( $this->input_attrs ) && ! empty( $this->input_attrs ) ) {
			foreach ( $this->input_attrs as $attr => $value ) {
				$attr_string .= $attr . '="' . esc_attr( $value ) . '" ';
			}
		}

		$data['inputAttrs'] = $attr_string;

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

		<input type="{{ data.input_type }}" name="_customize-text-{{ data.id }}" id="{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} {{{ data.inputAttrs }}} />
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
