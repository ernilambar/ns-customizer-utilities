<?php
/**
 * Editor control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

/**
 * Editor control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Editor extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-editor';

	public $choices = [];

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']      = $this->type . '-' . $this->id;
		$data['choices'] = $this->choices;
		$data['value']   = $this->value();
		$data['link']    = $this->get_link();

		return $data;
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_editor();
		wp_enqueue_style( 'nscu-customize-controls' );
		wp_enqueue_script( 'nscu-customize-controls' );
	}

	public function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>

		<textarea id="{{{ data.id.replace( '[', '' ).replace( ']', '' ) }}}" {{{ data.inputAttrs }}} {{{ data.link }}}>{{ data.value }}</textarea>

		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
