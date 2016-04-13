<?php 
/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Logic Hooks
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ WP Admin Bar - Extra Buttons
	@@ Translation
	@@ Post Thumbnails
	@@ Post Formats
	@@ WP Galleries
	@@ oEmbeds Filtering
	@@ Custom Menus
	@@ Content Width
	@@ Editor (TinyMCE) Style
	@@ Editor (TinyMCE) Style
	@@ Search Results
	@@ Sessions
	@@ Breadcrumb adjustment
	@@ Menu adjustment
	@@ Automatic Feed Links
	@@ Maintenance Mode
	@@ Admin Logo
	@@ Empty Search
	@@ WP Title
	@@ Post Video Ajax
	@@ Widgets
	@@ Body Classes
	@@ Post Classes
	@@ Post ReadMore

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

global $smof_data;

/*
== ------------------------------------------------------------------- ==
== @@ WP Admin Bar - Extra Buttons
== ------------------------------------------------------------------- ==
*/

add_action( 'wp_before_admin_bar_render', 'invicta_admin_bar_render' );

function invicta_admin_bar_render() {

    global $wp_admin_bar;
    
    $wp_admin_bar->add_menu( array(
        'parent' => false,
        'id' => 'new_media',
        'title' => __( 'Theme Options', 'invicta_dictionary' ),
        'href' => admin_url('themes.php?page=optionsframework')
    ));

}


/*
== ------------------------------------------------------------------- ==
== @@ Translation
== ------------------------------------------------------------------- ==
*/

add_action( 'after_setup_theme', 'invicta_language_setup' );

