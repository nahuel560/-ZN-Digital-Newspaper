<?php
/**
 * Menus Components
 *
 * This template can be overridden by copying it to your-child-theme/templates/header/components.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   4.0.2
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly

ob_start();


// Search
if( tie_get_option( $components_id.'-components_search' ) ):
	$live_search_class = tie_get_option( "$components_id-components_live_search" ) ? 'class="is-ajax-search" ' : '';

	if( tie_get_option( "$components_id-components_search_layout" ) == 'compact' ):?>
		<li class="search-compact-icon menu-item custom-menu-link">
			<a href="#" data-type="modal-trigger" class="tie-search-trigger">
				<span class="fa fa-search" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
			<span class="cd-modal-bg"></span>
		</li>
		<?php

	else: ?>
		<li class="search-bar menu-item custom-menu-link" aria-label="<?php esc_html_e( 'Search', TIELABS_TEXTDOMAIN ); ?>">
			<form method="get" id="search" action="<?php echo esc_url(home_url( '/' )); ?>/">
				<input id="search-input" <?php echo ( $live_search_class ); ?>type="text" name="s" title="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" placeholder="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" />
				<button id="search-submit" type="submit">
					<span class="fa fa-search" aria-hidden="true"></span>
					<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
				</button>
			</form>
		</li>
		<?php
	endif;
endif;


// Slide sidebar
if( tie_get_option( $components_id.'-components_slide_area' ) ):?>
	<li class="side-aside-nav-icon menu-item custom-menu-link">
		<a href="#">
			<span class="fa fa-navicon" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Sidebar', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	</li>
	<?php
endif;


// Random
if( tie_get_option( $components_id.'-components_random' ) ):?>
	<li class="random-post-icon menu-item custom-menu-link">
		<a href="<?php echo esc_url( add_query_arg( 'random-post', 1 ) ); ?>" class="random-post" title="<?php esc_html_e( 'Random Article', TIELABS_TEXTDOMAIN ) ?>" rel="nofollow">
			<span class="fa fa-random" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Random Article', TIELABS_TEXTDOMAIN ) ?></span>
		</a>
	</li>
	<?php
endif;


// Cart
if( tie_get_option( $components_id.'-components_cart' ) && TIELABS_WOOCOMMERCE_IS_ACTIVE ):?>
	<li class="shopping-cart-icon menu-item custom-menu-link">
		<a href="<?php echo wc_get_cart_url() ?>" title="<?php esc_html_e( 'View your shopping cart', TIELABS_TEXTDOMAIN ); ?>">
			<span class="shooping-cart-counter menu-counter-bubble-outer">
				<?php
					$cart_count_items = WC()->cart->get_cart_contents_count();
					if( ! empty( $cart_count_items ) ){
						$bubble_class = ( $cart_count_items > 9 ) ? 'is-two-digits' : 'is-one-digit'; ?>
						<span class="menu-counter-bubble <?php echo esc_attr( $bubble_class ) ?>"><?php echo ( $cart_count_items ) ?></span>
				<?php } ?>
			</span><!-- .menu-counter-bubble-outer -->
			<span class="fa fa-shopping-bag" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'View your shopping cart', TIELABS_TEXTDOMAIN ) ?></span>
		</a>

		<?php if( $components_id != 'mobile' ) { ?>
			<div class="components-sub-menu comp-sub-menu">
				<div class="shopping-cart-details">
					<?php do_action( 'TieLabs/wc_cart_menu_content' ) ?>
				</div><!-- shopping-cart-details -->
			</div><!-- .components-sub-menu /-->
		<?php } ?>

	</li><!-- .shopping-cart-btn /-->
	<?php
endif;


// BuddyPress Notifications
if( tie_get_option( $components_id.'-components_bp_notifications' ) && is_user_logged_in() && TIELABS_BUDDYPRESS_IS_ACTIVE ):

	$notification = apply_filters( 'TieLabs/BuddyPress/notifications', '' ); ?>

	<li class="notifications-icon menu-item custom-menu-link">
		<a href="<?php echo esc_url( $notification['link'] ) ?>" title="<?php esc_html_e( 'Notifications', TIELABS_TEXTDOMAIN ); ?>">
			<span class="notifications-total-outer">
				<?php if( ! empty( $notification['count'] )){
					$bubble_class = ( $notification['count'] > 9 ) ? 'is-two-digits' : 'is-one-digit'; ?>
					<span class="menu-counter-bubble <?php echo esc_attr( $bubble_class ) ?>"><?php echo ( $notification['count'] ) ?></span>
				<?php } ?>
			</span><!-- .menu-counter-bubble-outer -->
			<span class="fa fa-bell" aria-hidden="true"></span>
			<span class="screen-reader-text"><?php esc_html_e( 'Notifications', TIELABS_TEXTDOMAIN ) ?></span>
		</a>

		<?php if( $components_id != 'mobile' ) { ?>
			<div class="bp-notifications-menu components-sub-menu comp-sub-menu">
				<?php echo ( $notification['data'] ) ?>
			</div><!-- .components-sub-menu /-->
		<?php } ?>
	</li><!-- .notifications-btn /-->
	<?php
endif;


// Login
if( tie_get_option( $components_id.'-components_login' ) ): ?>

	<?php if( is_user_logged_in() ){ ?>

		<li class="profile-icon menu-item custom-menu-link">
			<a href="#" class="profile-btn">
				<?php
					$current_user = wp_get_current_user();
					echo get_avatar( $current_user->ID, apply_filters( 'TieLabs/Login/avatar_size', 30 ) );
				?>
				<span class="screen-reader-text"><?php esc_html_e( 'Your Profile', TIELABS_TEXTDOMAIN ) ?></span>
			</a>

			<div class="components-sub-menu comp-sub-menu components-user-profile">
				<?php tie_login_form(); ?>
			</div><!-- .components-sub-menu /-->
		</li>

		<?php } else { ?>

		<li class="popup-login-icon menu-item custom-menu-link">
			<a href="#" class="lgoin-btn tie-popup-trigger">
				<span class="fa fa-lock" aria-hidden="true"></span>
				<span class="screen-reader-text"><?php esc_html_e( 'Log In', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
		</li>

		<?php } ?>
	<?php
endif;


// Social
if( tie_get_option( $components_id.'-components_social' ) ):
	if( tie_get_option( "$components_id-components_social_layout" ) == 'list' ):?>
		<li class="list-social-icons menu-item custom-menu-link">
			<a href="#" class="follow-btn">
				<span class="fa fa-plus" aria-hidden="true"></span>
				<span class="follow-text"><?php esc_html_e( 'Follow', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
			<?php
				tie_get_social(
					array(
						'show_name' => true,
						'before'    => '<ul class="dropdown-social-icons comp-sub-menu">',
						'after'     => '</ul><!-- #dropdown-social-icons /-->'
					));
			?>
		</li><!-- #list-social-icons /-->
		<?php
	elseif( tie_get_option( $components_id.'-components_social_layout' ) == 'grid' ):?>
		<li class="grid-social-icons menu-item custom-menu-link">
			<a href="#" class="follow-btn">
				<span class="fa fa-plus" aria-hidden="true"></span>
				<span class="follow-text"><?php esc_html_e( 'Follow', TIELABS_TEXTDOMAIN ) ?></span>
			</a>
			<?php
				tie_get_social(
					array(
						'before' => '<ul class="dropdown-social-icons comp-sub-menu">',
						'after'  => '</ul><!-- #dropdown-social-icons /-->'
					));
			?>
		</li><!-- #grid-social-icons /-->
		<?php

	else:
		$reverse = false;

		if( $components_id == 'main-nav' || ( $components_id == 'top-nav' && ! empty( $position ) && $position == 'area-2' ) ){
			$reverse = true;
		}

		tie_get_social(
			array(
				'reverse' => $reverse,
				'before'  => ' ',
				'after'   => ' '
			));

	endif;
endif;


// Weather
if( tie_get_option( $components_id.'-components_weather' ) ):

	$location  = tie_get_option( $components_id.'-components_wz_location' );

	if( ! empty( $location ) ){

		$args = array(
			'location'      => $location,
			'units'         => tie_get_option( $components_id.'-components_wz_unit' ),
			'custom_name'   => tie_get_option( $components_id.'-components_wz_city_name' ),
			'animated'      => tie_get_option( $components_id.'-components_wz_animated' ),
			'compact'       => true,
			'forecast_days' => 'hide',
		);

		echo '<li class="weather-menu-item menu-item custom-menu-link">';
		new TIELABS_WEATHER( $args );
		echo '</li>';
	}
endif;


// Show the elements
$output = ob_get_clean();

if( ! empty( $output )){
	echo empty( $before ) ? '<ul class="components">' : $before;
	echo ( $output );
	echo empty( $after ) ? '</ul><!-- Components -->' : $before;
}
