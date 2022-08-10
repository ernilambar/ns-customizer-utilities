<?php
/**
 * Accordion control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Accordion control class.
 *
 * @since 1.0.0
 */
class Accordion extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-accordion';

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
		$data['label'] = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value'] = $this->value();
		$data['link']  = $this->get_link();

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
		<span class="customize-control-title">{{ data.label }} <span class="accordion-icon-toggle dashicons dashicons-plus"></span></span>
		<# } #>
		<# if ( data.description ) { #>
		<div class="description customize-control-description">{{{ data.description }}}</div>
		<# } #>
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
