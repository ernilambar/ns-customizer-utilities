<?php
/**
 * Customize Control for Heading.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

class Heading extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'nscu-heading';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since 1.0.0
	 */
	public function to_json() {
		parent::to_json();

		$this->json['value'] = $this->value();
		$this->json['link']  = $this->get_link();
		$this->json['id']    = $this->id;
	}

	public function enqueue() {
		wp_enqueue_style( 'nscu-customize-controls' );
		wp_enqueue_script( 'nscu-customize-controls' );
	}

	/**
	 * Content template.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
		<# if ( data.label ) { #>
		<h3><span class="customize-control-title">{{ data.label }}</span></h3>
		<# } #>
		<# if ( data.description ) { #>
		<span class="description customize-control-description">{{ data.description }}</span>
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
