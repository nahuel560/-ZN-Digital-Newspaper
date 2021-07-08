<?php
/**
 * Styles Function
 **/

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


class JANNAH_OPTIMIZATION_STYLES {


	/**
	 * Fire Filters and actions
	 */
	function __construct(){

		// Check if the theme is enabled
		if( ! class_exists( 'TIELABS_HELPER' ) || ! function_exists( 'jannah_theme_name' ) ){
			return;
		}

		// Dequeue the JS and CSS files
		add_action( 'wp_enqueue_scripts',         array( $this, 'dequeue_theme_styles' ), 99 );

		// Critical CSS
		add_action( 'wp_enqueue_scripts',         array( $this, 'print_critical_css' ), 25 );
		add_action( 'switch_theme',               array( $this, 'delete_critical_css' ) );
		add_action( 'TieLabs/after_db_update',    array( $this, 'delete_critical_css' ) );

		// Load Style files
		add_action( 'TieLabs/after_header',       array( $this, 'after_header' ),  1 );
		add_action( 'wp_body_open',               array( $this, 'after_body_without_header' ),  1 );
		add_action( 'dynamic_sidebar_before',     array( $this, 'sidebar_before' ),  1 );
		add_action( 'wp_footer',                  array( $this, 'after_footer' ), 99 );

		// no-js Body Class
		add_action( 'body_class',                 array( $this, 'body_class' ), 1 );

		// Override the inline CSS code
		if( tie_get_option( 'jso_css_delivery' ) ){

			add_filter( 'TieLabs/Styles/is_inline_css',  '__return_true' );
			add_filter( 'TieLabs/CSS/after_theme_color',   array( $this, 'inline_css_code' ), 100 );
			add_filter( 'TieLabs/CSS/Builder/block_style', array( $this, 'inline_css_code' ), 100 );
		}
	}


	/**
	 * Print the styles when it needed
	 */
	function do_style( $handle = '', $preload = false ){

		// Check if the option enabled and Disable on RTL
		if( is_rtl() || ! tie_get_option( 'jso_css_delivery' ) ){
			return;
		}

		if( empty( $handle ) ){
			return;
		}

		if( ! empty( $GLOBALS['tie_styles_files'] ) && is_array( $GLOBALS['tie_styles_files'] ) && in_array( $handle, $GLOBALS['tie_styles_files'] ) ){
			return;
		}

		$style = $this->style_path( $handle );

		if ( ! empty( $style ) ){

			$href  = $style->src;
			$media = $style->args;

			if( ! empty( $style->ver ) ){
				//$href = add_query_arg('ver', $style->ver, $href);
			}

			if( empty( $GLOBALS['tie_styles_files'] ) || ! is_array( $GLOBALS['tie_styles_files'] ) ){
				$GLOBALS['tie_styles_files'] = array( $handle );
			}
			else{
				$GLOBALS['tie_styles_files'][] = $handle;
			}

			// Preload
			if( $preload ){
				echo "<link rel='preload' href='$href' as='style' onload='this.onload=null;this.rel=\"stylesheet\"' />\n";
				echo "<noscript><link rel='stylesheet' id='$handle-css' href='$href' type='text/css' media='$media' /></noscript>\n";
			}
			// Normal
			else{
				echo "<link rel='stylesheet' id='$handle-css' href='$href' type='text/css' media='$media' />\n";
			}

			// We should insert <script> after <link> to stop the rendering till the css file loaded
			echo "<script>console.log('Style $handle')</script>\n";
		}
	}


	/**
	 * Get the CSS file path
	 */
	function style_path( $handle = '' ){

		global $wp_styles;

		if ( is_a( $wp_styles, 'WP_Styles' ) && ! empty( $wp_styles->registered[$handle]->src ) ){
			return $wp_styles->registered[$handle];
		}

		return false;
	}


