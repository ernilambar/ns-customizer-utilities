<?php
/**
 * Color Alpha control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

/**
 * Color Alpha control class.
 *
 * @since 1.0.0
 */
class ColorAlpha extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-color-alpha';

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
		$data['defaultValue'] = $this->setting->default;

		$data['choices'] = wp_parse_args(
			$this->choices,
			array(
				'palette'      => true,
				'show_opacity' => true,
			)
		);

		if ( is_array( $data['choices']['palette'] ) ) {
			$data['choices']['palette'] = implode( '|', $data['choices']['palette'] );
		}

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
		<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>
		<input class="color-alpha-picker" type="text" value="{{ data.value }}" data-show-opacity="{{ data.choices.show_opacity }}" data-palette="{{ data.choices.palette }}" data-default-color="{{ data.defaultValue }}" {{{ data.link }}} />
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
