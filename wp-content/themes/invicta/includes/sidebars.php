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

	@@ Sidebar Registering
	@@ Sidebar Generator
	@@ Manual Widgets
	@@ Default widgets customizing

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

/*
== ------------------------------------------------------------------- ==
== @@ Sidebar Registering
== ------------------------------------------------------------------- ==
*/
	
/**
* If in the future any Sidebar name needs to be changed
* I have to update all its dependencies:
* 	- /sidebar.php
* 	- /includes/metaboxes.php
**/	

global $smof_data;

register_sidebar(array(
	'id' 			=> 'global_sidebar',
	'name' 			=> "Global Sidebar",
	'description' 	=> "The widgets in this area will be show in all page's sidebars",
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div>',
	'before_title' 	=> '<h3 class="widget_title">',
	'after_title' 	=> '</h3>',
	));
	
register_sidebar(array(
	'id' 			=> 'page_sidebar',
	'name' 			=> "Page Sidebar",
	'description' 	=> "",
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div>',
	'before_title' 	=> '<h3 class="widget_title">',
	'after_title' 	=> '</h3>',
	));
	
register_sidebar(array(
	'id' 			=> 'blog_sidebar',
	'name' 			=> "Blog Sidebar",
	'description' 	=> "",
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div>',
	'before_title' 	=> '<h3 class="widget_title">',
	'after_title' 	=> '</h3>',
	));
	
register_sidebar(array(
	'id' 			=> 'photos_sidebar',
	'name' 			=> "Photos Sidebar",
	'description' 	=> "",
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' 	=> '</div>',
	'before_title' 	=> '<h3 class="widget_title">',
	'after_title' 	=> '</h3>',
	));
	
if ( class_exists( 'woocommerce' ) ) {
	
	register_sidebar(array(
		'id' 			=> 'shop_sidebar',
		'name' 			=> "Shop Sidebar",
		'description' 	=> "",
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' 	=> '</div>',
		'before_title' 	=> '<h3 class="widget_title">',
		'after_title' 	=> '</h3>',
		));
	
}	
	
if ( isset( $smof_data['footer-columns'] ) && is_numeric( $smof_data['footer-columns'] ) ) {
	
	for ( $i = 1; $i <= $smof_data['footer-columns']; $i ++ ) {
	
		register_sidebar(array(
			'id' 			=> 'blog_sidebar_' . $i,
			'name' 			=> "Footer Sidebar " . $i,
			'description' 	=> "",
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>',
			'before_title' 	=> '<h3 class="widget_title">',
			'after_title' 	=> '</h3>',
			));
		
	}
	
}
	
/*
== ------------------------------------------------------------------- ==
== @@ Sidebar Generator
== ------------------------------------------------------------------- ==
*/

new invicta_sidebar_generator();



/*
== ------------------------------------------------------------------- ==
== @@ Manual Widgets
== ------------------------------------------------------------------- ==
*/

