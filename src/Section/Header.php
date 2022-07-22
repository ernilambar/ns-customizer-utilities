<?php
/**
 * Header section
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Section;

use WP_Customize_Section;

/**
 * Header section class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Section
 */
class Header extends WP_Customize_Section {

	/**
	 * Section type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-header';

	/**
	 * Render template.
	 *
	 * @since 1.0.0
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand">
			<h3 class="accordion-section-title">
				{{ data.title }}
			</h3>
		</li>
		<?php
	}
}
