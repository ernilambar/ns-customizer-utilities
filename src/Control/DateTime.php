<?php
/**
 * Date Time control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Date Time control class.
 *
 * @since 1.0.0
 */
class DateTime extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-date-time';

	/**
	 * Disable time.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $disable_time = false;

	/**
	 * Disable date.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	public $disable_date = false;

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']          = $this->type . '-' . $this->id;
		$data['label']       = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']       = $this->value();
		$data['link']        = $this->get_link();
		$data['disableTime'] = $this->disable_time;
		$data['disableDate'] = $this->disable_date;

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
			<label class="customize-control-title" for="{{ data.id }}">{{ data.label }}</label>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>
		<label class="nscu-date-time">
			<div class="nscu-date-time-wrapper">
				<div class="nscu-date-time-field">
					<input id="{{ data.id }}" type="text" class="date-time-input" value="{{ data.value }}" data-disable-time="{{ data.disableTime }}" data-disable-date="{{ data.disableDate }}" {{{ data.link }}} />
				</div>
			</div>
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
