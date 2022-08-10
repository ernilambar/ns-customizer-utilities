<?php
/**
 * Dimension control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Dimension control class.
 *
 * @since 1.0.0
 */
class Dimension extends Base {

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

		$data['id']           = $this->type . '-' . $this->id;
		$data['label']        = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']        = $this->value();
		$data['link']         = $this->get_link();
		$data['defaultValue'] = $this->setting->default;

		$default_dimension_details = $this->get_dimension_details( $this->setting->default );

		$data['defaultDimensionNumber'] = $default_dimension_details['number'];
		$data['defaultDimensionUnit']   = $default_dimension_details['unit'];

		$current_dimension_details = $this->get_dimension_details( $data['value'] );

		$data['dimension_number'] = $current_dimension_details['number'];
		$data['dimension_unit']   = $current_dimension_details['unit'];

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
	 * Return dimension details.
	 *
	 * @since 1.0.0
	 *
	 * @param string $input Dimension value with unit.
	 * @return array Dimension details with number and unit.
	 */
	protected function get_dimension_details( $input ) {
		$output = array(
			'number' => '',
			'unit'   => '',
		);

		$is_number = preg_match( '(\d+)', $input, $matches );

		if ( $is_number ) {
			$output['number'] = reset( $matches );
		}

		$pattern = '/\d+/i';

		$output['unit'] = preg_replace( $pattern, '', $input );

		return $output;
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
		<div class="dimension-container">

			<# if ( data.label ) { #>
				<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>

			<div class="dimension-wrapper">
				<button class="dimension-reset" data-default-dimension-number="{{data.defaultDimensionNumber}}" data-default-dimension-unit="{{data.defaultDimensionUnit}}">
					<i class="dashicons dashicons-image-rotate"></i>
				</button>

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
			</div><!-- .dimension-wrapper -->

			<input type="hidden" value="{{ data.dimension_number }}{{ data.dimension_unit }}" {{{ data.link }}} />

		</div><!-- .dimension-container -->
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