	/**
	 * save_critical_css
	 */
	function save_critical_css(){

		// Don't run if this is an Ajax request
		if( defined( 'DOING_AJAX' ) && DOING_AJAX ){
			return;
		}

		// Get the registered base css file
		$file = $this->style_path( 'tie-css-base' );

		// Return if it is not exist
		if( empty( $file->src ) ){
			return;
		}

		// Request the file
		$request = wp_remote_get( $file->src );

		if( is_wp_error( $request ) ){

			tie_debug_log( $request->get_error_message(), true );
		}
		else{

			// Get the file content
			$css = wp_remote_retrieve_body( $request );

			if( ! empty( $css ) ){

				// Minify CSS if we loaded the non-minified file
				if( ! TIELABS_STYLES::is_minified() ){
					$css = TIELABS_STYLES::minify_css( $css );
				}

				// Store the code
				set_transient( 'tie_critical_css_'.TIELABS_THEME_ID, $css, YEAR_IN_SECONDS );

				//
				return $css;
			}
		}

		return false;
	}


	/**
	 * delete_critical_css
	 */
	function delete_critical_css(){
		delete_transient( 'tie_critical_css_'.TIELABS_THEME_ID );
	}


	/**
	 * print_critical_css
	 */
	function print_critical_css(){

		// Check if the option enabled and Disable on RTL
		if( is_rtl() || ! tie_get_option( 'jso_critical_css' ) ){
			return;
		}

		// Update the CSS if there is no CSS stored
		if ( false === ( $css = get_transient( 'tie_critical_css_'.TIELABS_THEME_ID ) ) ) {
			$css = $this->save_critical_css();
		}

		// return if no CSS
		if( empty( $css ) ){
			return;
		}

		// Print the code
		echo "<style id='tie-critical-css' type='text/css'>$css</style>\n";

		// Dequeue the original file
		wp_dequeue_style( 'tie-css-base' );
	}


	/**
	 * After Header Styles
	 */
	function after_header(){

		// General Styles
		$this->do_style( 'tie-css-styles' );

		// Single pages with no builder
		if( is_singular() && ! TIELABS_HELPER::has_builder() ){
			$this->do_style( 'tie-css-single' );
		}

		// Shortcodes
		if( ! JANNAH_OPTIMIZATION_RESOURCES::plugins_resources_disabled( 'shortcodes' ) ){
			$this->do_style( 'tie-css-shortcodes' );
		}

		// Taqyeem
		if( TIELABS_TAQYEEM_IS_ACTIVE && is_singular() ){

			$has_review = tie_get_postdata( 'taq_review_position' );

			if( ! empty( $has_review ) ){
				$this->do_style('taqyeem-styles');
				$this->do_style('taqyeem-buttons-style');
			}
		}
	}


	/**
	 * after_body_without_header
	 * Used in the pages without headers
	 */
	function after_body_without_header(){

		if( tie_get_postdata( 'tie_hide_header' )){
			$this->after_header();
		}
	}


	/**
	 * Before Sidebar Styles
	 */
	function sidebar_before(){
		if( ! is_admin() ){
			$this->do_style( 'tie-css-widgets' );
		}
	}


