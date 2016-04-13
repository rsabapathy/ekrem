<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Widget Registering
== ------------------------------------------------------------------- ==
*/

add_action( 'widgets_init', 'invicta_register_contacts_widget' );

function invicta_register_contacts_widget() {
	register_widget( 'invicta_contacts_widget' );
}


/*
== ------------------------------------------------------------------- ==
== @@ Widget Class
== ------------------------------------------------------------------- ==
*/

class invicta_contacts_widget extends WP_Widget {
	
	function __construct() {
		
		$args = array(
			'classname'		=> 'invicta_contacts',
			'description'	=> __( 'A widget to display a set of contacts', 'invicta_dictionary' )
		);
		
		parent::__construct( 'invicta_contacts_widget', THEMENAME . ' ' . __( 'Contacts', 'invicta_dictionary' ), $args );
	}
	
	function form( $instance ) {
		
		$defaults = array(
			'title'			=> '',
			'intro'			=> '',
			'address'		=> '',
			'phone'			=> '',
			'mobile'		=> '',
			'email'			=> '',
			'google_map'	=> '',
			'url'			=> ''
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
		<!-- address -->
		<p>
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e( 'Address', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" class="widefat"><?php echo esc_textarea( $instance['address'] ); ?></textarea>
		</p>
		<!-- phone -->
		<p>
			<label for="<?php echo $this->get_field_id('phone'); ?>"><?php _e( 'Phone', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('phone'); ?>" name="<?php echo $this->get_field_name('phone'); ?>" class="widefat"><?php echo esc_textarea( $instance['phone'] ); ?></textarea>
		</p>
		<!-- mobile -->
		<p>
			<label for="<?php echo $this->get_field_id('mobile'); ?>"><?php _e( 'Mobile', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('mobile'); ?>" name="<?php echo $this->get_field_name('mobile'); ?>" class="widefat"><?php echo esc_textarea( $instance['mobile'] ); ?></textarea>
		</p>
		<!-- email -->
		<p>
			<label for="<?php echo $this->get_field_id('email'); ?>"><?php _e( 'E-Mail', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('email'); ?>" name="<?php echo $this->get_field_name('email'); ?>" class="widefat"><?php echo esc_textarea( $instance['email'] ); ?></textarea>
			<cite><?php _e( 'One per line', 'invicta_dictionary' ) ?></cite>
		</p>
		<!-- url -->
		<p>
			<label for="<?php echo $this->get_field_id('url'); ?>"><?php _e( 'URL', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('url'); ?>" name="<?php echo $this->get_field_name('url'); ?>" class="widefat"><?php echo esc_textarea( $instance['url'] ); ?></textarea>
			<cite><?php _e( 'One per line', 'invicta_dictionary' ) ?></cite>
		</p>
		<!-- google_map -->
		<p>
			<label for="<?php echo $this->get_field_id('google_map'); ?>"><?php _e( 'Google Map Link', 'invicta_dictionary' ); ?>: </label>
			<textarea id="<?php echo $this->get_field_id('google_map'); ?>" name="<?php echo $this->get_field_name('google_map'); ?>" class="widefat"><?php echo esc_textarea( $instance['google_map'] ); ?></textarea>
			<cite><?php _e( 'Link to your map. Visit <a href="http://maps.google.com/">Google maps</a> to find your address and then click "Link" button to obtain your map link.', 'invicta_dictionary' ) ?></cite>
		</p>
		<?php
	}
	
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['intro'] = strip_tags( $new_instance['intro'] );
		$instance['address'] = strip_tags( $new_instance['address'] );
		$instance['phone'] = strip_tags( $new_instance['phone'] );
		$instance['mobile'] = strip_tags( $new_instance['mobile'] );
		$instance['email'] = strip_tags( $new_instance['email'] );
		$instance['google_map'] = strip_tags( $new_instance['google_map'] );
		$instance['url'] = strip_tags( $new_instance['url'] );
		
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
				$output .= icl_translate( 'invicta_dictionary', 'contacts_widget_intro_text', $intro );
			}
			else {
				$output .= $intro;
			}
			$output .=	'</div>';
		}
		
		$output .= 		'<ul class="contacts">';
		
		if ( $address ) {
			$output .=		'<li class="address">' . nl2br( $address ) . '</li>';
		}
		
		if ( $phone ) {
			$output .=		'<li class="phone">' . nl2br( $phone ) . '</li>';
		}
		
		if ( $mobile ) {
			$output .=		'<li class="mobile">' . nl2br( $mobile ) . '</li>';
		}
		
		if ( $email ) {
		
			$emails = str_replace( array( "\r\n", "\n" ), ',', $email );
			$emails = explode( ',' , $emails );	
					
			$output .=		'<li class="email accentcolor-text-on_children-on_hover">';
			foreach ( $emails as $email ) {
				if ( $email ) {
					$output .=		'<a href="mailto:' . trim( $email ) . '">' . $email . '</a><br/>';
				}
			}
			$output .= 		'</li>';
		}
		
		if ( $google_map ) {
			$output .=		'<li class="map accentcolor-text-on_children-on_hover">';
			$output	.=			'<a href="' . esc_url( trim( $google_map ) ) . '" target="_blank">' . __( 'Find us on the map', 'invicta_dictionary' ) . '</a>';
			$output .= 		'</li>';
		}
		
		if ( $url ) {
		
			$urls = str_replace( array( "\r\n", "\n" ), ',', $url );
			$urls = explode( ',' , $urls );	
					
			$output .=		'<li class="url accentcolor-text-on_children-on_hover">';
			foreach ( $urls as $url ) {
				if ( $url ) {
					$output .=		'<a href="' . esc_url( trim( $url ) ) . '" target="_blank">' . $url . '</a><br/>';
				}
			}
			$output .= 		'</li>';
		}
		
		$output .= 		'</ul>';
		
		echo $output;
		
		echo $after_widget;
			
	}
	
}
	
?>