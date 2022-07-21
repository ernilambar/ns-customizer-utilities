<?php
/**
 * Init
 */

namespace Nilambar\CustomizerUtils;

/**
 * Init class.
 *
 * @since 1.0.0
 */
class Init {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'load_assets' ), 0 );
	}

	public function load_assets() {
		$file_path = realpath( dirname( __FILE__ ) );

		$script_full_path = $file_path . '/assets/js/customize-controls.js';
		$style_full_path  = $file_path . '/assets/css/customize-controls.css';

		$script_url = \Kirki\URL::get_from_path( $script_full_path );
		$style_url  = \Kirki\URL::get_from_path( $style_full_path );

		// wp_register_script( 'nscu-flatpicker', NCSUCP_URL . '/third-party/flatpickr/js/flatpickr.js', array( 'jquery' ), '4.6.13', true );
		wp_register_script( 'nscu-customize-controls', $script_url, array( 'jquery', 'customize-controls'  ), '0.0.1', true );

		// wp_register_style( 'nscu-flatpicker', NCSUCP_URL . '/third-party/flatpickr/css/flatpickr.css', array(), '4.6.13' );
		wp_register_style( 'nscu-customize-controls', $style_url, array(), '0.0.1' );
	}
}

new Init();
