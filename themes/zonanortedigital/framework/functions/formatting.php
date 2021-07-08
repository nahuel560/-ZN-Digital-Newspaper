<?php
/**
 * Formating Functions
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



/**
 * Custom Classes for header
 */
if( ! function_exists( 'tie_header_class' )){

	function tie_header_class( $custom = '' ){

		// Custom Classes defined in the header.php file
		$classes = explode( ' ', $custom );

		// intial Class
		$classes[] = 'theme-header';

		// Header Layout
		$header_layout = tie_get_option( 'header_layout', 3 );
		$classes[] = 'header-layout-'.$header_layout;

		// Main Nav Skin
		$classes[] = tie_get_option( 'main_nav_dark' ) ? 'main-nav-dark' : 'main-nav-light';

		// Main Nav position
		$classes[] = tie_get_option( 'main_nav_position' ) ? 'main-nav-above' : 'main-nav-below';

		// Boxed Layout
		if( tie_get_option( 'main_nav_layout' ) && $header_layout != 1 ){
			$classes[] = 'main-nav-boxed';
		}

		// Top Nav classes
		if( tie_get_option( 'top_nav' ) ){

			$classes[] = 'top-nav-active';

			// Top Nav Dark Skin
			$classes[] = tie_get_option( 'top_nav_dark' ) ? 'top-nav-dark' : 'top-nav-light';

			// Boxed Layout
			$classes[] = tie_get_option( 'top_nav_layout' ) ? 'top-nav-boxed' : '';

			// Check if the top nav is below the header
			$classes[] = tie_get_option( 'top_nav_position' ) ? 'top-nav-below' : 'top-nav-above';
		}

		// Top Nav Below the Main Nav
		if( ! tie_get_option( 'main_nav_position' ) && tie_get_option( 'top_nav' ) && tie_get_option( 'top_nav_position' ) ){
			$classes[] = 'top-nav-below-main-nav';
		}

		// Header Shadow
		$classes[] = tie_get_option( 'header_disable_shadows' ) ? '' : 'has-shadow';

		// Custom Sticky Logo
		if( tie_get_option( 'sticky_logo_type' ) && tie_get_option( 'custom_logo_sticky' ) ){
			$classes[] = 'has-custom-sticky-logo';
		}

		// Centered Mobile Logo
		if( tie_get_option( 'mobile_header' ) ){
			$classes[] = 'mobile-header-'. tie_get_option( 'mobile_header' );
		}

		// Print the Classes
		echo 'class="'. join( ' ', array_filter( $classes ) ) .'"';
	}
}


/**
 * Get the Custom Classes for blocks
 */
if( ! function_exists( 'tie_get_box_class' )){

	function tie_get_box_class( $custom = '' ){

		// Custom Classes
		$classes = explode( ' ', $custom );

		// Default Class
		$classes[]   = 'the-global-title';
		$block_style = tie_get_option( 'blocks_style' );

		if( $block_style == 4 || $block_style == 5 || $block_style == 6 ){
			if( ! in_array( 'mag-box-title', $classes ) ){

				$classes[] = 'has-block-head-4';
			}
		}

		return join( ' ', array_filter( $classes ) );
	}
}


/**
 * Custom Classes for blocks
 */
if( ! function_exists( 'tie_box_class' )){

	function tie_box_class( $custom = '', $echo = true ){

		$out = 'class="'. tie_get_box_class( $custom ) .'"';

		if( $echo ){
			echo $out;
		}

		return $out;
	}
}


/**
 * Custom Classes for body
 */
