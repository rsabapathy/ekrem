<?php global $invicta_settings; ?>
<?php 
	
	// if none current page context is defined
	// 'page' will be assumed by default
	
	if ( empty( $invicta_settings['context'] ) ) {
		$invicta_settings['context'] = 'pages';
	}
	
	$show_sidebars = invicta_has_sidebar( $invicta_settings['context'] );
	
?>
<?php if ( $show_sidebars ) : ?>
	<div class="side_column">
<?php endif; ?>
<?php 

	if ( $show_sidebars ) {
	
		$show_default_sidebar = true;
		
		
		$post_id = get_queried_object_id();
		$custom_sidebar = get_post_meta( $post_id, '_invicta_layout_sidebar', true );
		
		if ( ! empty( $custom_sidebar ) && $custom_sidebar != 'default' ) { 
		
			// a sidebar will be displayed according to which was specified for this page/post
			if ( dynamic_sidebar( $custom_sidebar ) ) {
				$show_default_sidebar = false;	
			}
			
			
		} else {
		
			// a sidebar will be displayed according to the current page context defaults
			
			switch ( $invicta_settings['context'] ) {
				
				case 'blog_list' :
				case 'blog_post' :
				case 'blog_archives' :
					if ( dynamic_sidebar('Blog Sidebar') ) {
						$show_default_sidebar = false;	
					}
					break;
					
				case 'pages' :
					if ( dynamic_sidebar('Page Sidebar') ) {
						$show_default_sidebar = false;
					}
					break;
					
				case 'photos':
					invicta_manual_widget(8);
					$show_default_sidebar = false;
					break;
					
				case 'shop':
					if ( dynamic_sidebar('Shop Sidebar') ) {
						$show_default_sidebar = false;
					}
					break;
				case 'product': 
					$show_default_sidebar = false;
					break;
				
			}
		
		}
		
		// this sidebar is displayed in all pages	
		
		if ( dynamic_sidebar('Global Sidebar') ) {
			$show_default_sidebar = false;
		}
		
		// if none sidebar was displayed until here
		// the default sidebar will be displayed
		
		if ( $show_default_sidebar ) {
			
			invicta_manual_widget(1);
			invicta_manual_widget(2);
			// invicta_manual_widget(3);
			// invicta_manual_widget(4);
			
		}
	
	} // if ( $show_sidebars )
	
?>
<?php if ( $show_sidebars ) : ?>
	</div>
	<div class="alignclear"></div>
<?php endif; ?>