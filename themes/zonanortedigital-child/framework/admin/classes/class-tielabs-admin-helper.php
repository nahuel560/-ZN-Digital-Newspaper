<?php
/**
 * This file contains a bunch of helper functions used in the admin
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_ADMIN_HELPER' )){

	class TIELABS_ADMIN_HELPER {


		/**
		 * Get List of custom sliders
		 */
		public static function get_sliders( $label = false ){

			$sliders = array();

			// Default Label
			if( ! empty( $label ) ){
				$sliders[] = esc_html__( '- Select a Slider -', TIELABS_TEXTDOMAIN );
			}

			// Query the custom sliders
			$args = array(
				'post_type'        => 'tie_slider',
				'post_status'      => 'publish',
				'posts_per_page'   => 500,
				'offset'           => 0,
				'no_found_rows'    => 1,
				'no_found_rows'    => true,
			);

			$sliders_list = get_posts( $args );

			// Add the custom sliders to the array
			if( ! empty( $sliders_list ) && is_array( $sliders_list ) ){
				foreach ( $sliders_list as $slide ){
					$sliders[ $slide->ID ] = $slide->post_title;
				}
			}

			return $sliders;
		}


		/**
		 * Get all categories as array of ID and name
		 */
		public static function get_categories( $label = false ){

			$categories = array();

			// Default Label
			if( ! empty( $label ) ){
				$categories[] = esc_html__( '- Select a Category -', TIELABS_TEXTDOMAIN );
			}

			// Query the categories
			$get_categories = get_categories( 'hide_empty=0' );

			// Add the categories to the array
			if( ! empty( $get_categories ) && is_array( $get_categories ) ){
				foreach ( $get_categories as $category ){
					$categories[ $category->cat_ID ] = $category->cat_name;
				}
			}

			return $categories;
		}


		/**
		 * Get all menus as array of ID and name
		 */
		public static function get_menus( $label = false, $custom = false ){

			$menus = array();

			// Default Label
			if( ! empty( $label ) ){
				$menus[] = esc_html__( '- Select a Menu -', TIELABS_TEXTDOMAIN );
			}

			// Custom Menus
			if( ! empty( $custom ) && is_array( $custom ) ){
				$menus = array_merge( $menus, $custom );
			}

			// Query the menus
			$get_menus = get_terms( array( 'taxonomy' => 'nav_menu', 'hide_empty' => false ) );

			// Add the menus to the array
			if( ! empty( $get_menus ) && is_array( $get_menus ) ){
				foreach ( $get_menus as $menu ){
					$menus[ $menu->term_id ] = $menu->name;
				}
			}

			return $menus;
		}


		/**
		 * Get List of the Sidebars
		 */
		public static function get_sidebars(){

			global $wp_registered_sidebars;

			$sidebars      = array( '' => esc_html__( 'Default', TIELABS_TEXTDOMAIN ) );
			$sidebars_list = $wp_registered_sidebars;

			$custom_sidebars = tie_get_option( 'sidebars' );
			if( ! empty( $custom_sidebars ) && is_array( $custom_sidebars )){
				foreach ( $custom_sidebars as $sidebar ){

					// Remove sanitized custom sidebars titles from the sidebars array.
					$sanitized_sidebar = sanitize_title( $sidebar );
					unset( $sidebars_list[ $sanitized_sidebar ] );

					// Add the Unsanitized custom sidebars titles to the array.
					$sidebars_list[ $sidebar ] = array( 'name' => $sidebar );
				}
			}

			if( ! empty( $sidebars_list ) && is_array( $sidebars_list )){
				foreach( $sidebars_list as $name => $sidebar ){
					$sidebars[ $name ] = $sidebar['name'];
				}
			}

			return $sidebars;
		}


		/**
		 * Get all background Patterns
		 */
		public static function get_patterns(){

			$patterns = array();

			for( $i=1 ; $i<=47 ; $i++ ){
				$patterns['body-bg'.$i]	=	'patterns/'.$i.'.png';
			}

			return $patterns;
		}


		/**
		 * Remove Empty values from the Multi Dim Arrays
		 */
		public static function array_filter( $input ){

			foreach ( $input as &$value ){

				if( is_array( $value ) ){
					$value = self::array_filter($value);
				}
			}

			return array_filter( $input );
		}


		/**
		 * Check if the current page is the theme options
		 */
		public static function is_theme_options_page(){

			$current_page = ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';
			return $current_page == 'tie-theme-options';
		}


		/**
		 * Check if the current page uses Gutenberg
		 */
		public static function is_edit_gutenberg(){

			if( version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' ) ) {
				$current_screen = get_current_screen();
				if ( $current_screen && method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {
					return true;
				}
			}

			return false;
		}
	}

}
