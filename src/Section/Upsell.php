<?php
/**
 * Upsell section
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Section;

use WP_Customize_Section;

/**
 * Upsell section class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Section
 */
class Upsell extends WP_Customize_Section {

	/**
	 * Section type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-upsell';

	/**
	 * Link details.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $link = array();

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['link'] = wp_parse_args(
			$this->link,
			array(
				'text' => '',
				'url'  => '',
			)
		);

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
			<h3 class="accordion-section-title">
				<a href="{{ data.link.url }}" target="_blank">{{ data.link.text }}</a>
			</h3>
		</li>
		<?php
	}
}