if( ! function_exists( 'tie_body_class' )){

	add_filter( 'body_class', 'tie_body_class' );
	function tie_body_class( $classes ){

		// Theme layout
		$theme_layout = tie_get_object_option( 'theme_layout', 'cat_theme_layout', 'tie_theme_layout' );

		if( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() && TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' ) ){
			$theme_layout = TIELABS_BUDDYPRESS::get_page_data( 'tie_theme_layout' );
		}

		if( $theme_layout == 'boxed' ){
			$classes[] = 'boxed-layout'; // Boxed
		}
		elseif( $theme_layout == 'framed' ){
			$classes[] = 'boxed-layout framed-layout'; // Framed
		}
		elseif( $theme_layout == 'border' ){
			$classes[] = 'border-layout'; // Border
		}

		// Site Width Class
		if( strpos( tie_get_option( 'site_width' ), '%' ) !== false ){
			$classes[] = 'is-percent-width';
		}

		// Wrapper Shadow
		if( ! tie_get_option( 'wrapper_disable_shadows' ) ){
			$classes[] = 'wrapper-has-shadow';
		}

		// Blocks Style
		$block_style = tie_get_option( 'blocks_style', 1 );

		if( $block_style == 5 || $block_style == 6 ){
			$classes[] = 'block-head-4';
		}

		$classes[] = 'block-head-'. $block_style;

		// Boxes Style
		$classes[] = 'magazine'. tie_get_option( 'boxes_style', 1 );

		// Custom Body CLasses
		if( tie_get_option( 'body_class' ) ){
			$classes[] = tie_get_option( 'body_class' );
		}

		// Lazy Load
		if( tie_get_option( 'lazy_load' ) ){
			$classes[] = 'is-lazyload';
		}

		// Post Format icon overlay
		if( ! tie_get_option( 'thumb_overlay' ) ){
			$classes[] = 'is-thumb-overlay-disabled';
		}

		// is-mobile or desktop
		$classes[] = tie_is_mobile() ? 'is-mobile' : 'is-desktop';

		// Header Layout
		$header_layout = tie_get_option( 'header_layout', 3 );
		$classes[] = 'is-header-layout-'.$header_layout;


		// Header Ad
		if( tie_get_option( 'banner_top' ) && ! ( is_page() && tie_get_postdata( 'tie_hide_header' ) ) ){
			$classes[] = 'has-header-ad';
		}

		// Below Header Ad
		if( tie_get_option( 'banner_below_header' ) ){
			$classes[] = 'has-header-below-ad';
		}

		// Page Builder Classes
		if( TIELABS_HELPER::has_builder() ){

			$classes[] = 'has-builder';

			if( tie_get_postdata( 'tie_header_extend_bg' ) ){
				$classes[] = 'is-header-bg-extended';
			}
		}
		else{
			$sidebar_position = tie_get_sidebar_position();

			$GLOBALS['tie_has_sidebar'] = true;

			if( $sidebar_position == 'full-width' ){

				$GLOBALS['tie_has_sidebar'] = false;

				// Show 4 products per row for WooCommerce
				add_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns'), 99, 1 );
			}
			elseif( $sidebar_position == 'one-column-no-sidebar' ){
				$GLOBALS['tie_has_sidebar'] = false;
			}

			$classes[] = $sidebar_position;

			// Posts and pages layout
			if( TIELABS_HELPER::is_supported_post_type() ){

				// Post Layout
				$post_layout = tie_get_object_option( 'post_layout', 'cat_post_layout', 'tie_post_layout' );
				$post_layout = ! empty( $post_layout ) ? $post_layout : 1;

				$post_layout_class = 'narrow-title-narrow-media';

				if( $post_layout == 3 ){
					$post_layout_class = 'wide-title-narrow-media';
				}
				elseif( $post_layout == 6 ){
					$post_layout_class = 'wide-media-narrow-title';
				}
				elseif( $post_layout == 7 ){
					$post_layout_class = 'full-width-title-full-width-media';
				}
				elseif( $post_layout == 8 ){
					$post_layout_class = 'centered-title-big-bg';
				}

				$classes[] = 'post-layout-' . $post_layout;
				$classes[] = $post_layout_class;

				// Post Format
				if( $post_format = tie_get_postdata( 'tie_post_head' ) ){
					$classes[] = 'is-'. $post_format .'-format';
				}

			}
			elseif( is_page() || ( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ) || is_singular() ){
				$classes[] = 'post-layout-1';
			}

			// Mobile Share buttons
			if( is_singular() && tie_get_option( 'share_post_mobile' )){
				$classes[] = 'has-mobile-share';
			}
		}

		// Without Header or Footer
		if( is_page() ){

			// Without Header
			if( tie_get_postdata( 'tie_hide_header' ) ){

				$classes[] = 'without-header';
				add_filter('TieLabs/is_header_active', '__return_false');
			}

			// Without Footer
			if( tie_get_postdata( 'tie_hide_footer' )){

				$classes[] = 'without-footer';
				add_filter('TieLabs/is_footer_active', '__return_false');
			}
		}

		// Mobile show more button
		if( TIELABS_HELPER::is_supported_post_type() && tie_get_option( 'mobile_post_show_more' )){
			$classes[] = 'post-has-toggle';
		}

		// Hide some elements on mobiles
		$mobile_elements = array(
			'banner_header',
			'banner_top',
			'banner_below_header',
			'banner_bottom',
			'breaking_news',
			'sidebars',
			'footer',
			'copyright',
			'breadcrumbs',
			'read_more_buttons',
			'share_post_top',
			'share_post_bottom',
			'post_newsletter',
			'read_next',
			'related',
			'post_authorbio',
			'post_nav',
			'back_top_button'
		);

		foreach ( $mobile_elements as $element ){
			if( tie_get_option( 'mobile_hide_'.$element )){
				$classes[] = 'hide_' . $element;
			}
		}

		return $classes;
	}
}


