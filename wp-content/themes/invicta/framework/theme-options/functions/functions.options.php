<?php

/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

OPTIONS INDEX:

	@@ General Tab
	@@ Branding Tab
	@@ Styling Tab
	@@ Header Tab
	@@ Footer Tab
	@@ Sidebars
	@@ Icons Tab
	@@ Typography Tab
	@@ Blog Tab
	@@ Portfolio Tab
	@@ Photo Galleries Tab
	@@ Videos Tab
	@@ Social Services Tab
	@@ Maintenance Mode Tab
	@@ Backup Options Tab

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/


add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{

		// Set the Options Array
		global $of_options;
		$of_options = array();


		/* homepage slideshows */
		
		$homepage_slideshows = array();
		$homepage_slideshows['default'] = __( 'Default Slideshow', 'invicta_dictionary' );
		
		if ( function_exists('is_plugin_active') ) {
			if ( is_plugin_active( 'revslider/revslider.php' ) ) {
			
				global $wpdb;
				
				$revsliders_data = $wpdb->get_results( 'SELECT id, title, alias FROM ' . $wpdb->prefix . 'revslider_sliders ORDER BY id ASC LIMIT 100' );
				
				if ( $revsliders_data ) {
					foreach ( $revsliders_data as $slider ) {
						$homepage_slideshows[ $slider->alias ] = $slider->alias;
					}
				}
				
			}
		}
		
		/* background patterns */
		$patterns_path = get_template_directory(). '/styles/images/patterns/';
		$patterns_url = get_template_directory_uri() . '/styles/images/patterns/';
		
		$patterns = array();
		
		if ( is_dir( $patterns_path ) ) {
			if ( $patterns_dir = opendir( $patterns_path ) ) {
				while ( ( $pattern_file = readdir($patterns_dir)) !== false ) {
		            if( stristr( $pattern_file, ".png" ) !== false || stristr( $pattern_file, ".jpg" ) !== false ) {
		            	natsort( $patterns ); //Sorts the array into a natural order
		                $patterns[] = $patterns_url . $pattern_file;
		            }
		        } 
			}
		}


/*
== ------------------------------------------------------------------- ==
== @@ General Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array(
	"name" 		=> __( "General", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
			
	$of_options[] = array(
		"name" 		=> __( "Front Page Slideshow", "invicta_dictionary" ),
		"desc" 		=> __( "Display slideshow on FrontPage", "invicta_dictionary") ,
		"id" 		=> "general-home_slideshow",
		"std" 		=> "1",
		"type" 		=> "switch",
		"folds"		=> 1
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc"		=> sprintf( __( "Specify the slideshow to be displayed on the front page. You can create and manage slideshows under the %sRevolution Slider%s panel", "invicta_dictionary" ), "<a href='admin.php?page=revslider'>", "</a>" ),
			"id" 		=> "general-home_slideshow-slider",
			"std" 		=> "default",
			"type" 		=> "select",
			"options"	=> $homepage_slideshows,
			"fold"		=> "general-home_slideshow"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Breadcrumb", "invicta_dictionary" ),
		"desc" 		=> __( "Show the breadcrumb trail on the page title", "invicta_dictionary" ),
		"id" 		=> "general-breadcrumb",
		"std" 		=> "1",
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( 'Custom prefix eg.: <strong>"You are here:"</strong>', 'invicta_dictionary' ),
			"id" 		=> "general-breadcrumb-prefix",
			"std" 		=> "",
			"fold"		=> "general-breadcrumb",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( 'Separator', 'invicta_dictionary' ),
			"id" 		=> "general-breadcrumb-separator",
			"std" 		=> "/",
			"fold"		=> "general-breadcrumb",
			"type" 		=> "text"
			);
	
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( 'Home Node Name', 'invicta_dictionary' ),
			"id" 		=> "general-breadcrumb-home_name",
			"std" 		=> "Home",
			"fold"		=> "general-breadcrumb",
			"type" 		=> "text"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Comments on Pages", "invicta_dictionary" ),
		"desc" 		=> __( "Allow comments on pages", "invicta_dictionary") ,
		"id" 		=> "general-comments_pages",
		"std" 		=> "0",
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Featured Images on Pages", "invicta_dictionary" ),
		"desc" 		=> __( "Show Featured Images on pages", "invicta_dictionary") ,
		"id" 		=> "general-featured_images_pages",
		"std" 		=> "0",
		"type" 		=> "switch",
		"folds"		=> 1
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Use Parallax Effect", "invicta_dictionary" ),
			"id" 		=> "general-featured_images_pages-paralax",
			"std" 		=> 0,
			"type" 		=> "checkbox",
			"fold"		=> "general-featured_images_pages"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Parallax Image Height (px)", "invicta_dictionary" ),
				"id" 		=> "general-featured_images_pages-paralax-height",
				"std" 		=> "350",
				"type" 		=> "text",
				"fold"		=> "general-featured_images_pages"
				);
		
	$of_options[] = array(
		"name" 		=> __( "Scroll to Top Button", "invicta_dictionary" ),
		"desc" 		=> __( "Show a scroll to top button at the right-bottom corner of the page", "invicta_dictionary") ,
		"id" 		=> "general-scroll_top_top",
		"std" 		=> "1",
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Search Results", "invicta_dictionary" ),
		"desc" 		=> __( "Choose which type of content you want to display on search results page", "invicta_dictionary" ),
		"id" 		=> "general-search_results",
		"std" 		=> "opt_id",
		"type" 		=> "select",
		"options"	=> array(
			'all'	=> 'All',
			'pages'			=> __( 'Only Pages', "invicta_dictionary" ),
			'posts'			=> __( 'Only Posts', "invicta_dictionary" ),
			)
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Highlight search keywords", "invicta_dictionary" ),
			"id" 		=> "general-search_results-highlight",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Responsiveness", "invicta_dictionary" ),
		"desc" 		=> __( "Activate Responsive Design Features", "invicta_dictionary") ,
		"id" 		=> "general-responsiveness",
		"std" 		=> "1",
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "iOS Add to HomeScreen Popup", "invicta_dictionary" ),
		"desc" 		=> __( "Activate the floating balloon inviting the users to add your website to the home screen on iOS devices", "invicta_dictionary") ,
		"id" 		=> "general-ios_homescreen_popup",
		"std" 		=> "1",
		"type" 		=> "switch",
		"folds"		=> 1
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Define the message to display within the balloon", "invicta_dictionary" ),
			"id" 		=> "general-ios_homescreen_popup-message",
			"std" 		=> __( "Add this website as an App on your <strong>%device</strong>: tap %icon and then Add to Home Screen", 'invicta_dictionary' ),
			"type" 		=> "textarea",
			"fold"		=> "general-ios_homescreen_popup"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Milliseconds to wait before hiding the message", "invicta_dictionary" ),
			"id" 		=> "general-ios_homescreen_popup-lifespan",
			"std" 		=> "2000",
			"type" 		=> "text",
			"fold"		=> "general-ios_homescreen_popup"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Minutes before displaying the message again (0 = Show Always)", "invicta_dictionary" ),
			"id" 		=> "general-ios_homescreen_popup-expire",
			"std" 		=> "5",
			"type" 		=> "text",
			"fold"		=> "general-ios_homescreen_popup"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show the message to returning visitors only", "invicta_dictionary" ),
			"id" 		=> "general-ios_homescreen_popup-returning",
			"std" 		=> 1,
			"type" 		=> "checkbox",
			"fold"		=> "general-ios_homescreen_popup"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Display the application icon next to the message", "invicta_dictionary" ),
			"id" 		=> "general-ios_homescreen_popup-icon",
			"std" 		=> 0,
			"type" 		=> "checkbox",
			"fold"		=> "general-ios_homescreen_popup"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Custom JavaScript Code", "invicta_dictionary" ),
		"desc" 		=> __( "Add here your custom JavaScript code", "invicta_dictionary" ),
		"id" 		=> "general-custom_javascript",
		"std" 		=> "",
		"type" 		=> "textarea"
		);
					
	$of_options[] = array(
		"name" 		=> __( "Google Analytics Tracking Code", "invicta_dictionary" ),
		"desc" 		=> __( "Add here your Google Analytics tracking code", "invicta_dictionary" ),
		"id" 		=> "general-google_analytics",
		"std" 		=> "",
		"type" 		=> "textarea"
		);
		
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Don't track logged-in-administrator activity", "invicta_dictionary" ),
		"id" 		=> "general-google_analytics-dont_track_administrator",
		"std" 		=> 1,
		"type" 		=> "checkbox"
		);

/*
== ------------------------------------------------------------------- ==
== @@ Branding Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array(
	"name" 		=> __( "Branding", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Main Logo", "invicta_dictionary" ),
		"desc" 		=> __( "Upload your logo to display in the header", "invicta_dictionary" ),
		"id" 		=> "branding-logo_main",
		"std" 		=> "",
		"type" 		=> "upload"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Logo (Retina Version @2x)", "invicta_dictionary" ),
		"desc" 		=> __( "Please choose an image file for the retina version of the logo. It should be 2x the size of main logo.", "invicta_dictionary" ),
		"id" 		=> "branding-logo_main_retina",
		"std" 		=> "",
		"type" 		=> "upload"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Favicon", "invicta_dictionary" ),
		"desc" 		=> __( "The icon (.ico) could have both retina (32x32px) and non-retina (16x16px) versions embedded", "invicta_dictionary" ),
		"id" 		=> "branding-favicon",
		"std" 		=> "",
		"type" 		=> "upload"
		);
		
	$of_options[] = array(
		"name" 		=> __( "iOS Home Screen Icon", "invicta_dictionary" ),
		"desc" 		=> __( "iPhone<br/>(57x57 px)", "invicta_dictionary" ),
		"id" 		=> "branding-ios_home_icon-iphone",
		"std" 		=> "",
		"type" 		=> "upload"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "iPad<br/>(72x72 px)", "invicta_dictionary" ),
			"id" 		=> "branding-ios_home_icon-ipad",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "iPhone & iPad (Retina Display)<br/>(114x114 px)", "invicta_dictionary" ),
			"id" 		=> "branding-ios_home_icon-iphone_ipad_retina",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Add Reflective Shine Effect", "invicta_dictionary" ),
			"id" 		=> "branding-ios_home_icon-shine_effect",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Admin Logo", "invicta_dictionary" ),
		"desc" 		=> __( "Upload your logo to display in the WordPress login page.<br/>Recommended size: 323x67px", "invicta_dictionary" ),
		"id" 		=> "branding-logo_admin",
		"std" 		=> "",
		"type" 		=> "upload"
		);
		
/*
== ------------------------------------------------------------------- ==
== @@ Styling Tab
== ------------------------------------------------------------------- ==
*/
	
$of_options[] = array(
	"name" 		=> __( "Styling", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
		
	$of_options[] = array(
		"name" 		=> __( "Boxed Layout", "invicta_dictionary" ),
		"desc" 		=> "",
		"id" 		=> "styling-boxed_layout",
		"std" 		=> "0",
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> __( "Boxed Layout > Vertical Margin", "invicta_dictionary" ),
			"desc" 		=> "",
			"id" 		=> "styling-boxed_layout-vertical_margin",
			"std" 		=> "0",
			"min"		=> "0",
			"max"		=> "100",
			"step"		=> "10",
			"type" 		=> "sliderui",
			"fold"		=> "styling-boxed_layout",
			);
		
		$of_options[] = array(
			"name" 		=> __( "Boxed Layout > Drop Shadow", "invicta_dictionary" ),
			"desc" 		=> __( "Show Drop-Shadow", "invicta_dictionary" ),
			"id" 		=> "styling-boxed_layout-drop_shadow",
			"std" 		=> 1,
			"fold"		=> "styling-boxed_layout",
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> __( "Boxed Layout > Background Color", "invicta_dictionary" ),
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-boxed_layout-background_color",
			"std" 		=> "#e2e2e2",
			"fold"		=> "styling-boxed_layout",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> __( "Boxed Layout > Background Pattern", "invicta_dictionary" ),
			"desc" 		=> "",
			"id" 		=> "styling-boxed_layout-background_pattern",
			"std" 		=> $patterns_url . "0-none.png",
			"type" 		=> "tiles",
			"fold"		=> "styling-boxed_layout",
			"options" 	=> $patterns,
			);
			
		$of_options[] = array(
			"name" 		=> __( "Boxed Layout > Background Image", "invicta_dictionary" ),
			"desc" 		=> __( "If you specify a background image, it will overload the background pattern", "invicta_dictionary" ),
			"id" 		=> "styling-boxed_layout-background_image",
			"std" 		=> "",
			"fold"		=> "styling-boxed_layout",
			"type" 		=> "upload"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Repeat", "invicta_dictionary" ),
				"id" 		=> "styling-boxed_layout-background_repeat",
				"std" 		=> "fullscreen",
				"type" 		=> "select",
				"fold"		=> "styling-boxed_layout",
				"options"	=> array(
					'no-repeat'		=> __( 'No Repeat', 'invicta_dictionary'),
					'repeat'		=> __( 'Repeat', 'invicta_dictionary'),
					'repeat-y'		=> __( 'Tile Vertically', 'invicta_dictionary'),
					'repeat-x'		=> __( 'Tile Horizontally', 'invicta_dictionary'),
					'fullscreen'	=> __( 'Stretch Fullscreen', 'invicta_dictionary'),
					)
				);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Attachment", "invicta_dictionary" ),
				"id" 		=> "styling-boxed_layout-background_attachment",
				"std" 		=> "scroll",
				"type" 		=> "select",
				"fold"		=> "styling-boxed_layout",
				"options"	=> array(
					'scroll'	=> __( 'Scroll', 'invicta_dictionary'),
					'fixed'		=> __( 'Fixed', 'invicta_dictionary'),
					)
				);
				
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Position", "invicta_dictionary" ),
				"id" 		=> "styling-boxed_layout-background_position",
				"std" 		=> "center center",
				"type" 		=> "select",
				"fold"		=> "styling-boxed_layout",
				"options"	=> array(
					'top left'			=> __( 'Top Left', 'invicta_dictionary'),
					'top center'		=> __( 'Top Center', 'invicta_dictionary'),
					'top right'			=> __( 'Top Right', 'invicta_dictionary'),
					'bottom left'		=> __( 'Bottom Left', 'invicta_dictionary'),
					'bottom center'		=> __( 'Bottom Center', 'invicta_dictionary'),
					'bottom right'		=> __( 'Bottom Right', 'invicta_dictionary'),
					'center left'		=> __( 'Center Left', 'invicta_dictionary'),
					'center center'		=> __( 'Center Center', 'invicta_dictionary'),
					'center right'		=> __( 'Center Right', 'invicta_dictionary'),
					)
				);
				
	$of_options[] = array(
		"name" 		=> __( "Base Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Background Color", "invicta_dictionary" ),
		"id" 		=> "styling-colors-main-background",
		"std" 		=> "#FFFFFF",
		"type" 		=> "color"
		);
				
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-main-background_alternate",
			"std" 		=> "#fafafa",
			"type" 		=> "color"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-main-text",
			"std" 		=> "#737373",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-main-text_alternate",
			"std" 		=> "#b2b2b2",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Titles", "invicta_dictionary" ),
			"id" 		=> "styling-colors-main-text_titles",
			"std" 		=> "#282828",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Accent Color", "invicta_dictionary" ),
			"id" 		=> "colors-accent",
			"std" 		=> "#fb652b",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Graphics Color (icons, borders, tables, etc)", "invicta_dictionary" ),
			"id" 		=> "styling-colors-main-graphics",
			"std" 		=> "#e3e3e3",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Pattern", "invicta_dictionary" ),
			"id" 		=> "styling-background-main-pattern",
			"std" 		=> $patterns_url . "0-none.png",
			"type" 		=> "tiles",
			"options" 	=> $patterns,
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Image", "invicta_dictionary" ),
			"id" 		=> "styling-background-main-image",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Repeat", "invicta_dictionary" ),
				"id" 		=> "styling-background-main-repeat",
				"std" 		=> "repeat",
				"type" 		=> "select",
				"options"	=> array(
					'no-repeat'		=> __( 'No Repeat', 'invicta_dictionary'),
					'repeat'		=> __( 'Repeat', 'invicta_dictionary'),
					'repeat-y'		=> __( 'Tile Vertically', 'invicta_dictionary'),
					'repeat-x'		=> __( 'Tile Horizontally', 'invicta_dictionary')
					)
				);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Attachment", "invicta_dictionary" ),
				"id" 		=> "styling-background-main-attachment",
				"std" 		=> "scroll",
				"type" 		=> "select",
				"options"	=> array(
					'scroll'	=> __( 'Scroll', 'invicta_dictionary'),
					'fixed'		=> __( 'Fixed', 'invicta_dictionary'),
					)
				);
				
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Position", "invicta_dictionary" ),
				"id" 		=> "styling-background-main-position",
				"std" 		=> "center center",
				"type" 		=> "select",
				"options"	=> array(
					'top left'			=> __( 'Top Left', 'invicta_dictionary'),
					'top center'		=> __( 'Top Center', 'invicta_dictionary'),
					'top right'			=> __( 'Top Right', 'invicta_dictionary'),
					'bottom left'		=> __( 'Bottom Left', 'invicta_dictionary'),
					'bottom center'		=> __( 'Bottom Center', 'invicta_dictionary'),
					'bottom right'		=> __( 'Bottom Right', 'invicta_dictionary'),
					'center left'		=> __( 'Center Left', 'invicta_dictionary'),
					'center center'		=> __( 'Center Center', 'invicta_dictionary'),
					'center right'		=> __( 'Center Right', 'invicta_dictionary'),
					)
				);
			
		
			
	$of_options[] = array(
		"name" 		=> __( "Header Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-header",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-background",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#FFFFFF",
			"type" 		=> "color"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-background_alternate",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#fdfdfd",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-text",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#737373",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-text_alternate",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#b2b2b2",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Borders Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-border",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#e8e8e8",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Top Border Line Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-header-top_border_line",
			"fold"		=> "styling-colors-header",
			"std" 		=> "#424242",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Pattern", "invicta_dictionary" ),
			"id" 		=> "styling-background-header-pattern",
			"fold"		=> "styling-colors-header",
			"std" 		=> $patterns_url . "0-none.png",
			"type" 		=> "tiles",
			"options" 	=> $patterns,
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Image", "invicta_dictionary" ),
			"id" 		=> "styling-background-header-image",
			"fold"		=> "styling-colors-header",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Repeat", "invicta_dictionary" ),
				"id" 		=> "styling-background-header-repeat",
				"std" 		=> "repeat-x",
				"type" 		=> "select",
				"fold"		=> "styling-colors-header",
				"options"	=> array(
					'no-repeat'		=> __( 'No Repeat', 'invicta_dictionary'),
					'repeat'		=> __( 'Repeat', 'invicta_dictionary'),
					'repeat-y'		=> __( 'Tile Vertically', 'invicta_dictionary'),
					'repeat-x'		=> __( 'Tile Horizontally', 'invicta_dictionary')
					)
				);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Attachment", "invicta_dictionary" ),
				"id" 		=> "styling-background-header-attachment",
				"std" 		=> "scroll",
				"type" 		=> "select",
				"fold"		=> "styling-colors-header",
				"options"	=> array(
					'scroll'	=> __( 'Scroll', 'invicta_dictionary'),
					'fixed'		=> __( 'Fixed', 'invicta_dictionary'),
					)
				);
				
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Position", "invicta_dictionary" ),
				"id" 		=> "styling-background-header-position",
				"std" 		=> "center center",
				"type" 		=> "select",
				"fold"		=> "styling-colors-header",
				"options"	=> array(
					'top left'			=> __( 'Top Left', 'invicta_dictionary'),
					'top center'		=> __( 'Top Center', 'invicta_dictionary'),
					'top right'			=> __( 'Top Right', 'invicta_dictionary'),
					'bottom left'		=> __( 'Bottom Left', 'invicta_dictionary'),
					'bottom center'		=> __( 'Bottom Center', 'invicta_dictionary'),
					'bottom right'		=> __( 'Bottom Right', 'invicta_dictionary'),
					'center left'		=> __( 'Center Left', 'invicta_dictionary'),
					'center center'		=> __( 'Center Center', 'invicta_dictionary'),
					'center right'		=> __( 'Center Right', 'invicta_dictionary'),
					)
				);
			
	$of_options[] = array(
		"name" 		=> __( "Title Area Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-title",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-title-background",
			"fold"		=> "styling-colors-title",
			"std" 		=> "#fafafa",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Border Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-title-border",
			"fold"		=> "styling-colors-title",
			"std" 		=> "#e3e3e3",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-title-text",
			"fold"		=> "styling-colors-title",
			"std" 		=> "#282828",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-title-text_alternate",
			"fold"		=> "styling-colors-title",
			"std" 		=> "#737373",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Pattern", "invicta_dictionary" ),
			"id" 		=> "styling-background-title-pattern",
			"fold"		=> "styling-colors-title",
			"std" 		=> $patterns_url . "0-none.png",
			"type" 		=> "tiles",
			"options" 	=> $patterns,
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Image", "invicta_dictionary" ),
			"id" 		=> "styling-background-title-image",
			"fold"		=> "styling-colors-title",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Repeat", "invicta_dictionary" ),
				"id" 		=> "styling-background-title-repeat",
				"std" 		=> "repeat-x",
				"type" 		=> "select",
				"fold"		=> "styling-colors-title",
				"options"	=> array(
					'no-repeat'		=> __( 'No Repeat', 'invicta_dictionary'),
					'repeat'		=> __( 'Repeat', 'invicta_dictionary'),
					'repeat-y'		=> __( 'Tile Vertically', 'invicta_dictionary'),
					'repeat-x'		=> __( 'Tile Horizontally', 'invicta_dictionary')
					)
				);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Attachment", "invicta_dictionary" ),
				"id" 		=> "styling-background-title-attachment",
				"std" 		=> "scroll",
				"type" 		=> "select",
				"fold"		=> "styling-colors-title",
				"options"	=> array(
					'scroll'	=> __( 'Scroll', 'invicta_dictionary'),
					'fixed'		=> __( 'Fixed', 'invicta_dictionary'),
					)
				);
				
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Position", "invicta_dictionary" ),
				"id" 		=> "styling-background-title-position",
				"std" 		=> "center center",
				"type" 		=> "select",
				"fold"		=> "styling-colors-title",
				"options"	=> array(
					'top left'			=> __( 'Top Left', 'invicta_dictionary'),
					'top center'		=> __( 'Top Center', 'invicta_dictionary'),
					'top right'			=> __( 'Top Right', 'invicta_dictionary'),
					'bottom left'		=> __( 'Bottom Left', 'invicta_dictionary'),
					'bottom center'		=> __( 'Bottom Center', 'invicta_dictionary'),
					'bottom right'		=> __( 'Bottom Right', 'invicta_dictionary'),
					'center left'		=> __( 'Center Left', 'invicta_dictionary'),
					'center center'		=> __( 'Center Center', 'invicta_dictionary'),
					'center right'		=> __( 'Center Right', 'invicta_dictionary'),
					)
				);
			
	$of_options[] = array(
		"name" 		=> __( "Footer Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-footer",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-background",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#fcfcfc",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-background_alternate",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#fafafa",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Border Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-border",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#dddddd",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-text",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#737373",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-text_alternate",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#b2b2b2",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Titles", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-text_titles",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#282828",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Graphics Color (icons, borders, tables, etc)", "invicta_dictionary" ),
			"id" 		=> "styling-colors-footer-graphics",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "#e3e3e3",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Pattern", "invicta_dictionary" ),
			"id" 		=> "styling-background-footer-pattern",
			"fold"		=> "styling-colors-footer",
			"std" 		=> $patterns_url . "0-none.png",
			"type" 		=> "tiles",
			"options" 	=> $patterns,
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Image", "invicta_dictionary" ),
			"id" 		=> "styling-background-footer-image",
			"fold"		=> "styling-colors-footer",
			"std" 		=> "",
			"type" 		=> "upload"
			);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Repeat", "invicta_dictionary" ),
				"id" 		=> "styling-background-footer-repeat",
				"std" 		=> "repeat",
				"type" 		=> "select",
				"fold"		=> "styling-colors-footer",
				"options"	=> array(
					'no-repeat'		=> __( 'No Repeat', 'invicta_dictionary'),
					'repeat'		=> __( 'Repeat', 'invicta_dictionary'),
					'repeat-y'		=> __( 'Tile Vertically', 'invicta_dictionary'),
					'repeat-x'		=> __( 'Tile Horizontally', 'invicta_dictionary')
					)
				);
			
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Attachment", "invicta_dictionary" ),
				"id" 		=> "styling-background-footer-attachment",
				"std" 		=> "scroll",
				"type" 		=> "select",
				"fold"		=> "styling-colors-footer",
				"options"	=> array(
					'scroll'	=> __( 'Scroll', 'invicta_dictionary'),
					'fixed'		=> __( 'Fixed', 'invicta_dictionary'),
					)
				);
				
			$of_options[] = array(
				"name" 		=> "",
				"desc" 		=> __( "Background Image Position", "invicta_dictionary" ),
				"id" 		=> "styling-background-footer-position",
				"std" 		=> "center center",
				"type" 		=> "select",
				"fold"		=> "styling-colors-footer",
				"options"	=> array(
					'top left'			=> __( 'Top Left', 'invicta_dictionary'),
					'top center'		=> __( 'Top Center', 'invicta_dictionary'),
					'top right'			=> __( 'Top Right', 'invicta_dictionary'),
					'bottom left'		=> __( 'Bottom Left', 'invicta_dictionary'),
					'bottom center'		=> __( 'Bottom Center', 'invicta_dictionary'),
					'bottom right'		=> __( 'Bottom Right', 'invicta_dictionary'),
					'center left'		=> __( 'Center Left', 'invicta_dictionary'),
					'center center'		=> __( 'Center Center', 'invicta_dictionary'),
					'center right'		=> __( 'Center Right', 'invicta_dictionary'),
					)
				);
			
	$of_options[] = array(
		"name" 		=> __( "Socket Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-socket",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-socket-background",
			"fold"		=> "styling-colors-socket",
			"std" 		=> "#424242",
			"type" 		=> "color"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-socket-text",
			"fold"		=> "styling-colors-socket",
			"std" 		=> "#B2B2B2",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-socket-text_alternate",
			"fold"		=> "styling-colors-socket",
			"std" 		=> "#FFFFFF",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Bottom Border Line Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-socket-bottom_border_line",
			"fold"		=> "styling-colors-socket",
			"std" 		=> "#fb652b",
			"type" 		=> "color"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Menu Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-menu",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-menu-text",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#737373",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Accent Color (hover, active, etc.)", "invicta_dictionary" ),
			"id" 		=> "styling-colors-menu-accent",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#fb652b",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Child Nodes Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-menu-background",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#f9f9f9",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Child Nodes Background Color - Alternate", "invicta_dictionary" ),
			"id" 		=> "styling-colors-menu-background_alternate",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#FFFFFF",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Child Nodes Divider Color - Top", "invicta_dictionary" ), // the top/bottom labels were swapped purposely 
			"id" 		=> "styling-colors-menu-divider_bottom",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#e2e2e2",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Child Nodes Divider Color - Bottom", "invicta_dictionary" ), // the top/bottom labels were swapped purposely 
			"id" 		=> "styling-colors-menu-divider_top",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#fdfdfd",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Arrows Color", "invicta_dictionary" ), // the top/bottom labels were swapped purposely 
			"id" 		=> "styling-colors-menu-arrows",
			"fold"		=> "styling-colors-menu",
			"std" 		=> "#aaaaaa",
			"type" 		=> "color"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Hover Effect Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Override Base Styles", "invicta_dictionary" ),
		"id" 		=> "styling-colors-hover_effect",
		"std" 		=> 1,
		"type" 		=> "checkbox",
		"folds"		=> 1
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Background Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-hover_effect-background",
			"fold"		=> "styling-colors-hover_effect",
			"std" 		=> "#fb652b",
			"type" 		=> "color"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Text Color", "invicta_dictionary" ),
			"id" 		=> "styling-colors-hover_effect-text",
			"fold"		=> "styling-colors-hover_effect",
			"std" 		=> "#FFFFFF",
			"type" 		=> "color"
			);
			
		
	$of_options[] = array(
		"name" 		=> __( "Other Styles", "invicta_dictionary" ),
		"desc" 		=> __( "Front Page Slideshow Border Color", "invicta_dictionary" ),
		"id" 		=> "styling-colors-other-front_page_slideshow_border",
		"std" 		=> "#d3d3d3",
		"type" 		=> "color"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Custom CSS Code", "invicta_dictionary" ),
		"desc" 		=> __( "Add here your custom CSS code", "invicta_dictionary" ),
		"id" 		=> "general-custom_css",
		"std" 		=> "",
		"type" 		=> "textarea"
		);
		
		
/*
== ------------------------------------------------------------------- ==
== @@ Header Tab
== ------------------------------------------------------------------- ==
*/
	
$of_options[] = array(
	"name" 		=> __( "Header", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Fixed Header", "invicta_dictionary" ),
		"desc" 		=> __( "If the header is Fixed it will be always visible, even when user scrolls down the page", "invicta_dictionary" ),
		"id" 		=> "header-fixed",
		"std" 		=> 0,
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Logo Vertical Spacing", "invicta_dictionary" ),
		"desc" 		=> __( "Specify the vertical empty-space around the logo. This will make your logo look bigger or smaller.<br/> (default = 40px)", "invicta_dictionary" ),
		"id" 		=> "header-logo_spacing",
		"std" 		=> "40",
		"min"		=> "10",
		"max"		=> "60",
		"step"		=> "10",
		"type" 		=> "sliderui"
		);
	
	$of_options[] = array(
		"name" 		=> __( "Meta Bar", "invicta_dictionary" ),
		"desc" 		=> __( "Display a bar with some meta information", "invicta_dictionary" ),
		"id" 		=> "header-meta_bar",
		"std" 		=> 1,
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Call Us phone number", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_phone",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Mail Us address", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_email",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Twitter URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_twitter_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Facebook URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_facebook_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Google Plus URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_googleplus_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "LinkedIn URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_linkedin_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Xing URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_xing_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);

		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Flickr URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_flickr_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);	

		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Tumblr URL", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_tumblr_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);			
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Dribbble URL" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_dribbble_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Skype Username" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_skype_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Instagram URL" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_instagram_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Pinterest URL" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_pinterest_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Foursquare URL" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_foursquare_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Youtube URL" , "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_youtube_url",
			"std" 		=> "",
			"fold"		=> "header-meta_bar",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Search Box", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_searchbox",
			"std" 		=> 1,
			"fold"		=> "header-meta_bar",
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Tagline", "invicta_dictionary" ),
			"id" 		=> "header-meta_bar_tagline",
			"std" 		=> 1,
			"fold"		=> "header-meta_bar",
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc"		=> sprintf( __( "Show WPML Language Switcher<br/><small>%s plugin must be installed</small>", 'invicta_dictionary' ), "<a href='http://wpml.org' target='_blank'>WPML</a>" ),
			"id" 		=> "header-meta_bar_languages_witcher",
			"std" 		=> 1,
			"fold"		=> "header-meta_bar",
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc"		=> sprintf( __( "Show WooCommerce Cart DropDown<br/><small>%s plugin must be installed</small>", 'invicta_dictionary' ), "<a href='http://wordpress.org/plugins/woocommerce/' target='_blank'>WooCommerce</a>" ),
			"id" 		=> "header-meta_bar_woocommerce_cart_dropdown",
			"std" 		=> 1,
			"fold"		=> "header-meta_bar",
			"type" 		=> "checkbox"
			);
			
			
/*
== ------------------------------------------------------------------- ==
== @@ Footer Tab
== ------------------------------------------------------------------- ==
*/
	
$of_options[] = array(
	"name" 		=> __( "Footer", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Columns", "invicta_dictionary" ),
		"desc" 		=> __( "How many columns should be displayed in the footer", "invicta_dictionary" ),
		"id" 		=> "footer-columns",
		"std" 		=> "3",
		"type" 		=> "select",
		"options"	=> array(
			'1' => '1', 
			'2' => '2', 
			'3' => '3', 
			'4' => '4', 
			)
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Hide dummy widgets from footer<br/> when their sidebars are empty", "invicta_dictionary" ),
		"id" 		=> "footer-hide_dummy_widgets",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Socket Area", "invicta_dictionary" ),
		"desc" 		=> __( "Show Socket Area", "invicta_dictionary" ),
		"id" 		=> "footer-socket",
		"std" 		=> "1",
		"folds"		=> 1,
		"type" 		=> "switch"
		);
	
	$of_options[] = array(
		"name" 		=> __( "Copyright", "invicta_dictionary" ),
		"desc" 		=> __( "Add a custom copyright text at the bottom of your site", "invicta_dictionary" ),
		"id" 		=> "footer-copyright",
		"std" 		=> "&copy; 2013 Oitentaecinco -  All Rights Reserved",
		"fold"		=> "footer-socket",
		"type" 		=> "textarea"
		);

			
/*
== ------------------------------------------------------------------- ==
== @@ Sidebars
== ------------------------------------------------------------------- ==
*/

	$opt_sidebars = array(
		'right_sidebar'		=> ADMIN_DIR . 'assets/images/sidebars/right-sidebar.png', 
		'no_sidebar'		=> ADMIN_DIR . 'assets/images/sidebars/no-sidebar.png',
		'left_sidebar'		=> ADMIN_DIR . 'assets/images/sidebars/left-sidebar.png'
		);
	
$of_options[] = array(
	"name" 		=> __( "Sidebars", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Blog Page", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on the Blog List Page", "invicta_dictionary" ),
		"id" 		=> "sidebars-blog_list",
		"std" 		=> "right_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	$of_options[] = array(
		"name" 		=> __( "Blog Post", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on the Blog Post Page", "invicta_dictionary" ),
		"id" 		=> "sidebars-blog_post",
		"std" 		=> "right_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	$of_options[] = array(
		"name" 		=> __( "Blog Archives", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on the Blog Archives Page", "invicta_dictionary" ),
		"id" 		=> "sidebars-blog_archives",
		"std" 		=> "right_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	$of_options[] = array(
		"name" 		=> __( "Pages", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on common Pages", "invicta_dictionary" ),
		"id" 		=> "sidebars-pages",
		"std" 		=> "no_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	$of_options[] = array(
		"name" 		=> __( "Photo Galleries", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on Photo Gallery Pages", "invicta_dictionary" ),
		"id" 		=> "sidebars-photos",
		"std" 		=> "left_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	$of_options[] = array(
		"name" 		=> __( "Video Pages", "invicta_dictionary" ),
		"desc" 		=> __( "Select main content and sidebar alignment on Video Pages", "invicta_dictionary" ),
		"id" 		=> "sidebars-videos",
		"std" 		=> "no_sidebar",
		"type" 		=> "images",
		"options"	=> $opt_sidebars
		);
		
	if ( class_exists('woocommerce') ) {
	
		$of_options[] = array(
			"name" 		=> __( "Shop Pages", "invicta_dictionary" ),
			"desc" 		=> __( "Select main content and sidebar alignment on Shop Pages", "invicta_dictionary" ),
			"id" 		=> "sidebars-shop",
			"std" 		=> "right_sidebar",
			"type" 		=> "images",
			"options"	=> $opt_sidebars
			);
		
	}
	
		
/*
== ------------------------------------------------------------------- ==
== @@ Icons Tab
== ------------------------------------------------------------------- ==
*/
	
$of_options[] = array(
	"name" 		=> __( "Icons", "invicta_dictionary" ),
	"type" 		=> "heading"
	);	
	
	$of_options[] = array(
		"id" 		=> "i_icons-info",
		"std" 		=> __( 'Select the icons you want to use in the website.<br/>The selected icons will be available on your shortcodes, widgets, etc.', 'invicta_dictionary' ),
		"icon" 		=> true,
		"type" 		=> "info"
		);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-glass"></i>',
		'id' => "icons-icon_glass",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-music"></i>',
		'id' => "icons-icon_music",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-search"></i>',
		'id' => "icons-icon_search",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-heart"></i>',
		'id' => "icons-icon_heart",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-star"></i>',
		'id' => "icons-icon_star",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-user"></i>',
		'id' => "icons-icon_user",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-group"></i>',
		'id' => "icons-icon_group",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-film"></i>',
		'id' => "icons-icon_film",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-ok"></i>',
		'id' => "icons-icon_ok",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-remove"></i>',
		'id' => "icons-icon_remove",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-zoom-in"></i>',
		'id' => "icons-icon_zoom_in",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-zoom-out"></i>',
		'id' => "icons-icon_zoom_out",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-off"></i>',
		'id' => "icons-icon_off",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-signal"></i>',
		'id' => "icons-icon_signal",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cog"></i>',
		'id' => "icons-icon_cog",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-home"></i>',
		'id' => "icons-icon_home",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-time"></i>',
		'id' => "icons-icon_time",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-road"></i>',
		'id' => "icons-icon_road",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-download-alt"></i>',
		'id' => "icons-icon_download_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-download"></i>',
		'id' => "icons-icon_download",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-upload"></i>',
		'id' => "icons-icon_upload",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-inbox"></i>',
		'id' => "icons-icon_inbox",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-play-circle"></i>',
		'id' => "icons-icon_play_circle",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-repeat"></i>',
		'id' => "icons-icon_repeat",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-refresh"></i>',
		'id' => "icons-icon_refresh",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-list-alt"></i>',
		'id' => "icons-icon_list_alt",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-lock"></i>',
		'id' => "icons-icon_lock",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-flag"></i>',
		'id' => "icons-icon_flag",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-headphones"></i>',
		'id' => "icons-icon_headphones",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-volume-up"></i>',
		'id' => "icons-icon_volume_up",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-qrcode"></i>',
		'id' => "icons-icon_qrcode",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-tags"></i>',
		'id' => "icons-icon_tags",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-book"></i>',
		'id' => "icons-icon_book",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-print"></i>',
		'id' => "icons-icon_print",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-camera"></i>',
		'id' => "icons-icon_camera",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-font"></i>',
		'id' => "icons-icon_font",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-facetime-video"></i>',
		'id' => "icons-icon_facetime_video",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-picture"></i>',
		'id' => "icons-icon_picture",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-pencil"></i>',
		'id' => "icons-icon_pencil",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-map-marker"></i>',
		'id' => "icons-icon_map_marker",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-adjust"></i>',
		'id' => "icons-icon_adjust",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-tint"></i>',
		'id' => "icons-icon_tint",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-move"></i>',
		'id' => "icons-icon_move",
		'std' => 0,
		'type' => "checkbox"
	);
		
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-play"></i>',
		'id' => "icons-icon_play",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-screenshot"></i>',
		'id' => "icons-icon_screenshot",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-remove-circle"></i>',
		'id' => "icons-icon_remove_circle",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-ok-circle"></i>',
		'id' => "icons-icon_ok_circle",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-ban-circle"></i>',
		'id' => "icons-icon_ban_circle",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-mail-forward"></i>',
		'id' => "icons-icon_mail_forward",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-plus"></i>',
		'id' => "icons-icon_plus",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-minus"></i>',
		'id' => "icons-icon_minus",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-exclamation-sign"></i>',
		'id' => "icons-icon_exclamation_sign",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-gift"></i>',
		'id' => "icons-icon_gift",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-leaf"></i>',
		'id' => "icons-icon_leaf",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-fire"></i>',
		'id' => "icons-icon_fire",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-eye-open"></i>',
		'id' => "icons-icon_eye_open",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-eye-close"></i>',
		'id' => "icons-icon_eye_close",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-warning-sign"></i>',
		'id' => "icons-icon_warning_sign",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-plane"></i>',
		'id' => "icons-icon_plane",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-calendar"></i>',
		'id' => "icons-icon_calendar",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-comment"></i>',
		'id' => "icons-icon_comment",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-comments"></i>',
		'id' => "icons-icon_comments",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-magnet"></i>',
		'id' => "icons-icon_magnet",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-retweet"></i>',
		'id' => "icons-icon_retweet",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-shopping-cart"></i>',
		'id' => "icons-icon_shopping_cart",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bar-chart"></i>',
		'id' => "icons-icon_bar_chart",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-camera-retro"></i>',
		'id' => "icons-icon_camera_retro",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-key"></i>',
		'id' => "icons-icon_key",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cogs"></i>',
		'id' => "icons-icon_cogs",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-thumbs-up-alt"></i>',
		'id' => "icons-icon_thumbs_up_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-thumbs-down-alt"></i>',
		'id' => "icons-icon_thumbs_down_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-pushpin"></i>',
		'id' => "icons-icon_pushpin",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-trophy"></i>',
		'id' => "icons-icon_trophy",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-upload-alt"></i>',
		'id' => "icons-icon_upload_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-phone"></i>',
		'id' => "icons-icon_phone",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-envelope"></i>',
		'id' => "icons-icon_envelope",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-unlock"></i>',
		'id' => "icons-icon_unlock",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-credit-card"></i>',
		'id' => "icons-icon_credit_card",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-rss"></i>',
		'id' => "icons-icon_rss",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-hdd"></i>',
		'id' => "icons-icon_hdd",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bullhorn"></i>',
		'id' => "icons-icon_bullhorn",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bell"></i>',
		'id' => "icons-icon_bell",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-hand-right"></i>',
		'id' => "icons-icon_hand_right",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-hand-left"></i>',
		'id' => "icons-icon_hand_left",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-hand-up"></i>',
		'id' => "icons-icon_hand_up",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-hand-down"></i>',
		'id' => "icons-icon_hand_down",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-globe"></i>',
		'id' => "icons-icon_globe",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-wrench"></i>',
		'id' => "icons-icon_wrench",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-tasks"></i>',
		'id' => "icons-icon_tasks",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-briefcase"></i>',
		'id' => "icons-icon_briefcase",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-link"></i>',
		'id' => "icons-icon_link",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cloud"></i>',
		'id' => "icons-icon_cloud",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-beaker"></i>',
		'id' => "icons-icon_beaker",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cut"></i>',
		'id' => "icons-icon_cut",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-paperclip"></i>',
		'id' => "icons-icon_paperclip",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-save"></i>',
		'id' => "icons-icon_save",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-table"></i>',
		'id' => "icons-icon_table",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-magic"></i>',
		'id' => "icons-icon_magic",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-truck"></i>',
		'id' => "icons-icon_truck",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-money"></i>',
		'id' => "icons-icon_money",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-undo"></i>',
		'id' => "icons-icon_undo",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-legal"></i>',
		'id' => "icons-icon_legal",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-dashboard"></i>',
		'id' => "icons-icon_dashboard",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bolt"></i>',
		'id' => "icons-icon_bolt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-sitemap"></i>',
		'id' => "icons-icon_sitemap",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-umbrella"></i>',
		'id' => "icons-icon_umbrella",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-paste"></i>',
		'id' => "icons-icon_paste",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-lightbulb"></i>',
		'id' => "icons-icon_lightbulb",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cloud-download"></i>',
		'id' => "icons-icon_cloud_download",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-cloud-upload"></i>',
		'id' => "icons-icon_cloud_upload",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-user-md"></i>',
		'id' => "icons-icon_user_md",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-stethoscope"></i>',
		'id' => "icons-icon_stethoscope",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-suitcase"></i>',
		'id' => "icons-icon_suitcase",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bell-alt"></i>',
		'id' => "icons-icon_bell_alt",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-coffee"></i>',
		'id' => "icons-icon_coffee",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-food"></i>',
		'id' => "icons-icon_food",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-file-text-alt"></i>',
		'id' => "icons-icon_file_text_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-ambulance"></i>',
		'id' => "icons-icon_ambulance",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-medkit"></i>',
		'id' => "icons-icon_medkit",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-fighter-jet"></i>',
		'id' => "icons-icon_fighter_jet",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-beer"></i>',
		'id' => "icons-icon_beer",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-h-sign"></i>',
		'id' => "icons-icon_h_sign",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-desktop"></i>',
		'id' => "icons-icon_desktop",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-laptop"></i>',
		'id' => "icons-icon_laptop",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-tablet"></i>',
		'id' => "icons-icon_tablet",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-mobile-phone"></i>',
		'id' => "icons-icon_mobile_phone",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-quote-left"></i>',
		'id' => "icons-icon_quote_left",
		'std' => 0,
		'type' => "checkbox"
	);
		
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-gamepad"></i>',
		'id' => "icons-icon_gamepad",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-keyboard"></i>',
		'id' => "icons-icon_keyboard",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-flag-checkered"></i>',
		'id' => "icons-icon_flag_checkered",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-location-arrow"></i>',
		'id' => "icons-icon_location_arrow",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-crop"></i>',
		'id' => "icons-icon_crop",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-question"></i>',
		'id' => "icons-icon_question",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-info"></i>',
		'id' => "icons-icon_info",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-exclamation"></i>',
		'id' => "icons-icon_exclamation",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-puzzle-piece"></i>',
		'id' => "icons-icon_puzzle_piece",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-microphone"></i>',
		'id' => "icons-icon_microphone",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-shield"></i>',
		'id' => "icons-icon_shield",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-calendar-empty"></i>',
		'id' => "icons-icon_calendar_empty",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-fire-extinguisher"></i>',
		'id' => "icons-icon_fire_extinguisher",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-rocket"></i>',
		'id' => "icons-icon_rocket",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-anchor"></i>',
		'id' => "icons-icon_anchor",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-unlock-alt"></i>',
		'id' => "icons-icon_unlock_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bullseye"></i>',
		'id' => "icons-icon_bullseye",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-rss-sign"></i>',
		'id' => "icons-icon_rss_sign",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-ticket"></i>',
		'id' => "icons-icon_ticket",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-compass"></i>',
		'id' => "icons-icon_compass",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-file"></i>',
		'id' => "icons-icon_file",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-file-text"></i>',
		'id' => "icons-icon_file_text",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-thumbs-up"></i>',
		'id' => "icons-icon_thumbs_up",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-thumbs-down"></i>',
		'id' => "icons-icon_thumbs_down",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-female"></i>',
		'id' => "icons-icon_female",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-male"></i>',
		'id' => "icons-icon_male",
		'std' => 1,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-sun"></i>',
		'id' => "icons-icon_sun",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-moon"></i>',
		'id' => "icons-icon_moon",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bug"></i>',
		'id' => "icons-icon_bug",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-adn"></i>',
		'id' => "icons-icon_adn",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-android"></i>',
		'id' => "icons-icon_android",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-apple"></i>',
		'id' => "icons-icon_apple",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-linux"></i>',
		'id' => "icons-icon_linux",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-windows"></i>',
		'id' => "icons-icon_windows",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-bitbucket"></i>',
		'id' => "icons-icon_bitbucket",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-html5"></i>',
		'id' => "icons-icon_html5",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-css3"></i>',
		'id' => "icons-icon_css3",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-dribbble"></i>',
		'id' => "icons-icon_dribbble",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-dropbox"></i>',
		'id' => "icons-icon_dropbox",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-twitter"></i>',
		'id' => "icons-icon_twitter",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-facebook"></i>',
		'id' => "icons-icon_facebook",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-instagram"></i>',
		'id' => "icons-icon_instagram",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-flickr"></i>',
		'id' => "icons-icon_flickr",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-pinterest"></i>',
		'id' => "icons-icon_pinterest",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-linkedin"></i>',
		'id' => "icons-icon_linkedin",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-foursquare"></i>',
		'id' => "icons-icon_foursquare",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-github"></i>',
		'id' => "icons-icon_github",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-github-alt"></i>',
		'id' => "icons-icon_github_alt",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-github-sign"></i>',
		'id' => "icons-icon_github_sign",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-gittip"></i>',
		'id' => "icons-icon_gittip",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-google-plus"></i>',
		'id' => "icons-icon_google_plus",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-renren"></i>',
		'id' => "icons-icon_renren",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-skype"></i>',
		'id' => "icons-icon_skype",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-stackexchange"></i>',
		'id' => "icons-icon_stackexchange",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-trello"></i>',
		'id' => "icons-icon_trello",
		'std' => 0,
		'type' => "checkbox"
	);
	
		
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-tumblr"></i>',
		'id' => "icons-icon_tumblr",
		'std' => 0,
		'type' => "checkbox"
	);
	
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-vk"></i>',
		'id' => "icons-icon_vk",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-weibo"></i>',
		'id' => "icons-icon_weibo",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-xing"></i>',
		'id' => "icons-icon_xing",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array( 
		'desc' => '<i class="icon-2x icon-youtube"></i>',
		'id' => "icons-icon_youtube",
		'std' => 0,
		'type' => "checkbox"
	);
	
	$of_options[] = array(
		"id" 		=> "i_icons-info_2",
		"std" 		=> sprintf( __( "All of this icons are based on the %s iconic font.<br/><br/>If you check their %sfull list of icons%s you will see that only some of them are included by default in the theme. If you want to include any other icon, please use the following field.", 'invicta_dictionary' ), "<a href='http://fortawesome.github.io/Font-Awesome/3.2.1/' target='_blank'>Font Awesome</a>", "<a href='http://fortawesome.github.io/Font-Awesome/3.2.1/icons/' target='_blank'>", "</a>" ),
		"icon" 		=> true,
		"type" 		=> "info"
		);
	
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "One icon ID per line.<br/><br/>Example:<br/><i>icon-star-empty</i><br/><i>icon-heart-empty</i><br/><i>icon-archive</i>", "invicta_dictionary" ),
		"id" 		=> "i_icons-extra_icons",
		"std" 		=> "",
		"type" 		=> "textarea"
		);

