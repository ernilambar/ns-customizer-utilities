<?php
/**
 * Range control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Range control class.
 *
 * @since 1.0.0
 */
class Range extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-range';

	/**
	 * Suffix.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $suffix = '';

	/**
	 * Conditional logic.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $conditional_logic = array();

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

		$data['suffix'] = $this->suffix;

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
		<div class="range-container">
			<# if ( data.label ) { #>
				<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
			<# } #>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
			<div class="range-wrapper">
				<div class="range-field">
					<input type="range" class="range-input" value="{{ data.value }}" min="{{ data.input_attrs.min }}" max="{{ data.input_attrs.max }}" step="{{ data.input_attrs.step }}" id="{{ data.id }}" {{{ data.link }}} />

					<div class="range-value-holder">
						<input type="text" class="range-number" value="{{ data.value }}" />
						<span class="range-value-suffix">{{ data.suffix }}</span>
					</div>
				</div>

				<button class="range-reset" data-default="{{data.defaultValue}}">
					<i class="dashicons dashicons-image-rotate"></i>
				</button><!-- .range-reset -->

			</div><!-- .range-wrapper -->

		</div><!-- .range-container -->
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
