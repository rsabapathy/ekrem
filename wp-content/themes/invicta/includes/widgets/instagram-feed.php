<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Widget Registering
== ------------------------------------------------------------------- ==
*/

add_action( 'widgets_init', 'invicta_register_instagram_feed_widget' );

function invicta_register_instagram_feed_widget() {
	register_widget( 'invicta_instagram_feed_widget' );
}


/*
== ------------------------------------------------------------------- ==
== @@ Widget Class
== ------------------------------------------------------------------- ==
*/

class invicta_instagram_feed_widget extends WP_Widget {
	
	function __construct() {
		
		$args = array(
			'classname'		=> 'invicta_instagram_feed',
			'description'	=> __( 'A widget to display a Instagram Feed', 'invicta_dictionary' )
		);
		
		parent::__construct( 'invicta_instagram_feed_widget', THEMENAME . ' ' . __( 'Instagram Feed', 'invicta_dictionary' ), $args );
	}
	
	function form( $instance ) {
	
		global $smof_data;
		
		$defaults = array(
			'title'					=> '',
			'count'					=> 10,
			'cache_timeout'			=> 0,
			'user_id'				=> '',
			'access_token'			=> ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		if ( ! $instance['user_id'] ) { 
			$instance['user_id'] = $smof_data['auth-instagram-user_id']; 
		}
		
		if ( ! $instance['access_token'] ) { 
			$instance['access_token'] = $smof_data['auth-instagram-access_token']; 
		}
		
		$authentication = false;
		if ( $instance['user_id'] && $instance['access_token'] ) {
			$authentication = true;
		}
		
		?>
		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<!-- count -->
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Number of Items?', 'invicta_dictionary' ); ?>: </label>
			<select id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" class="widefat">
				<?php 
				for ( $i = 1; $i <= 30; $i ++ ) {
					$selected = '';
					if ( $instance['count'] == $i ) {
						$selected = 'selected="selected" ';
					}
					echo '<option ' . $selected . 'value="' . $i . '">' . $i . '</option>';
				}
				?>
			</select>
		</p>
		<!-- cache timeout -->
		<p>
			<label for="<?php echo $this->get_field_id('cache_timeout'); ?>"><?php _e( 'Cache Timeout', 'invicta_dictionary' ); ?>: </label>
			<select id="<?php echo $this->get_field_id('cache_timeout'); ?>" name="<?php echo $this->get_field_name('cache_timeout'); ?>" class="widefat">
				<option <?php if ( 0 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="0"><?php _e( "Don't cache items", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 5 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="5"><?php _e( "5 Minutes", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 30 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="30"><?php _e( "30 Minutes", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 60 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="30"><?php _e( "1 Hour", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 360 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="360"><?php _e( "6 Hours", 'invicta_dictionary' ); ?></option>
			</select>
		</p>
		<!-- authentication warning -->
		<?php if ( ! $authentication ) : ?>
		<div style="margin:20px 0 10px 0;">
			<p><i class="icon-info-sign" style="color:#BE3131;"></i> <?php printf( __( 'To obtain your authorization keys you should register the website on <a href="%s" target="_blank">Instagram\'s Dev Center</a>.', 'invicta_dictionary' ), 'http://instagram.com/developer' ); ?></p>
		</div>
		<?php endif; ?>
		<!-- user id -->
		<p>
			<label for="<?php echo $this->get_field_id('user_id'); ?>"><?php _e( 'User ID', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('user_id'); ?>" name="<?php echo $this->get_field_name('user_id'); ?>" type="text" value="<?php echo $instance['user_id']; ?>" class="widefat" />
		</p>
		<!-- access token -->
		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e( 'Access Token', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $instance['access_token']; ?>" class="widefat" />
		</p>
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = absint( $new_instance['count'] );
		$instance['cache_timeout'] = absint( $new_instance['cache_timeout'] );
		$instance['user_id'] = strip_tags( $new_instance['user_id'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		global $post;
		
		extract( $args );
		extract( $instance );
		
		$title = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Instagram Feed', 'invicta_dictionary' );
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		echo $this->get_html( $instance );
		
		echo $after_widget;
			
	}
	
	function get_html( $args = array() ) {
		
		global $smof_data;
				
		if ( ! $args['user_id'] ) {
			$args['user_id'] = $smof_data[ 'auth-instagram-user_id' ];
		}
		
		if ( ! $args['access_token'] ) {
			$args['access_token'] = $smof_data[ 'auth-instagram-access_token' ];
		}

		$args = shortcode_atts( array(
			'count' 		=> 10,
			'cache_timeout' => 0,
			'user_id' 		=> '',
			'access_token' 	=> '',
		), $args );
		
		$feed_data = $this->get_data( $args );
		
		$html = '';
		
		if ( ! is_wp_error( $feed_data ) ) {
			
			$html .= '<div class="invicta_instagramfeed">';
			
			foreach ( $feed_data['data'] as $entry ) {
				
				$photo_title = $this->get_photo_title($entry);
				
				$html .= 	'<div class="entry">';
				$html .= 		'<a href="' . esc_url( $entry['link'] ) .'" title="' . esc_attr( $photo_title ) . '" target="_blank">';
				$html .=			'<img src="' . esc_attr( $entry['images']['thumbnail']['url'] ) . '" alt="' . esc_attr( $photo_title ) . '" />';
				$html .=		'</a>';
				$html .= 	'</div>';

			}
			
			$html .= '</div>';
			
		}
		else {
			foreach( $feed_data->errors as $error_code=>$error ) {
				$html .= '<div><i class="icon-warning-sign"></i> ' . $error[0] . '</div>';
			}
		}
				
		return $html;
		
	}
	
	function get_data( $args ) {
		/*
		** the data will be cached without any timout
		**   in order to never loose the data, even if the service is down
		** although we will store the supposed timeout
		**   so when we get the data from the cache 
		**      we can see if it is supposed to has expired
		**         if so, we will try to remotly retrieve the data again
		**           if it's available, we use it and update the cache
		**           if not we use the old data, that is permanently stored in cache
		*/
		
		$transient_key = 'invicta_' . md5( 'instagram' . $args['user_id'] . $args['count'] );
				
		$transient = get_transient( $transient_key );
		
		if ( false === $transient ) {
			
			// fb::log('data is not cached');
		
			$feed_data = $this->get_remote_data( $args );
			
			if ( ! is_wp_error( $feed_data ) ) {
				
				$serialized_data = serialize( $feed_data );
				$encoded_data = base64_encode( $serialized_data );
				
				$expiration = time() + $args['cache_timeout'] * 60;
				set_transient( $transient_key, array( $expiration, $encoded_data ) ); 
				
			}
			
			return $feed_data;
			
		}
		else {
			//fb::log('data is cached');
			
			if ( $transient[0] !== 0 && $transient[0] <= time() ) {
				//fb::log('but is supposed to have expired');
			
				$feed_data = $this->get_remote_data( $args );
				
				if ( ! is_wp_error( $feed_data ) ) {	
					//fb::log('as we could retrieve new data, we have updated');
					
					$serialized_data = serialize( $feed_data );
					$encoded_data = base64_encode( $serialized_data );
					
					$expiration = time() + $args['cache_timeout'] * 60;
					set_transient( $transient_key, array( $expiration, $encoded_data ) ); 
					
					$transient[1] = $encoded_data;
					
				}	
				
			}
			
			$decoded_data = base64_decode( $transient[1] );
			$feed_data = unserialize( $decoded_data );
			
			return $feed_data;
			
		}
		
	}
	
	private function get_remote_data( $args ) {
		
		$feed_url = 'https://api.instagram.com/v1/users/' . $args['user_id'] . '/media/recent/?access_token=' . $args['access_token'] . '&count=' . $args['count'];
		
		$response = wp_remote_get( $feed_url );
		
		$feed_data = json_decode( $response['body'], true);
		
		// operation validation
		if ( isset( $feed_data['meta']['code'] ) ) { 
			if ( $feed_data['meta']['code'] == 200 ) {
				return $feed_data;
			}
			else {
			
				if ( $feed_data['meta']['code'] == 400 ) {

					// if the access token has expired we'll contact the administrator
					try {
						$to = get_bloginfo('admin_email');
						$subject = get_bloginfo('name') . ' - Instagram access token expired';
						$message = 'Your Instagram access token has expired. Please generate a new one and update it in your website settings.';
						wp_mail( get_bloginfo('admin_email'), $subject, $message );
					} 
					catch( Exception $e ) {	
					}
					
				}
			
				return new WP_Error( $feed_data['meta']['code'], $feed_data['meta']['error_message'] );
			}
		} else {
			return new WP_Error( 1, 'Invalid Response' );
		}
		
	}
	
	private function get_photo_title( $entry ) {

		$entry_caption = $entry['caption']['text'];
	
		if ( $entry_caption ) {
			
			$original_parts = explode( " ", $entry_caption );
			$picked_parts = array();
			
			foreach ( $original_parts as $part ) {
				if ( substr( $part, 0, 1 ) !== "#" ) {
					array_push( $picked_parts, $part );
				}
			}
			
			if ( $picked_parts ) {
				$entry_caption = join( " ", $picked_parts );	
			} else {
				$entry_caption = get_bloginfo('name');	
			}
			
			
		} else {
			$entry_caption = get_bloginfo('name');
		}
		
		return $entry_caption;
		
	}

	
}
	
?>