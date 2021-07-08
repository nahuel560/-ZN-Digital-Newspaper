<?php

if( ! class_exists( 'TIE_INSTAGRAM_WIDGET' )){

	/**
	 * Widget API: TIE_INSTAGRAM_WIDGET class
	 */
	 class TIE_INSTAGRAM_WIDGET extends WP_Widget {


		public function __construct(){
			parent::__construct( 'tie-instagram-theme', apply_filters( 'TieLabs/theme_name', 'TieLabs' ) .' - '.esc_html__( 'Instagram', TIELABS_TEXTDOMAIN ) );
		}

		/**
		 * Outputs the content for the widget instance.
		 */
		public function widget( $args, $instance ){

			/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
			$instance['title'] = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

			echo ( $args['before_widget'] );

			if ( ! empty( $instance['title'] ) ){
				echo ( $args['before_title'] . $instance['title'] . $args['after_title'] );
			}

			// Instagram feed
			$media_link   = ! empty( $instance['media_link'] )   ? $instance['media_link']   : 'file';
			$username     = ! empty( $instance['username'] )     ? $instance['username']     : '';
			$userid       = ! empty( $instance['userid'] )       ? $instance['userid']       : '';
			$media_number = ! empty( $instance['media_number'] ) ? $instance['media_number'] : 9;
			$button_text  = ! empty( $instance['button_text'] )  ? $instance['button_text']  : '';
			$button_url   = ! empty( $instance['button_url'] )   ? $instance['button_url']   : '';
			$user_data    = ! empty( $instance['user_data'] )    ? true : false;

			$atts = array(
				'username'  => $username,
				'userid'    => $userid,
				'number'    => $media_number,
				'link'      => $media_link,
				'user_data' => $user_data,
			);

			new TIELABS_INSTAGRAM( $atts );

			if( ! empty( $button_text )){?>
				<a target="_blank" rel="nofollow noopener" href="<?php echo esc_url( $button_url ) ?>" class="button dark-btn fullwidth"><?php echo esc_html( $button_text ); ?></a>
				<?php
			}

			echo ( $args['after_widget'] );
		}

		/**
		 * Handles updating settings for widget instance.
		 */
		public function update( $new_instance, $old_instance ){
			$instance                 = $old_instance;
			$instance['title']        = sanitize_text_field( $new_instance['title'] );
			$instance['media_link']   = $new_instance['media_link'];
			$instance['username']     = $new_instance['username'];
			$instance['userid']       = $new_instance['userid'];
			$instance['media_number'] = $new_instance['media_number'];
			$instance['button_text']  = $new_instance['button_text'];
			$instance['button_url']   = $new_instance['button_url'];
			$instance['user_data']    = ! empty( $new_instance['user_data'] ) ? 'true' : false;
			return $instance;
		}

		/**
		 * Outputs the settings form for the widget.
		 */
		public function form( $instance ){
			$defaults = array( 'title' => esc_html__( 'Follow Us', TIELABS_TEXTDOMAIN), 'media_number' => 9, 'media_link' => 'file' );
			$instance = wp_parse_args( (array) $instance, $defaults );

			$title        = isset( $instance['title'] )        ? $instance['title']        : '';
			$media_link   = isset( $instance['media_link'] )   ? $instance['media_link']   : 'file';
			$username     = isset( $instance['username'] )     ? $instance['username']     : '';
			$userid       = isset( $instance['userid'] )       ? $instance['userid']       : '';
			$media_number = isset( $instance['media_number'] ) ? $instance['media_number'] : 9;
			$button_text  = isset( $instance['button_text'] )  ? $instance['button_text']  : '';
			$button_url   = isset( $instance['button_url'] )   ? $instance['button_url']   : '';
			$user_data    = isset( $instance['user_data'] )    ? $instance['user_data']    : false;

			?>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" value="<?php echo esc_attr( $username ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>"><?php esc_html_e( 'User ID', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'userid' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'userid' ) ); ?>" value="<?php echo esc_attr( $userid ); ?>" class="widefat" type="text" />
					<small><a href="<?php echo esc_url( 'https://tielabs.com/go/find-instagram-user-id' ); ?>" target="_blank" rel="nofollow noopener"><?php esc_html_e( 'Find your Instagram User ID.', TIELABS_TEXTDOMAIN ); ?></a></small>
				</p>

				<p>
					<input id="<?php echo esc_attr( $this->get_field_id( 'user_data' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'user_data' ) ); ?>" value="true" <?php checked( $user_data, 'true' ); ?> type="checkbox" />
					<label for="<?php echo esc_attr( $this->get_field_id( 'user_data' ) ); ?>"><?php esc_html_e( 'Show the Bio and counters?', TIELABS_TEXTDOMAIN) ?></label>
				</p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>"><?php esc_html_e( 'Link Images to', TIELABS_TEXTDOMAIN) ?> *</label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_link' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_link' ) ); ?>" class="widefat">
						<option value="file" <?php selected( $media_link, 'file' ); ?>><?php esc_html_e( 'Media File', TIELABS_TEXTDOMAIN) ?></option>
						<option value="page" <?php selected( $media_link, 'page' ); ?>><?php esc_html_e( 'Media Page on Instagram', TIELABS_TEXTDOMAIN) ?></option>
					</select>
					<small>* <?php esc_html_e( 'Videos always linked to the Media Page on Instagram.', TIELABS_TEXTDOMAIN) ?></small>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>"><?php esc_html_e( 'Number of Media Items', TIELABS_TEXTDOMAIN) ?></label>
					<select id="<?php echo esc_attr( $this->get_field_id( 'media_number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'media_number' ) ); ?>" class="widefat">
						<option value="3" <?php selected( $media_number, 3 ); ?>><?php echo '3'; ?></option>
						<option value="6" <?php selected( $media_number, 6 ); ?>><?php echo '6'; ?></option>
						<option value="9" <?php selected( $media_number, 9 ); ?>><?php echo '9'; ?></option>
						<option value="12" <?php selected( $media_number, 12 ); ?>><?php echo '12'; ?></option>
					</select>
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>"><?php esc_html_e( 'Follow Us Button Text', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_text' ) ); ?>" value="<?php echo esc_attr( $button_text ); ?>" class="widefat" type="text" />
				</p>
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>"><?php esc_html_e( 'Follow Us Button URL', TIELABS_TEXTDOMAIN) ?></label>
					<input id="<?php echo esc_attr( $this->get_field_id( 'button_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'button_url' ) ); ?>" value="<?php echo esc_attr( $button_url ); ?>" class="widefat" type="text" />
				</p>
		<?php

		}
	}



	/**
	 * Register the widget.
	 */
	add_action( 'widgets_init', 'tie_instagram_widget_register' );
	function tie_instagram_widget_register(){
		register_widget( 'TIE_INSTAGRAM_WIDGET' );
	}

}