/*
== ------------------------------------------------------------------- ==
== @@ Typography Tab
== ------------------------------------------------------------------- ==
*/

$native_fonts = invicta_get_os_native_fonts();
$google_fonts = invicta_get_google_web_fonts();

$fonts = array();

$fonts['none'] = "-- Native Fonts --";
foreach ( $native_fonts as $font ) {
	$fonts[ $font ] = $font;
}
$fonts['google'] = "-- Google Web Fonts --";
foreach ( $google_fonts as $font ) {
	$fonts[ $font ] = $font;
}


$of_options[] = array(
	"name" 		=> __( "Typography", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
		
	$of_options[] = array(
		"name" 		=> __( "Body Font", "invicta_dictionary" ),
		"desc" 		=> __( "Select a font for body text", "invicta_dictionary" ),
		"id" 		=> "typography-body-family",
		"std" 		=> "Open Sans",
		"type" 		=> "select_google_font",
		"preview" 	=> array(
			"text" => __( "This is my preview text!", 'invicta_dictionary' ),
			"size" => "23px"
		),
		"options"	=> $fonts
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Specify the base font size for the website. (default = 13px)", "invicta_dictionary" ),
			"id" 		=> "typography-body-size",
			"std" 		=> "13",
			"min"		=> "8",
			"max"		=> "20",
			"step"		=> "1",
			"type" 		=> "sliderui"
			);
				
	$of_options[] = array(
		"name" 		=> __( "Headings", "invicta_dictionary" ),
		"desc" 		=> __( "Select a font for headings", "invicta_dictionary" ),
		"id" 		=> "typography-headings-family",
		"std" 		=> "Open Sans",
		"type" 		=> "select_google_font",
		"preview" 	=> array(
			"text" => "This is my preview text!",
			"size" => "23px"
			),
		"options"	=> $fonts
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Uppercase Widget Titles", "invicta_dictionary" ),
			"id" 		=> "typography-headings-uppercase-widget_titles",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Uppercase Page Title", "invicta_dictionary" ),
			"id" 		=> "typography-headings-uppercase-page_title",
			"std" 		=> 0,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Uppercase Content Titles", "invicta_dictionary" ),
			"id" 		=> "typography-headings-uppercase-content_titles",
			"std" 		=> 0,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"id" 		=> "typography-subsets-info",
			"std" 		=> __( 'The following values are percentages (%) relatives to the body font size.<br/> If you set 200% and your body font size is 13px, the real value of the heading will be 26px.', 'invicta_dictionary' ),
			"icon" 		=> true,
			"type" 		=> "info"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Page Title Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-page_title",
			"std" 		=> "180",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 1 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h1",
			"std" 		=> "200",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 2 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h2",
			"std" 		=> "150",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 3 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h3",
			"std" 		=> "130",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 4 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h4",
			"std" 		=> "110",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 5 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h5",
			"std" 		=> "100",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Heading 6 Font-size", "invicta_dictionary" ),
			"id" 		=> "typography-headings-size-h6",
			"std" 		=> "90",
			"min"		=> "80",
			"max"		=> "300",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Menu", "invicta_dictionary" ),
		"desc" 		=> __( "Select a font for the main menu", "invicta_dictionary" ),
		"id" 		=> "typography-menu-family",
		"std" 		=> "Open Sans",
		"type" 		=> "select_google_font",
		"preview" 	=> array(
			"text" => "This is my preview text!",
			"size" => "23px"
		),
		"options"	=> $fonts
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Uppercase Root Elements", "invicta_dictionary" ),
			"id" 		=> "typography-menu-uppercase-root",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Uppercase Child Elements", "invicta_dictionary" ),
			"id" 		=> "typography-menu-uppercase-children",
			"std" 		=> 0,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "<strong>Menu Font-size</strong> <cite>(Percentage (%) relative to the body font-size)</cite>", "invicta_dictionary" ),
			"id" 		=> "typography-menu-size",
			"std" 		=> "100",
			"min"		=> "50",
			"max"		=> "150",
			"step"		=> "10",
			"type" 		=> "sliderui"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Google Font Subsets", "invicta_dictionary" ),
		"desc" 		=> __( "Latin Extended", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-latin_extended",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Cyrillic", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-cyrillic",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Cyrillic Extended", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-cyrillic_extended",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Greek", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-greek",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Greek Extended", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-greek_extended",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Khmer", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-khmer",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Vietnamese", "invicta_dictionary" ),
		"id" 		=> "typography-subsets-vietnamese",
		"std" 		=> 0,
		"type" 		=> "checkbox"
		);
		
	$of_options[] = array(
		"id" 		=> "typography-subsets-info",
		"std" 		=> sprintf( __( '<p>Latin subset is already included by default.</p><p>Using many subsets will slow down your website, so only select subsets that you actually need.<br> Make sure the fonts you are using supports the chosen subsets. More info on %s</p>', 'invicta_dictionary' ), '<a href="http://www.google.com/fonts/" target="_blank">Google Web Fonts</a>' ),
		"icon" 		=> true,
		"type" 		=> "info"
		);
	
	
/*
== ------------------------------------------------------------------- ==
== @@ Blog Tab
== ------------------------------------------------------------------- ==
*/

	$opt_layouts = array(
		'full_width'		=> ADMIN_DIR . 'assets/images/blog-layout/fullwidth-thumb.png',
		'left_thumbnail'	=> ADMIN_DIR . 'assets/images/blog-layout/left-small-thumb.png',
		'right_thumbnail'	=> ADMIN_DIR . 'assets/images/blog-layout/right-small-thumb.png',
		'grid'				=> ADMIN_DIR . 'assets/images/blog-layout/grid-2x.png'
		);

$of_options[] = array(
	"name" 		=> __( "Blog", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Default Layout", "invicta_dictionary" ),
		"desc" 		=> __( "Specify how you want to display the posts", "invicta_dictionary" ),
		"id" 		=> "blog-layout-list",
		"std" 		=> "full_width",
		"type" 		=> "images",
		"options"	=> $opt_layouts
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Activate clean style<br/> <small>(no container around each post)</small>", "invicta_dictionary" ),
			"id" 		=> "blog-layout-clean_style",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Archive Layout", "invicta_dictionary" ),
		"desc" 		=> __( "Specify how you want to display the archived posts", "invicta_dictionary" ),
		"id" 		=> "blog-layout-archive",
		"std" 		=> "grid",
		"type" 		=> "images",
		"options"	=> $opt_layouts
		);

	$of_options[] = array(
		"name" 		=> __( "Date Format", "invicta_dictionary" ),
		"desc" 		=> __( "Read more about", "invicta_dictionary" ) . ' <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">' . __( "Formatting Date &amp; Time", "invicta_dictionary" ) . '</a>',
		"id" 		=> "blog-date_format",
		"std" 		=> "F jS, Y",
		"type" 		=> "text"
		);
			
	$of_options[] = array(
		"name" 		=> __( "Metadata Visibility", "invicta_dictionary" ),
		"desc" 		=> __( "Show post author", "invicta_dictionary" ),
		"id" 		=> "blog-metadata-author",
		"std" 		=> 1,
		"folds"		=> 1,
		"type" 		=> "checkbox"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show post author details", "invicta_dictionary" ),
			"id" 		=> "blog-metadata-author_details",
			"std" 		=> 1,
			"fold"		=> "blog-metadata-author",
			"type" 		=> "checkbox"
			);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show post date", "invicta_dictionary" ),
			"id" 		=> "blog-metadata-date",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show post categories", "invicta_dictionary" ),
			"id" 		=> "blog-metadata-categories",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show post comments", "invicta_dictionary" ),
			"id" 		=> "blog-metadata-comments",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show post tags", "invicta_dictionary" ),
			"id" 		=> "blog-metadata-tags",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Custom post-page title", "invicta_dictionary" ),
		"desc" 		=> __( "You could use a custom title for the Single Post Page, instead of the default's post title. <strong>e.g.: If you use the custom title 'Blog' all posts will have this same title</strong>", "invicta_dictionary" ),
		"id" 		=> "blog-custom_single_title",
		"std" 		=> 1,
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> "Custom Title",
			"id" 		=> "blog-custom_single_title-text",
			"std" 		=> "Blog",
			"fold"		=> "blog-custom_single_title",
			"type" 		=> "text"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Share on Twitter", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display a Twitter sharer button on the post page", "invicta_dictionary" ),
		"id" 		=> "blog-share-twitter",
		"std" 		=> 0,
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Add <strong>via username</strong> to the tweet", "invicta_dictionary" ),
			"id" 		=> "blog-share-twitter-via",
			"std" 		=> "",
			"fold"		=> "blog-share-twitter",
			"type" 		=> "text"
			);			
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Add <strong>hashtags</strong> to the tweet (comma separated)", "invicta_dictionary" ),
			"id" 		=> "blog-share-twitter-hashtags",
			"std" 		=> "",
			"fold"		=> "blog-share-twitter",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Tweet counter", "invicta_dictionary" ),
			"id" 		=> "blog-share-twitter-counter",
			"std" 		=> 1,
			"fold"		=> "blog-share-twitter",
			"type" 		=> "checkbox"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Share on Facebook", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display a Facebook Like button on the post page", "invicta_dictionary" ),
		"id" 		=> "blog-share-facebook",
		"std" 		=> 0,
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Post Navigation", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display the post navigation links on each individual post page", "invicta_dictionary" ),
		"id" 		=> "blog-post_navigation",
		"std" 		=> 1,
		"type" 		=> "switch"
		);

		
