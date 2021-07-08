<?php
/**
 * Theme functions and definitions
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

/*
 * Works with PHP 5.3 or Later
 */
if ( version_compare( phpversion(), '5.3', '<' ) ) {
	require get_template_directory() . '/framework/functions/php-disable.php';
	return;
}

/*
 * Define Constants
 */
define( 'TIELABS_DB_VERSION',            '4.7.1' );
define( 'TIELABS_THEME_SLUG',            'jannah' );
define( 'TIELABS_TEXTDOMAIN',            'jannah' );
define( 'TIELABS_THEME_ID',              '19659555' );
define( 'TIELABS_TEMPLATE_PATH',         get_template_directory() );
define( 'TIELABS_TEMPLATE_URL',          get_template_directory_uri() );
define( 'TIELABS_AMP_IS_ACTIVE',         function_exists( 'amp_init' ));
define( 'TIELABS_WPUC_IS_ACTIVE',        function_exists( 'run_MABEL_WPUC' ));
define( 'TIELABS_ARQAM_IS_ACTIVE',       function_exists( 'arqam_init' ));
define( 'TIELABS_SENSEI_IS_ACTIVE',      function_exists( 'Sensei' ));
define( 'TIELABS_TAQYEEM_IS_ACTIVE',     function_exists( 'taqyeem_get_option' ));
define( 'TIELABS_EXTENSIONS_IS_ACTIVE',  function_exists( 'jannah_extensions_shortcodes_scripts' ));
define( 'TIELABS_BBPRESS_IS_ACTIVE',     class_exists( 'bbPress' ));
define( 'TIELABS_JETPACK_IS_ACTIVE',     class_exists( 'Jetpack' ));
define( 'TIELABS_BWPMINIFY_IS_ACTIVE',   class_exists( 'BWP_MINIFY' ));
define( 'TIELABS_REVSLIDER_IS_ACTIVE',   class_exists( 'RevSlider' ));
define( 'TIELABS_CRYPTOALL_IS_ACTIVE',   class_exists( 'CPCommon' ));
define( 'TIELABS_BUDDYPRESS_IS_ACTIVE',  class_exists( 'BuddyPress' ));
define( 'TIELABS_LS_Sliders_IS_ACTIVE',  class_exists( 'LS_Sliders' ));
define( 'TIELABS_FB_INSTANT_IS_ACTIVE',  class_exists( 'Instant_Articles_Wizard' ));
define( 'TIELABS_WOOCOMMERCE_IS_ACTIVE', class_exists( 'WooCommerce' ));
define( 'TIELABS_MPTIMETABLE_IS_ACTIVE', class_exists( 'Mp_Time_Table' ));

/*
 * Theme Settings Option Field
 */
add_filter( 'TieLabs/theme_options', 'jannah_theme_options_name' );
function jannah_theme_options_name( $option ){
	return 'tie_jannah_options';
}

/*
 * Translatable Theme Name
 */
add_filter( 'TieLabs/theme_name', 'jannah_theme_name' );
function jannah_theme_name( $option ){
	return esc_html__( 'Jannah', TIELABS_TEXTDOMAIN );
}

/**
 * Default Theme Color
 */
add_filter( 'TieLabs/default_theme_color', 'jannah_theme_color' );
function jannah_theme_color(){
	return '#0088ff';
}

/*
 * Import Files
 */
require TIELABS_TEMPLATE_PATH . '/framework/framework-load.php';
require TIELABS_TEMPLATE_PATH . '/inc/theme-setup.php';
require TIELABS_TEMPLATE_PATH . '/inc/style.php';
require TIELABS_TEMPLATE_PATH . '/inc/deprecated.php';
require TIELABS_TEMPLATE_PATH . '/inc/widgets.php';
require TIELABS_TEMPLATE_PATH . '/inc/updates.php';

if( is_admin() ){
	require TIELABS_TEMPLATE_PATH . '/inc/help-links.php';
}

/**
 * Load the Sliders.js file in the Post Slideshow shortcode
 */
if( ! function_exists( 'jannah_enqueue_js_slideshow_sc' ) ){

	add_action( 'tie_extensions_sc_before_post_slideshow', 'jannah_enqueue_js_slideshow_sc' );
	function jannah_enqueue_js_slideshow_sc(){
		wp_enqueue_script( 'tie-js-sliders' );
	}
}

/*
 * Set the content width in pixels, based on the theme's design and stylesheet.
 */
add_action( 'wp_body_open',      'jannah_content_width' );
add_action( 'template_redirect', 'jannah_content_width' );
function jannah_content_width() {

	$content_width = ( TIELABS_HELPER::has_sidebar() ) ? 708 : 1220;

	/**
	 * Filter content width of the theme.
	 */
	$GLOBALS['content_width'] = apply_filters( 'TieLabs/content_width', $content_width );
}


