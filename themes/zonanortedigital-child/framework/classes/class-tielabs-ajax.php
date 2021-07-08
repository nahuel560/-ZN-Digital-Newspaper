<?php
/**
 * Ajax Class
 *
 */


defined( 'ABSPATH' ) || exit; // Exit if accessed directly


if( ! class_exists( 'TIELABS_AJAX' )){

	class TIELABS_AJAX {

		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			// Block Load More
			add_action( 'wp_ajax_nopriv_tie_blocks_load_more',    array( $this, 'block_load_more' ) );
			add_action( 'wp_ajax_tie_blocks_load_more',           array( $this, 'block_load_more' ) );

			// Archive Load More
			add_action( 'wp_ajax_nopriv_tie_archives_load_more',  array( $this, 'archive_load_more' ) );
			add_action( 'wp_ajax_tie_archives_load_more',         array( $this, 'archive_load_more' ) );

			// Mega Menu
			add_action( 'wp_ajax_nopriv_tie_mega_menu_load_ajax', array( $this, 'mega_menu' ) );
			add_action( 'wp_ajax_tie_mega_menu_load_ajax',        array( $this, 'mega_menu' ) );

			// Live Search
			add_action( 'wp_ajax_nopriv_tie_ajax_search',         array( $this, 'live_search' ) );
			add_action( 'wp_ajax_tie_ajax_search',                array( $this, 'live_search' ) );
		}


		/**
		 * Block Load More
		 */
		function block_load_more(){

			$block = $_REQUEST['block'];
			$style = $block['style'];
			$count = 0;

			if( ! empty( $_REQUEST['page'] ) ){
				$block['target_page'] = $_REQUEST['page'];
			}

			// WooCommerce number of columns
			if( $block['style'] == 'woocommerce' && TIELABS_WOOCOMMERCE_IS_ACTIVE ){

				// Full Width section
				if( $_REQUEST['width'] == 'full' ){
					add_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns'), 99, 1 );
				}
				else{
					remove_filter( 'loop_shop_columns', array( 'TIELABS_WOOCOMMERCE', 'full_width_loop_shop_columns'), 99, 1 );
				}
			}

			// Run the query
			$block_query = tie_query( $block );

			ob_start();

			if( $block_query->have_posts() ){
				while ( $block_query->have_posts() ){

					$block_query->the_post();
					$count++;

					if( $block['style'] == 'woocommerce' && TIELABS_WOOCOMMERCE_IS_ACTIVE ){
						wc_get_template_part( 'content', 'product' );
					}
					else{
						TIELABS_HELPER::get_template_part( 'templates/loops/loop', $style, array( 'block' => $block, 'count' => $count ) );
					}
				}

				$hide_next = $hide_prev = false;

				if( $block_query->query_vars['new_max_num_pages'] == 1 || ( $block_query->query_vars['new_max_num_pages'] == $block_query->query_vars['paged'])){
					$hide_next = true;
				}

				if( empty( $block_query->query_vars['paged'] ) || $block_query->query_vars['paged'] == 1 ){
					$hide_prev = true;
				}

				wp_send_json( wp_json_encode(
					array(
						'hide_next' => $hide_next,
						'hide_prev' => $hide_prev,
						'code'      => ob_get_clean(),
						'button'    => esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ),
					)));
			}
			else{
				wp_send_json( wp_json_encode(
					array(
						'hide_next' => true,
						'hide_prev' => $hide_prev,
						'code'      => esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ),
						'button'    => esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ),
					)));
			}

			die;
		}


		/**
		 * Archive Load More
		 */
		function archive_load_more(){

			// is_archive() doesn't available in the Ajax requests
			define( 'TIE_IS_ARCHIVE', true );

			// General
			$max_pages   = $_REQUEST['max'];
			$layout      = $_REQUEST['layout'];
			$latest_post = ! empty( $_REQUEST['latest_post'] ) ? $_REQUEST['latest_post'] : 0;

			// Settings
			$settings = stripslashes( $_REQUEST['settings'] );
			$settings = json_decode( str_replace( '\'', '"', $settings ), true );
			$settings['is_archive'] = true;

			// Hide the category label on category pages
			if( ! empty( $settings['is_category'] ) ){
				add_filter( 'TieLabs/Archive_Thumbnail/category_meta', '__return_false' );
			}

			// Query
			$query = stripslashes( $_REQUEST['query'] );
			$query = json_decode ( str_replace( '\'', '"', $query ), true );
			$query['paged'] = (int) $_REQUEST['page'];
			$query['post_status'] = 'publish';

			$block_query = new WP_Query( $query );

			ob_start();

			if( $block_query->have_posts() ){
				while ( $block_query->have_posts() ){

					$latest_post++;

					$block_query->the_post();

					TIELABS_HELPER::get_template_part( 'templates/loops/loop', $layout, array( 'block' => $settings ) );

					do_action( 'TieLabs/after_post_in_archives', $layout, $latest_post );
				}

				// Disable the Load more button
				$hide_next = false;

				if( $block_query->max_num_pages == 1 || ( $block_query->max_num_pages == $block_query->query_vars['paged'] )){
					$hide_next = true;
				}

				wp_send_json( wp_json_encode(
					array(
						'hide_next'   => $hide_next,
						'code' 		    => ob_get_clean(),
						'button'      => esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ),
						'latest_post' => $latest_post,
					)));
			}
			else{

				wp_send_json( wp_json_encode(
					array(
						'hide_next' => true,
						'code'      => '<li>'. esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ) .'</li>',
						'button'    => esc_html__( 'No More Posts', TIELABS_TEXTDOMAIN ),
					)));
			}

			die;
		}


		/**
		 * Mega Menu
		 */
		function mega_menu(){

			$block = array(
				'id'     => $_REQUEST['id'],
				'number' => $_REQUEST['number'],
			);

			$block = apply_filters( 'TieLabs/mega_menu/posts_query/args', $block );

			$count      = 0;
			$is_featurd = false;
			$thumbnail  = TIELABS_THEME_SLUG.'-image-large';
			$media_icon = ! empty( $_REQUEST['post_icon'] ) ? true : false;

			if( ! empty( $_REQUEST['featured'] ) && 'false' !== $_REQUEST['featured'] ){
				$is_featurd = true;
				$thumbnail  = TIELABS_THEME_SLUG.'-image-small';
			}

			// Cache key
			$cache_key = apply_filters( 'TieLabs/cache_key', '' ) . '_mega_'.implode( '_', $block ) .'_'. (int) $is_featurd .'_'. $thumbnail;

			// Get the Cached data
			if ( ! tie_get_option( 'jso_cache' ) || false === ( $cached_data = get_transient( $cache_key ) ) ){

				ob_start();

				$block_query = tie_query( $block );

				if( $block_query->have_posts() ){
					while ( $block_query->have_posts() ){

						$block_query->the_post();
						$count++;

						if( $is_featurd && $count == 1 ){
							TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'mega-menu-featured', array( 'media_icon' => $media_icon ) );
							echo " <div class=\"mega-check-also\">\n<ul>";
						}
						else{
							TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'mega-menu-default', array( 'thumbnail' => $thumbnail, 'media_icon' => $media_icon ) );
						}
					}

					if( $is_featurd ){
						echo "</ul>\n</div><!-- mega-check-also -->\n";
					}
				}
				else{
					echo '<div class="ajax-no-more-posts">'. esc_html__( 'Nothing Found', TIELABS_TEXTDOMAIN ) .'</div>';
				}

				$cached_data = ob_get_clean();
				set_transient( $cache_key, $cached_data, 24 * HOUR_IN_SECONDS );
			}

			echo $cached_data;

			die;
		}


		/**
		 * Live Search
		 */
		function live_search(){

			$search_qry	= $_REQUEST['query'];

			$supported_post_types = array( 'post' );
			$exclude_post_types   = tie_get_option( 'search_exclude_post_types' );

			if( empty( $exclude_post_types ) || ( is_array( $exclude_post_types ) && ! in_array( 'page', $exclude_post_types ) ) ){
				$supported_post_types[] = 'page';
			}

			$supported_post_types = apply_filters( 'TieLabs/live_search/post_types', $supported_post_types );

			$search_json = array(
				'query'       => 'Unit',
				'suggestions' => array(),
			);

			$args = array(
				's'                   => $search_qry,
				'post_type'           => $supported_post_types,
				'no_found_rows'       => true,
				'posts_per_page'      => 4,
				'post_status'			    => 'publish',
				'ignore_sticky_posts' => true,
			);

			// Exclude specific categories from search
			if ( tie_get_option( 'search_cats' ) ){
				$args['cat'] = tie_get_option( 'search_cats' );
			}

			$block_query = new WP_Query( $args );

			if( $block_query->have_posts() ){

				while ( $block_query->have_posts() ){

					ob_start();
					$block_query->the_post();

					TIELABS_HELPER::get_template_part( 'templates/loops/loop', 'live-search' );
					$search_json["suggestions"][] = array(
						'layout'   => ob_get_clean(),
						'value'    => get_the_title(),
						'url'      => get_permalink(),
					);
				}

				$search_json['suggestions'][] = array(
					'layout'   => '<div class="widget-post-list"><a class="button fullwidth" href="'. esc_url(home_url('?s=' . urlencode( $search_qry ) )) .'">'. esc_html__( 'View all results', TIELABS_TEXTDOMAIN ) .'</a></div>',
					'value'    => $search_qry,
					'url'      => esc_url(home_url('?s=' . urlencode( $search_qry ))),
				);

			}
			else{
				//echo '<div>'.esc_html__( 'Nothing Found', TIELABS_TEXTDOMAIN ).'</div>';
			}

			echo json_encode( $search_json );
			die;
		}

	}

	// Single instance.
	$TIELABS_AJAX = new TIELABS_AJAX();
}
