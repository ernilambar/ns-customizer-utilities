<?php
/**
 * Radio control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use WP_Customize_Control;

/**
 * Radio control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Radio extends WP_Customize_Control {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-radio';

	/**
	 * Layout.
	 *
	 * @access public
	 * @var string
	 */
	public $layout = 'vertical';

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']       = $this->type . '-' . $this->id;
		$data['value']    = $this->value();
		$data['link']     = $this->get_link();
		$data['choices']  = $this->choices;
		$data['layout']  = $this->layout;

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
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>

		<ul class="layout-{{ data.layout }}">
			<# _.each( data.choices, function( label, key ) { #>
				<li>
		      <label>
		        <input
		          {{{ data.inputAttrs }}}
		          type="radio"
		          data-id="{{ data.id }}"
		          value="{{ key }}"
		          {{ data.link }}
		          name="_customize-radio-{{ data.id }}"
		          <# if ( data.value === key ) { #> checked<# } #>
		        />
		        {{ label }}
		      </label>
				</li>
	    <# } ); #>
		</ul>
		<?php
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}