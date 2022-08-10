<?php
/**
 * Media control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Base;

/**
 * Media control class.
 *
 * @since 1.0.0
 *
 * @see WP_Customize_Control
 */
class Media extends Base {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-media';

	/**
	 * Conditional logic.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $conditional_logic = array();

	/**
	 * Mime type
	 *
	 * @since 1.0.0
	 * @var array
	 */
	public $mime_type = 'image';

	/**
	 * Export data to JS.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON data.
	 */
	public function json() {
		$data = parent::json();

		$data['id']        = $this->type . '-' . $this->id;
		$data['label']     = html_entity_decode( $this->label, ENT_QUOTES, get_bloginfo( 'charset' ) );
		$data['value']     = $this->value();
		$data['link']      = $this->get_link();
		$data['mime_type'] = $this->mime_type;

		if ( 'image' === $this->mime_type ) {
			$i18n = array(
				'uploader_title'       => esc_html__( 'Select Image' ),
				'uploader_button_text' => esc_html__( 'Choose Image' ),
			);
		} elseif ( 'video' === $this->mime_type ) {
			$i18n = array(
				'uploader_title'       => esc_html__( 'Select Video' ),
				'uploader_button_text' => esc_html__( 'Choose Video' ),
			);
		} elseif ( 'audio' === $this->mime_type ) {
			$i18n = array(
				'uploader_title'       => esc_html__( 'Select Audio' ),
				'uploader_button_text' => esc_html__( 'Choose Audio' ),
			);
		} else {
			$i18n = array(
				'uploader_title'       => esc_html__( 'Select Attachment' ),
				'uploader_button_text' => esc_html__( 'Choose Attachment' ),
			);
		}

		$data['i18n'] = $i18n;

		return $data;
	}

	/**
	 * Render JS template.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{ data.label }}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{ data.description }}</span>
		<# } #>

		<div class="field-media">
			<div class="field-input-wrap">
				<input type="text" class="field-input" name="_customize-{{ data.type }}-{{ data.id }}" value="{{ data.value }}" {{{ data.link }}} />
				<a href="javascript:void(0);" class="media-button field-upload" data-uploader_title="{{ data.i18n.uploader_title }}" data-uploader_button_text="{{ data.i18n.uploader_button_text }}" data-mime_type="{{ data.mime_type }}"><span class="dashicons dashicons-upload"></span></a>

				<a href="javascript:void(0);" class="media-button media-button-danger field-remove <# if ( ! data.value ) { #>hide<# } #>"><span class="dashicons dashicons-no"></span></a>
			</div>

			<# if ( 'image' === data.mime_type ) { #>
				<div class="preview-wrap <# if ( data.value ) { #>preview-on<# } #>">
					<img class="field-preview" src="{{ data.value }}" draggable="false" alt="" />
				</div>
			<# } #>

		</div>
		<?php
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_media();
		wp_enqueue_style( 'nscu-controls' );
		wp_enqueue_script( 'nscu-controls' );
	}

	/**
	 * Render content.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {}
}
