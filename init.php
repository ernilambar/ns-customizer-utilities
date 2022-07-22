<?php
/**
 * Init
 *
 * @package NS_Customizer_Utilities
 */

namespace Nilambar\CustomizerUtils;


if ( ! defined( 'NSCU_DIR' ) ) {
	define( 'NSCU_DIR' , rtrim( plugin_dir_path( __FILE__ ), '/' ) );
}

if ( ! defined( 'NSCU_URL' ) ) {
	define( 'NSCU_URL' , rtrim( plugin_dir_url( __FILE__ ), '/' )  );
}
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
		wp_register_script( 'nscu-flatpicker', NSCU_URL . '/assets/third-party/flatpickr/js/flatpickr.js', array( 'jquery' ), '4.6.13', true );
		wp_register_script( 'nscu-customize-controls', NSCU_URL . '/assets/js/customize-controls.js', array( 'jquery', 'customize-controls', 'nscu-flatpicker'  ), '0.0.1', true );

		wp_register_style( 'nscu-flatpicker', NSCU_URL . '/assets/third-party/flatpickr/css/flatpickr.css', array(), '4.6.13' );
		wp_register_style( 'nscu-customize-controls', NSCU_URL . '/assets/css/customize-controls.css', array( 'nscu-flatpicker' ), '0.0.1' );
	}
}

new Init();
