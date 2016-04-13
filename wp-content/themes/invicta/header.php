<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	
	<head>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	
		<title><?php wp_title('|', true, 'right'); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		
		<?php global $smof_data; ?>
		
		<?php echo invicta_ios_home_screen_icon_links() ?>
		<?php echo invicta_favicon_link() ?>
		<?php echo invicta_add2home_popup() ?>
		
		<?php echo invicta_googleanalytics_trackingcode() ?>
		
		<?php wp_head(); ?>
	</head>
	
	<body <?php body_class( invicta_layout_class( 'body_classes', '', false) ); ?>>
	
		<div class="body_background">
	
			<?php invicta_scroll_top_link(); ?>
			
			<?php invicta_style_switcher(); ?>
		
			<div id="invicta_root">
					
				<header class="page_header">
				
					<div class="header_wrapper">
								
						<?php invicta_header_meta_bar(); ?>
						
						<div class="header_main">
							<div class="invicta_canvas">
							
								<?php invicta_main_logo(); ?>
								<?php invicta_page_menu('main_menu'); ?>
								
								<div class="alignclear"></div>
			
							</div>
						</div>
					
					</div>
					
					<div class="header_wrapper_extras">
					
						<?php if ( is_front_page() && $smof_data['general-home_slideshow'] ) : ?>
						
							<?php invicta_homepage_slideshow(); ?>
						
						<?php else : ?>
						
							<?php if ( ! is_404() ) : ?>
						
							<div class="title_area">
						
								<div class="invicta_canvas">
			
									<div class="alignleft">
										<h1><?php echo invicta_page_title(); ?></h1>
									</div>
									
									<div class="alignright">
										<?php invicta_page_breadcrumb(); ?>
									</div>
									
									<div class="alignclear"></div>
									
								</div>
								
							</div>
							
							<?php invicta_page_slideshow(); ?>
						
							<?php endif; ?>	
						
						<?php endif; ?>
					
					</div>
					
					<?php invicta_page_image(); ?>
					
				</header>
				
				<div id="page_body">