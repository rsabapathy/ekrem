<!DOCTYPE html>
<html <?php language_attributes(); ?>>

	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
		<title><?php wp_title('|', true, 'right'); ?> - <?php bloginfo( 'description' ) ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
		<?php global $smof_data; ?>
		
		<?php echo invicta_ios_home_screen_icon_links() ?>
		<?php echo invicta_favicon_link() ?>
		
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class( 'error503' ); ?>>
		
		<section id="page503_body">
		
			<!-- Logo -->
			<?php if ( $smof_data['maintenance-logo'] ) : ?>
			<div class="logo">
				<img src="<?php echo $smof_data['maintenance-logo']; ?>" alt="<?php echo get_bloginfo('name') ?>" />
			</div>
			<?php endif; ?>
		
			<!-- Heading -->
			<div class="invicta_heading">
				<div class="primary">
					<?php 
						if ( $smof_data['maintenance-title'] ) {
							echo $smof_data['maintenance-title'];
						}
						else {
							_e("Coming <strong>Soon</strong>", "invicta_dictionary" );
						}
					?>
				</div>
				<div class="secondary">
					<?php 
						if ( $smof_data['maintenance-message'] ) {
							echo nl2br( $smof_data['maintenance-message'] );
						}
						else {
							_e("We are preparing something new. Please come back soon.<br/>Meanwhile, stay in touch through the social networks.", 'invicta_dictionary');
						}
					?>
				</div>
			</div>
			
			<!-- Social Networks-->
			<?php 

			$social_links_data = array();
			
			if ( $smof_data['maintenance-social-email'] ) { 
				array_push( $social_links_data, array( 'id' => 'email', 'url' => $smof_data['maintenance-social-email'] ) );
			}
			
			if ( $smof_data['maintenance-social-skype_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'skype', 'url' => $smof_data['maintenance-social-skype_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-twitter_url'] ) {
				array_push( $social_links_data, array( 'id' => 'twitter', 'url' => $smof_data['maintenance-social-twitter_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-facebook_url'] ) {
				array_push( $social_links_data, array( 'id' => 'facebook', 'url' => $smof_data['maintenance-social-facebook_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-googleplus_url'] ) {
				array_push( $social_links_data, array( 'id' => 'googleplus', 'url' => $smof_data['maintenance-social-googleplus_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-linkedin_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'linkedin', 'url' => $smof_data['maintenance-social-linkedin_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-xing_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'xing', 'url' => $smof_data['maintenance-social-xing_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-flickr_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'flickr', 'url' => $smof_data['maintenance-social-flickr_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-tumblr_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'tumblr', 'url' => $smof_data['maintenance-social-tumblr_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-dribbble_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'dribbble', 'url' => $smof_data['maintenance-social-dribbble_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-instagram_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'instagram', 'url' => $smof_data['maintenance-social-instagram_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-pinterest_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'pinterest', 'url' => $smof_data['maintenance-social-pinterest_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-foursquare_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'foursquare', 'url' => $smof_data['maintenance-social-foursquare_url'] ) );
			}
			
			if ( $smof_data['maintenance-social-youtube_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'youtube', 'url' => $smof_data['maintenance-social-youtube_url'] ) );
			}
			
			if ( $social_links_data ) : 
			
				$args = array(
					'target'	=> '_blank',
					'data'		=> $social_links_data
				);
				
				$social_links = new invicta_social_links( $args );
				
			?>
			<div class="social_networks">
				<?php $social_links->print_html(); ?>
			</div>
			<?php endif; ?>
		
		</section>
		
		<script type="text/javascript">
			jQuery(window).load(function(){
				jQuery('#page503_body').invicta_page503();
			});
		</script>
		
		<?php wp_footer(); ?>
	</body>
	
</html>