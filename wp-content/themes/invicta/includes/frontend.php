<?php 
/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Sidebars
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ Menu
	@@ Main Logo
	@@ Header Meta
	@@ WPML Language Switcher
	@@ Page Title
	@@ Page Breadcrumb
	@@ Pagination
	@@ Post Featured Image
	@@ Widget Post Featured Image
	@@ Project Featured Image
	@@ Video Featured Image
	@@ Post Title
	@@ Post Author
	@@ Post Pagination
	@@ Social Share Buttons
	@@ iOS Home Screen Icon Links
	@@ FavIcon
	@@ Add2Home Popup
	@@ Google Analytics
	@@ Custom JavaScript Code
	@@ Homepage Slideshow
	@@ Page Image
	@@ Related Projects
	@@ Photo Categories Widget
	@@ Comments Listing
	@@ Pings Listing

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

/*
== ------------------------------------------------------------------- ==
== @@ Menu
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_page_menu' ) ) {

	function invicta_page_menu( $menu_location = 'main_menu' ) {
	
		// in case of dealing with the main menu
		// if there is no custom menu specified
		// we should display the default pages list
		if ( $menu_location == 'main_menu') {
		
			// there is a custom WP menu
			if ( function_exists('register_nav_menus') && has_nav_menu('main_menu') ) { 
			
				$menu_args = array(
					'theme_location' 	=> 'main_menu',
					'container'			=> 'nav',
					'menu_class'		=> 'menu',
					'echo'				=> true,
					'fallback_cb'		=> 'wp_list_pages',
					'items_wrap'		=> '<ul id="main_menu" class="sf-menu">%3$s</ul>',
					'depth'				=> 0
				);
				
				wp_nav_menu($menu_args);
				
			}
			
			// the default pages list will be displayed
			else {
				
				$menu_args = array(
					'depth'        => 0,
					'show_date'    => '',
					'date_format'  => get_option('date_format'),
					'child_of'     => 0,
					'exclude'      => '',
					'include'      => '',
					'title_li'     => '',
					'echo'         => 1,
					'authors'      => '',
					'sort_column'  => 'menu_order, post_title',
					'link_before'  => '',
					'link_after'   => '',
					'walker'       => '',
					'post_status'  => 'publish'
				);
				
				echo '<nav>';
				echo 	'<ul id="main_menu" class="sf-menu">';
							wp_list_pages($menu_args);
				echo 	'</ul>';
				echo '</nav>';
				
			}
			
			echo '<script type="text/javascript">';
			echo 	'jQuery(document).ready(function($){';
			echo 		'$("#main_menu").invicta_menu({';
			echo 			'go_to_label: "' . __( "Go to...", "invicta_dictionary" ) . '",';
			echo 			'home_url: "' . home_url() . '/",';
			echo 			'delay: 500';
			echo 		'});';
			echo 	'});';
			echo '</script>';
			
		}	
		
		// in case of dealing with the footer menu
		// if there is no custom menu specified
		// we do not show anything
		elseif ( $menu_location == 'footer_menu' ) {
		
			if ( function_exists('register_nav_menus') && has_nav_menu('footer_menu') ) { 
			
				$menu_args = array(
					'theme_location' 	=> 'footer_menu',
					'container'			=> '',
					'menu_class'		=> 'menu',
					'echo'				=> true,
					'fallback_cb'		=> 'wp_list_pages',
					'items_wrap'		=> '<ul id="footer_menu" class="menu">%3$s</ul>',
					'depth'				=> -1
				);
				
				wp_nav_menu($menu_args);
				
			}
			
		}
		
	}

}
	
/*
== ------------------------------------------------------------------- ==
== @@ Main Logo
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_main_logo' ) ) {
	
	function invicta_main_logo() {
	
		global $smof_data;
		
		if ( $smof_data['branding-logo_main'] ) {
		
			$retina_logo = $smof_data['branding-logo_main_retina'];
			
			if ( $retina_logo ) { 
				echo '<div class="logo retina">';
				echo 	'<a href="' . home_url() . '" title="' . get_bloginfo('name') . '">';
				echo 		'<img src="' . $smof_data['branding-logo_main'] . '" alt="' . get_bloginfo('name') . '" data-retina="' . $retina_logo . '" />';
				echo 	'</a>';
				echo '</div>';
			}
			else {
				echo '<div class="logo">';
				echo 	'<a href="' . home_url() . '" title="' . get_bloginfo('name') . '">';
				echo 		'<img src="' . $smof_data['branding-logo_main'] . '" alt="' . get_bloginfo('name') . '" />';
				echo 	'</a>';
				echo '</div>';
			}
			
		}
		else {
			
			echo '<div class="logo retina">';
			echo 	'<a href="' . home_url() . '" title="' . get_bloginfo('name') . '">';
			echo 		'<img src="' . get_template_directory_uri() . '/styles/images/logo.png" alt="' . get_bloginfo('name') . '" data-retina="' . get_template_directory_uri() . '/styles/images/logo@2x.png" />';
			echo 	'</a>';
			echo '</div>';
	
		}
	
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Header Meta
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_header_meta_bar' ) ) {
	
	function invicta_header_meta_bar() {
	
		global $smof_data;
		
		if ( $smof_data['header-meta_bar'] ) {
		
			$social_links_data = array();
			
			if ( $smof_data['header-meta_bar_skype_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'skype', 'url' => $smof_data['header-meta_bar_skype_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_twitter_url'] ) {
				array_push( $social_links_data, array( 'id' => 'twitter', 'url' => $smof_data['header-meta_bar_twitter_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_facebook_url'] ) {
				array_push( $social_links_data, array( 'id' => 'facebook', 'url' => $smof_data['header-meta_bar_facebook_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_googleplus_url'] ) {
				array_push( $social_links_data, array( 'id' => 'googleplus', 'url' => $smof_data['header-meta_bar_googleplus_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_linkedin_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'linkedin', 'url' => $smof_data['header-meta_bar_linkedin_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_xing_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'xing', 'url' => $smof_data['header-meta_bar_xing_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_flickr_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'flickr', 'url' => $smof_data['header-meta_bar_flickr_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_tumblr_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'tumblr', 'url' => $smof_data['header-meta_bar_tumblr_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_dribbble_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'dribbble', 'url' => $smof_data['header-meta_bar_dribbble_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_instagram_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'instagram', 'url' => $smof_data['header-meta_bar_instagram_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_pinterest_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'pinterest', 'url' => $smof_data['header-meta_bar_pinterest_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_foursquare_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'foursquare', 'url' => $smof_data['header-meta_bar_foursquare_url'] ) );
			}
			
			if ( $smof_data['header-meta_bar_youtube_url'] ) { 
				array_push( $social_links_data, array( 'id' => 'youtube', 'url' => $smof_data['header-meta_bar_youtube_url'] ) );
			}
			
			$args = array(
				'target'	=> '_blank',
				'data'		=> $social_links_data
			);
			
			$social_links = new invicta_social_links( $args );
			
			echo '<section class="header_meta">';
			echo 	'<div class="invicta_canvas">';
			
			echo 		'<div class="callus">';
			
			if ( $smof_data['header-meta_bar_phone'] ) {
				echo 		'<span class="meta phone">';
				echo 			'<i class="icon-phone"></i> ';
				echo 			'<span class="inherit-color">';
				echo  				$smof_data['header-meta_bar_phone'];
				echo 			'</span>';
				echo 		'</span>';
			}
			
			if ( $smof_data['header-meta_bar_email'] ) {
				echo 		'<span class="meta email">';
				echo 			'<i class="icon-envelope"></i> ';
				echo 			'<a href="mailto:' . $smof_data['header-meta_bar_email'] .'" class="accentcolor-text-on_hover inherit-color">';
				echo 				$smof_data['header-meta_bar_email'];
				echo 			'</a>';
				echo 		'</span>';
			}
			
			if ( $smof_data['header-meta_bar_tagline'] ) {
				echo 		'<span class="meta tagline">';
				echo  			get_bloginfo('description');
				echo 		'</span>';
			}
			
			echo 		'</div>';
			
			echo 		'<div class="social">';
			
							$social_links->print_html();
							
			if ( $smof_data['header-meta_bar_searchbox'] ) {
			
				echo 		'<div class="searchbox">';
				echo 			'<span class="divider">|</span>';
								get_search_form();
				echo 		'</div>';
				
			}
			
			if ( isset( $smof_data['header-meta_bar_languages_witcher'] ) && $smof_data['header-meta_bar_languages_witcher']  ) {
				invicta_wpml_language_switcher( $smof_data['header-meta_bar_searchbox'] );
			}
			
			do_action( 'invicta_header_meta_right_place_end' );
			
			echo 		'</div>';
			
			echo 		'<div class="alignclear"></div>';
			
			echo 	'</div>';
			echo '</section>';
		
		}
	
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ WPML Language Switcher
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_wpml_language_switcher' ) ) {

	function invicta_wpml_language_switcher( $search_visible = false ) {
		
		if ( function_exists('icl_get_languages') ) { // is wpml installed and enabled?
		
			if ( $search_visible ) {
				$css_helper = ' style="margin-left:0;"';
			}
			else {
				$css_helper = '';
			}
			
			echo '<span class="language_switcher"' . $css_helper . '>';
			echo 	'<span class="divider">|</span>';
					do_action('icl_language_selector');
			echo '</span>';
		
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Page Title
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_page_title' ) ) {

	function invicta_page_title() {
		
		$page_title = '';
		
		if ( is_single() ) {
		
			global $smof_data;
			
			if ( get_post_type() == 'invicta_portfolio' ) {
				$page_title = get_the_title();	
			}
			elseif ( get_post_type() == 'invicta_photos' ) {
				$page_title = get_the_title();
			}
			elseif ( get_post_type() == 'invicta_videos' ) {
				$page_title = get_the_title();
			}
			else {
				if ( $smof_data['blog-custom_single_title'] && ! is_attachment() ) {
					$page_title = $smof_data['blog-custom_single_title-text'];
				} else {
					$page_title = get_the_title();	
				}
			}
			
		}
		else if ( is_home() ) {
			$page_title = single_post_title( '', false );
		}
		else if ( is_search() ) {
			$page_title = __( "Search Results for", "invicta_dictionary" ) . ': ' . get_search_query();
		}
		else if ( is_category() ) {
			$page_title = __( "Archive for the category", "invicta_dictionary" ) . ': ' . single_cat_title( "", false );
		}
		else if ( is_tag() ) {
			$page_title = __( "Articles tagged with", "invicta_dictionary" ) . ': ' . single_cat_title( "", false );
		}
		else if ( is_author() ) {
			$author_id = get_query_var('author');
			$author_name = get_the_author_meta( 'display_name', $author_id );
			$page_title = __( "Articles posted by", "invicta_dictionary" ) . ': ' . $author_name;
		}
		else if ( is_date() ) {
			$page_title = __( 'Archive for', 'invicta_dictionary' ) . ' ';
			if (is_day()) {
				$page_title .= get_the_date();
			}
			elseif (is_month()) {
				$page_title .= get_the_time('F Y');
			}
			elseif (is_year()) {
				$page_title .= get_the_time('Y');
			}
		}
		else if ( is_tax() ) {
			global $wp_query;
			$term = $wp_query->get_queried_object();
			if ( get_post_type() == 'invicta_portfolio' ) { 
				$page_title = __( 'Portfolio', 'invicta_dictionary' ) . ' > ' . $term->name;	
			}
			elseif ( get_post_type() == 'invicta_photos' ) {
				$photos_page = '';
				if ( session_id() && ! empty( $_SESSION['invicta_photos_page'] ) ) {
					$photos_page = $_SESSION['invicta_photos_page'];
				}
				if ( $photos_page ) {
					$page_title = get_the_title( $photos_page ) . ' > ' . $term->name;		
				}
				else {
					$page_title = __( 'Photos', 'invicta_dictionary' ) . ' > ' . $term->name;		
				}
			}
			
		}
		else if ( is_404() ) { 
			$page_title = __( "Page Not Found", "invicta_dictionary" );
		}
		else {
			$page_title = get_the_title();
		}
		
		$page_title = apply_filters( 'invicta_filter_page_title', $page_title );
		
		return $page_title;
	
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Page Breadcrumb
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_page_breadcrumb' ) ) { 

	function invicta_page_breadcrumb() {
	
		global $smof_data;
		
		if ( $smof_data['general-breadcrumb'] ) {
		
			$breadcrumb = new invicta_breadcrumb(array(
				'separator'		=> $smof_data['general-breadcrumb-separator'],
				'before'		=> $smof_data['general-breadcrumb-prefix'],
				'home_node'		=> $smof_data['general-breadcrumb-home_name'],
			));
		
			echo $breadcrumb->get_html();
			
		}
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Scroll To Top Link
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_scroll_top_link' ) ) {

	function invicta_scroll_top_link() {
	
		global $smof_data;
		
		if ( $smof_data['general-scroll_top_top'] ) {	
			echo '<a id="invicta_top_arrow" href="#"><i class="icon-angle-up"></i></a>';
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Style Switcher
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_style_switcher' ) ) {

	function invicta_style_switcher() {
		if ( STYLE_SWITCHER == true ) {
			locate_template( 'template-parts/style-switcher.php', true, false );
		}
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Pagination
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_pagination' ) ) {

	function invicta_pagination($pages = '') {
	
		global $paged;
		
		if ( get_query_var('paged') ) {
			$paged = get_query_var('paged');
		}
		elseif ( get_query_var('page') ) {
			$paged = get_query_var('page'); 
		}
		else {
			$paged = 1;
		}
		
		$html = '';
		
		$prev_page = $paged - 1;
		$next_page = $paged + 1;
		$range = 2;
		$show_items = ($range * 2) + 1;
		
		if ($pages == '') {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}
		
		
		if ( $pages != 1) {
			
			$html .= '<div class="invicta_pagination">';
			
			$html .= 	'<div class="pages">';
						
			// First page
			if ( ($paged > 2) && ($paged > $range + 1) && ($show_items < $pages) ) {
				$html .= '<a href="' . get_pagenum_link(1) . '" class="btn first_page accentcolor-background-on_hover">1</a>';
				$html .= '<span class="bullet">&bullet;</span>';
			}
			
			// Pages
			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( ($pages != 1) && ( ! ($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $show_items ) ) {
					if ( $paged == $i ) {
						$html .= '<span class="btn current">' . $i . '</span>';
					}
					else {
						$html .= '<a href="' . get_pagenum_link($i) . '" class="btn inactive accentcolor-background-on_hover">' . $i . '</a>';
					}
				}
			}
			
			// Last page
			if ( ($paged < $pages - 1) &&  ($paged + $range - 1 < $pages) && ($show_items < $pages) ) {
				$html .= '<span class="bullet">&bullet;</span>';
				$html .= '<a href="' . get_pagenum_link($pages) . '" class="btn last_page accentcolor-background-on_hover">' . $pages . '</a>';
			}
			
			$html .=	'</div>';
			
			$html .= 	'<div class="nav">';
			
			// Meta data
			$html .= 		'<span class="meta">';
			$html .= 			sprintf( __('Page %d of %d', 'invicta_dictionary'), $paged, $pages );
			$html .=		'</span>';
			
			// Previous page
			if ( $paged > 1 ) {
				$html .= '<a href="' . get_pagenum_link($prev_page) . '" class="btn accentcolor-background-on_hover"><i class="icon-chevron-left"></i></a>';
			}
			
			// Next Page
			if ( $paged < $pages ) {
				$html .= '<a href="' . get_pagenum_link($next_page) . '" class="btn accentcolor-background-on_hover"><i class="icon-chevron-right"></i></a>';
			}
			
			$html .=	'</div>';
						
			$html .= '</div>';
		}
		
		return $html;
		
	}

}
	

/*
== ------------------------------------------------------------------- ==
== @@ Post Featured Image
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_post_featured_image' ) ) {

	function invicta_post_featured_image() {
		
		global $post;
		global $smof_data;
		global $content_width;
		
		$linked = ( is_single() ) ? false : true;
		$resize = true;
		$width = $content_width;
		$height = BLOG__PHOTO_HEIGHT;
		
		$post_id = $post->ID;
		$image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
		
		$hyperlink_css = 'image_hover_effect';
		$image_css = 'attachment-post-thumbnail wp-post-image';
			
		$html = '';
		
		if ( $image_url ) {
			
			if ( $resize ) {
				if ( $resized_image_url = aq_resize( $image_url, $width, $height, true, true, false) ) {
					$image_url = $resized_image_url;
				}
			}
			
			$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" />';
				
			if ( $linked ) {
				$image_html = $html;
				$html = '<a href="' . get_permalink($post->ID) . '" class="' . $hyperlink_css . ' invicta_hover_effect">';
				$html .=	'<span class="element">';
				$html .= 	    $image_html;
				$html .=	'</span>';
				$html .= 	'<span class="mask">';
				$html .= 	'	<span class="caption">';
				$html .= 			'<span class="title">';
				$html .=				'<i class="icon-link"></i>';
				$html .=			'</span>';
				$html .=		'</span>';
				$html .= 	'</span>';
				$html .= '</a>';
			}
			
		}
		
		return $html;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Widget Post Featured Image
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_widget_post_featured_image' ) ) {

	function invicta_widget_post_featured_image() {
		
		global $post;
	
		$width = WIDGET__PHOTO_WIDTH;
		$height = WIDGET__PHOTO_HEIGHT;	
		$post_id = $post->ID;
		
		$image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
		$original_image_url = $image_url;
		$force_resize = false;
		
		if ( ! $image_url ) {
			$image_url = get_template_directory_uri() . '/styles/images/defaults/no_photo_small.jpg';
		}
		
		$hyperlink_css = 'project_image';
		$image_css = 'attachment-post-thumbnail wp-post-image';
			
		$html = '';
		
		if ( $image_url ) {
			
			$resized_image_url = aq_resize( $image_url, $width, $height, true, true, false);
			
			if ( $resized_image_url ) {
				$image_url = $resized_image_url;
			}
			else {
				$force_resize = true;
			}
				
			if ( ! $force_resize ) {
				$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" />';
			}
			else {
				$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" style="width:' . $width . 'px;" />';
			}
			
			// link setup	
			$html = '<a href="' . get_permalink($post->ID) . '" class="' . $hyperlink_css . '">' . $html . '</a>';
			
		}
		
		return $html;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Project Featured Image
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_project_featured_image' ) ) {

	function invicta_project_featured_image( $linking_type, $width = null, $height = null ) {
		
		global $post;
		global $smof_data;
		global $content_width;
		
		$force_resize = false;
		$linked = ( is_single() ) ? false : true;
		$linked = false;
		$resize = true;
		$width = ( $width ) ? $width : $content_width;
		$height = ( $height ) ? $height : PORTFOLIO_LIST__PHOTO_HEIGHT;
		
		$post_id = $post->ID;
		
		$image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
		$original_image_url = $image_url;
		
		if ( ! $image_url ) {
			$image_url = get_template_directory_uri() . '/styles/images/defaults/no_photo.jpg';
		}
		
		$hyperlink_css = 'project_image';
		$image_css = 'attachment-post-thumbnail wp-post-image';
			
		$html = '';
		
		if ( $image_url ) {
			
			if ( $resize ) {
				$resized_image_url = aq_resize( $image_url, $width, $height, true, true, false);
				if ( $resized_image_url ) {
					$image_url = $resized_image_url;
				}
				else {
					$force_resize = true;
				}
			}
				
			if ( ! $force_resize ) {
				$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" />';
			}
			else {
				$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" style="width:' . $width . 'px;" />';
			}
			
			// link setup
				
			if ( $linked ) {
				
				if ( $linking_type == '1' ) { // Open the single project page
	
					$html = '<a href="' . get_permalink($post->ID) . '" class="' . $hyperlink_css . '">' . $html . '</a>';
					
				}
				elseif ( $linking_type == '2' ) { // Display the featured image in a lightbox
					
					$html = '<a href="' . $original_image_url . '" class="' . $hyperlink_css . '">' . $html . '</a>';
	
					wp_enqueue_script('invicta_fancybox');	
					
				}
				else {
				
					$html = '<a href="' . get_permalink($post->ID) . '" class="' . $hyperlink_css . '">' . $html . '</a>';
					
				}
			
				
			}
			
		}
		
		return $html;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Video Featured Image
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_video_featured_image' ) ) {

	function invicta_video_featured_image( $width = null, $height = null ) {
		
		global $post;
		global $smof_data;
		global $content_width;
		
		$linked = false;
		$resize = true;
		$width = ( $width ) ? $width : $content_width;
		$height = ( $height ) ? $height : VIDEOS__PHOTO_WIDTH;
		
		$post_id = $post->ID;
		
		$image_url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
		
		// if there is no featured image, get the _invicta_video_video_thumbnail meta
		if ( ! $image_url ) {
			$image_url = get_post_meta( $post_id, '_invicta_video_video_thumbnail', true );
            if ( is_ssl() ) {
                $image_url = str_replace( 'http://', 'https://', $image_url );    
            }
		}
		
		$original_image_url = $image_url;
		
		if ( ! $image_url ) {
			$image_url = get_template_directory_uri() . '/styles/images/defaults/no_photo.jpg';
		}
		
		$hyperlink_css = 'video_image';
		$image_css = 'attachment-post-thumbnail wp-post-image';
			
		$html = '';
		
		if ( $image_url ) {
			
			if ( $resize ) {
				$resized_image_url = aq_resize( $image_url, $width, $height, true, true, false);
				if ( $resized_image_url ) {
					$image_url = $resized_image_url;
				}
				else {
					$force_resize = true;
				}
			}
				
			$html .= '<img src="' . $image_url . '" alt="' . esc_attr( get_the_title($post_id) ) . '" class="' . $image_css . '" />';
			
			// link setup
				
			if ( $linked ) {
				$html = '<a href="' . get_permalink($post->ID) . '#page_body" class="' . $hyperlink_css . '">' . $html . '</a>';
			}
			
		}
		
		return $html;
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Post Title
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_post_title' ) ) {

	function invicta_post_title() {
		
		$title = get_the_title();
		
		if ( empty( $title ) ) {
			$title = __( 'Untitled Article', 'invicta_dictionary' );
		}
		
		$html = '';
		
		if ( ! is_single() ) {
		
			$html .= '<a';
			$html .=	' href="' . get_permalink() . '"';
			$html .= 	' title="' . __("Permalink to", "invicta_dictionary") . ' ' . esc_attr( get_the_title() ) . '"';
			$html .= 	' rel="bookmark"';
			$html .= 	' class="inherit-color accentcolor-text-on_hover"';
			$html .= 	'>';
			$html .=		$title;
			$html .= '</a>';
		
		}
		else {
			$html .= $title;
		}
		
		return $html;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Post Author
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_post_author' ) ) {

	function invicta_post_author() {
		
		$author_id = get_the_author_meta('ID');
		$author_name = get_the_author_meta('display_name');
		$author_email = get_the_author_meta('user_email');
		$author_url = get_the_author_meta('user_url');
		$author_feed = get_author_feed_link( $author_id );
		$author_posts_count = count_user_posts( $author_id );
		$author_posts_link = get_author_posts_url( $author_id );
		$author_show_avatar = get_option('show_avatars');
		$author_show_social_links = false;
		$author_description = get_the_author_meta('description');
		if ( ! $author_description ) {
			$author_description = sprintf( __("%s has not yet written their Bio.<br/>Meanwhile we can say that he already contributed with %s articles.", "invicta_dictionary"), $author_name, $author_posts_count);
		}
		
		// helper-css-class to add to the author container so we can control the css positioning
		
		$helper_css_classes = array();
		if ( ! $author_show_avatar ) {
			array_push( $helper_css_classes, 'without_media');
		}
		$helper_css = implode(' ', $helper_css_classes);
		if ( $helper_css ) { $helper_css = ' ' . $helper_css; }
		
		// social links
		
		$social_links_data = array();
		
		if ( $author_email ) {
			array_push( $social_links_data, array( 
				'id' 		=> 'email', 
				'url' 		=> $author_email, 
				'tooltip' 	=> $author_email) 
				);
			$author_show_social_links = true;
		}
		
		if ( $author_url ) {
			array_push( $social_links_data, array( 
				'id' 		=> 'url', 
				'url' 		=> $author_url, 
				'tooltip' 	=> $author_url) 
				);
			$author_show_social_links = true;
		}
		
		if ( $author_feed ) {
			array_push( $social_links_data, array( 
				'id' 		=> 'feed', 
				'url'		=> $author_feed, 
				'tooltip' 	=> $author_feed) 
				);
			$author_show_social_links = true;
		}
		
		$args = array(
			'target'	=> '_blank',
			'data'		=> $social_links_data
		);
		
		$social_links = new invicta_social_links( $args );
		
		$author_posts_phrase =  $author_name . ' ' . __('has posted', 'invicta_dictionary') . ' ' . $author_posts_count . ' ' .  _n('article', 'articles', $author_posts_count, 'invicta_dictionary');
		
		
		// output setup
		
		$output = '';
		
		$output .= '<div class="post_author' . $helper_css .'">';
		
		if ( $author_show_avatar ) {
			$output .= 	'<div class="media">';
			$output .= 		'<div class="invicta_avatar">';
			$output .= 			get_avatar( $author_email, 300 );
			$output .= 		'</div>';
			if ( $author_show_social_links ) {
				$output .= 	'<div class="social">';
				$output .= 		$social_links->get_html();
				$output .= 	'</div>';
			}
			$output .= 	'</div>';
		}
		
		$output .= 		'<div class="text">';
		$output .= 			'<cite>' . __('Posted by', 'invicta_dictionary') . '</cite>';
		$output .= 			'<div class="author_name">';
		$output .= 				$author_name;
		$output .= 			'</div>';
		$output .= 			'<div class="author_bio text_styles">';
		$output .= 				$author_description;
		$output .= 			'</div>';
		$output .= 			'<div class="author_stats text_styles">';
		$output .= 				'<a href="' . $author_posts_link . '" title="' . __( 'View all articles posted by', 'invicta_dictionary' ) . ' ' . $author_name . '">';
		$output .= 					$author_posts_phrase;
		$output .= 				'</a>';
		$output .= 			'</div>';
		$output .= 		'</div>';
		
		$output .= 		'<div class="alignclear"></div>';
		
		$output .= '</div>';
		
		echo $output;
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Post Pagination
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_post_pagination' ) ) {

	function invicta_post_pagination() {
		
		if ( get_post_type() == 'invicta_portfolio' ) {
		
			$next_format = '';
			$next_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$next_format .= '%link';
			$next_format .= '</span>';
		
			$next_link = '';
			$next_link .= '<cite class="accentcolor-text-on_children">';
			$next_link .= '<i class="icon-long-arrow-left"></i> ';
			$next_link .= __('Previous project', 'invicta_dictionary');
			$next_link .= '</cite>';
			$next_link .= '%title';
		
			$previous_format = '';
			$previous_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$previous_format .= '%link';
			$previous_format .= '</span>';
		
			$previous_link = '';
			$previous_link .= '<cite class="accentcolor-text-on_children">';
			$previous_link .= __('Next project', 'invicta_dictionary');
			$previous_link .= ' <i class="icon-long-arrow-right"></i>';
			$previous_link .= '</cite>';
			$previous_link .= '%title';
			
			ob_start();
			previous_post_link($previous_format, $previous_link);
			$previous_html = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			next_post_link($next_format, $next_link);
			$next_html = ob_get_contents();
			ob_end_clean();
			
			$output = '';
			
			$output .= '<div class="invicta_post_navigation">';
			$output .=		'<div class="prev">';
			$output .=			$next_html;
			$output .=		'</div>';
			$output .=		'<div class="next">';
			$output .=			$previous_html;
			$output .=		'</div>';
			$output .=		'<div class="alignclear"></div>';
			$output .= '</div>';
			
			echo $output;
		
		}
		elseif ( get_post_type() == 'product' ) {
		
			$previous_format = '';
			$previous_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$previous_format .= '%link';
			$previous_format .= '</span>';
		
			$previous_link = '';
			$previous_link .= '<cite class="accentcolor-text-on_children">';
			$previous_link .= '<i class="icon-long-arrow-left"></i> ';
			$previous_link .= __('Previous product', 'invicta_dictionary');
			$previous_link .= '</cite>';
			$previous_link .= '%title';
		
			$next_format = '';
			$next_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$next_format .= '%link';
			$next_format .= '</span>';
		
			$next_link = '';
			$next_link .= '<cite class="accentcolor-text-on_children">';
			$next_link .= __('Next product', 'invicta_dictionary');
			$next_link .= ' <i class="icon-long-arrow-right"></i>';
			$next_link .= '</cite>';
			$next_link .= '%title';
			
			ob_start();
			previous_post_link($previous_format, $previous_link);
			$previous_html = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			next_post_link($next_format, $next_link);
			$next_html = ob_get_contents();
			ob_end_clean();
			
			$output = '';
			
			$output .= '<div class="invicta_post_navigation">';
			$output .=		'<div class="prev">';
			$output .=			$previous_html;
			$output .=		'</div>';
			$output .=		'<div class="next">';
			$output .=			$next_html;
			$output .=		'</div>';
			$output .=		'<div class="alignclear"></div>';
			$output .= '</div>';
			
			echo $output;
		
		}
		else {
		
			$previous_format = '';
			$previous_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$previous_format .= '%link';
			$previous_format .= '</span>';
		
			$previous_link = '';
			$previous_link .= '<cite class="accentcolor-text-on_children">';
			$previous_link .= '<i class="icon-long-arrow-left"></i> ';
			$previous_link .= __('Previous article', 'invicta_dictionary');
			$previous_link .= '</cite>';
			$previous_link .= '%title';
		
			$next_format = '';
			$next_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
			$next_format .= '%link';
			$next_format .= '</span>';
		
			$next_link = '';
			$next_link .= '<cite class="accentcolor-text-on_children">';
			$next_link .= __('Next article', 'invicta_dictionary');
			$next_link .= ' <i class="icon-long-arrow-right"></i>';
			$next_link .= '</cite>';
			$next_link .= '%title';
			
			ob_start();
			previous_post_link($previous_format, $previous_link);
			$previous_html = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			next_post_link($next_format, $next_link);
			$next_html = ob_get_contents();
			ob_end_clean();
			
			$output = '';
			
			$output .= '<div class="invicta_post_navigation">';
			$output .=		'<div class="prev">';
			$output .=			$previous_html;
			$output .=		'</div>';
			$output .=		'<div class="next">';
			$output .=			$next_html;
			$output .=		'</div>';
			$output .=		'<div class="alignclear"></div>';
			$output .= '</div>';
			
			echo $output;
		
		}
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Social Share Buttons
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_social_share_buttons' ) ) {

	function invicta_social_share_buttons($context = 'blog') {
	
		global $smof_data;
		
		if ( $context == 'portfolio' ) {
			$alignment = 'left';
		}
		else {
			$alignment = 'right';
		}
		
		if ( $smof_data[ $context . '-share-twitter' ] ) {
		
			$twitter_sharer = new invicta_social_sharer_twitter(array(
				'via' 		=> $smof_data[ $context . '-share-twitter-via'],
				'count' 	=> $smof_data[ $context . '-share-twitter-counter'],
				'hashtag' 	=> $smof_data[ $context . '-share-twitter-hashtags'],
				'language' 	=> substr(get_bloginfo('language'), 0, 2),
				'alignment' => $alignment
			));
			
			echo $twitter_sharer->get_html();
		
		}
		
		if ( $smof_data[ $context . '-share-facebook'] ) {
		
			$facebook_sharer = new invicta_social_sharer_facebook(array());
			echo $facebook_sharer->get_html();
		
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ iOS Home Screen Icon Links
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_ios_home_screen_icon_links' ) ) {

	function invicta_ios_home_screen_icon_links() {
		
		global $smof_data;
		
		$output = '';
		
		$iphone = $smof_data['branding-ios_home_icon-iphone'];
		$ipad = $smof_data['branding-ios_home_icon-ipad'];
		$retina = $smof_data['branding-ios_home_icon-iphone_ipad_retina'];
		
		if ( $smof_data['branding-ios_home_icon-shine_effect'] ) {
			$rel = 'apple-touch-icon';
		}
		else {
			$rel = 'apple-touch-icon-precomposed';
		}
		
		if ( $iphone ) {
			$output .= '<link rel="' . $rel . '" sizes="57x57" href="' . $iphone . '" /> ';
		}
		
		if ( $ipad ) {
			$output .= '<link rel="' . $rel . '" sizes="72x72" href="' . $ipad . '" /> ';
		}
		
		if ( $retina ) {
			$output .= '<link rel="' . $rel . '" sizes="114x114" href="' . $retina . '" /> ';
		}
		
		return $output;
			
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ FavIcon
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_favicon_link' ) ) {

	function invicta_favicon_link() {
		
		global $smof_data;
	
		$output = '';
		
		$favicon = $smof_data['branding-favicon'];
		
		if ( $favicon ) {
			$output .= '<link rel="shortcut icon" href="' . $favicon . '" type="image/x-icon" /> ';
		}
		
		return $output;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Add2Home Popup
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_add2home_popup' ) ) {
	
	function invicta_add2home_popup() {
		
		global $smof_data;
		
		$output = '';
		
		if ( $smof_data['general-ios_homescreen_popup'] ) {
		
			$message = $smof_data['general-ios_homescreen_popup-message'];
			$icon = ( $smof_data['general-ios_homescreen_popup-icon'] ) ? 'true' : 'false' ;
			$lifespan = ( $smof_data['general-ios_homescreen_popup-lifespan'] && is_numeric( $smof_data['general-ios_homescreen_popup-lifespan'] ) ) ? $smof_data['general-ios_homescreen_popup-lifespan'] : '' ;
			$expire = ( $smof_data['general-ios_homescreen_popup-expire'] && is_numeric( $smof_data['general-ios_homescreen_popup-expire'] ) ) ? $smof_data['general-ios_homescreen_popup-expire'] : 0 ;
			$returning = ( $smof_data['general-ios_homescreen_popup-returning'] ) ? 'true' : 'false' ;
		
			$output .= '<script type="text/javascript">';
			
			$output .=		'var addToHomeConfig = {';
			$output .=		'	animationIn: "bubble",';
			$output .=		'	animationOut: "drop",';
			if ( $lifespan ) {
				$output .=	'	lifespan:' . $lifespan . ',';
			}
			if ( $expire ) {
				$output .=	'	expire:' . $expire . ',';
			}
			if ( $icon ) {
				$output .=	'	touchIcon:' . $icon . ',';
			}
			if ( $returning ) {
				$output .=	'	returningVisitor:' . $returning . ',';
			}
			if ( $message ) {
				$output .=	'	message:"' . $message . '"';
			}
			$output .=		'};';
			
			$output .= '</script>';
		
		}
		
		return $output;
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Google Analytics
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_googleanalytics_trackingcode' ) ) {

	function invicta_googleanalytics_trackingcode() {
		
		global $smof_data;
		
		$admin_logged_in = current_user_can('manage_options');
		
		$output = '';
		
		if ( $smof_data['general-google_analytics'] ) {
		
			if ( ! $admin_logged_in || ( $admin_logged_in && ! $smof_data['general-google_analytics-dont_track_administrator'] ) ) {
				$output .= $smof_data['general-google_analytics'];
			}
			
		}
		
		return $output;
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Custom JavaScript Code
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_custom_javascript' ) ) { 

	function invicta_custom_javascript() {
		
		global $smof_data;
		
		$output = '';
		
		if ( $smof_data['general-custom_javascript'] ) {
			
			$output .= '<script type="text/javascript">';
			$output .= 		'jQuery(document).ready(function($){';
			$output .= 			$smof_data['general-custom_javascript'];
			$output .= 		'});';
			$output .= '</script>';
			
		}
		
		return $output;
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Homepage Slideshow
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_homepage_slideshow' ) ) {

	function invicta_homepage_slideshow() {
	
		global $smof_data;
		
		$selected_slideshow = $smof_data['general-home_slideshow-slider'];
		
		if ( ( $selected_slideshow == 'default' ) || ( is_plugin_active( 'revslider/revslider.php' ) == false ) ) {
			
			echo '<div class="home_slideshow">';
			echo 	'<div class="default_slideshow">';
			echo 		'<div class="invicta_canvas">';
			echo 			'<img src="' . get_template_directory_uri() . '/styles/images/defaults/home_slideshow_slide.png" alt="" />';
			echo 		'</div>';
			echo 	'</div>';
			echo '</div>';
			
		}
		else {
		
			// get the slideshow type
			
			$slideshow_type = '';
			
			global $wpdb;
		
			$slideshow_info = $wpdb->get_results("SELECT id, title, alias, params FROM " . $wpdb->prefix . "revslider_sliders WHERE alias = '" . $selected_slideshow . "'");
			
			if ( $slideshow_info ) {
				$slideshow_params = json_decode( $slideshow_info[0]->params, true );
				$slideshow_type = $slideshow_params['slider_type'];	
			}
			
			echo '<div class="home_slideshow ' . esc_attr( $slideshow_type ) . '">';
			putRevSlider( $selected_slideshow );	
			echo '</div>';
		
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Page Slideshow
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_page_slideshow' ) ) {

	function invicta_page_slideshow() {
	
		$page_id = get_queried_object_id();
		$slider = get_post_meta( $page_id, '_invicta_page_slider', true );
		
		if ( $slider && is_plugin_active( 'revslider/revslider.php' ) ) {
			
			echo '<div class="page_slideshow">';
			putRevSlider( $slider );
			echo '</div>';
			
		}
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Page Image
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_page_image' ) ) {

	function invicta_page_image() {
		
		global $smof_data;
		
		if ( $smof_data['general-featured_images_pages'] ) {
		
			if ( $smof_data['general-featured_images_pages-paralax'] ) {
	
				$page_id = get_queried_object_id();	
				$image_id = get_post_thumbnail_id($page_id);
	
				if ( $image_id ) {
					$image_url = wp_get_attachment_image_src($image_id,'full', true);
					$image = $image_url[0];
				}
				else { 
					$image = '';
				}
				
				$height = $smof_data['general-featured_images_pages-paralax-height'];
				if ( ! is_numeric( $height ) ) {
					$height = 350;
				}
	
				if ( $image && ! is_single() ) {
					echo '<div class="page_image_paralax">';
					echo 	'<div class="image" style="background-image:url(' . $image . '); height:' . $height . 'px;"></div>';
					echo '</div>';
				}
				
			}
			else {
				
				$page_id = get_queried_object_id();	
				$image = get_the_post_thumbnail( $page_id );
				
				if ( $image && ! is_single() ) {
					echo '<div class="page_image_static">';
					echo 	$image;
					echo '</div>';
				}
				
			}
		
		}
			
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Related Projects
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_related_projects' ) ) {

	function invicta_related_projects( $project, $posts_per_page = 4 ) {
		
		global $smof_data;
		
		if ( $smof_data['portfolio-related_projects'] ) {
		
			// atts (general) setup
		
			$metadata = $smof_data['portfolio-related_projects-metadata'];
			$linking = 1;
			
			// atts (categories) setup 	
			
			$project_categories = wp_get_post_terms( $project->ID, 'invicta_portfolio_category' );
			
			$filtered_categories = array();
			foreach ( $project_categories as $category ) {
				$filtered_categories[] = $category->term_id;
			}
			
			if ( $filtered_categories ) {
				$filtered_categories = join( ',', $filtered_categories );
			}
			else {
				$filtered_categories = '';
			}
		
			// output
			
			$output = '';
			$shortcode_output = do_shortcode('[invicta_portfolio metadata="' . $metadata . '" filtered_categories="' . $filtered_categories . '" excluded_projects="' . $project->ID . '"]');
							
			$output .= '<div class="portfolio_related_projects">';
			
			if ( $shortcode_output ) {
				$output .= 		'<div class="invicta_heading_separator">';
				$output .=			'<div>' . __( 'Related Projects', 'invicta_dictionary' ) . '</div>';
				$output .= 		'</div>';
				$output .= 		$shortcode_output;	
			}
			$output .= '</div>';

			
			echo $output;
		
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Photo Categories Widget
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_photo_categories_widget' ) ) {

	function invicta_photo_categories_widget( $echo = 0 ) {
	
		$output = '';
		
		$sort_params = invicta_get_sorting_parameters_on_custom_post_types('photos');
		
		// get categories
		
		$categories = get_categories( array(
			'hierarchical' 	=> 0,
			'taxonomy'		=> 'invicta_photos_category'
		) );
		
		if ( $categories ) {
		
			$output .= '<div id="photo_category_filters" class="widget widget_categories widget_photos_categories">';
			$output .= 		'<ul>';
		
			// page-template
			if ( ! is_single() ) {
				
				$output .=		'<li class="cat-item cat-item-0 current-cat">';
				$output .=		    '<a href="#" class="active" data-filter="*">';
				$output .=		    	__( 'All Galleries', 'invicta_dictionary' );
				$output .=		    '</a>';
				$output .=			'<cite class="count"><i class="icon-chevron-right"></i></cite>';
				$output .=		'</li>';
				
				foreach ( $categories as $category ) {
				
					$output .=	'<li class="cat-item cat-item-' . $category->term_id . '">';
					$output .=		'<a href="' . get_term_link( $category ) . '" data-filter=".' . $category->slug . '">';
					$output .=			$category->name;
					$output .=		'</a>';
					$output .=		'<cite class="count"><i class="icon-chevron-right"></i></cite>';
					$output .=	'</li>';
				
				}
				
			} 
			// single page
			else {
			
				$photos_category = wp_get_post_terms( get_queried_object()->ID, 'invicta_photos_category' );
				if ( isset( $photos_category[0] ) ) { 
					$photos_category = $photos_category[0]->term_id;
				}
				else {
					$photos_category = 0;
				}
			
				foreach ( $categories as $category ) {
				
					$css_classes = array();
					$css_classes[] = 'cat-item';
					$css_classes[] = 'cat-item-' . $category->term_id;
					if ( $photos_category == $category->term_id ) {
						$css_classes[] = 'current-cat';
					}
				
					$output .=	'<li class="' . join( ' ', $css_classes ) . '">';
					$output .=		'<a href="#">';
					$output .=			$category->name;
					$output .=		'</a>';
					if ( $photos_category != $category->term_id ) {
						$output .=	'<cite class="count"><i class="icon-chevron-right"></i></cite>';
					}
					else {
						$output .=	'<cite class="count"><i class="icon-chevron-down"></i></cite>';	
					}
					
					// photo galleries for each category
					
					$photo_galleries_query = new WP_Query( array(
						'post_type'			=> 'invicta_photos',
						'posts_per_page'	=> -1,
						'orderby'			=> $sort_params['orderby'],
						'order'				=> $sort_params['order'],
						'tax_query'			=> array(
							array(
								'taxonomy'	=> 'invicta_photos_category',
								'field'		=> 'id',
								'terms'		=> $category->term_id
							)
						)
					) );
						
					if ( $photo_galleries_query->have_posts() ) {
					
						$output .=	'<ul class="children">';
						
						while ( $photo_galleries_query->have_posts() ) {
						
							$photo_galleries_query->the_post();
							
							$css_classes = array();
							$css_classes[] = 'post-item';
							if ( get_queried_object()->ID == get_the_ID() ) {
								$css_classes[] = 'current-cat';
							}
							
							$output .=		'<li class="' . join( ' ', $css_classes ) . '">';
							$output .=			'<a href="' . get_permalink( get_the_ID() ) . '" title="">';
							$output .=				get_the_title();
							$output .=			'</a>';
							if ( get_queried_object()->ID == get_the_ID() ) {
								$output .=		'<cite class="count"><i class="icon-chevron-right"></i></cite>';
							}
							$output .=		'</li>';
							
						}
						
						$output .=	'</ul>';
					
					}
					
					$output .=	'</li>';
				
				}
				
			}
			
			$output .= 		'</ul>';
			
			if ( is_single() ) {
				$output .= 		'<div class="tooltip">';
				$output .= 			__( 'Choose an album above to view their photos', 'invicta_dictionary' );
				$output .=		'</div>';		
			}
			else {
				$output .= 		'<div class="tooltip">';
				$output .= 			__( 'Choose a category above to view albums from that category', 'invicta_dictionary' );
				$output .=		'</div>';
			}
			
			$output .= '</div>';
			
			if ( is_single() ) {
				
				$output .= '<script type="text/javascript">';
				$output .=		'jQuery(document).ready(function($){';
				$output .=			'$("#photo_category_filters").invicta_photo_categories_widget_toggle()';
				$output .=		'});';
				$output .= '</script>';
				
			}
		
		}
			
		if ( $echo ) { echo $output; } else { return $output; }
		
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Comments Listing
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_comments_list' ) ) {

	function invicta_comments_list($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$GLOBALS['comment_depth'] = $depth;	
		?>
		<li id="comment-<?php comment_ID() ?>" <?php comment_class('entry'); ?>>
			<div class="media">
				<span class="invicta_avatar">
				<?php echo get_avatar( $comment, 200 ); ?>
				</span>
			</div>
			<div class="text">
			
				<div class="head">
				
					<span class="author">
						<span class="inherit-color-on_children accentcolor-text-on_children-on_hover"><?php echo get_comment_author_link(); ?></span>
						<span class="author_marker"><?php _e('Author', 'invicta_dictionary'); ?></span>
					</span>
					
					<span class="date">
						<i class="icon-time"></i>
						<?php echo get_comment_date('F j, Y'); ?>  (<?php echo get_comment_time('g:i a'); ?>)
					</span>
					
				</div>
		        <div class="body text_styles">
		        	<?php if ( $comment->comment_approved == '0' ) : ?>
		        		<em class="moderation">
		        			<i class="icon-warning-sign"></i>
		        			<?php _e('Your comment is awaiting moderation', 'invicta_dictionary') ?>
		        		</em>
		        	<?php endif; ?>
		        	<?php comment_text(); ?>
			        <?php
			            if($args['type'] == 'all' || get_comment_type() == 'comment') :
			                comment_reply_link(array_merge($args, array(
			                    'reply_text' => __('Reply to','invicta_dictionary') . ' ' . $comment->comment_author,
			                    'login_text' => __('Log in to reply.','invicta_dictionary'),
			                    'depth' => $depth,
			                    'before' => '<span class="reply"><i class="icon-pencil"></i>',
			                    'after' => '</span>'
			                )));
			            endif;
			        ?>
			        <?php edit_comment_link(__('Edit this comment', 'invicta_dictionary'), '<span class="edit"><i class="icon-cog"></i>', '</span>'); ?>
		        </div>
			</div>
			<div class="alignclear"></div>
		</li>
		<?php	
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Pings Listing
== ------------------------------------------------------------------- ==
*/

if ( ! function_exists( 'invicta_pings_list' ) ) {

	function invicta_pings_list($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
		$GLOBALS['comment_depth'] = $depth;	
		?>
		<li id="ping-<?php comment_ID() ?>" <?php comment_class('entry'); ?>>
			<span class="author">
				<?php echo get_comment_author_link(); ?>
			</span>
			<span class="date">
				<i class="icon-time"></i> 
				<?php echo get_comment_date('F j, Y'); ?>  (<?php echo get_comment_time('g:i a'); ?>)
			</span>
			<div class="body">
				<?php comment_text(); ?>
			</div>
			<?php edit_comment_link(__('Edit', 'invicta_dictionary'), '<span class="edit">', '</span>'); ?>	
		</li>
		<?php	
	}

}
	
?>