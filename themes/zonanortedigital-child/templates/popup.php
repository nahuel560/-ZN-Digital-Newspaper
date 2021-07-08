<?php
/**
 * Popup
 *
 * This template can be overridden by copying it to your-child-theme/templates/popup.php.
 *
 * HOWEVER, on occasion TieLabs will need to update template files and you
 * will need to copy the new files to your child theme to maintain compatibility.
 *
 * @author 		TieLabs
 * @version   4.0.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly


// Search popup module
if( tie_menu_has_search( 'top_nav', false, true ) || tie_menu_has_search( 'main_nav', false, true ) ){

	$live_search_class = '';

	if( tie_menu_has_search( 'top_nav', true ) || tie_menu_has_search( 'main_nav', true ) ){
		$live_search_class = 'class="is-ajax-search" ';
	}
	?>
	<div id="tie-popup-search-wrap" class="tie-popup">

		<a href="#" class="tie-btn-close remove big-btn light-btn">
			<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
		</a>
		<div class="container">
			<div class="popup-search-wrap-inner">
				<div class="tie-row">
					<div id="pop-up-live-search" class="tie-col-md-12 live-search-parent" data-skin="live-search-popup" aria-label="<?php esc_html_e( 'Search', TIELABS_TEXTDOMAIN ); ?>">
						<form method="get" id="tie-popup-search-form" action="<?php echo esc_url(home_url( '/' )); ?>/">
							<input id="tie-popup-search-input" <?php echo ( $live_search_class ); ?>type="text" name="s" title="<?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?>" autocomplete="off" placeholder="<?php esc_html_e( 'Type and hit Enter', TIELABS_TEXTDOMAIN ) ?>" />
							<button id="tie-popup-search-submit" type="submit">
								<span class="fa fa-search" aria-hidden="true"></span>
								<span class="screen-reader-text"><?php esc_html_e( 'Search for', TIELABS_TEXTDOMAIN ) ?></span>
							</button>
						</form>
					</div><!-- .tie-col-md-12 /-->
				</div><!-- .tie-row /-->
			</div><!-- .popup-search-wrap-inner /-->
		</div><!-- .container /-->
	</div><!-- .tie-popup-search-wrap /-->
	<?php
}

// Login popup module
if( ! is_user_logged_in() &&
		( tie_get_option( 'top_nav' ) && tie_get_option( 'top-nav-components_login'  ) ) ||
		( tie_get_option( 'main_nav' ) && tie_get_option( 'main-nav-components_login' ) ) ||
		( tie_get_option( 'mobile-components_login' ) )
	){
	?>
	<div id="tie-popup-login" class="tie-popup">
		<a href="#" class="tie-btn-close remove big-btn light-btn">
			<span class="screen-reader-text"><?php esc_html_e( 'Close', TIELABS_TEXTDOMAIN ); ?></span>
		</a>
		<div class="tie-popup-container">
			<div class="container-wrapper">
				<div class="widget login-widget">

					<div <?php tie_box_class( 'widget-title' ) ?>>
						<div class="the-subtitle"><?php echo esc_html__( 'Log In', TIELABS_TEXTDOMAIN ) ?> <span class="widget-title-icon fa"></span></div>
					</div>

					<div class="widget-container">
						<?php tie_login_form(); ?>
					</div><!-- .widget-container  /-->
				</div><!-- .login-widget  /-->
			</div><!-- .container-wrapper  /-->
		</div><!-- .tie-popup-container /-->
	</div><!-- .tie-popup /-->
	<?php
}
