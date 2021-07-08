<?php
/**
 * Theme Notifier and Auto Update
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_THEME_UPDATER' ) ){


	class TIELABS_THEME_UPDATER {

		/**
		 * Holds the remote theme version.
		 * @var string
		 */
		private $remote_theme_version = '';

		/**
		 * Holds the current theme version.
		 * @var string
		 */
		private $current_theme_version = '';

		/**
		 * Holds the theme's changelog page url.
		 * @var string
		 */
		private $theme_changeLog_url = '';


		/**
		 * __construct
		 *
		 * Class constructor where we will call our filter and action hooks.
		 */
		function __construct( ) {

			// Debug
			/*
			global  $wp_current_filter;
			echo '<br /><br /><br /><br />--------------- <br />';
			var_dump( $wp_current_filter );
			var_dump( get_site_transient( 'update_themes' ));
			*/

			$this->remote_theme_version  = tie_get_latest_theme_data( 'version' );
			$this->current_theme_version = TIELABS_DB_VERSION;
			$this->theme_changeLog_url   = apply_filters( 'TieLabs/External/changelog', '' );

			if( empty( $this->current_theme_version ) || version_compare( $this->remote_theme_version, $this->current_theme_version, '<=' ) ){
				return;
			}

			// Filters
			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );

			// Actions
			add_action( 'admin_menu', array( $this, 'update_notifier_menu' ), 11 );
			add_action( 'TieLabs/after_theme_data_update', array( $this, 'update_cached_data' ) );
		}


		/**
		 * check_for_update
		 *
		 * Check if update is available.
		 * @param object $transient
		 */
		function check_for_update( $transient ){

			if ( empty( $transient->checked ) || ! tie_get_latest_theme_data( 'download_url' ) ){
				return $transient;
			}

			$data = array(
				'new_version' => $this->remote_theme_version,
				'url'         => $this->theme_changeLog_url . '&via-iframe=true',
				'package'     => tie_get_latest_theme_data( 'download_url' ),
			);

			if( ! empty( $data ) ){
				$transient->response[ TIELABS_THEME_SLUG ] = $data;
			}

			return $transient;
		}


		/**
		 * update_cached_data
		 *
		 * Update the theme's update URL after updating the theme data via the API
		 */
		function update_cached_data(){
			set_site_transient( 'update_themes', null );
		}


		/**
		 * update_notifier_menu
		 *
		 * Set custom menu for the updates
		 */
		function update_notifier_menu(){

			add_submenu_page(
				'tie-theme-options',
				esc_html__( 'Theme Updates', TIELABS_TEXTDOMAIN ),
				esc_html__( 'New Update', TIELABS_TEXTDOMAIN ) . ' <span class="update-plugins tie-theme-update"><span class="update-count">'. $this->remote_theme_version .'</span></span>',
				'administrator',
				'theme-update-notifier',
				array( $this, 'redirect_to_update_notifier' )
			);

			add_filter( 'TieLabs/options_tab_title',           array( $this, 'add_theme_updates_tab_title' ) );
			add_action( 'tie_theme_options_tab_theme-updates', array( $this, 'add_theme_updates_tab' ) );

		}


		/**
		 * redirect_to_update_notifier
		 *
		 * Redirect to the Notifier page
		 */
		function redirect_to_update_notifier(){
			$updater_tab = add_query_arg( array( 'page' => 'tie-theme-options#tie-options-tab-theme-updates-target' ), admin_url( 'admin.php' ));
			echo "<script>document.location.href='$updater_tab';</script>";
		}


		/**
		 * add_theme_updates_tab_title
		 *
		 * Add a tab for the notifier in the theme options page
		 */
		function add_theme_updates_tab_title( $settings_tabs ){

			$settings_tabs['theme-updates'] = array(
				'icon'  => 'update',
				'title' => esc_html__( 'New Update', TIELABS_TEXTDOMAIN ) . ' <span class="tie-theme-update"><span class="update-count">'.esc_html__( 'New', TIELABS_TEXTDOMAIN ).'</span></span>',
			);

			return $settings_tabs;
		}


		/**
		 * add_theme_updates_tab
		 *
		 * Add new section for the notifier in the theme options page
		 */
		function add_theme_updates_tab(){

			if ( is_multisite() && current_user_can('update_themes') ) {
				wp_clean_themes_cache( true );
				wp_update_themes();
			}

			tie_build_theme_option(
				array(
					'title' =>	esc_html__( 'New Theme Update', TIELABS_TEXTDOMAIN ),
					'type'  => 'tab-title',
				));

			tie_build_theme_option(
				array(
					'text' => sprintf( esc_html__( 'There is a new version of the %s available.', TIELABS_TEXTDOMAIN ), apply_filters( 'TieLabs/theme_name', 'TieLabs' ) ) .' <a href="'. $this->theme_changeLog_url .'" target="_blank">'. sprintf( esc_html__( 'View version %1$s details.', TIELABS_TEXTDOMAIN ), $this->remote_theme_version ) .'</a>',
					'type' => 'message',
				));

			$support_info = tie_get_support_period_info();

			if( ! empty( $support_info['status'] ) && $support_info['status'] == 'active' ){

				// Check the theme folder name
				if( get_template() != TIELABS_THEME_SLUG ) {

					tie_build_theme_option(
						array(
							'text' => sprintf(
								esc_html__( 'The theme folder name does not match the original theme folder name %1$s%3$s%2$s, you need to chnage the theme folder name back to be able to update the theme automatically, or you can update the theme manually via FTP.', TIELABS_TEXTDOMAIN ),
								'<strong>',
								'</strong>',
								TIELABS_THEME_SLUG
							),
							'type' => 'error',
						));
						?>

						<div class="tie-theme-updates-buttons">
							<a class="tie-primary-button button button-primary" target="_blank" href="<?php echo apply_filters( 'TieLabs/External/update_manually', '' ); ?>"><?php esc_html_e( 'How to update the theme manually?', TIELABS_TEXTDOMAIN ) ?></a>
						</div>

						<?php
				}
				else{

					$update_url = add_query_arg( array(
							'action' => 'upgrade-theme',
							'theme'  => TIELABS_THEME_SLUG,
						), self_admin_url( 'update.php' ) );
					?>

					<div class="tie-theme-updates-buttons">
						<a class="tie-primary-button button button-primary button-hero" href="<?php echo esc_url( wp_nonce_url( $update_url, 'upgrade-theme_' . TIELABS_THEME_SLUG ) ) ?>"><?php esc_html_e( 'Update Automatically', TIELABS_TEXTDOMAIN ) ?></a>
					</div>

					<?php
				}
			}
			else{

				if( tie_get_latest_theme_data( 'sale_banner' ) ){
					?>
						<div class="renew-support-banner">
							<a href="<?php echo tie_get_purchase_link( array( 'utm_medium' => 'sale-renew-support' ) ) ?>" target="_blank">
								<img src="<?php echo esc_url( tie_get_latest_theme_data( 'sale_banner' ) ) ?>" alt="" />
							</a>
						</div>
					<?php
				}

				tie_build_theme_option(
					array(
						'text' => sprintf(
							esc_html__( 'Your Support Period has expired, %1$sAutomatic Theme Updates%2$s and %1$sSupport System Access%2$s have been disabled. %3$sRenew your Support Period%5$s. Once the support is renewed please go to the %4$stheme registration section%5$s and click on the %1$sRefresh expiration date%2$s button.', TIELABS_TEXTDOMAIN ),
							'<strong>',
							'</strong>',
							'<a target="_blank" href="'. tie_get_purchase_link( array( 'utm_medium' => 'renew-support' ) ) .'">',
							'<a href="'. menu_page_url( 'tie-theme-welcome', false ) .'">',
							'</a>'
						),
						'type' => 'error',
					));

				?>

				<div class="tie-theme-updates-buttons">
					<a class="tie-primary-button button button-primary" target="_blank" href="<?php echo apply_filters( 'TieLabs/External/update_manually', '' ); ?>"><?php esc_html_e( 'How to update the theme manually?', TIELABS_TEXTDOMAIN ) ?></a>
				</div>

				<?php
			}

			?>

			<p><?php esc_html_e( 'Please Note: Any customizations you have made to theme files will be lost. Please consider using child themes for modifications.', TIELABS_TEXTDOMAIN ); ?></p>

			<?php
		}
	}


	add_action( 'init', 'tie_update_the_theme' );
	function tie_update_the_theme() {
		new TIELABS_THEME_UPDATER();
	}

}
