<?php
/**
 * The template for displaying the header
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>

	<script>
	jQuery( document ).ready(function() {
			
		htele = '<div class="post-thumb-overlay-wrap">';
		htele += '<div class="post-thumb-overlay">';
		htele += '<span class="icon"></span>';
		htele += '</div>';
		
		htelenw = '<div>';
		htelenw += '<div>';
		htelenw += '<span class="icon"></span>';
		htelenw += '</div>';		
		
		if( jQuery(".tie-video").length ){
		
		//	jQuery(".tie-video").find(".thumb-overlay").remove();
			
			jQuery(".tie-slick-slider .tie-video").parent().addClass("media-overlay mediacuston");
			jQuery(".tie-slick-slider .tie-video .thumb-overlay").append(htelenw);
			
			jQuery(".tie-video .big-thumb-left-box-inner").parent().parent().addClass("media-overlay mediacuston");
			jQuery(".tie-video .big-thumb-left-box-inner .post-overlay").append(htelenw);
			
			
			
			
			
			jQuery(".mag-box .tie-video .post-thumb").parent().addClass("media-overlay mediacuston");
			jQuery(".mag-box .tie-video .post-thumb").append(htelenw);


			jQuery(".related-posts-list .tie-video .post-thumb").parent().addClass("media-overlay mediacuston");
			jQuery(".related-posts-list .tie-video .post-thumb").append(htelenw);
		
			
			jQuery(".tab-content .tie-video .post-thumb").parent().addClass("media-overlay mediacuston");
			jQuery(".tab-content .tie-video .post-thumb").parent().append(htelenw);	


			jQuery("#posts-list-widget-3 .tie-video .post-thumb").parent().addClass("media-overlay mediacuston");
			jQuery("#posts-list-widget-3 .tie-video .post-thumb").parent().append(htelenw);	
			
			jQuery("#posts-list-widget-3 .tie-video .post-thumb .post-thumb-overlay-wrap").remove();			
			
		}
		
	});
	
	</script>
	
	<style>
		.mediacuston .icon{
			position: absolute;
			float: none;
			height: 40px;
			width: 40px;
			font-size: 40px;
			top: calc( 50% - 20px );
			left: calc( 50% - 20px );
			z-index: 8;
			margin: 0;
			display: block !important;
			color:#fff;
		}


		.mediacuston .icon:before{
			content: "\f04b";
			letter-spacing: -3px;
		}	
			
	</style>
		
</head>

<body id="tie-body" <?php body_class(); ?>>

<?php wp_body_open(); ?>
<div class="background-overlay">

	<div id="tie-container" class="site tie-container">

		<?php do_action( 'TieLabs/before_wrapper' ); ?>

		<div id="tie-wrapper">

			<?php

				TIELABS_HELPER::get_template_part( 'templates/header/load' );

				do_action( 'TieLabs/before_main_content' );