function banner300x250($params = array()) {

	// default parameters
	extract(shortcode_atts(array(
		'group' => false
	), $params));
	
	
	$text = "";
	if( $group !== false )
		$text = 'group='.$group.'&random=1&limit=1';
	
	if( $text != "" ){
		if(function_exists( 'wp_bannerize' )) {
			return wp_bannerize($text); 	
		}else{
			return ""; 
		}	
	}else{
		return ""; 
	}
   
}
add_shortcode('bannerZND', 'banner300x250');



function banner300x250New($params = array()) {

	// default parameters
	extract(shortcode_atts(array(
		'group' => false
	), $params));
	
	
	$text = "";
	if( $group !== false )
		$text = 'group='.$group.'&random=1&randcutom=1';
	
	if( $text != "" ){
		if(function_exists( 'wp_bannerize' )) {
			return wp_bannerize($text); 	
		}else{
			return ""; 
		}	
	}else{
		return ""; 
	}
   
}
add_shortcode('bannerZNDNew', 'banner300x250New');



function bannersZNDslider3($params = array()) {

	// default parameters
	extract(shortcode_atts(array(
		'group' => false
	), $params));
	
	
	$text = "";
	if( $group !== false )
		$text = 'group='.$group.'&random=1&limit=5';
	
	if( $text != "" ){
		if(function_exists( 'wp_bannerize' )) {
			return wp_bannerize($text); 	
		}else{
			return ""; 
		}	
	}else{
		return ""; 
	}
   
}
add_shortcode('bannersZNDslider', 'bannersZNDslider3');


function rkv_remove_linkmanager() {

	$enabled = get_option( 'link_manager_enabled' );

	if ( 0 !== $enabled  )
		update_option( 'link_manager_enabled', 0 );

}

add_action('admin_init', 'rkv_remove_linkmanager');


function create_posttypemun() {
 
    register_post_type( 'municipios',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Municipios' ),
                'singular_name' => __( 'Municipio' )
            ),
			'supports' => array( 'title','excerpt', 'thumbnail'),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'municipios'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttypemun' );

function suppress_if_blurb( $title, $id) {

	
	$format = get_post_meta($id,"tie_post_head",true);
	
	if( $format == "video" ){
		
		$tie_video_self = get_post_meta($id,"tie_video_self",true);
		$tie_video_url = get_post_meta($id,"tie_video_url",true);
		
		if( empty( $tie_video_self ) and  empty( $tie_video_url ) ){
			return $title;
		}else{
			
			if( !empty( $tie_video_self ) and  empty($tie_video_url) ){
				
				
				$image_id = pippin_get_image_id($tie_video_self);
				$ata = get_the_post_thumbnail_url( $image_id );

				if( !has_post_thumbnail( $id ) ){
					fifu_dev_set_image($id, $ata);
				}
				
			}else if( empty( $tie_video_self ) and  !empty($tie_video_url) ){
				
				if (strpos($tie_video_url, 'be/') !== false) {

					$c = explode( "be/",$tie_video_url );
					$ti = "https://i.ytimg.com/vi/".$c[1]."/hqdefault.jpg";
				}


				if (strpos($tie_video_url, "=") !== false) {
					$c = explode( "=",$tie_video_url );
					$ti = "https://i.ytimg.com/vi/".$c[1]."/hqdefault.jpg";
				}
				
				if( !has_post_thumbnail( $id ) ){
					fifu_dev_set_image($id, $ti);
				}
				
				
			}else{
				return $title;	
			}
			
			return $title;
		
		}
		
	
	}else{
		return $title;
	}
	
}

add_filter( 'the_title', 'suppress_if_blurb', 10, 2 );



function pippin_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}


