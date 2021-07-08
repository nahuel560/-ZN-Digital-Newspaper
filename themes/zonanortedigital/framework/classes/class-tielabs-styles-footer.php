<?php

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_STYLES_FOOTER' )){

	class TIELABS_STYLES_FOOTER{

		public $stored_styles = '';

		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct(){

			# BWP Minify Plugin is requried and the theme's Styles to footer is enabled
			if ( ! TIELABS_BWPMINIFY_IS_ACTIVE || ! defined( 'STYLES_TO_FOOTER' ) ) return;

			# Check if the minfying CSS option is active
			$bwp_options = get_option( 'bwp_minify_general' );
			if( empty( $bwp_options[ 'enable_min_css'] ) || $bwp_options[ 'enable_min_css'] != 'yes' ) return;

			# Run the Actions
			add_action( 'bwp_minify_before_header_styles',  array( $this, 'before_header_styles' ) );
			add_action( 'bwp_minify_printed_header_styles', array( $this, 'after_header_styles'  ) );

			add_action( 'wp_footer', array( $this, 'print_styles' ), 6 );
			add_action( 'wp_head',   array( $this, 'hide_body' ) );
		}


		/**
		 * hide_body
		 */
		function hide_body(){
			echo '<style id="hide-the-body" type="text/css">body{visibility: hidden;}</style>';
		}


		/**
		 * before_header_styles
		 *
		 * Buffering the styles
		 */
		function before_header_styles(){
			ob_start();
		}


		/**
		 * after_header_styles
		 *
		 * Get the styles
		 */
		function after_header_styles(){
			$this->stored_styles = ob_get_clean();
		}


		/**
		 * print_styles
		 *
		 * Print the styles
		 */
		function print_styles(){
			echo ( $this->stored_styles );
		}

	}

	# Instantiate the class
	new TIELABS_STYLES_FOOTER();
}
