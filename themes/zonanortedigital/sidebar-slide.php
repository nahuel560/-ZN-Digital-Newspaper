<?php
/**
 * The template for the sidebar containing the slide widget area
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

?>

<?php
	if(
		apply_filters( 'TieLabs/is_header_active', true ) &&
		(
			(
				( tie_get_option( 'top_nav'  ) && tie_get_option( 'top-nav-components_slide_area'  )) ||
				( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_slide_area' ))
			) || tie_get_option( 'mobile_menu_active' )
		)
	):

		$mobile_menu_layout = tie_get_option( 'mobile_menu_layout' ) == 'fullwidth' ? 'is-fullwidth' : '';
	?>

	<aside class="side-aside normal-side tie-aside-effect dark-skin dark-widgetized-area <?php echo $mobile_menu_layout ?>" aria-label="<?php esc_html_e( 'Secondary Sidebar', TIELABS_TEXTDOMAIN ); ?>">
		<div data-height="100%" class="side-aside-wrapper has-custom-scroll">

			<a href="#" class="close-side-aside remove big-btn light-btn">
				<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
			</a><!-- .close-side-aside /-->

			<div id="mobile-container">

				<?php

					// Get components template
					TIELABS_HELPER::get_template_part( 'templates/header/components', '', array( 'components_id' => 'mobile' ) );

					// Menu Classes
					$class = ! tie_get_option( 'mobile_menu_icons' ) ? 'hide-menu-icons' : '';

					if( tie_get_option( 'mobile_the_menu' ) && tie_get_option( 'mobile_the_menu' ) != 'main-secondary' ){
						$class = ' has-custom-menu';
					}

				?>

				<div id="mobile-menu" class="<?php echo esc_attr( $class ) ?>">

					<?php
						// Mobile Menu
						if( tie_get_option( 'mobile_the_menu' ) && tie_get_option( 'mobile_the_menu' ) != 'main-secondary' ){

							wp_nav_menu(
								array(
									'menu'       => tie_get_option( 'mobile_the_menu' ),
									'walker'     => new TIELABS_MEGA_MENU(),
									'items_wrap' => '<ul id="mobile-custom-menu" class="%2$s" role="menubar">%3$s</ul>',
								));
						}
					?>

				</div><!-- #mobile-menu /-->

				<div class="mobile-social-search">
					<?php

					# Social Networks
					if( tie_get_option( 'mobile_menu_social' ) ){ ?>
						<div id="mobile-social-icons" class="social-icons-widget solid-social-icons">
							<?php tie_get_social(); ?>
						</div><!-- #mobile-social-icons /-->
						<?php
					}

					# Search
					if( tie_get_option( 'mobile_menu_search' ) ){ ?>
						<div id="mobile-search">
							<?php get_search_form(); ?>
						</div><!-- #mobile-search /-->
						<?php
					}

					?>
				</div><!-- #mobile-social-search /-->

			</div><!-- #mobile-container /-->


			<?php if( ! tie_is_mobile() &&
							( ( tie_get_option( 'top_nav' ) && tie_get_option( 'top-nav-components_slide_area' )) ||
								( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_slide_area' )))){ ?>

				<div id="slide-sidebar-widgets">
					<?php dynamic_sidebar( 'slide-sidebar-area' ); ?>
				</div>
			<?php } ?>

		</div><!-- .side-aside-wrapper /-->
	</aside><!-- .side-aside /-->

	<?php

endif;
