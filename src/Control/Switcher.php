<?php
/**
 * Switcher control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Switcher control class.
 *
 * @since 1.0.0
 */
class Switcher extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-switcher';

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
		<label>
			<div class="field-wrapper">
				<# if ( data.label ) { #>
					<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
				<# } #>
				<div class="field-holder">
					<input id="{{ data.id }}" type="checkbox" class="switcher-input" value="{{ data.value }}" {{{ data.link }}} <# if ( true == data.value ) { #> checked="checked" <# } #> />
					<span class="field-slider round"></span>
				</div>
			</div>
			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{ data.description }}</span>
			<# } #>
		</label>
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
