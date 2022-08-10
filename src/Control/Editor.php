<?php
/**
 * Editor control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Editor control class.
 *
 * @since 1.0.0
 */
class Editor extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-editor';

	/**
	 * Editor options.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $choices = array();

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
		$data['label']   = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']   = $this->value();
		$data['link']    = $this->get_link();
		$data['choices'] = wp_parse_args(
			$this->choices,
			array(
				'tabs'            => 'both',
				'media_buttons'   => false,
				'toolbar'         => 'default',
				'toolbar_buttons' => '',
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
		wp_enqueue_editor();
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
			<label class="customize-control-title" for="{{{ data.id.replace( '[', '' ).replace( ']', '' ) }}}">{{ data.label }}</label>
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
