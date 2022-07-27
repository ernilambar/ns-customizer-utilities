<?php
/**
 * Dimension control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

/**
 * Dimension control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Dimension extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-dimension';

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']    = $this->type . '-' . $this->id;
		$data['value'] = $this->value();
		$data['link']  = $this->get_link();

		$data['dimension_number'] = '';
		$data['dimension_unit'] = 'px';

		$is_number = preg_match( '(\d+)', $data['value'], $matches );

		if ( $is_number ) {
			$data['dimension_number'] = reset( $matches );
		}

		$pattern = '/\d+/i';

		$data['dimension_unit'] = preg_replace( $pattern, '', $data['value']);

		$data['input_attrs'] = wp_parse_args(
			$this->input_attrs,
			array(
				'min'  => 1,
				'max'  => 100,
				'step' => 1,
			)
		);

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
		<# if ( data.label ) { #>
		<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>

		<div class="dimension-field">
			<input type="range" class="dimension-slider" value="{{ data.dimension_number }}" min="{{ data.input_attrs.min }}" max="{{ data.input_attrs.max }}" step="{{ data.input_attrs.step }}" id="{{ data.id }}"  />

			<input type="text" class="dimension-number" value="{{ data.dimension_number }}" />

			<select class="dimension-unit">
				<option value="px" <# if ( 'px' === data.dimension_unit ) { #> selected="selected" <# } #>>px</option>
				<option value="%" <# if ( '%' === data.dimension_unit ) { #> selected="selected" <# } #>>%</option>
				<option value="em" <# if ( 'em' === data.dimension_unit ) { #> selected="selected" <# } #>>em</option>
				<option value="rem" <# if ( 'rem' === data.dimension_unit ) { #> selected="selected" <# } #>>rem</option>
				<option value="vh" <# if ( 'vh' === data.dimension_unit ) { #> selected="selected" <# } #>>vh</option>
				<option value="vw" <# if ( 'vw' === data.dimension_unit ) { #> selected="selected" <# } #>>vw</option>
			</select>
		</div>

		<input type="hidden" value="{{ data.dimension_number }}{{ data.dimension_unit }}" {{{ data.link }}} />
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