function invicta_language_setup() {
	
	$language_files_path = get_template_directory() . '/languages';
	load_theme_textdomain( 'invicta_dictionary', $language_files_path );
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Post Thumbnails
== ------------------------------------------------------------------- ==
*/

add_theme_support('post-thumbnails');
	
	
/*
== ------------------------------------------------------------------- ==
== @@ Post Formats
== ------------------------------------------------------------------- ==
*/	

add_theme_support( 'post-formats', array( 'video', 'audio', 'link', 'gallery', 'image', 'aside', 'quote', 'status' ) );


/*
== ------------------------------------------------------------------- ==
== @@ WP Galleries
== ------------------------------------------------------------------- ==
*/	

add_filter( 'use_default_gallery_style', '__return_false' );

add_filter( 'post_gallery', 'invicta_post_gallery_customization', 10, 2 );

function invicta_post_gallery_customization( $null, $attr ) {
	
	wp_enqueue_script('invicta_fancybox');
	
}


/*
== ------------------------------------------------------------------- ==
== @@ oEmbeds Filtering
== ------------------------------------------------------------------- ==
*/

add_filter( 'embed_oembed_html', 'invicta_oembed_html', 10, 4 );

function invicta_oembed_html( $html, $url, $attr, $post_id ) {
	
	// add fitvids to all embeded videos (iframe)
	if ( strpos( $html, '<iframe' ) !== false ) {
		$html = '<div class="invicta_fitvids">' . $html . '</div>';
	}
	
	return $html;
}
	
/*
== ------------------------------------------------------------------- ==
== @@ Custom Menus
== ------------------------------------------------------------------- ==
*/	
if ( function_exists('register_nav_menus') ) {
	register_nav_menu( 'main_menu', 'Main Menu' );
	register_nav_menu( 'footer_menu', 'Footer Menu<br/><small>(no child levels)</small>' );
}

/*
== ------------------------------------------------------------------- ==
== @@ Content Width
== ------------------------------------------------------------------- ==
*/

if ( ! isset( $content_width ) ) {
	$content_width = 940;
	}
	
/*
== ------------------------------------------------------------------- ==
== @@ Editor (TinyMCE) Style
== ------------------------------------------------------------------- ==
*/

add_editor_style( 'styles/editor.css' );


/*
== ------------------------------------------------------------------- ==
== @@ Search Results
== ------------------------------------------------------------------- ==
*/

add_action( 'pre_get_posts', 'invicta_search_filter' );

function invicta_search_filter( $query ) {

	if ( ! is_admin() && $query->is_main_query() ) {
		if ( $query->is_search ) {
		
			global $smof_data;

			switch ( $smof_data['general-search_results'] ) {
				
				case 'pages':
					$query->set( 'post_type', 'page' );
					break;
					
				case 'posts':
					$query->set( 'post_type', 'post' );
					break;
					
			}		
			
		}
	}
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Sessions
== ------------------------------------------------------------------- ==
*/

add_action( 'init', 'invicta_session_start' );

function invicta_session_start() {
	if ( ! is_admin() && ! session_id() ) {
		session_start();
	}
}


/*
== ------------------------------------------------------------------- ==
== @@ Breadcrumb adjustment
== ------------------------------------------------------------------- ==
*/	

add_filter( 'invicta_breadcrumb_trail', 'invicta_modify_breadcrumb' );
	
function invicta_modify_breadcrumb( $trail ) {
	
	if ( get_post_type() === 'invicta_portfolio' ) {
	
		$portfolio_page = '';
		$front_page = get_option('page_on_front');
		
		if ( session_id() && ! empty( $_SESSION['invicta_portfolio_page'] ) ) {
			$portfolio_page = $_SESSION['invicta_portfolio_page'];
		}
		
		if ( $portfolio_page ) {
		
			if ( $portfolio_page == $front_page ) {
			
				$new_trail[0] = $trail[0];
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
				
			}
			else {
		
				$new_trail = invicta_breadcrumb::get_parents( $portfolio_page, '' );
				array_unshift( $new_trail, $trail[0] );
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
			
			}
			
		}
		
	}
	
	elseif ( get_post_type() === 'invicta_photos' ) {
	
		$photos_page = '';
		$front_page = get_option('page_on_front');
		
		if ( session_id() && ! empty( $_SESSION['invicta_photos_page'] ) ) {
			$photos_page = $_SESSION['invicta_photos_page'];
		}
		
		if ( $photos_page ) {
		
			if ( $photos_page == $front_page ) {
			
				$new_trail[0] = $trail[0];
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
				
			}
			else {
		
				$new_trail = invicta_breadcrumb::get_parents( $photos_page, '' );
				array_unshift( $new_trail, $trail[0] );
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
			
			}
			
		}
		
	}
	
	elseif ( get_post_type() === 'invicta_videos' ) {
	
		$videos_page = '';
		$front_page = get_option('page_on_front');
		
		if ( session_id() && ! empty( $_SESSION['invicta_videos_page'] ) ) {
			$videos_page = $_SESSION['invicta_videos_page'];
		}
		
		if ( $videos_page ) {
		
			if ( $videos_page == $front_page ) {
			
				$new_trail[0] = $trail[0];
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
				
			}
			else {
		
				$new_trail = invicta_breadcrumb::get_parents( $videos_page, '' );
				array_unshift( $new_trail, $trail[0] );
				$new_trail['trail_end'] = $trail['trail_end'];
				$trail = $new_trail;
			
			}
			
		}
		
	}
	
	elseif ( is_attachment() ) {
		
		$new_trail[0] = $trail[0];
		$new_trail['trail_end'] = $trail['trail_end'];
		$trail = $new_trail;
		
	}
	
	elseif ( get_post_type() === 'post' && ( is_category() || is_archive() || is_tag() ) ) {
		
		$front_page = get_option('page_on_front');
		$blog_page = get_option('page_for_posts');
		
		if ( $front_page && $blog_page ) {
			$blog = '<a href="' . get_permalink( $blog_page ) . '" title="' . esc_attr( get_the_title( $blog_page ) ) . '">' . get_the_title( $blog_page ) . '</a>';
			array_splice( $trail, 1, 0, array( $blog ) );
		}
		
	}
	
	return $trail;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Menu adjustment
== ------------------------------------------------------------------- ==
*/	

add_filter( 'nav_menu_css_class', 'invicta_customize_wp_nav_menu_classes');

function invicta_customize_wp_nav_menu_classes( $classes ) {

	if ( get_post_type() === 'invicta_portfolio' ) {
		
		// remove the parent classes from menu
		$classes = array_filter( $classes, 'invicta_menu_remove_parent_classes' );
		
		$portfolio_page = '';
		if ( session_id() && ! empty( $_SESSION['invicta_portfolio_page'] ) ) {
			$portfolio_page = $_SESSION['invicta_portfolio_page'];
		}

		if ( $portfolio_page ) {
		
			global $wpdb;
			
			$portfolio_page_menu_item = $wpdb->get_var( 'SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_object_id" AND meta_value="' . $portfolio_page . '"' );
			
			if ( $portfolio_page_menu_item ) {
			
				$portfolio_page_parent_menu_item = $wpdb->get_var( 'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_menu_item_parent" AND post_id="' . $portfolio_page_menu_item . '"' );
			
				if ( in_array( 'menu-item-' . $portfolio_page_menu_item, $classes ) ) {
					$classes[] = 'current_page_parent';
				}
				
				if ( in_array( 'menu-item-' . $portfolio_page_parent_menu_item, $classes ) ) {
					$classes[] = 'current_page_ancestor';
				}
				
			}
		
		}
		
	}
	
	elseif ( get_post_type() === 'invicta_photos' ) {
		
		// remove the parent classes from menu
		$classes = array_filter( $classes, 'invicta_menu_remove_parent_classes' );
		
		$photos_page = '';
		if ( session_id() && ! empty( $_SESSION['invicta_photos_page'] ) ) {
			$photos_page = $_SESSION['invicta_photos_page'];
		}

		if ( $photos_page ) {
		
			global $wpdb;
			
			$photos_page_menu_item = $wpdb->get_var( 'SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_object_id" AND meta_value="' . $photos_page . '"' );
			
			if ( $photos_page_menu_item ) {
			
				$photos_page_parent_menu_item = $wpdb->get_var( 'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_menu_item_parent" AND post_id="' . $photos_page_menu_item . '"' );
			
				if ( in_array( 'menu-item-' . $photos_page_menu_item, $classes ) ) {
					$classes[] = 'current_page_parent';
				}
				
				if ( in_array( 'menu-item-' . $photos_page_parent_menu_item, $classes ) ) {
					$classes[] = 'current_page_ancestor';
				}
				
			}
		
		}
		
	}
	
	elseif ( get_post_type() === 'invicta_videos' ) {
		
		// remove the parent classes from menu
		$classes = array_filter( $classes, 'invicta_menu_remove_parent_classes' );
		
		$photos_page = '';
		if ( session_id() && ! empty( $_SESSION['invicta_videos_page'] ) ) {
			$photos_page = $_SESSION['invicta_videos_page'];
		}

		if ( $photos_page ) {
		
			global $wpdb;
			
			$photos_page_menu_item = $wpdb->get_var( 'SELECT post_id FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_object_id" AND meta_value="' . $photos_page . '"' );
			
			if ( $photos_page_menu_item ) {
			
				$photos_page_parent_menu_item = $wpdb->get_var( 'SELECT meta_value FROM ' . $wpdb->postmeta . ' WHERE meta_key="_menu_item_menu_item_parent" AND post_id="' . $photos_page_menu_item . '"' );
			
				if ( in_array( 'menu-item-' . $photos_page_menu_item, $classes ) ) {
					$classes[] = 'current_page_parent';
				}
				
				if ( in_array( 'menu-item-' . $photos_page_parent_menu_item, $classes ) ) {
					$classes[] = 'current_page_ancestor';
				}
				
			}
		
		}
		
	}
	
	elseif ( is_attachment() ) {
		$classes = array_filter( $classes, 'invicta_menu_remove_parent_classes' );
	}
	
	elseif ( is_404() ) {
		$classes = array_filter( $classes, 'invicta_menu_remove_parent_classes' );
	}
	
	return $classes;
	
}

function invicta_menu_remove_parent_classes( $class ) {
	
	if ( $class == 'current_page_item' || 
		 $class == 'current_page_parent' || 
		 $class == 'current_page_ancestor'  || 
		 $class == 'current-menu-item' ) 
	{
		return false;
	}
	else {
		return true;
	}
	
}


add_filter( 'wp_list_pages', 'invicta_customize_wp_page_menu_classes', 0 );

function invicta_customize_wp_page_menu_classes( $wp_list_pages ) { 

	if ( get_post_type() === 'invicta_portfolio' || get_post_type() === 'invicta_photos' || get_post_type() === 'invicta_videos' || is_attachment() || is_404() ) {
	
		$pattern = '/\<li class="page_item[^>]*>/';
		$replace_with = '<li>';
		$wp_list_pages = preg_replace( $pattern, $replace_with, $wp_list_pages );
	}
	
	return $wp_list_pages;
}


/*
== ------------------------------------------------------------------- ==
== @@ Automatic Feed Links
== ------------------------------------------------------------------- ==
*/	

add_theme_support( 'automatic-feed-links' );



/*
== ------------------------------------------------------------------- ==
== @@ Maintenance Mode
== ------------------------------------------------------------------- ==
*/	

if ( ! is_admin() &&  ! ( in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) ) ) ) {
	add_action( 'init', 'invicta_maintenance_mode', 99 );
}

function invicta_maintenance_mode() {
	
	global $smof_data;
	
	if ( $smof_data['maintenance-status'] ) {
		if ( ! current_user_can( 'edit_pages' ) || ! is_user_logged_in() ) { 
			include( get_template_directory() . '/503.php' );
			exit();
		}			
	}

}


/*
== ------------------------------------------------------------------- ==
== @@ Admin Logo
== ------------------------------------------------------------------- ==
*/	

add_action( 'login_enqueue_scripts', 'invicta_custom_admin_logo' );

function invicta_custom_admin_logo() {
	
	global $smof_data;
	
	$admin_logo = $smof_data['branding-logo_admin'];
	
	if ( $admin_logo ) {
	
		$max_width = 323;
		$max_height = 67;
		
		echo '<style type="text/css">';
		echo     'body.login div#login h1 a {';
		echo         'background-image: url(' . $admin_logo . ');';
		echo         'margin-bottom:20px;';
		echo         'background-size:contain;';
		echo 		 'width:100%;';
		echo     '}';
		echo '</style>';
		
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Empty Search
== ------------------------------------------------------------------- ==
*/	
	
add_filter( 'pre_get_posts', 'invicta_search_results_filter' );
	
function invicta_search_results_filter( $query ) {

    // If 's' request variable is set but empty
    if ( isset( $_GET['s'] ) && empty( $_GET['s'] ) && $query->is_main_query() ) {
		$query->is_search = true;
        $query->is_home = false;
    }
    
    return $query;
    
}	
	
/*
== ------------------------------------------------------------------- ==
== @@ WP Title
== ------------------------------------------------------------------- ==
*/

add_filter( 'wp_title', 'invicta_filter_wp_title' );

function invicta_filter_wp_title( $title ) {

	global $page, $paged;

	if ( is_feed() )
		return $title;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_front_page() ) ) ? ' - ' . $site_description : '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s', 'invicta_dictionary' ), max( $paged, $page ) ) : '';

	return $filtered_title;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Widgets