/**
 * Custom Classes for HTML
 */
if( ! function_exists( 'tie_html_class' )){

	add_filter( 'language_attributes', 'tie_html_class' );
	function tie_html_class( $output ){

		$classes = array();

		// Enable Theme Dark Skin
		if( tie_get_option( 'dark_skin' ) ){
			$classes[] = 'dark-skin';
		}

		$classes = apply_filters( 'tie_html_class', $classes );

		if( ! empty( $classes ) ){
			$output .= ' class="'. join( ' ', array_filter( $classes ) ) .'"';
		}

		return $output;
	}
}


/**
 * Get Sidebar Position
 */
if( ! function_exists( 'tie_get_sidebar_position' )){

	function tie_get_sidebar_position(){

		// 404 page is full width by default
		if( is_404() ){
			return 'full-width';
		}

		// Get the default sidebar position
		$sidebar_position = tie_get_option( 'sidebar_pos' );

		// WooCommerce sidebar position
		if( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_product() && tie_get_option( 'woo_product_sidebar_pos' )){
			$sidebar_position = tie_get_option( 'woo_product_sidebar_pos' );
		}

		// WooCommerce sidebar position
		elseif( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() && tie_get_option( 'woo_sidebar_pos' )){
			$sidebar_position = tie_get_option( 'woo_sidebar_pos' );
		}

		// buddyPress Sidebar Settings
		elseif( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ){
			$sidebar_position = TIELABS_BUDDYPRESS::get_page_data( 'tie_sidebar_pos' );
		}

		// bbPress Sidebar Settings
		elseif( TIELABS_BBPRESS_IS_ACTIVE && is_bbpress() ){
			$sidebar_position = tie_get_option( 'bbpress_sidebar_pos' );
		}

		// Posts
		elseif( is_single() ){

			$sidebar_position = tie_get_object_option( 'sidebar_pos', 'cat_posts_sidebar_pos', 'tie_sidebar_pos' );
		}

		// Custom Sidebar Position for pages and categories
		else{
			$sidebar_position = tie_get_object_option( 'sidebar_pos', 'cat_sidebar_pos', 'tie_sidebar_pos' );
		}

		// Add the sidebar class
		if( $sidebar_position == 'left' ){
			$sidebar = 'sidebar-left has-sidebar';
		}
		elseif( $sidebar_position == 'full' ){
			$sidebar = 'full-width';
		}
		elseif( $sidebar_position == 'one-column' ){
			$sidebar = 'one-column-no-sidebar';
		}
		else{
			$sidebar = 'sidebar-right has-sidebar';
		}


		return $sidebar;
	}
}


/**
 * Post Classes
 */
if( ! function_exists( 'tie_get_post_class' ) ){

	function tie_get_post_class( $classes = false, $post_id = null, $standard = false ){

		$classes = ! empty( $classes ) ? explode( ' ', $classes ) : array();

		if( $standard ){
 			$classes = get_post_class( $classes );

 			// Remove the hentry class.
			$classes = array_diff( $classes , array( 'hentry' ) );
		}

		// is this post trending?
		if( tie_get_postdata( 'tie_trending_post', false, $post_id ) ){
			$classes[] = 'is-trending';
		}

		// Post format
		if( $post_format = tie_get_postdata( 'tie_post_head', false, $post_id ) ){
			$classes[] = 'tie-'. $post_format;
		}

		$classes = apply_filters( 'TieLabs/post_classes', $classes );

		// Return the classes
		if( ! empty( $classes )){
			return 'class="'. join( ' ', $classes ) .'"';
		}
	}
}