function invicta_manual_widget( $widget_id, $echo = true ) {
	
	$output = '';

	switch ( $widget_id ) {
		
		case 1 : // search form
		
			// we have to use ouput buffering since its a bug in wordpress
			// the $echo parameter is ignored when searchform.php is present.
			// there is a issue in the WordPress Trac concerning this.
			ob_start(); 
			get_search_form();
			$search_form_html = ob_get_clean();
			
			$output .= '<div class="widget widget_search">';
			$output .= 		$search_form_html;
			$output .= '</div>';
			
			break;
			
		case 2 : // pages
		
			$output .= '<div class="widget widget_pages">';
			$output .= 		'<h3 class="widget_title">' . __( 'Pages', 'invicta_dictionary' ) . '</h3>';
			$output .= 		'<ul>';
			$output .= 			wp_list_pages('title_li=&depth=-1&echo=0');
			$output .= 		'</ul>';
			$output .= '</div>';	
			
			break;
			
		case 3 : // categories
		
			$output .= '<div class="widget widget_categories">';
			$output .= 		'<h3 class="widget_title">' . __( 'Categories', 'invicta_dictionary' ) . '</h3>';
			$output .= 		'<ul>';
			$output .= 			wp_list_categories('sort_column=name&optioncount=0&hierarchical=0&title_li=&echo=0');
			$output .= 		'</ul>';
			$output .= '</div>';
			
			break;
			
		case 4 : // archive
		
			$output .= '<div class="widget widget_archive">';
			$output .= 		'<h3 class="widget_title">' . __( 'Archive', 'invicta_dictionary' ) . '</h3>';
			$output .= 		'<ul>';
			$output .= 			wp_get_archives('type=monthly&echo=0');
			$output .= 		'</ul>';
			$output .= '</div>';
			
			break;
			
		case 5 : // about us
		
			$social_links_data = array();
			$social_links_data[] = array( 'id' => 'twitter', 'url' => 'http://twitter.com/oitentaecinco' );
			$social_links_data[] = array( 'id' => 'facebook', 'url' => 'http://www.facebook.com/oitentaecinco' );
			$social_links_data[] = array( 'id' => 'linkedin', 'url' => 'www.linkedin.com/oitentaecinco' );
			$social_links_data[] = array( 'id' => 'dribbble', 'url' => 'www.dribbble.com/oitentaecinco' );
			$social_links_data[] = array( 'id' => 'skype', 'url' => 'pedro.oitentaecinco' );
			$social_links_data[] = array( 'id' => 'googleplus', 'url' => 'http://plus.google.com/oitentaecinco' );
			$social_links_data[] = array( 'id' => 'pinterest', 'url' => 'http://pinterest.com/oitentaecinco' );
			$args = array(
				'target'	=> '_blank',
				'data'		=> $social_links_data
			);
			$social_links = new invicta_social_links( $args );
		
			$output .= '<div class="widget widget_about_manual">';
			$output .= 		'<h3 class="widget_title">' . __( 'About Us', 'invicta_dictionary' ) . '</h3>';
			$output .= 		'<div class="text_styles">';
			$output .= 			'<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam.</p>';
			$output .=		'</div>';
			$output .=  	'<div>' . $social_links->get_html() . '</div>';
			$output .= 		'<div class="map">';
			$output .=			'<img src="' . get_template_directory_uri() . '/styles/images/defaults/about_map_small.png" alt="Where we are" />';
			$output .= 		'</div>';
			$output .= '</div>';
			
			break;
			
		case 6 : // contacts
		
			$invicta_contacts_shortcode  = '[invicta_contacts';
			$invicta_contacts_shortcode .= 		' title="Contacts"';
			$invicta_contacts_shortcode .= 		' intro="Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy."';
			$invicta_contacts_shortcode .= 		' address="Oitentaecinco Tower St. 158-56<br/>Porto, 4460, Portugal"';
			$invicta_contacts_shortcode .= 		' phone="+351 223 345 234,+351 223 345 236"';
			$invicta_contacts_shortcode .= 		' mobile="+351 910 345 234,+351 910 345 235"';
			$invicta_contacts_shortcode .= 		' email="commercial@oitentaecinco.com, support@oitentaecinco.com"';
			$invicta_contacts_shortcode .= 		' google_map="http://goo.gl/maps/b1Fyg"';
			$invicta_contacts_shortcode .= 		'';
			$invicta_contacts_shortcode .= 		'';
			$invicta_contacts_shortcode .= ']';
		
			$output .= do_shortcode( $invicta_contacts_shortcode );
			
			break;
			
		case 7 : // latest posts
		
			global $wp_widget_factory;
			
			$instance = array(
				'count' => 6,
				'show_photo' => false
			);
			
			$args = array(
				'before_widget' => '<div class="widget widget_recent_posts_manual">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h3 class="widget_title">',
				'after_title' 	=> '</h3>',
			);
			
			ob_start();
			the_widget( 'invicta_latest_posts_widget', $instance, $args);
			$output = ob_get_contents();
			ob_end_clean();
			
			break;
			
		case 8 : // photo categories
		
			$output = invicta_photo_categories_widget();
			
			break;
		
	}
	
	if ( $echo ) { echo $output; } else { return $output; }
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Default widgets customizing
== ------------------------------------------------------------------- ==
*/

/* tags */

function invicta_tagcloud_filter( $content ) {
	$new_content = '<div class="invicta_tags accentcolor-border-on_children accentcolor-background-on_children-on_hover">' . $content . '</div>';
	return $new_content;
}   
add_filter('wp_tag_cloud', 'invicta_tagcloud_filter');

/* archive */

function invicta_archive_filter( $content ) {

	if ( strpos( $content, '&nbsp;(' ) !== false ) {
	    // 'show_post_counts' is active
		$new_content = str_replace( "&nbsp;" , "&nbsp;<cite class='count'>", $content );
		$new_content = str_replace( "</li>" , "</cite></li>", $new_content );
	}
	else {
		$new_content = $content;
	}

	return $new_content;
	
}   
add_filter('get_archives_link', 'invicta_archive_filter');

/* categories */

function invicta_categories_filter( $content ) {

	if ( strpos( $content, '</a> (' ) !== false ) {
		// 'show_post_counts' is active
		$new_content = str_replace( "</a> (" , "</a> <cite class='count'>(", $content );
		$new_content = str_replace( ")" , ")</cite>", $new_content );
	}
	else {
		$new_content = $content;
	}	

	return $new_content;

}
add_filter( 'wp_list_categories', 'invicta_categories_filter' );

?>
