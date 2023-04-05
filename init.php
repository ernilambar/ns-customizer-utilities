<?php
/**
 * Init
 *
 * @package NS_Customizer_Utilities
 */

namespace Nilambar\CustomizerUtils;

if ( defined( 'NSCU_VERSION' ) ) {
	return;
}

if ( ! defined( 'NSCU_VERSION' ) ) {
	define( 'NSCU_VERSION' , '1.1.0' );
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

if ( ! defined( 'NSCU_URL' ) ) {
	define( 'NSCU_URL' , rtrim( get_parent_theme_file_uri(), '/' ) . '/vendor/ernilambar/ns-customizer-utilities' );
}

if ( ! class_exists( Init::class, false ) ) :
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
endif;