function homeLayout( $atts ) {
	
	global $post,$first10Posts;	
	
	/* 
	extract( shortcode_atts( array(
		'subtype' => 'RSS',
		'subtypeurl' => 'http://feeds.feedburner.com/ElegantThemes',
	), $atts, 'multilink' ) );
	*/


	$args = array(
		'posts_per_page' => 10,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
    );
		
	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$first10Posts[] = $post->ID;
		endwhile;
	endif;

	wp_reset_postdata();
	
	
	$argsFinal = array(
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
		'post__not_in' => $first10Posts
    );
		
	$the_queryFinal = new WP_Query( $argsFinal );

	if ( $the_queryFinal->have_posts() ) :
	
	?>	
	
	<div class="section-item homeLayoutclass">

		<div class="container-normal">
			<div class="tie-row main-content-row">
		
		<?php
			$contpubli = 1;
			
			while ( $the_queryFinal->have_posts() ) : $the_queryFinal->the_post();
			
			$id = get_the_ID();
			$tit = get_the_title();
			$categories = wp_get_post_categories($id);
			$perma = get_the_permalink();
			$format = get_post_meta($id,"tie_post_head",true);
			
			$cate = array(); 
			//30 --> el pais, 444 --> la ciudad, la provincia --> 19, 6--> san fernando, 15-> san isidro, 11-> san martin, 10 -> tigre,13->vicente lopez
			$muni = array(30,444,19,6,15,11,10,13);
			
			//var_dump($categories);
			
			foreach ($categories as $categ){
				
				$cat = ""; $linkcat = ""; $catname = "";
				$tid = $categ;
				//echo $tid." - ";
				
				if(in_array( $tid, $muni )){
					$cat = $tid;	
					$catname = get_cat_name($tid);
					//echo $catname." - ";
				}else{
					continue;
				}
				  
			}
			
			if ( $cat != "" ){
				$linkcat = esc_url( get_category_link( $categ ) );
			}
			
			$classli = "post-item  tie-standard tie-animate-slideInUp tie-animate-delay";
			
			if( $format == "video" ){
				
				$classli = "post-item  tie-video media-overlay mediacuston";
				
				$tie_video_self = get_post_meta($id,"tie_video_self",true);
				$tie_video_url = get_post_meta($id,"tie_video_url",true);
				
				if( !empty( $tie_video_self ) and  empty($tie_video_url) ){
					
					
					$image_id = pippin_get_image_id($tie_video_self);
					$ata = get_the_post_thumbnail_url( $image_id );

					
				}else if( empty( $tie_video_self ) and  !empty($tie_video_url) ){
					
					if (strpos($tie_video_url, 'be/') !== false) {

						$c = explode( "be/",$tie_video_url );
						$ata = "https://i.ytimg.com/vi/".$c[1]."/hqdefault.jpg";
					}


					if (strpos($tie_video_url, "=") !== false) {
						$c = explode( "=",$tie_video_url );
						$ata = "https://i.ytimg.com/vi/".$c[1]."/hqdefault.jpg";
					}
						
				}
					
			}else{
				
				$ptid = get_post_thumbnail_id( $id );
				$ata = wp_get_attachment_image_src( $ptid,"full" );
				
				$ata = $ata[0];
			}
			
			//var_dump($ata);
			
			
			if($contpubli % 2 == 0){ 
			
		?>
		
			<div class="tie-col-md-4 tie-col-xs-12 bannerizeitem">
			
				<div class="container-wrapper">
				
					<div class="mag-box-container clearfix" >
						<ul class="posts-items posts-list-container posts-items-3">
							<li class="post-item  tie-standard tie-animate-slideInUp tie-animate-delay liconeinerclass" >
								<?php echo do_shortcode('[bannerZNDNew group="1"]'); ?>	
							</li>
						</ul>
					</div>	
					
				</div>	
				
				
			</div>
			
		<?php }else{ ?>
		
			<div class="tie-col-md-4 tie-col-xs-12">
			
				<div class="container-wrapper">
				
					<div class="mag-box-container clearfix" >
						<ul class="posts-items posts-list-container posts-items-3">
							<li class="<?php echo $classli; ?> liconeinerclass" >
								
								<a aria-label="<?php echo $tit; ?>" href="<?php echo $perma; ?>" class="post-thumb">
									
									<?php if( $catname != "" ){ ?>
								
									<span class="post-cat-wrap">
										<span class="post-cat tie-cat-6"><?php echo $catname; ?></span>
									</span>
									
									<?php } ?>
									
									<img  src="<?php echo $ata; ?>" class="attachment-jannah-image-large size-jannah-image-large wp-post-image" style="max-height: 246px;">
								</a>
								
								<div class="post-details">

									<div class="post-meta clearfix">
									
										<?php echo tie_get_post_meta(); ?>
										
									</div>
									
									
									<h2 class="post-title">
										<a href="<?php echo $perma; ?>">
											<?php echo $tit; ?>
										</a>
									</h2>

									<!--p class="post-excerpt">
										San Fernando duplicó la cantidad de materiales no reutilizables que fueron separados por vecinos para confeccionar tablas plásticas ecológicas,. Esto…
									</p-->
									
									<?php echo tie_get_more_button(); ?>	
									
								</div>
							</li>

						</ul>
					</div>
					
				</div>			
			
			</div>
			
		<?php

			}
		
			$contpubli += 1;
			endwhile;
		?>
		
			</div>
		</div>
		
	</div>	

<?php	
	endif;

	wp_reset_postdata();	

}

add_shortcode( 'homeLayoutShortcode', 'homeLayout' );