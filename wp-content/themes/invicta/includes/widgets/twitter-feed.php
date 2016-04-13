<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Widget Registering
== ------------------------------------------------------------------- ==
*/

add_action( 'widgets_init', 'invicta_register_twitter_feed_widget' );

function invicta_register_twitter_feed_widget() {
	register_widget( 'invicta_twitter_feed_widget' );
}


/*
== ------------------------------------------------------------------- ==
== @@ Widget Class
== ------------------------------------------------------------------- ==
*/

class invicta_twitter_feed_widget extends WP_Widget {
	
	function __construct() {
		
		$args = array(
			'classname'		=> 'invicta_twitter_feed',
			'description'	=> __( 'A widget to display a Twitter Feed', 'invicta_dictionary' )
		);
		
		parent::__construct( 'invicta_twitter_feed_widget', THEMENAME . ' ' . __( 'Twitter Feed', 'invicta_dictionary' ), $args );
	}
	
	function form( $instance ) {
	
		global $smof_data;
		
		$defaults = array(
			'title'					=> '',
			'username'				=> '',
			'count'					=> 3,
			'cache_timeout'			=> 0,
			'consumer_key'			=> '',
			'consumer_secret'		=> '',
			'access_token'			=> '',
			'access_token_secret'	=> ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		if ( ! $instance['consumer_key'] ) { 
			$instance['consumer_key'] = $smof_data['auth-twitter-consumer_key']; 
		}
		
		if ( ! $instance['consumer_secret'] ) { 
			$instance['consumer_secret'] = $smof_data['auth-twitter-consumer_secret']; 
		}
		
		if ( ! $instance['access_token'] ) { 
			$instance['access_token'] = $smof_data['auth-twitter-access_token']; 
		}
		
		if ( ! $instance['access_token_secret'] ) { 
			$instance['access_token_secret'] = $smof_data['auth-twitter-access_token_secret']; 
		}
		
		$authentication = false;
		if ( $instance['consumer_key'] && $instance['consumer_secret'] && $instance['access_token'] && $instance['access_token_secret'] ) {
			$authentication = true;
		}
		
		?>
		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<!-- username -->
		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e( 'Username', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $instance['username']; ?>" class="widefat" />
		</p>
		<!-- count -->
		<p>
			<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Number of Tweets?', 'invicta_dictionary' ); ?>: </label>
			<select id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" class="widefat">
				<?php 
				for ( $i = 1; $i <= 10; $i ++ ) {
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
				<option <?php if ( 0 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="0"><?php _e( "Don't cache tweets", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 5 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="5"><?php _e( "5 Minutes", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 30 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="30"><?php _e( "30 Minutes", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 60 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="30"><?php _e( "1 Hour", 'invicta_dictionary' ); ?></option>
				<option <?php if ( 360 == $instance['cache_timeout'] ) echo 'selected="selected"'; ?> value="360"><?php _e( "6 Hours", 'invicta_dictionary' ); ?></option>
			</select>
		</p>
		<!-- authentication warning -->
		<?php if ( ! $authentication ) : ?>
		<div style="margin:20px 0 10px 0;">
			<p><i class="icon-info-sign" style="color:#BE3131;"></i> <?php printf( __( 'To obtain your authorization keys you should register the website on <a href="%s" target="_blank">Twitter\'s Dev Center</a>.', 'invicta_dictionary' ), 'https://dev.twitter.com/apps' ); ?></p>
		</div>
		<?php endif; ?>
		<!-- consumer key -->
		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e( 'Consumer Key', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" type="text" value="<?php echo $instance['consumer_key']; ?>" class="widefat" />
		</p>
		<!-- consumer secret -->
		<p>
			<label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php _e( 'Consumer Secret', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" type="text" value="<?php echo $instance['consumer_secret']; ?>" class="widefat" />
		</p>
		<!-- access token -->
		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e( 'Access Token', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" type="text" value="<?php echo $instance['access_token']; ?>" class="widefat" />
		</p>
		<!-- access token secret -->
		<p>
			<label for="<?php echo $this->get_field_id('access_token_secret'); ?>"><?php _e( 'Access Token Secret', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" type="text" value="<?php echo $instance['access_token_secret']; ?>" class="widefat" />
		</p>
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['username'] = preg_replace( '/[^A-Za-z0-9_]/', '', $new_instance['username'] );
		$instance['count'] = absint( $new_instance['count'] );
		$instance['cache_timeout'] = absint( $new_instance['cache_timeout'] );
		$instance['consumer_key'] = strip_tags( $new_instance['consumer_key'] );
		$instance['consumer_secret'] = strip_tags( $new_instance['consumer_secret'] );
		$instance['access_token'] = strip_tags( $new_instance['access_token'] );
		$instance['access_token_secret'] = strip_tags( $new_instance['access_token_secret'] );
		
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		global $post;
		
		extract( $args );
		extract( $instance );
		
		$title = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : __( 'Twitter Feed', 'invicta_dictionary' );
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		echo $this->get_html( $instance );
		
		echo $after_widget;
			
	}
	
	function get_html( $args = array() ) {
	
		if ( $args['username'] == '' ) {
			return '';
		}
	
		global $smof_data;
				
		$twitter_args = array(
			'include_entities' 		=> true,
			'include_rts' 	   		=> true,
			'screen_name'	   		=> $args['username'],
			'count'			   		=> $args['count'],
			'published_when'   		=> 1,
			'consumer_key'	   		=> $args['consumer_key'],
			'consumer_secret'  		=> $args['consumer_secret'],
			'access_token'	   		=> $args['access_token'],
			'access_token_secret'	=> $args['access_token_secret']
		);
		
		if ( ! $twitter_args['consumer_key'] ) {
			$twitter_args['consumer_key'] = $smof_data[ 'auth-twitter-consumer_key' ];
		}
		
		if ( ! $twitter_args['consumer_secret'] ) {
			$twitter_args['consumer_secret'] = $smof_data[ 'auth-twitter-consumer_secret' ];
		}
		
		if ( ! $twitter_args['access_token'] ) {
			$twitter_args['access_token'] = $smof_data[ 'auth-twitter-access_token' ];
		}
		
		if ( ! $twitter_args['access_token_secret'] ) {
			$twitter_args['access_token_secret'] = $smof_data[ 'auth-twitter-access_token_secret' ];
		}
		
		if ( ! $twitter_args['consumer_key'] ) { $twitter_args['consumer_key'] = '-1'; }
		if ( ! $twitter_args['consumer_secret'] ) { $twitter_args['consumer_secret'] = '-1'; }
		
		$twitter_args = shortcode_atts( array(
			'include_entities' => true,
			'include_rts' => true,
			'screen_name' => '',
			'count' => 5,
			'published_when' => 1,
			'consumer_key' => '-1',
			'consumer_secret' => '-1',
			'access_token' => '',
			'access_token_secret' => ''
		), $twitter_args );
		
		$tweets = $this->get_tweets( $twitter_args, $args['cache_timeout'] );
		
		$html = '';
		
		$html .= '<div class="invicta_twitterfeed">';
		
		if ( is_wp_error( $tweets ) || ! is_array( $tweets ) || count( $tweets ) == 0 ) {
			foreach( $tweets->errors as $error_code=>$error ) {
				$html .= '<div><i class="icon-warning-sign"></i> ' . $error[0] . '</div>';
			}
		}
		else {
			$count = 0;
			foreach ( $tweets as $tweet ) {
				
				$html .= '<div class="tweet">';
				
				// tweet text
				$html .= 	'<span class="tweet_body text_styles">';
				$html .= 		'<i class="icon-twitter"></i>';
				$html .= 		$this->get_tweet_text( $tweet );
				$html .= 	'</span>';
				
				$html .= 	'<span class="tweet_date">';
								$href = esc_url( "http://twitter.com/{$tweet->user->screen_name}/statuses/{$tweet->id_str}" );
								$time_diff = human_time_diff( strtotime( $tweet->created_at ) ) . ' ' . __( 'ago', 'invicta_dictionary' );
				$html .= 		'<a href="' . $href . '" class="inherit-color accentcolor-text-on_hover" target="_blank">' . $time_diff . '</a>';
				$html .= 	'</span>';
				
				$html .= '</div>';
				
				if (++$count >= $args['count']) {
					break;
				}
				
			}
		}
		
		$html .= '</div>';
		
		return $html;
		
	}
	
	/*
	== Get tweets from cache and/or twitter
	*/
	function get_tweets( $args, $cacheTimeout ) {
		
		// generate key
		$key = 'invicta_' . md5( 'twitter' . $args['screen_name'] . $args['count'] );
		
		// setup cache expiration
		$expiration = $cacheTimeout * 60;
		
		$transient = get_transient( $key );
		
		if ( false === $transient ) { // hard expiration
		
			//Fb::log('not cached');
			
			// get data
			$data = $this->retrieve_remote_tweets( $args );
			
			// if no errors... update transient
			if ( ! is_wp_error( $data ) ) {
				$this->set_twitter_transient( $key, $data, $expiration );
			}
			
			return $data;
			
		}
		else { // soft expiration
		
			//Fb::log('cached');
			
			// expiration time passed, attempt to get new data
			if ( $transient[0] !== 0 && $transient[0] <= time() ) {
			
				//Fb::log('cached but expired');

				// get data				
				$new_data = $this->retrieve_remote_tweets( $args );
				
				// if no errors... update transient
				if ( ! is_wp_error( $new_data ) ) {
					$this->set_twitter_transient( $key, $new_data, $expiration ); 
					$transient[1] = $new_data;
				}
				
			}
			
			return $transient[1];
			
		}
		
	}
	
	/*
	== Retrieves tweets from twitter
	*/
	function retrieve_remote_tweets( $args ) {
		
		if ( class_exists('Codebird') ) { // codebird is the class that will do the interface with twitter
		
			Codebird::setConsumerKey( $args['consumer_key'], $args['consumer_secret'] );
			
			$cb = Codebird::getInstance();			
			$cb->setToken( $args['access_token'], $args['access_token_secret'] );
						
			$params = array(
				'screen_name' 	=> $args['screen_name'],
				'count' 		=> $args['count'],
				'include_rts' 	=> $args['include_rts']
			);
			
			$response = (array) $cb->statuses_userTimeline( $params );
			
			if ( isset( $response['errors'] ) ) {
			
				if ( $response['errors'][0]->code == 89 ) { 
					// if the access token has expired we'll contact the administrator
					try {
						$to = get_bloginfo('admin_email');
						$subject = get_bloginfo('name') . ' - Twitter authentication token expired';
						$message = 'Your Twitter authentication token has expired. Please generate a new one and update your info in Theme Options panel.';
						wp_mail(get_bloginfo('admin_email'), $subject, $message);
					} 
					catch( Exception $e ) {	
					}
				}
				
				return new WP_Error( $response['errors'][0]->code, $response['errors'][0]->message );
				
			} 
			
			if ( sizeof( $response ) <= 1 ) {
				return new WP_Error( 1000, 'No tweets available' );	
			}
			
			return $response;

		}
		else {
			return new WP_Error( 1001, 'No Twitter interface available' );
		}
		
	}
	
	/*
	== Set cache
	*/
	function set_twitter_transient( $key, $data, $expiration ) {
		$expire = time() + $expiration;
		set_transient( $key, array( $expire, $data ) );
	}
	
	/*
	== Converts links, hashtags and users into html hyperlinks
	*/
	function get_tweet_text( $tweet ) {
		
		$entities = $tweet->entities;
		$content = $tweet->text;
		
		// make any links clickable
		if ( ! empty( $entities->urls ) ) {
			foreach ( $entities->urls as $url ) {
				$content = str_ireplace( $url->url, '<a href="' . esc_url($url->expanded_url) . '" target="_blank">' . $url->display_url . '</a>', $content );
			}
		}
		
		// make anu hashtags clickable
		if ( ! empty( $entities->hashtags ) ) {
			foreach ( $entities->hashtags as $hashtag ) {
				$url = 'http://search.twitter.com/search?q=' . urlencode( $hashtag->text );
				$content = str_ireplace( '#' . $hashtag->text, '<a href="' . esc_url($url) . '" target="_blank" class="hash inherit-color accentcolor-text-on_hover">#' . $hashtag->text . '</a>', $content );
			}
		}
		
		// make any users clickable
		if ( ! empty( $entities->user_mentions ) ) {  
		    foreach ( $entities->user_mentions as $user ) {  
		        $url = 'http://twitter.com/' . urlencode( $user->screen_name );  
		        $content = str_ireplace( '@'. $user->screen_name, '<a href="' . esc_url($url) . '" target="_blank" class="user inherit-color accentcolor-text-on_hover">@' . $user->screen_name . '</a>', $content );  
		    }  
		} 
		
		// make any media urls clickable  
		if ( ! empty( $entities->media ) ) {  
			foreach ( $entities->media as $media ) {  
		    	$content = str_ireplace( $media->url, '<a href="' . esc_url($media->expanded_url) . '" target="_blank" class="media inherit-color accentcolor-text-on_hover">' . $media->display_url . '</a>', $content );  
		    }  
		}
		
		return $content;
		
	}

	
}
	
?>