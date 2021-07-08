<?php
/**
 * The template for displaying the footer
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

$loop = new WP_Query( array(
    'post_type' => 'municipios',
    'posts_per_page' => -1
  )
);


//var_dump($loop);

?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.theme.default.min.css">

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/owl.carousel.min.js"></script>

<script>

jQuery(document).ready(function() {
	
	
	if( jQuery('.wp_bannerize_3	').length ){
		
		jQuery('.wp_bannerize_3').find('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:3,
					nav:false
				},
				1000:{
					items:4,
					nav:true,
					loop:false
				}
			}
		})
		
	}	

})


</script>

<?php

if ( $loop->have_posts() ) {
?>





<script>

jQuery(document).ready(function() {
	
	
	if( jQuery('.footerslider').length ){
		
		jQuery('.footerslider').find('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			responsive:{
				0:{
					items:1,
					nav:true
				},
				600:{
					items:3,
					nav:false
				},
				1000:{
					items:5,
					nav:true,
					loop:false
				}
			}
		})
		
	}	

})


</script>

<style>

.owl-carousel .owl-item img {
    max-width: 200px;
    margin: 0 auto;
}


</style>
		<div class="container footerslider">
			
			<div class="mag-box">
				<div class="mag-box-title the-global-title">
					<h3>Municipios que nos apoyan</h3>
				</div>
			</div>	
			
			<div class="owl-carousel owl-theme">
			
				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				
				<div class="item">
					
					<?php 
						
						$ex = get_the_excerpt();
						$tit = get_the_title();
						$thum = get_the_post_thumbnail_url();
						
						//echo $ex."<br>".$tit."<br>".$thum."<br><hr>";
						
						if( $ex != "" ){
					?>
						<a href="<?php echo $ex; ?>" title="<?php echo $tit; ?>" target="_blank">
					
					<?php }	?>
					
						<img src="<?php echo $thum; ?>" alt="<?php echo $tit; ?>" />	
					
					<?php if( $ex != "" ){	?>
						</a>
					<?php }	?>					
					

				</div>
				
				<?php endwhile;  ?>
			</div>


		</div>


<?php


};

wp_reset_query();

?>


<?php
do_action( 'TieLabs/after_main_content' );

TIELABS_HELPER::get_template_part( 'templates/footer' );

?>

		</div><!-- #tie-wrapper /-->

		<?php get_sidebar( 'slide' ); ?>

	</div><!-- #tie-container /-->
</div><!-- .background-overlay /-->
<?php wp_footer(); ?>
</body>
</html>
