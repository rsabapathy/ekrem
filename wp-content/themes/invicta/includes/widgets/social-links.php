<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Widget Registering
== ------------------------------------------------------------------- ==
*/

add_action( 'widgets_init', 'invicta_register_sociallinks_widget' );

function invicta_register_sociallinks_widget() {
	register_widget( 'invicta_sociallinks_widget' );
}


/*
== ------------------------------------------------------------------- ==
== @@ Widget Class
== ------------------------------------------------------------------- ==
*/

class invicta_sociallinks_widget extends WP_Widget {
	
	function __construct() {
		
		$args = array(
			'classname'		=> 'invicta_sociallinks',
			'description'	=> __( 'A widget to display a set of social links', 'invicta_dictionary' )
		);
		
		parent::__construct( 'invicta_sociallinks_widget', THEMENAME . ' ' . __( 'Social Links', 'invicta_dictionary' ), $args );
	}
	
	function form( $instance ) {
		
		$defaults = array(
			'title'			=> '',
			'intro'			=> '',
			'email'			=> '',
			'skype'			=> '',
			'twitter'		=> '',
			'facebook'		=> '',
			'googleplus'	=> '',
			'linkedin'		=> '',
			'xing'			=> '',
			'dribbble'		=> '',
			'flickr'		=> '',
			'tumblr'		=> '',
			'instagram'		=> '',
			'pinterest'		=> '',
			'foursquare'	=> '',
			'youtube'		=> ''
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>
		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<!-- intro -->
		<p>
			<label for="<?php echo $this->get_field_id('intro'); ?>"><?php _e( 'Intro', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('intro'); ?>" name="<?php echo $this->get_field_name('intro'); ?>" class="widefat"><?php echo esc_textarea( $instance['intro'] ); ?></textarea>
		</p>
		<!-- email -->
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e( 'Email', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" type="text" value="<?php echo $instance['email']; ?>" class="widefat" />
		</p>
		<!-- skype -->
		<p>
			<label for="<?php echo $this->get_field_id('skype'); ?>"><?php _e( 'Skype', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('skype'); ?>" name="<?php echo $this->get_field_name('skype'); ?>" type="text" value="<?php echo $instance['skype']; ?>" class="widefat" />
		</p>
		<!-- twitter -->
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e( 'Twitter', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo $instance['twitter']; ?>" class="widefat" />
		</p>
		<!-- facebook -->
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e( 'Facebook', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo $instance['facebook']; ?>" class="widefat" />
		</p>
		<!-- googleplus -->
		<p>
			<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e( 'Google Plus', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" type="text" value="<?php echo $instance['googleplus']; ?>" class="widefat" />
		</p>
		<!-- linkedin -->
		<p>
			<label for="<?php echo $this->get_field_id('linkedin'); ?>"><?php _e( 'LinkedIn', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('linkedin'); ?>" name="<?php echo $this->get_field_name('linkedin'); ?>" type="text" value="<?php echo $instance['linkedin']; ?>" class="widefat" />
		</p>
		<!-- xing -->
		<p>
			<label for="<?php echo $this->get_field_id('xing'); ?>"><?php _e( 'Xing', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('xing'); ?>" name="<?php echo $this->get_field_name('xing'); ?>" type="text" value="<?php echo $instance['xing']; ?>" class="widefat" />
		</p>
		<!-- dribbble -->
		<p>
			<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php _e( 'Dribbble', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" type="text" value="<?php echo $instance['dribbble']; ?>" class="widefat" />
		</p>
		<!-- flickr -->
		<p>
			<label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e( 'Flickr', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('flickr'); ?>" name="<?php echo $this->get_field_name('flickr'); ?>" type="text" value="<?php echo $instance['flickr']; ?>" class="widefat" />
		</p>
		<!-- tumblr -->
		<p>
			<label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e( 'Tumblr', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('tumblr'); ?>" name="<?php echo $this->get_field_name('tumblr'); ?>" type="text" value="<?php echo $instance['tumblr']; ?>" class="widefat" />
		</p>
		<!-- instagram -->
		<p>
			<label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e( 'Instagram', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" value="<?php echo $instance['instagram']; ?>" class="widefat" />
		</p>
		<!-- pinterest -->
		<p>
			<label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e( 'Pinterest', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" value="<?php echo $instance['pinterest']; ?>" class="widefat" />
		</p>
		<!-- foursquare -->
		<p>
			<label for="<?php echo $this->get_field_id('foursquare'); ?>"><?php _e( 'Foursquare', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('foursquare'); ?>" name="<?php echo $this->get_field_name('foursquare'); ?>" type="text" value="<?php echo $instance['foursquare']; ?>" class="widefat" />
		</p>
		<!-- youtube -->
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e( 'Youtube', 'invicta_dictionary' ); ?>: </label>
			<input id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo $instance['youtube']; ?>" class="widefat" />
		</p>
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['intro'] = strip_tags( $new_instance['intro'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['skype'] = strip_tags( $new_instance['skype'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );
		$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
		$instance['xing'] = strip_tags( $new_instance['xing'] );
		$instance['dribbble'] = strip_tags( $new_instance['dribbble'] );
		$instance['flickr'] = strip_tags( $new_instance['flickr'] );
		$instance['tumblr'] = strip_tags( $new_instance['tumblr'] );
		$instance['instagram'] = strip_tags( $new_instance['instagram'] );
		$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
		$instance['foursquare'] = strip_tags( $new_instance['foursquare'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
				
		return $instance;
		
	}
	
	function widget( $args, $instance ) {
	
		global $post;
		
		extract( $args );
		extract( $instance );
		
		$title = ( ! empty( $instance['title'] ) ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		
		echo $before_widget;
		
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		
		$output = '';
		
		if ( $intro ) {
			$output .= 	'<div class="intro">';
			if ( defined('ICL_SITEPRESS_VERSION') && function_exists('icl_translate') ) {
				$output .= icl_translate( 'invicta_dictionary', 'social_links_widget_intro_text', $intro );
			}
			else {
				$output .= $intro;
			}
			$output .=	'</div>';
		}
		
		unset($instance['title']);
		
		echo invicta_sociallinks_shortcode($instance);
		
		echo $after_widget;
			
	}
	
}
	
?>