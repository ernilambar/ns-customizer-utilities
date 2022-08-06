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
	public $type = 'alpha-color';

	/**
	 * Palettes.
	 *
	 * Supported palette values are true, false, or an array of RGBa and Hex colors.
	 *
	 * @since 1.0.0
	 * @var bool|array
	 */
	public $palette;

	/**
	 * Show opacity value in slider handle.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $show_opacity;

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
		$data['value']   = $this->value();
		$data['link']    = $this->get_link();
		$data['choices'] = $this->choices;

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
	 * Render the control.
	 */
	public function render_content() {

		// Process the palette
		if ( is_array( $this->palette ) ) {
			$palette = implode( '|', $this->palette );
		} else {
			// Default to true.
			$palette = ( false === $this->palette || 'false' === $this->palette ) ? 'false' : 'true';
		}

		// Support passing show_opacity as string or boolean. Default to true.
		$show_opacity = ( false === $this->show_opacity || 'false' === $this->show_opacity ) ? 'false' : 'true';

		// Begin the output. ?>

		<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
		<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>

		<label>
			<input class="alpha-color-control" type="text" data-show-opacity="<?php echo $show_opacity; ?>" data-palette="<?php echo esc_attr( $palette ); ?>" data-default-color="<?php echo esc_attr( $this->settings['default']->default ); ?>" <?php $this->link(); ?>  />
		</label>
		<?php
	}
}
