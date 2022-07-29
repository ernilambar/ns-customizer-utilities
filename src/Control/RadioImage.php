<?php
/**
 * Radio Image control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

/**
 * Radio Image control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class RadioImage extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-radio-image';

	/**
	 * Images columns.
	 *
	 * @since 1.0.0
	 * @var int
	 */
	public $columns = 3;

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
		$data['columns']      = $this->columns;
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

			<div class="radio-images columns-{{data.columns}}">
				<# _.each( data.choices, function( args, choice ) { #>
					<label>
						<input type="radio" value="{{ choice }}" name="_customize-{{ data.type }}-{{ data.id }}" {{{ data.link }}} <# if ( choice == data.value ) { #> checked="checked" <# } #> />
						<span class="screen-reader-text">{{ args.label }}</span>
						<img src="{{ args.url }}" alt="{{ args.label }}" />
					</label>
				<# } ) #>
			</div><!-- .radio-images -->

		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
