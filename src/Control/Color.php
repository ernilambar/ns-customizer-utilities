<?php
/**
 * Color control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Color control class.
 *
 * @since 1.0.0
 */
class Color extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-color';

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

		$data['choices'] = wp_parse_args(
			$this->choices,
			array(
				'palette'      => true,
				'show_opacity' => true,
				'alpha'        => false,
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
		<input class="color-picker-input" type="text" value="{{ data.value }}" data-alpha-mode="{{ data.choices.alpha }}" data-show-opacity="{{ data.choices.show_opacity }}" data-palette="{{ data.choices.palette }}" data-default-color="{{ data.defaultValue }}" {{{ data.link }}} />
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
