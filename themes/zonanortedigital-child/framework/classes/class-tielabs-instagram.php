<?php
/**
 * Instagram Class
 *
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly



if( ! class_exists( 'TIELABS_INSTAGRAM' )){

	class TIELABS_INSTAGRAM {

		public $link_to;
		public $number_images;
		public $show_card;


		/**
		 *
		 */
		function __construct( $atts ) {

			// Check if there is no a username || userid
			if( empty( $atts['username'] ) || empty( $atts['userid'] ) ){
				return TIELABS_HELPER::notice_message( esc_html__( 'You need to set the Username and the UserID.', TIELABS_TEXTDOMAIN ) );
			}

			// Set the global variables
			$this->username      = $atts['username'];
			$this->userid        = $atts['userid'];
			$this->link_to       = ! empty( $atts['link'] )      ? $atts['link']      : 'file';
			$this->number_images = ! empty( $atts['number'] )    ? $atts['number']    : 6;
			$this->show_card     = ! empty( $atts['user_data'] ) ? $atts['user_data'] : false;

			// Get the raw data
			$user_data = $this->get_data();

			// Print if there is an error
			if( ! empty( $user_data['error'] ) ){
				return TIELABS_HELPER::notice_message( $user_data['error'] );
			}

			// Display
			$this->show_card( $user_data );
			$this->show_photos( $user_data );
		}


		/**
		 * Show the user info section
		 */
		private function show_card( $user_data ){

			if( empty( $user_data['profile'] ) || ! $this->show_card ){
				return;
			}

			$user_data = wp_parse_args( $user_data['profile'], array(
				'biography' => '',
				'followed'  => '',
				'posts'     => '',
				'follow'    => '',
				'full_name' => '',
				'avatar'    => '',
			));

			extract( $user_data );

			?>

			<div class="tie-insta-header">

				<div class="tie-insta-avatar">
					<a href="https://instagram.com/<?php echo esc_attr( $username ) ?>" target="_blank" rel="nofollow noopener">
						<img src="<?php echo $avatar ?>" alt="<?php echo esc_attr( $username ) ?>">
					</a>
				</div>

				<div class="tie-insta-info">
					<a href="https://instagram.com/<?php echo esc_attr( $username ) ?>" target="_blank" rel="nofollow noopener" class="tie-instagram-username"><?php echo esc_attr( $full_name ); ?></a>
				</div>

				<div class="tie-insta-counts clearfix">
					<ul>

				<?php
					if( $posts ){ ?>
						<li>
							<span class="counts-number"><?php echo $this->format_number( $posts ) ?></span>
							<span><?php esc_html_e( 'Posts', TIELABS_TEXTDOMAIN ) ?></span>
						</li>
						<?php
					}

					if( $followed ){ ?>
						<li>
							<span class="counts-number"><?php echo $this->format_number( $followed ) ?></span>
							<span><?php esc_html_e( 'Followers', TIELABS_TEXTDOMAIN ) ?></span>
						</li>
						<?php
					}

					if( $follow ){ ?>
						<li>
							<span class="counts-number"><?php echo $this->format_number( $follow ) ?></span>
							<span><?php esc_html_e( 'Following', TIELABS_TEXTDOMAIN ) ?></span>
						</li>
						<?php
					}
				?>
					</ul>
				</div>

				<?php
					if( $biography ){ ?>
						<div class="tie-insta-desc">
							<?php echo $this->links_mentions( $biography, true ); ?>
						</div>

						<?php
					}
				?>

			</div>
			<?php
		}


		/**
		 * Show the photos
		 */
		private function show_photos( $user_data ){

			if( empty( $user_data['photos'] ) ){
				return;
			}

			$user_data = $user_data['photos'];

			$class = ( $this->link_to == 'file' ) ? 'instagram-lightbox' : '';
			?>

			<div class="tie-insta-box <?php echo $class ?>">
				<div class="tie-insta-photos">

					<?php

						$count = 0;

						foreach ( $user_data as $image ) {

							if( empty( $image['node']['thumbnail_src'] ) ){
								return;
							}

							$img_link  = false;
							$is_video  = ! empty( $image['node']['is_video'] ) ? true : false;
							$lightbox  = array();

							// Comments
							if( ! empty( $image['node']['edge_media_to_comment']['count'] ) ){
								$comments = $image['node']['edge_media_to_comment']['count'];
							}

							// Likes
							if( ! empty( $image['node']['edge_media_preview_like']['count'] ) ){
								$likes = $image['node']['edge_media_preview_like']['count'];
							}
							elseif( ! empty( $image['node']['edge_liked_by']['count'] ) ){
								$likes = $image['node']['edge_liked_by']['count'];
							}

							// Thumbnail
							$thumbnail = $image['node']['thumbnail_src'];

							// If the 320 x 320 image exists use it
							if( ! empty( $image['node']['thumbnail_resources'][2]['src'] ) ){
								$thumbnail = $image['node']['thumbnail_resources'][2]['src'];
							}

							$photo_desc = '';

							if( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ){
								$photo_desc = wp_trim_words ( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], 40 );
								$photo_desc = $this->links_mentions( $photo_desc );
							}

							if( $this->link_to ){
								if( $this->link_to == 'file' && ! empty( $image['node']['display_url'] ) && ! $is_video ){

									$img_link = $image['node']['display_url'];

									$lightbox[] = 'aria-label="Instagram Photo"';
									$lightbox[] = 'class="lightbox-enabled"';
									$lightbox[] = 'data-options="thumbnail: \''. $thumbnail .'\', width: 800, height: 800"';
									$lightbox[] = 'data-title="'. $photo_desc .'"';

									// Caption
									if( ! empty( $comments ) || ! empty( $likes ) ){

										$caption = 'data-caption="';
										if( ! empty( $likes ) ){
											$caption .= '&lt;span class=\'fa fa-heart\'&gt;&lt;/span&gt; &nbsp;'. $this->format_number( $likes ) .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
										}
										if( ! empty( $comments ) ){
											$caption .= '&lt;span class=\'fa fa-comment\'&gt;&lt;/span&gt; &nbsp;'. $this->format_number( $comments );
										}
										$caption .= '"';

										$lightbox[] = $caption;
									}

								}
								elseif( ! empty( $image['node']['shortcode'] ) ) {
									$img_link = 'https://www.instagram.com/p/'.$image['node']['shortcode'];
								}
							}

							?>

							<div class="tie-insta-post">

								<?php
									if( ! empty( $img_link ) ){
										echo '<a href="'. esc_url( $img_link ) .'" '. join( ' ', $lightbox ) .' target="_blank" rel="nofollow noopener">';
									}

									// Lazy Load
									if( tie_get_option( 'lazy_load' ) ){
										echo '<img class="lazy-img" src="'. tie_lazyload_placeholder('square') .'" data-src="'. $thumbnail .'" width="320" height="320" alt="Instagram Photo" />';
									}
									else{
										echo '<img src="'. $thumbnail .'" width="320" height="320" alt="Instagram Photo" />';
									}

									if( $is_video ){
										echo '<span class="media-video"><span class="fa fa-video-camera"></span></span>';
									}

									if( ! empty( $img_link ) ){
										echo '</a>';
									}
								?>
							</div>
						<?php

						$count++;

						if( $count == $this->number_images ){
							break;
						}
					}

					// Enqueue the LightBox Js file
					wp_enqueue_script( 'tie-js-ilightbox' );

					?>
				</div>
			</div>

			<?php
		}


		/**
		 * Activate the links and mentiones in the image description
		 */
		private function links_mentions( $text , $html = false ){
			$text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1&lt;a href='\\2' target='_blank'&gt;\\2&lt;/a&gt;", $text);
			$text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1&lt;a href='http://\\2' target='_blank'&gt;\\2&lt;/a&gt;", $text);
			$text = preg_replace("/@(\w+)/", "&lt;a href='http://instagram.com/\\1' target='_blank'&gt;@\\1&lt;/a&gt;", $text);
			$text = preg_replace("/#(\w+)/", "&lt;a href='http://instagram.com/explore/tags/\\1' target='_blank'&gt;#\\1&lt;/a&gt; ", $text);

			if( $html ){
				$text = htmlspecialchars_decode( $text );
			}

			return $text;
		}


		/**
		 * Format the comments and links numbers
		 */
		private function format_number( $number ){

			if( ! is_numeric( $number ) ){
				return $number;
			}

			if($number >= 1000000){
				return round( ($number/1000)/1000 , 1) . "M";
			}

			if($number >= 100000){
				return round( $number/1000, 0) . "k";
			}

			return @number_format( $number );
		}


		/**
		 * Make the connection to Instagram
		 */
		private function remote_get( $api_url = false ){

			$args = array(
				'timeout'    => 10,
				'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36',
				'headers'    => array(
					'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
					'Accept-Encoding' => 'gzip, deflate, br',
					'Accept-Language' => 'en-US,en;q=0.9,ar;q=0.8,fr;q=0.7,it;q=0.6,es;q=0.5,pt;q=0.4,tr;q=0.3',
					'Dnt' => '1',
					'Sec-Fetch-Mode' => 'navigate',
					'Sec-Fetch-Site' => 'cross-site',
					'Sec-Fetch-User' => '?1',
					'Upgrade-Insecure-Requests' => '1',
				),
			);

			return wp_remote_get( $api_url, $args );
		}


		/**
		 * Make the connection to Instagram
		 */
		private function get_data(){

			// debug
			// delete_option( 'tie_instagram_ip_blocked' );
			// delete_transient( 'tie_insta_'.$this->username );

			// Check if we have a cached version
			if( get_transient( 'tie_insta_'.$this->username ) !== false ){
				return get_transient( 'tie_insta_'.$this->username );
			}

			// Check the connection method we need to use
			if( get_option( 'tie_instagram_ip_blocked' ) ){
				$request = $this->get_by_userid();
			}
			else{
				$request = $this->get_by_username();
			}

			// Return if there is an error
			if( ! empty( $request['error'] ) ){
				return $request;
			}

			// Set the cache for 12 hours
			set_transient( 'tie_insta_'.$this->username, $request, rand(5,20)*HOUR_IN_SECONDS );

			return $request;
		}


		/**
		 * Make the connection to Instagram by Username
		 */
		private function get_by_username(){

			$request = $this->remote_get( 'https://www.instagram.com/'. $this->username );

			// Error
			if( empty( $request ) || is_wp_error( $request ) ){
				return array( 'error' => esc_html__( 'Can not connect to Instagram!', TIELABS_TEXTDOMAIN ) );
			}

			// Get the data from the HTNL
			$data = wp_remote_retrieve_body( $request );

			$pattern = '/window\._sharedData = (.*);<\/script>/';
			preg_match( $pattern, $data, $matches );

			// Is the json data available?
			if ( empty( $matches[1] ) ){
				return array( 'error' => esc_html__( 'Can not fetch the images!', TIELABS_TEXTDOMAIN ) );
			}
			else{

				// Check if there is an error with the JSON decoding
				$instagram_data = json_decode( $matches[1], true );

				if( $instagram_data === null && json_last_error() !== JSON_ERROR_NONE ){
					return array( 'error' => esc_html__( 'Can not decoding the instagram json', TIELABS_TEXTDOMAIN ) );
				}

				// Check if we redirected to the Login page then use the alt method
				if( ! empty( $instagram_data['entry_data']['LoginAndSignupPage'] ) ){

					update_option( 'tie_instagram_ip_blocked', true, 'no' );

					return $this->get_by_userid();
					//return array( 'error' => esc_html__( 'Instagram redirected to login and signup page. Rate limiting occured. Try to use other ip or try crawling with authentication.', TIELABS_TEXTDOMAIN ) );
				}

				// Check if the images set is available
				if( empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user'] ) ){
					return array( 'error' => esc_html__( 'Can not find the user!', TIELABS_TEXTDOMAIN ) );
				}

				// All the good :)
				$user_data = array(
					'photos'  => false,
					'profile' => array(
						'username' => $this->username,
					),
				);

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ){
					$user_data['photos'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['biography'] ) ){
					$user_data['profile']['biography'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['biography'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'] ) ){
					$user_data['profile']['followed'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_followed_by']['count'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'] ) ){
					$user_data['profile']['posts'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['count'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_follow']['count'] ) ){
					$user_data['profile']['follow'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['edge_follow']['count'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['full_name'] ) ){
					$user_data['profile']['full_name'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['full_name'];
				}

				if( ! empty( $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'] ) ){
					$user_data['profile']['avatar'] = $instagram_data['entry_data']['ProfilePage'][0]['graphql']['user']['profile_pic_url'];
				}

				return $user_data;
			}
		}


		/**
		 * Make the connection to Instagram by UserID
		 */
		private function get_by_userid(){

			$api_url = "https://www.instagram.com/graphql/query/?query_id=17880160963012870&id=$this->userid&first=12&after=";

			$request = $this->remote_get( $api_url );

			// Error
			if( empty( $request ) || is_wp_error( $request ) ){
				return array( 'error' => esc_html__( 'Can not connect to Instagram!', TIELABS_TEXTDOMAIN ) );
			}

			$data = wp_remote_retrieve_body( $request );

			// Check if there is an error with the JSON decoding
			$instagram_data = json_decode( $data, true );

			if( $instagram_data === null && json_last_error() !== JSON_ERROR_NONE ){
				return array( 'error' => esc_html__( 'Can not decoding the instagram json', TIELABS_TEXTDOMAIN ) );
			}

			// All the good :)
			$user_data = array(
				'photos'  => false,
				'profile' => array(
					'username' => $this->username,
				),
			);

			if( ! empty( $instagram_data['data']['user']['edge_owner_to_timeline_media']['edges'] ) ){
				$user_data['photos'] = $instagram_data['data']['user']['edge_owner_to_timeline_media']['edges'];
			}

			// New Request to get the ptofile data
			$profile_request = $this->remote_get( "https://www.instagram.com/web/search/topsearch/?context=blended&query=$this->username" );

			if( ! empty( $profile_request ) && ! is_wp_error( $profile_request ) ){

				$profile = wp_remote_retrieve_body( $profile_request );
				$profile = json_decode( $profile, true );

				if( ! empty( $profile['users'] ) ){

					foreach ( $profile['users'] as $user ) {
						if( $user['user']['pk'] == $this->userid ) {

							if( ! empty( $user['user']['follower_count'] ) ){
								$user_data['profile']['followed'] = $user['user']['follower_count'];
							}

							if( ! empty( $user['user']['full_name'] ) ){
								$user_data['profile']['full_name'] = $user['user']['full_name'];
							}

							if( ! empty( $user['user']['profile_pic_url'] ) ){
								$user_data['profile']['avatar'] = $user['user']['profile_pic_url'];
							}

							break;
						}
					}
				}
			}

			return $user_data;
		}

	}
}