== ------------------------------------------------------------------- ==
*/

add_filter( 'widget_text', 'do_shortcode' );

/*
== ------------------------------------------------------------------- ==
== @@ Body Classes
== ------------------------------------------------------------------- ==
*/

add_filter( 'body_class', 'invicta_body_extra_classes' );

function invicta_body_extra_classes( $classes ) {
	
	$theme_info = wp_get_theme();
	$theme_info_name = $theme_info->get( 'Name' );
	$theme_info_version = $theme_info->get( 'Version' );
	
	$theme_info_class = strtolower( $theme_info_name . '-ver-' . str_replace( '.', '_', $theme_info_version ) );
	
	$classes[] = esc_attr( $theme_info_class );
	
	return $classes;
}

/*
== ------------------------------------------------------------------- ==
== @@ Post Classes
== ------------------------------------------------------------------- ==
*/

add_filter( 'post_class', 'invicta_post_extra_classes' );

function invicta_post_extra_classes( $classes ) {
	
	global $post;
	
	$post_format = get_post_format( $post->ID );
	
	if ( false === $post_format ) {
		$post_format = 'standard';
	}
	
	switch ( $post_format ) {
		case 'chat':
		case 'gallery':
		case 'image':
		case 'standard':
		case 'video':
		case 'audio':
			$classes[] = esc_attr( 'invicta_simple_style_entry' );
			break;
		case 'link':
		case 'status':
		case 'quote':
		case 'aside':
			$classes[] = esc_attr( 'invicta_complex_style_entry' );
			break;
	}
	
	return $classes;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Post ReadMore
== ------------------------------------------------------------------- ==
*/

add_filter( 'the_content_more_link', 'invicta_remove_more_jump_link' );

function invicta_remove_more_jump_link( $link ) {

	global $smof_data;
	
	if ( isset( $smof_data['header-fixed'] ) && $smof_data['header-fixed'] ) {
	
		$offset = strpos( $link, '#more-' );
		
		if ( $offset ) {
			$end = strpos( $link, '"', $offset );
		}
		if ( $end ) {
			$link = substr_replace( $link, '', $offset, $end-$offset );
		}
	
	}
	
	return $link;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Responsiveness Status on Visual Composer
== ------------------------------------------------------------------- ==
*/

add_filter( 'body_class', 'invicta_vc_responsiveness_status', 11 );

function invicta_vc_responsiveness_status( $classes ) {
	
	global $smof_data;
	
	if ( ! $smof_data['general-responsiveness'] ) { 
		$classes[] = 'vc_non_responsive';
		$classes = array_diff( $classes, array('vc_responsive') );		
	}

	return $classes;
	
}

?>