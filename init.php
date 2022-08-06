<?php
/**
 * Init
 *
 * @package NS_Customizer_Utilities
 */

namespace Nilambar\CustomizerUtils;

define( 'NSCU_VERSION' , '1.0.1' );

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
		wp_register_style( 'nscu-controls', NSCU_URL . '/assets/controls.css', array( 'wp-color-picker' ), NSCU_VERSION );
		wp_register_script( 'nscu-controls', NSCU_URL . '/assets/controls.js', array( 'jquery', 'customize-controls', 'wp-color-picker' ), NSCU_VERSION, true );
	}
}

new Init();
