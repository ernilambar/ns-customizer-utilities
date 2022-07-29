<?php
/**
 * Button section
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Section;

use WP_Customize_Section;

/**
 * Button section class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Section
 */
class Button extends WP_Customize_Section {

	/**
	 * Section type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-button';

	/**
	 * Button details.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $button = array();

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['button'] = wp_parse_args(
			$this->button,
			array(
				'text'       => '',
				'url'        => '',
				'new_window' => true,
			)
		);

		$data['button_status'] = ( ! empty( $data['button']['text'] ) && ! empty( $data['button']['url'] ) ) ? true : false;

		return $data;
	}

	/**
	 * Render template.
	 *
	 * @since 1.0.0
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title<# if ( true == data.button.button_status ) { #> no-button<# } #>">
				<span class="nscu-title">{{ data.title }}</span>

				<# if ( data.button.text && data.button.url ) { #>
					<span class="nscu-button"><a href="{{ data.button.url }}" <# if ( true == data.button.new_window ) { #> target="_blank" <# } #> class="button button-primary">{{ data.button.text }}</a></span>
				<# } #>
			</h3>
		</li>
		<?php
	}
}
