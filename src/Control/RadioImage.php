<?php
/**
 * Radio Image control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Radio Image control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class RadioImage extends Base {

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
		$data['label']        = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']        = $this->value();
		$data['link']         = $this->get_link();
		$data['choices']      = $this->choices;
		$data['columns']      = $this->columns;
		$data['defaultValue'] = $this->setting->default;

		$options = array();

		if ( is_array( $this->choices ) && ! empty( $this->choices ) ) {
			foreach ( $this->choices as $key => $val ) {
				$options[] = "{$key}|||{$val}";
			}
		}

		$data['options'] = $options;

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
			<# if ( ! data.choices ) {
				return;
			} #>
			<# if ( data.label ) { #>
				<span class="customize-control-title">{{ data.label }}</span>
			<# } #>

			<# if ( data.description ) { #>
				<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>

			<# var optionArr, optionKey, optionVal #>

			<div class="radio-images columns-{{data.columns}}">
				<# _.each( data.options, function( option ) { #>

					<# optionArr = option.split( '|||' ) #>
					<# optionKey = optionArr[0] #>
					<# optionVal = optionArr[1] #>

					<label>
						<input type="radio" value="{{ optionKey }}" name="_customize-{{ data.type }}-{{ data.id }}" {{{ data.link }}} <# if ( optionKey === data.value ) { #> checked="checked" <# } #> />
						<img src="{{ optionVal }}" alt="{{ optionKey }}" />
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