/*
== ------------------------------------------------------------------- ==
== @@ Portfolio Tab
== ------------------------------------------------------------------- ==
*/
		
$of_options[] = array(
	"name" 		=> __( "Portfolio", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Date Format", "invicta_dictionary" ),
		"desc" 		=> __( "Read more about", "invicta_dictionary" ) . ' <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">' . __( "Formatting Date &amp; Time", "invicta_dictionary" ) . '</a>',
		"id" 		=> "portfolio-date_format",
		"std" 		=> "F jS, Y",
		"type" 		=> "text"
		);
		
		$of_options[] = array(
			"name" 		=> __( "Project Permalink Slug", "invicta_dictionary" ),
			"desc"		=> sprintf( __( "Don't use characters that are not allowed in urls and make sure that this slug is not used anywhere else on your site (for example as a category or a page).<br/><br/>Ex.: if the slug is '%s' the link to the project will be %s<br/><br/><strong>Important:</strong> Every time you change this field you should update your permalinks structure. To do that just go to %sSettings > Permalinks%s and hit the Save Changes button.", "invicta_dictionary" ), 'porfolio-project', get_home_url() . '/porfolio-project/project-name', "<a href='" . admin_url('options-permalink.php') . "'>", '</a>' ),			
			"id" 		=> "portfolio-slug",
			"std" 		=> "porfolio-project",
			"type" 		=> "text"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Project Sort", "invicta_dictionary" ),
		"desc" 		=> __( "How you want to sort your projects in the portfolio listing view?", "invicta_dictionary" ),
		"id" 		=> "portfolio-sort",
		"std" 		=> "date-DESC",
		"type" 		=> "select",
		"options"	=> array(
			'menu_order-DESC'		=> __( 'Order Attribute (DESC)', 'invicta_dictionary' ),
			'menu_order-ASC'		=> __( 'Order Attribute (ASC)', 'invicta_dictionary' ),
			'date-DESC'				=> __( 'Date (DESC)', 'invicta_dictionary' ),
			'date-ASC'				=> __( 'Date (ASC)', 'invicta_dictionary' ),
			)
		);
			
	$of_options[] = array(
		"name" 		=> __( "Metadata Visibility", "invicta_dictionary" ),
		"desc" 		=> __( "Show project client", 'invicta_dictionary' ),
		"id" 		=> "portfolio-metadata-client",
		"std" 		=> 1,
		"type" 		=> "checkbox"
		);
		
		$of_options[] = array(
			"name" 		=> '',
			"desc" 		=> __( "Show project date", 'invicta_dictionary' ),
			"id" 		=> "portfolio-metadata-date",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> '',
			"desc" 		=> __( "Show project categories", 'invicta_dictionary' ),
			"id" 		=> "portfolio-metadata-categories",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> '',
			"desc" 		=> __( "Show project skills", 'invicta_dictionary' ),
			"id" 		=> "portfolio-metadata-skills",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
			
		$of_options[] = array(
			"name" 		=> '',
			"desc" 		=> __( "Show project price", 'invicta_dictionary' ),
			"id" 		=> "portfolio-metadata-price",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
		
		$of_options[] = array(
			"name" 		=> '',
			"desc" 		=> __( "Show Launch Project button", 'invicta_dictionary' ),
			"id" 		=> "portfolio-metadata-launch",
			"std" 		=> 1,
			"type" 		=> "checkbox"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Project Navigation", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display the project navigation links on each individual project page", "invicta_dictionary" ),
		"id" 		=> "portfolio-project_navigation",
		"std" 		=> 1,
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Related Projects", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display a list of related projects on the individual project page", "invicta_dictionary" ),
		"id" 		=> "portfolio-related_projects",
		"std" 		=> 1,
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> __( "Related Projects Metadata", "invicta_dictionary" ),
			"desc" 		=> __( "What extra info do you want to show with the project title?", "invicta_dictionary" ),
			"id" 		=> "portfolio-related_projects-metadata",
			"fold"		=> "portfolio-related_projects",
			"std" 		=> "date",
			"type" 		=> "select",
			"options"	=> array(
				'date'			=> __( 'The project date', 'invicta_dictionary' ),
				'categories'	=> __( 'The project categories', 'invicta_dictionary' ),
				'-1'			=> __( 'Nothing', 'invicta_dictionary' ),
				)
			);
		
	$of_options[] = array(
		"name" 		=> __( "Share on Twitter", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display a Twitter sharer button on the post page", "invicta_dictionary" ),
		"id" 		=> "portfolio-share-twitter",
		"std" 		=> 1,
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Add <strong>via username</strong> to the tweet", "invicta_dictionary" ),
			"id" 		=> "portfolio-share-twitter-via",
			"std" 		=> "",
			"fold"		=> "portfolio-share-twitter",
			"type" 		=> "text"
			);			
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Add <strong>hashtags</strong> to the tweet (comma separated)", "invicta_dictionary" ),
			"id" 		=> "portfolio-share-twitter-hashtags",
			"std" 		=> "",
			"fold"		=> "portfolio-share-twitter",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Tweet counter", "invicta_dictionary" ),
			"id" 		=> "portfolio-share-twitter-counter",
			"std" 		=> 1,
			"fold"		=> "portfolio-share-twitter",
			"type" 		=> "checkbox"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Share on Facebook", "invicta_dictionary" ),
		"desc" 		=> __( "Specify if you want to display a Facebook Like button on the post page", "invicta_dictionary" ),
		"id" 		=> "portfolio-share-facebook",
		"std" 		=> 1,
		"type" 		=> "switch"
		);
	
/*
== ------------------------------------------------------------------- ==
== @@ Photo Galleries Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array(
	"name" 		=> __( "Photos", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Gallery Sort", "invicta_dictionary" ),
		"desc" 		=> __( "How you want to sort your galleries in the gallery listing view?", "invicta_dictionary" ),
		"id" 		=> "photos-sort",
		"std" 		=> "date-DESC",
		"type" 		=> "select",
		"options"	=> array(
			'menu_order-DESC'		=> __( 'Order Attribute (DESC)', 'invicta_dictionary' ),
			'menu_order-ASC'		=> __( 'Order Attribute (ASC)', 'invicta_dictionary' ),
			'date-DESC'				=> __( 'Date (DESC)', 'invicta_dictionary' ),
			'date-ASC'				=> __( 'Date (ASC)', 'invicta_dictionary' ),
			)
		);
		
	$of_options[] = array(
		"name" 		=> __( "Photo Gallery Permalink Slug", "invicta_dictionary" ),
		"desc"		=> sprintf( __( "Don't use characters that are not allowed in urls and make sure that this slug is not used anywhere else on your site (for example as a category or a page).<br/><br/>Ex.: if the slug is '%s' the link to the project will be %s<br/><br/><strong>Important:</strong> Every time you change this field you should update your permalinks structure. To do that just go to %sSettings > Permalinks%s and hit the Save Changes button.", "invicta_dictionary" ), 'photo-gallery', get_home_url() . '/photo-gallery/gallery-name', "<a href='" . admin_url('options-permalink.php') . "'>", '</a>' ),
		"id" 		=> "photos-slug",
		"std" 		=> "photo-gallery",
		"type" 		=> "text"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Show photos in mosaic", "invicta_dictionary" ),
		"desc" 		=> __( "", "invicta_dictionary" ),
		"id" 		=> "photos-mosaic",
		"std" 		=> "0",
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
	$of_options[] = array(
		"name" 		=> __( "Photo Gallery Columns", "invicta_dictionary" ),
		"desc" 		=> __( "On how many columns do you want to display the photos in the single gallery page?", "invicta_dictionary" ),
		"id" 		=> "photos-columns",
		"std" 		=> "6",
		"type" 		=> "select",
		"options"	=> array(
			'none'		=> '',
			'1'			=> '1',
			'2'			=> '2',
			'3'			=> '3',
			'4'			=> '4',
			'5'			=> '5',
			'6'			=> '6',
			'7'			=> '7',
			'8'			=> '8',
			'9'			=> '9'
			),
		"fold"		=> 'photos-mosaic'
		);
		
	$of_options[] = array(
		"name" 		=> __( "Photo Behavior", "invicta_dictionary" ),
		"desc" 		=> __( "What do you want to happen when user clicks on a photo?", "invicta_dictionary" ),
		"id" 		=> "photos-behavior",
		"std" 		=> "file",
		"type" 		=> "select",
		"options"	=> array(
			'default'			=> '', 
			'none'				=> __( 'None', 'invicta_dictionary' ),
			'file'				=> __( 'Open in a Lightbox', 'invicta_dictionary' ),
			'attachment'		=> __( 'Redirect to Attachment Page', 'invicta_dictionary' ),
			),
		"fold"		=> 'photos-mosaic'
		);
		
/*
== ------------------------------------------------------------------- ==
== @@ Videos Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array(
	"name" 		=> __( "Videos", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Videos List Page", "invicta_dictionary" ),
		"desc" 		=> __( "Video Sort", "invicta_dictionary" ),
		"id" 		=> "videos-sort",
		"std" 		=> "date-DESC",
		"type" 		=> "select",
		"options"	=> array(
			'menu_order-DESC'		=> __( 'Order Attribute (DESC)', 'invicta_dictionary' ),
			'menu_order-ASC'		=> __( 'Order Attribute (ASC)', 'invicta_dictionary' ),
			'date-DESC'				=> __( 'Date (DESC)', 'invicta_dictionary' ),
			'date-ASC'				=> __( 'Date (ASC)', 'invicta_dictionary' ),
			)
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Popular Videos Carousel", "invicta_dictionary" ),
			"id" 		=> "videos-popular_videos",
			"std" 		=> "1",
			"folds"		=> 1,
			"type" 		=> "switch"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Videos by Category Carousel", "invicta_dictionary" ),
			"id" 		=> "videos-category_videos",
			"std" 		=> "1",
			"folds"		=> 1,
			"type" 		=> "switch"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Num. of items per Carousel", "invicta_dictionary" ),
			"id" 		=> "videos-carousel_size",
			"std" 		=> "",
			"type" 		=> "text"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Video Detail Page", "invicta_dictionary" ),
		"desc" 		=> __( "Show Related Videos", "invicta_dictionary" ),
		"id" 		=> "videos-related_videos",
		"std" 		=> "1",
		"folds"		=> 1,
		"type" 		=> "switch"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Show Other Videos", "invicta_dictionary" ),
			"id" 		=> "videos-other_videos",
			"std" 		=> "1",
			"folds"		=> 1,
			"type" 		=> "switch"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Num. of items per List", "invicta_dictionary" ),
			"id" 		=> "videos-list_size",
			"std" 		=> "8",
			"type" 		=> "text"
			);
		
	$of_options[] = array(
		"name" 		=> __( "Video Permalink Slug", "invicta_dictionary" ),
		"desc"		=> sprintf( __( "Don't use characters that are not allowed in urls and make sure that this slug is not used anywhere else on your site (for example as a category or a page).<br/><br/>Ex.: if the slug is '%s' the link to the project will be %s<br/><br/><strong>Important:</strong> Every time you change this field you should update your permalinks structure. To do that just go to %sSettings > Permalinks%s and hit the Save Changes button.", "invicta_dictionary" ), 'video', get_home_url() . '/video/video-name', "<a href='" . admin_url('options-permalink.php') . "'>", '</a>' ),
		"id" 		=> "videos-slug",
		"std" 		=> "video",
		"type" 		=> "text"
		);
		
/*
== ------------------------------------------------------------------- ==
== @@ Social Services Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array(
	"name" 		=> __( "Feeds Auth", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
	
	$of_options[] = array(
		"name" 		=> __( "Twitter Authorization", "invicta_dictionary" ),
		"desc" 		=> __( "Consumer Key", "invicta_dictionary" ),
		"id" 		=> "auth-twitter-consumer_key",
		"std" 		=> "",
		"type" 		=> "text"
		);
		
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Consumer Secret", "invicta_dictionary" ),
			"id" 		=> "auth-twitter-consumer_secret",
			"std" 		=> "",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Access Token", "invicta_dictionary" ),
			"id" 		=> "auth-twitter-access_token",
			"std" 		=> "",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Access Token Secret", "invicta_dictionary" ),
			"id" 		=> "auth-twitter-access_token_secret",
			"std" 		=> "",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"id" 		=> "auth-twitter-info",
			"std" 		=> sprintf( __( '<p>In order to your Twitter Feed widgets work, you\'ll have to request permission to Twitter. Please login at %s, create a new application and generate an access token.</p><p>Twitter will provide you with a <strong>Consumer Key</strong>, a <strong>Consumer Secret</strong>, an <strong>Access Token</strong> and an <strong>Access Token Secret</strong> that you should copy and paste here.</p>', 'invicta_dictionary' ), '<a href="https://dev.twitter.com/apps" target="_blank">dev.twitter.com/apps</a>' ),
			"icon" 		=> true,
			"type" 		=> "info"
			);
			
	$of_options[] = array(
		"name" 		=> __( "Instagram Authorization", "invicta_dictionary" ),
		"desc" 		=> __( "User ID", "invicta_dictionary" ),
		"id" 		=> "auth-instagram-user_id",
		"std" 		=> "",
		"type" 		=> "text"
		);

		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Access Token", "invicta_dictionary" ),
			"id" 		=> "auth-instagram-access_token",
			"std" 		=> "",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"id" 		=> "auth-twitter-info",
			"std" 		=> sprintf( __( '<p>In order to your Instagram Feed widgets work, you\'ll have to request permission to Instagram. Please login at %s and create a new application</p><p>Instagram will provide you with a <strong>User ID</strong> and an <strong>Access Token</strong> that you should copy and paste here.</p>', 'invicta_dictionary' ), '<a href="http://instagram.com/developer" target="_blank">instagram.com/developer</a>' ),
			"icon" 		=> true,
			"type" 		=> "info"
			);
			

/*
== ------------------------------------------------------------------- ==
== @@ Maintenance Mode Tab
== ------------------------------------------------------------------- ==
*/		

$of_options[] = array(
	"name" 		=> __( "Maintenance", "invicta_dictionary" ),
	"type" 		=> "heading"
	);
		
	$of_options[] = array(
		"name" 		=> __( "Maintenance Mode", "invicta_dictionary" ),
		"desc" 		=> __( "The website will only be visible for the administrator", "invicta_dictionary") ,
		"id" 		=> "maintenance-status",
		"std" 		=> "0",
		"type" 		=> "switch",
		);	
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Title", "invicta_dictionary" ),
		"id" 		=> "maintenance-title",
		"std" 		=> __( "Coming <strong>Soon</strong>", "invicta_dictionary"),
		"type" 		=> "text",
		"fold"		=> "maintenance-status",
		);
		
	$of_options[] = array(
		"name" 		=> "",
		"desc" 		=> __( "Message", "invicta_dictionary" ),
		"id" 		=> "maintenance-message",
		"std" 		=> __( "We are preparing something new. Please come back soon.\nMeanwhile, stay in touch through the social networks.", "invicta_dictionary"),
		"type" 		=> "textarea",
		"fold"		=> "maintenance-status",
		);
		
	$of_options[] = array(
		"name" 		=> __( "Logo", "invicta_dictionary" ),
		"desc" 		=> __( "Upload your logo to display at the top", "invicta_dictionary" ),
		"id" 		=> "maintenance-logo",
		"std" 		=> "",
		"type" 		=> "upload",
		"fold"		=> "maintenance-status",
		);
		
	$of_options[] = array(
		"name" 		=> __( "Social Networks", "invicta_dictionary" ),
		"desc" 		=> __( "Mail Address", "invicta_dictionary" ),
		"id" 		=> "maintenance-social-email",
		"std" 		=> "",
		"fold"		=> "maintenance-status",
		"type" 		=> "text"
		);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Twitter URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-twitter_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Facebook URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-facebook_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Google Plus URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-googleplus_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "LinkedIn URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-linkedin_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Xing URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-xing_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);

		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Flickr URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-flickr_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);	

		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Tumblr URL", "invicta_dictionary" ),
			"id" 		=> "maintenance-social-tumblr_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);			
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Dribbble URL" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-dribbble_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Skype Username" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-skype_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Instagram URL" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-instagram_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Pinterest URL" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-pinterest_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Foursquare URL" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-foursquare_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);
			
		$of_options[] = array(
			"name" 		=> "",
			"desc" 		=> __( "Youtube URL" , "invicta_dictionary" ),
			"id" 		=> "maintenance-social-youtube_url",
			"std" 		=> "",
			"fold"		=> "maintenance-status",
			"type" 		=> "text"
			);

/*
== ------------------------------------------------------------------- ==
== @@ Backup Options Tab
== ------------------------------------------------------------------- ==
*/

$of_options[] = array( 	
	"name" 		=> __( "Backups", 'invicta_dictionary' ),
	"type" 		=> "heading",
	"icon"		=> ADMIN_IMAGES . "icon-slider.png"
	);
				
$of_options[] = array( 	
	"name" 		=> __( "Backup and Restore Options", 'invicta_dictionary' ),
	"id" 		=> "of_backup",
	"std" 		=> "",
	"type" 		=> "backup",
	"desc" 		=> __( 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'invicta_dictionary' ),
	);
				
$of_options[] = array( 	
	"name" 		=> __( "Transfer Theme Options Data", 'invicta_dictionary' ),
	"id" 		=> "of_transfer",
	"std" 		=> "",
	"type" 		=> "transfer",
	"desc" 		=> __( 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'invicta_dictionary' ),
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()

?>