/**
 * Print Post Classes
 */
if( ! function_exists( 'tie_post_class' )){

	function tie_post_class( $classes = false, $post_id = null, $standard = false ){

		echo tie_get_post_class( $classes, $post_id, $standard );
	}
}


/**
 * Before Comments Form
 */
if( ! function_exists( 'tie_comment_form_before' )){

	add_action( 'comment_form_before', 'tie_comment_form_before', 5 );
	function tie_comment_form_before(){

		if( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() ){
			return;
		}

		echo '<div id="add-comment-block" class="container-wrapper">';
	}
}


/**
 * After Comments Form
 */
if( ! function_exists( 'tie_comment_form_after' )){

	add_action( 'comment_form_after', 'tie_comment_form_after', 100 );
	function tie_comment_form_after(){

		if ( TIELABS_WOOCOMMERCE_IS_ACTIVE && is_woocommerce() ){
			return;
		}

		//|| ( TIELABS_JETPACK_IS_ACTIVE && Jetpack::is_active() && in_array( 'comments', Jetpack::get_active_modules() ) ) ){

		echo '</div><!-- #add-comment-block /-->';
	}
}


/**
 * Main Content Column attributes
 */
if( ! function_exists( 'tie_content_column_attr' )){

	function tie_content_column_attr( $echo = true ){

		$columns_classes = 'tie-col-md-8 tie-col-xs-12';

		if( ! TIELABS_HELPER::has_builder() ){

			$sidebar_position = tie_get_sidebar_position();

			if( $sidebar_position == 'full-width' ){
				$columns_classes = 'tie-col-md-12';
			}
		}

		$attr = apply_filters( 'TieLabs/content_column_attr', 'class="main-content '. $columns_classes .'" role="main"' );

		if( ! $echo ){
			return $attr;
		}

		echo ( $attr );
	}
}


/**
 * Before Content markup
 */
if( ! function_exists( 'tie_before_main_content' )){

	add_action( 'TieLabs/before_main_content', 'tie_before_main_content' );
	function tie_before_main_content(){

		if( ( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( TIELABS_HELPER::has_builder() && ! post_password_required() )){
			return;
		}

		tie_html_before_main_content();
	}
}

if( ! function_exists( 'tie_html_before_main_content' )){

	function tie_html_before_main_content(){

		echo '
			<div id="content" class="site-content container">
				<div class="tie-row main-content-row">
		';
	}
}


/**
 * After Content markup
 */
if( ! function_exists( 'tie_after_main_content' )){

	add_action( 'TieLabs/after_main_content', 'tie_after_main_content' );
	function tie_after_main_content(){

		if( ( TIELABS_BUDDYPRESS_IS_ACTIVE && is_buddypress() ) || ( TIELABS_HELPER::has_builder() && ! post_password_required() )){
			return;
		}

		tie_html_after_main_content();
	}
}

if( ! function_exists( 'tie_html_after_main_content' )){

	function tie_html_after_main_content(){
		echo '
				</div><!-- .main-content-row /-->
			</div><!-- #content /-->
		';
	}
}



/**
 * Post Media icon code
 */
if( ! function_exists( 'tie_post_format_icon' )){

	function tie_post_format_icon( $force = false, $echo = true ){

		$is_enabled = false;

		if( tie_get_option( 'thumb_overlay' ) ){
			$is_enabled = true;
		}
		elseif( $force ){
			$post_format = tie_get_postdata( 'tie_post_head', 'standard' );

			if( $post_format != 'standard' && $post_format != 'map' ){
				$is_enabled = true;
			}
		}

		// ----
		if( ! $is_enabled ){
			return;
		}

		$code = '
			<div class="post-thumb-overlay-wrap">
				<div class="post-thumb-overlay">
					<span class="icon"></span>
				</div>
			</div>
		';

		if( ! $echo ){
			return $code;
		}

		echo $code;
	}
}