	/**
	 * After Footer
	 */
	function after_footer(){

		$this->do_style( 'tie-css-helpers', true );

		// LightBox
		if( tie_get_option( 'jso_homepage_lightbox' ) && ( is_home() || is_front_page() ) ){
			// Do nothing
		}else{
			$this->do_style( 'tie-css-ilightbox', true );
		}

		?>
			<script type='text/javascript'>
				!function(t){"use strict";t.loadCSS||(t.loadCSS=function(){});var e=loadCSS.relpreload={};if(e.support=function(){var e;try{e=t.document.createElement("link").relList.supports("preload")}catch(t){e=!1}return function(){return e}}(),e.bindMediaToggle=function(t){var e=t.media||"all";function a(){t.addEventListener?t.removeEventListener("load",a):t.attachEvent&&t.detachEvent("onload",a),t.setAttribute("onload",null),t.media=e}t.addEventListener?t.addEventListener("load",a):t.attachEvent&&t.attachEvent("onload",a),setTimeout(function(){t.rel="stylesheet",t.media="only x"}),setTimeout(a,3e3)},e.poly=function(){if(!e.support())for(var a=t.document.getElementsByTagName("link"),n=0;n<a.length;n++){var o=a[n];"preload"!==o.rel||"style"!==o.getAttribute("as")||o.getAttribute("data-loadcss")||(o.setAttribute("data-loadcss",!0),e.bindMediaToggle(o))}},!e.support()){e.poly();var a=t.setInterval(e.poly,500);t.addEventListener?t.addEventListener("load",function(){e.poly(),t.clearInterval(a)}):t.attachEvent&&t.attachEvent("onload",function(){e.poly(),t.clearInterval(a)})}"undefined"!=typeof exports?exports.loadCSS=loadCSS:t.loadCSS=loadCSS}("undefined"!=typeof global?global:this);

				var c = document.body.className;
				c = c.replace(/tie-no-js/, 'tie-js');
				document.body.className = c;
			</script>
		<?php
	}


	/**
	 * Custom Js Class
	 */
	function body_class( $classes ){
		$classes[] = 'tie-no-js';
		return $classes;
	}


	/*
	 * dequeue_theme_resources
	 * Dequeue Theme CSS files
	 */
	function dequeue_theme_styles(){

		// Check if the option enabled and Disable on RTL
		if( is_rtl() || ! tie_get_option( 'jso_css_delivery' ) ){
			return;
		}

		wp_dequeue_style( 'tie-css-styles' );
		wp_dequeue_style( 'tie-css-widgets' );
		wp_dequeue_style( 'tie-css-helpers' );
		wp_dequeue_style( 'tie-css-ilightbox' );
		wp_dequeue_style( 'tie-css-shortcodes' );
		wp_dequeue_style( 'tie-css-single' );
		wp_dequeue_style( 'taqyeem-styles' );
		wp_dequeue_style( 'taqyeem-buttons-style' );
	}


	/*
	 * Add HTML selector to the inline CSS to give it a highr periorty
	 * as the External CSS files loaded after it and they overide it
	 */
	function inline_css_code( $css = '' ){

		if( empty( $css ) ){
			return;
		}

		$prefix  = 'html';
		$groups  = explode( '}', $css );
		$exclude = array( );

		$is_media_query = false;

		foreach( $groups as &$single_group ){

			$single_group = trim( $single_group );

			if( empty( $single_group ) ){
				continue;
			}
			else{

				$group_details = explode( '{', $single_group );

				if( substr_count( $single_group, '{' ) == 2 ){
					$media_query       = $group_details[0] . '{';
					$group_details[0]  = $group_details[1];
					$is_media_query    = true;
				}

				$selectors = explode( ',', $group_details[0] );

				foreach( $selectors as &$single_selector ){
					if( trim( $single_selector ) === '@font-face' ){
						continue;
					}
					else{
						$single_selector = $prefix . ' ' . trim( $single_selector );
					}
				}

				if( ! empty( $media_query ) ){
					$single_group = $media_query . implode( ",", $selectors ) .'{'. $group_details[2];
				}
				elseif( empty( $single_group[0] ) && $is_media_query ){
					$is_media_query = false;
					$single_group = implode( ",", $selectors ) .'{'. $group_details[2] ."}";
				}
				else{
					if( isset( $group_details[1] ) ){
						$single_group = implode( ",", $selectors ) .'{'. $group_details[1];
					}
				}

				unset( $group_details, $media_query, $selectors );
			}

			unset( $single_group );
		}

		$css = implode( "}", $groups );

		return $css;
	}

} // class

//
add_filter( 'init', 'jannah_optimization_styles_init' );
function jannah_optimization_styles_init(){

	// This method available in v4.0.0 and above
	if( method_exists( 'TIELABS_HELPER','has_builder' ) ){
		new JANNAH_OPTIMIZATION_STYLES();
	}
}
