<?php
/**
 * Video Playlist Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_VIDEOS_LIST' )){

	class TIELABS_VIDEOS_LIST {

		// Vimeo
		static $vimeo_api_base = 'https://vimeo.com/api/v2/video/';

		/**
		 * Runs on class initialization. Adds filters and actions.
		 */
		function __construct() {

			// Save Videos list block
			add_filter( 'TieLabs/save_block', array( $this, 'save_block' ) );

			// Save Videos list category
			add_filter( 'TieLabs/save_category', array( $this, 'save_category' ) );
		}


		/**
		 * Save Videos list block
		 */
		function save_block( $sections ){

			if( !empty( $sections ) && is_array( $sections ) ){
				foreach ( $sections as $s_id => $section ){
					if( ! empty( $section['blocks'] ) && is_array( $section['blocks'] )){
						foreach( $section['blocks'] as $b_id => $block ){

							if( ! empty( $block['style'] ) && $block['style'] == 'videos_list' && ! empty( $block['videos'] ) ){
								$videos_list = explode( PHP_EOL, $block['videos'] );
								$videos_data = self::get_video_info( $videos_list );

								$sections[ $s_id ]['blocks'][ $b_id ]['videos_list_data'] = $videos_data;
							}

						}
					}
				}
			}

			return $sections;
		}


		/**
		 * Save Videos list category
		 */
		function save_category( $category_data ){

			if( ! empty( $category_data['featured_posts'] ) && ! empty( $category_data['featured_posts_style'] ) && $category_data['featured_posts_style'] == 'videos_list' && ! empty( $category_data['featured_videos_list'] )){

				$videos_list = explode( PHP_EOL, $category_data['featured_videos_list'] );
				$videos_data = self::get_video_info( $videos_list );

				# Return the videos data
				$category_data['featured_videos_list_data'] = $videos_data;
			}

			return $category_data;
		}


		/*
		 * Get Videos List data
		 */
		public static function get_video_info( $videos_list ){

			$videos_ids	     = array();
			$vimeo_ids	     = array();
			$videos_list     = array_filter( $videos_list );
			$youtube_videos  = get_option( 'tie_youtube_videos' );
			$vimeo_videos    = get_option( 'tie_vimeo_videos' );
			$youtube_updated = false;
			$vimeo_updated   = false;

			// Reset the api error
			delete_option( 'tie_youtube_api_error' );

			//
			foreach ( $videos_list as $video ){

				// YouTube
				if( preg_match( "#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $video, $matches )){

					$video_id = TIELABS_HELPER::remove_spaces( $matches[0] );

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'y',
					);

					if( ! isset( $youtube_videos[ $video_id ] )){
						$video_data = self::get_youtube_info( $video_id );

						if( $video_data ){
							$youtube_videos[ $video_id ] = $video_data;
							$youtube_updated = true;
						}
					}
				}

				// Vimeo
				elseif( preg_match( "/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video, $matches )){

					$video_id = TIELABS_HELPER::remove_spaces( $matches[5] );

					$videos_ids[] = array(
						'id'   => $video_id,
						'type' => 'v',
					);

					if( ! isset( $vimeo_videos[ $video_id ] )){
						$video_data = self::get_vimeo_info( $video_id );

						if( $video_data ){
							$vimeo_videos[ $video_id ] = $video_data;
							$vimeo_updated = true;
						}
					}
				}

			}

			if( $youtube_updated ){
				update_option( 'tie_youtube_videos', $youtube_videos, false );
			}

			if( $vimeo_updated ){
				update_option( 'tie_vimeo_videos', $vimeo_videos, false );
			}

			return $videos_ids;
		}


		/*
		 * Get YouTube Video data
		 */
		private static function get_youtube_info( $vid ){

			if( ! tie_get_option( 'api_youtube' ) ){
				return false;
			}

			// Build the Api request
			$params = array(
				'part' => 'snippet,contentDetails',
				'id'   => $vid,
				'key'  => TIELABS_HELPER::remove_spaces( tie_get_option( 'api_youtube' ) ),
			);

			$api_url = 'https://www.googleapis.com/youtube/v3/videos?' . http_build_query( $params );
			$request = wp_remote_get( $api_url );

			// Check if there are errors
			if( is_wp_error( $request ) ){
				tie_debug_log( $request->get_error_message(), true );
				return null;
			}

			// Prepare the data
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			// Check Youtube API Errors
			if( ! empty( $result['error']['errors'][0]['message'] ) ){
				update_option( 'tie_youtube_api_error', $result['error']['errors'][0]['message'], 'no' );
				tie_debug_log( $result['error']['errors'][0]['message'], true );
				return null;
			}

			// Check if the video title is exists
			if( empty( $result['items'][0]['snippet']['title'] )){
				return null;
			}

			// Prepare the Video duration
			$video_info = $result['items'][0]['contentDetails'];

			if( ! empty( $video_info['duration'] )){
				$interval          = new DateInterval( $video_info['duration'] );
				$duration_sec      = $interval->h * 3600 + $interval->i * 60 + $interval->s;
				$time_format       = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';
				$video['duration'] = gmdate( $time_format, $duration_sec );
			}

			// Video data
			$video['title'] = $result['items'][0]['snippet']['title'];
			$video['id']    = $vid;

			return $video;
		}


		/*
		 * Get Vimeo Video data
		 */
		private static function get_vimeo_info( $vid ){

			// Build the Api request
			$api_url = self::$vimeo_api_base.$vid.'.json';
			$request = wp_remote_get( $api_url );

			# Check if there is no any errors
			if( is_wp_error( $request ) ){

				tie_debug_log( $request->get_error_message(), true );

				return null;
			}

			// Prepare the data
			$result = json_decode( wp_remote_retrieve_body( $request ), true );

			# Check if the video title is exists
			if( empty( $result[0]['title'] )){
				return null;
			}

			// Prepare the Video duration
			if( ! empty( $result[0]['duration'] )){

				$duration_sec      = $result[0]['duration'];
				$time_format       = ( $duration_sec >= 3600 ) ? 'H:i:s' : 'i:s';
				$video['duration'] = gmdate( $time_format, $duration_sec );
			}

			// Prepare the Video thumbnail
			if( ! empty( $result[0]['thumbnail_small'] )){
				$video_thumb    = @parse_url( $result[0]['thumbnail_small'] );
				$video_thumb    = str_replace( '/video/', '', $video_thumb['path'] );
				$video['thumb'] = $video_thumb;
			}

			// Video data
			$video['title'] = $result[0]['title'];
			$video['id']    = $vid;

			return $video;
		}

	}

	// Instantiate the class
	new TIELABS_VIDEOS_LIST();

}
