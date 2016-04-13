<?php 
/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Visual Composer Extend
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ Register theme shortcodes
	
	@@ Shortcode Mapping - Heading
	@@ Shortcode Mapping - Iconbox
	@@ Shortcode Mapping - Steps
	@@ Shortcode Mapping - Counters
	@@ Shortcode Mapping - Partners
	@@ Shortcode Mapping - Testimonial
	@@ Shortcode Mapping - Testimonial Carousel
	@@ Shortcode Mapping - Person
	@@ Shortcode Mapping - Letter
	@@ Shortcode Mapping - Portfolio
	@@ Shortcode Mapping - Blog
	@@ Shortcode Mapping - Contacts
	@@ Shortcode Mapping - Timespan
	@@ Shortcode Mapping - World Map
	@@ Shortcode Mapping - Europe Map
	@@ Shortcode Mapping - ProgressBars
	@@ Shortcode Mapping - Button
	@@ Shortcode Mapping - Social Links
	@@ Shortcode Mapping - Instagram Feed
	@@ Shortcode Mapping - Twitter Feed
	@@ Shortcode Mapping - Icon Tab
	@@ Shortcode Mapping - Go Pricing Table
	
	@@ Shortcode Customization - Single Image
	@@ Hide Settings Menu

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

//add_filter( 'pre_site_transient_update_plugins', '__return_null' );
if ( function_exists( 'vc_set_as_theme' ) ) {
	vc_set_as_theme(true);
}

/*
== ------------------------------------------------------------------- ==
== @@ Register theme shortcodes
== ------------------------------------------------------------------- ==
*/

if ( function_exists( 'vc_is_inline' ) && vc_is_inline() ) {
	add_action( 'init', 'invicta_visual_composer_extender' );
}
else {
	add_action( 'admin_init', 'invicta_visual_composer_extender' );
}

function invicta_visual_composer_extender() {

	global $smof_data;
	
	invicta_visual_composer_extender_remove_elements();

	/* animation */
	
	$add_css_animation = array(
		'type' 			=> 'dropdown',
		'heading' 		=> __('CSS Animation', 'invicta_dictionary'),
		'param_name' 	=> 'css_animation',
		'admin_label' 	=> true,
		'value' 		=> array(
			__('No', 'invicta_dictionary') 					=> '', 
			__('Top to bottom', 'invicta_dictionary') 		=> 'top-to-bottom', 
			__('Bottom to top', 'invicta_dictionary') 		=> 'bottom-to-top', 
			__('Left to right', 'invicta_dictionary') 		=> 'left-to-right', 
			__('Right to left', 'invicta_dictionary') 		=> 'right-to-left', 
			__('Appear from center', 'invicta_dictionary') 	=> 'appear'
		),
		'description' => __( "Select animation type if you want this element to be animated when it enters into the browsers viewport. <br />Note: Works only in modern browsers.", 'invicta_dictionary' )
	);
	
	/* icons */
	
	$invicta_active_icons = invicta_get_active_icons();
	$icons = array();
	
	foreach ( $invicta_active_icons as $icon ) {
		$icons['<i class="invicta_icon icon-2x ' . $icon . '"></i>'] = $icon;	
	}
	
	// link types
	
	$link_types[ __( 'Set Manually', 'invicta_dictionary') ] = 'manually';
	$link_types[ __( 'Page', 'invicta_dictionary') ] = 'page';
	$link_types[ __( 'Post', 'invicta_dictionary') ] = 'post';
	$link_types[ __( 'Portfolio Project', 'invicta_dictionary') ] = 'project';
	$link_types[ __( 'Photo Gallery', 'invicta_dictionary') ] = 'photo_gallery';
	
	$link_types_pages[ __( 'None', 'invicta_dictionary') ] = '';
	$link_types_pages[ __( 'Set Manually', 'invicta_dictionary') ] = 'manually';
	$link_types_pages[ __( 'Page', 'invicta_dictionary') ] = 'page';
	
	$link_types_iconbox[ __( 'None', 'invicta_dictionary') ] = 'none';
	$link_types_iconbox[ __( 'Set Manually', 'invicta_dictionary') ] = 'manually';
	$link_types_iconbox[ __( 'Page', 'invicta_dictionary') ] = 'page';
	$link_types_iconbox[ __( 'Post', 'invicta_dictionary') ] = 'post';
	$link_types_iconbox[ __( 'Portfolio Project', 'invicta_dictionary') ] = 'project';
	$link_types_iconbox[ __( 'Photo Gallery', 'invicta_dictionary') ] = 'photo_gallery';
		
	// wordpress pages

	$wp_pages = array();
	$parents = array();
	
	foreach ( $wp_pages_set = get_pages() as $page ) {
	
		// the following set of IFs 
		// is to calculate the number of '-' that should be preppended to the page name
		// in order to represent the pages hierarchy
		if ( $page->post_parent == 0 ) {
			$parents = array();
		}
		else {
			if ( count( $parents ) == 0 ) {
				array_push( $parents, $page->post_parent );
			}
			else {
			
				if ( ! in_array( $page->post_parent, $parents ) ) {
					array_push( $parents, $page->post_parent );
				}
				else {
					if ( $parents[ count( $parents ) - 1 ] != $page->post_parent ) {
						array_pop( $parents );
					}
				}
			}
		}

		$wp_pages[ str_repeat( '-', count( $parents ) ) . ' ' . $page->post_title ] = $page->ID;

	}
	
	// wordpress posts
	
	$wp_posts = array();
	
	foreach ( $wp_posts_set = get_posts('posts_per_page=-1') as $post ) {
		$wp_posts[ $post->post_title ] = $post->ID;
	}
	
	// wordpress portfolio projects
	
	$wp_projects = array();
	
	foreach ( $wp_projects_set = get_posts('post_type=invicta_portfolio&posts_per_page=-1') as $project ) {
		$wp_projects[ $project->post_title ] = $project->ID;
	}
	
	// wordpress photo galleries
	
	$wp_photogalleries = array();
	
	foreach ( $wp_galleries_set = get_posts('post_type=invicta_photos&posts_per_page=-1') as $photo_gallery ) {
		$wp_photogalleries[ $photo_gallery->post_title ] = $photo_gallery->ID;
	}
	
	// invicta countries
	
	$invicta_countries = invicta_get_countries();
	$invicta_countries_europe = invicta_get_countries_europe();
	$invicta_countries_usa = invicta_get_countries_usa();
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Heading
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$html_elements = array(
			__( 'Default', 'invicta_dictionary' ) 	=> '',
			__( 'h1', 'invicta_dictionary' )		=> 'h1',
			__( 'h2', 'invicta_dictionary' )		=> 'h2',
			__( 'h3', 'invicta_dictionary' )		=> 'h3',
			__( 'h4', 'invicta_dictionary' )		=> 'h4',
			__( 'h5', 'invicta_dictionary' )		=> 'h5',
			__( 'h6', 'invicta_dictionary' )		=> 'h6'
		);
	
		vc_map( array(
			"name"           => __( "Heading", "invicta_dictionary" ),
			'description'    => __( "Invicta Heading", 'invicta_dictionary'),
			"base"           => "invicta_heading",
			"class"          => "invicta_shortcode_heading",
			'icon'           => 'icon-wpb-heading',
			"category"       => __("Content", "invicta_dictionary" ),
			"params"         => array(
				array(
					"type"			=> "textfield",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Primary Line", "invicta_dictionary" ),
					'param_name'	=> 'primary_line',
					'description'	=> __('The primary heading line', "invicta_dictionary" )
				),
				array(
					"type"			=> "exploded_textarea",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Primary Line Keywords", "invicta_dictionary") ,
					'param_name'	=> 'primary_line_keywords',
					'description'	=> __('Keywords that should be highlighted in primary line (one per line)', "invicta_dictionary" )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Primary Line HTML Element", "invicta_dictionary") ,
					'param_name'	=> 'primary_line_html_elem',
					'description'	=> __( "HTML Element to wrap the title's primary line", "invicta_dictionary" ),
					'value'			=> $html_elements,
				),
				array(
					"type"			=> "textarea",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Secondary Line", "invicta_dictionary" ),
					'param_name'	=> 'secondary_line',
					'description'	=> __('The secondary heading line', "invicta_dictionary" )
				),
				array(
					"type"			=> "exploded_textarea",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Secondary Line Keywords", "invicta_dictionary" ),
					'param_name'	=> 'secondary_line_keywords',
					'description'	=> __( 'Keywords that should be highlighted in secondary line (one per line)', "invicta_dictionary" )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Secondary Line HTML Element", "invicta_dictionary") ,
					'param_name'	=> 'secondary_line_html_elem',
					'description'	=> __( "HTML Element to wrap the title's secondary line", "invicta_dictionary" ),
					'value'			=> $html_elements,
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Text Alignment", "invicta_dictionary" ),
					'param_name'	=> 'alignment',
					'value'			=> array(
						'Center' 		=> 'center',
						'Left' 			=> 'left',
						'Right'			=> 'right'
						)
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Text Alignment", "invicta_dictionary" ),
					'param_name'	=> 'size',
					'value'			=> array(
						'Big' 			=> 'big',
						'Small' 		=> 'small'
						)
				)
				
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Iconbox
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
		
		vc_map( array(
			'name'           => __( 'Iconbox', 'invicta_dictionary' ),
			'description'    => __( "Invicta Iconbox", 'invicta_dictionary'),
			'base'           => 'invicta_iconbox',
			'class'          => 'invicta_shortcode_iconbox',
			'icon'           => 'icon-wpb-iconbox',
			'category'       => __('Content', 'invicta_dictionary' ),
			"params"         => array(
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Title', 'invicta_dictionary' ),
					'param_name'	=> 'title',
					'value'			=> __( 'Iconbox Title', 'invicta_dictionary' ),
				),
				array(
					"type"			=> "checkbox",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Icon", "invicta_dictionary" ),
					'param_name'	=> 'icon',
					'value' 		=> $icons
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __('Text', 'invicta_dictionary' ),
					'param_name'	=> 'text',
					'value' 		=> __( "I am test iconbox. Please populate me a couple of words.", 'invicta_dictionary' ),
					'description'	=> "",
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Style", "invicta_dictionary" ),
					'param_name'	=> 'style',
					'value'			=> array(
						__( 'Default', 'invicta_dictionary' ) 	=> 'default',
						__( 'Centered', 'invicta_dictionary' ) 	=> 'centered',
						__( 'Clean', 'invicta_dictionary' )		=> 'clean'
						)
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'link_type',
					'heading'		=> __( "Link","invicta_dictionary" ),
					'value'			=> $link_types_iconbox,
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'page_id',
					'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
					'value'			=> $wp_pages,
					'dependency'	=> array(
						'element' 		=> 'link_type',
						'value'			=> array('page')
					)
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'post_id',
					'description'	=> __( 'Where should the link redirect to?', 'invicta_dictionary' ),
					'value'			=> $wp_posts,
					'dependency'	=> array(
						'element' 		=> 'link_type',
						'value'			=> array('post')
					)
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'project_id',
					'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
					'value'			=> $wp_projects,
					'dependency'	=> array(
						'element' 		=> 'link_type',
						'value'			=> array('project')
					)
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'photogallery_id',
					'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
					'value'			=> $wp_photogalleries,
					'dependency'	=> array(
						'element' 		=> 'link_type',
						'value'			=> array('photo_gallery')
					)
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'url',
					'value'			=> 'http://',
					'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
					'dependency'	=> array(
						'element' 		=> 'link_type',
						'value'			=> array('manually')
					)
				),
				$add_css_animation
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Steps
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Steps', 'invicta_dictionary' ),
				'description'   => __( "Invicta Steps", 'invicta_dictionary'),
				'base'          => 'invicta_steps',
				'class'         => 'invicta_shortcode_steps',
				'icon'          => 'icon-wpb-steps',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'checkbox',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Animation', 'invicta_dictionary' ),
						'param_name'	=> 'animation',
						'value' 		=> array(
							__("Add animation to the icons", "invicta_dictionary" ) => "animated"
							)
					),
					// Step #1
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Step #1', 'invicta_dictionary' ),
						'param_name'	=> 'name_1',
						'description'	=> __( 'Step Name', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'text_1',
						'description'	=> __( 'Step Description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_1',
						'value' 		=> $icons,
						'description'	=> __( 'Step Icon', 'invicta_dictionary' )
					),
					// Step #2
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Step #2', 'invicta_dictionary' ),
						'param_name'	=> 'name_2',
						'description'	=> __( 'Step Name', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'text_2',
						'description'	=> __( 'Step Description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_2',
						'value' 		=> $icons,
						'description'	=> __( 'Step Icon', 'invicta_dictionary' )
					),
					// Step #3
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Step #3', 'invicta_dictionary' ),
						'param_name'	=> 'name_3',
						'description'	=> __( 'Step Name', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'text_3',
						'description'	=> __( 'Step Description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_3',
						'value' 		=> $icons,
						'description'	=> __( 'Step Icon', 'invicta_dictionary' )
					),
					// Step #4
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Step #4', 'invicta_dictionary' ),
						'param_name'	=> 'name_4',
						'description'	=> __( 'Step Name', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'text_4',
						'description'	=> __( 'Step Description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_4',
						'value' 		=> $icons,
						'description'	=> __( 'Step Icon', 'invicta_dictionary' )
					),
					// Step #5
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Step #5', 'invicta_dictionary' ),
						'param_name'	=> 'name_5',
						'description'	=> __( 'Step Name', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'text_5',
						'description'	=> __( 'Step Description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_5',
						'value' 		=> $icons,
						'description'	=> __( 'Step Icon', 'invicta_dictionary' )
					),
				)
			) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Counters
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Counters', 'invicta_dictionary' ),
				'description'   => __( "Invicta Counters", 'invicta_dictionary'),
				'base'          => 'invicta_counters',
				'class'         => 'invicta_shortcode_counters',
				'icon'          => 'icon-wpb-counters',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'checkbox',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Animation', 'invicta_dictionary' ),
						'param_name'	=> 'animation',
						'value' 		=> array(
							__("Add animation to the counters", "invicta_dictionary" ) => "animated"
							)
					),
					array(
						"type"			=> "exploded_textarea",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("Counters Values", "invicta_dictionary") ,
						'param_name'	=> 'counters_values',
						'value' 		=> '100|Products,200|Sales,300|Members,400|Views',
						'description'	=> __('Input counters values here. Divide values with linebreaks (Enter). Example: 85|Products', "invicta_dictionary" )
					)
				)
			) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Partners
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
			'name'           => __( 'Partners', 'invicta_dictionary' ),
			'description'    => __( "Invicta Partners", 'invicta_dictionary'),
			'base'           => 'invicta_partners',
			'class'          => 'invicta_shortcode_partners',
			'icon'           => 'icon-wpb-partners',
			'category'       => __('Content', 'invicta_dictionary' ),
			'params'         => array(
				$add_css_animation,
				array(
					"type"			=> "checkbox",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'blackandwhite_effect',
					'value' 		=> array(
											__("Activate Black & White Effect on Logos (works better on .jpg with background images)", "invicta_dictionary" ) => "yes"
										),
					'heading'		=> __( 'Black White Effect', 'invicta_dictionary' ),
				),
				
				
				// Partner #1
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #1', 'invicta_dictionary' ),
					'param_name'	=> 'name_1',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_1',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_1',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #2
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #2', 'invicta_dictionary' ),
					'param_name'	=> 'name_2',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_2',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_2',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #3
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #3', 'invicta_dictionary' ),
					'param_name'	=> 'name_3',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_3',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_3',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #4
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #4', 'invicta_dictionary' ),
					'param_name'	=> 'name_4',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_4',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_4',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #5
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #5', 'invicta_dictionary' ),
					'param_name'	=> 'name_5',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_5',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_5',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #6
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #6', 'invicta_dictionary' ),
					'param_name'	=> 'name_6',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_6',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_6',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #7
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #7', 'invicta_dictionary' ),
					'param_name'	=> 'name_7',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_7',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_7',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				// Partner #8
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Partner #8', 'invicta_dictionary' ),
					'param_name'	=> 'name_8',
					'description'	=> __( 'Partner Name', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'link_8',
					'description'	=> __( 'Partner URL', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'logo_8',
					'value' 		=> '',
					'description'	=> __( "Partner Logo", 'invicta_dictionary' )
				),
				
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Testimonial
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
		
		$countries = array();
	
		$countries['-- ' . __( 'Select Country', 'invicta_dictionary' ) . ' --'] = '';
		foreach ( $invicta_countries as $country_id => $country_name ) {
			$countries[ $country_name ] = $country_id;
		}
		
		vc_map( array(
			'name'           => __( 'Testimonial', 'invicta_dictionary' ),
			'description'    => __( "Invicta Testimonial", 'invicta_dictionary'),
			'base'           => 'invicta_testimonial',
			'class'          => 'invicta_shortcode_testimonial',
			'icon'           => 'icon-wpb-testimonial',
			'category'       => __('Content', 'invicta_dictionary' ),
			"params"         => array(
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Author Name', 'invicta_dictionary' ),
					'param_name'	=> 'author_name',
					'value'			=> __( 'Author Name', 'invicta_dictionary' ),
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo',
					'value' 		=> '',
					'heading'		=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea_html',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __('Content', 'invicta_dictionary' ),
					'param_name'	=> 'content',
					'value' 		=> __( "<p>I am test testimonial. Please populate me a couple of phrases.</p>", 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url',
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Style", "invicta_dictionary" ),
					'param_name'	=> 'style',
					'value'			=> array(
						__( 'Style #1', 'invicta_dictionary' ) 	=> 'style_1',
						__( 'Style #2', 'invicta_dictionary' ) 	=> 'style_2'
						)
				),
				$add_css_animation
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Testimonial Carousel
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
		
		$invicta_countries = invicta_get_countries();
		$countries = array();
	
		$countries['-- ' . __( 'Select Country', 'invicta_dictionary' ) . ' --'] = '';
		foreach ( $invicta_countries as $country_id => $country_name ) {
			$countries[ $country_name ] = $country_id;
		}
		
		vc_map( array(
			'name'           => __( 'Testimonial Carousel', 'invicta_dictionary' ),
			'description'    => __( "Invicta Testimonial Carousel", 'invicta_dictionary'),
			'base'           => 'invicta_testimonial_carousel',
			'class'          => 'invicta_shortcode_testimonial_carousel',
			'icon'           => 'icon-wpb-testimonial_carousel',
			'category'       => __('Content', 'invicta_dictionary' ),
			"params"         => array(
				array(
					'type'			=> 'dropdown',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Carousel Timeout', 'invicta_dictionary' ),
					'param_name'	=> 'carousel_timeout',
					'value'			=> array(
						__( "Don't auto scroll", 'invicta_dictionary' ) => 0,
						__( '5 seconds', 'invicta_dictionary' ) => 5000,
						__( '6 seconds', 'invicta_dictionary' ) => 6000,
						__( '7 seconds', 'invicta_dictionary' ) => 7000,
						__( '8 seconds', 'invicta_dictionary' ) => 8000,
						__( '9 seconds', 'invicta_dictionary' ) => 9000,
						__( '10 seconds', 'invicta_dictionary' ) => 10000,
						__( '11 seconds', 'invicta_dictionary' ) => 11000,
						__( '12 seconds', 'invicta_dictionary' ) => 12000,
						__( '13 seconds', 'invicta_dictionary' ) => 13000,
						__( '14 seconds', 'invicta_dictionary' ) => 14000,
						__( '15 seconds', 'invicta_dictionary' ) => 15000,
					),
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Background Label', 'invicta_dictionary' ),
					'param_name'	=> 'background_label',
					'value'			=> "",
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #1', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_1',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_1',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_1',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_1',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_1',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_1',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #2', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_2',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_2',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_2',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_2',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_2',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_2',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #3', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_3',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_3',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_3',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_3',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_3',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_3',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #4', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_4',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_4',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_4',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_4',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_4',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_4',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #5', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_5',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_5',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_5',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_5',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_5',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_5',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Testimonial #6', 'invicta_dictionary' ),
					'param_name'	=> 'author_name_6',
					'value'			=> "",
					'description'	=> __( "Author Name", 'invicta_dictionary' )
				),
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'description'	=> __( "Author Country", "invicta_dictionary" ),
					'param_name'	=> 'author_country_6',
					'value'			=> $countries
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'param_name'	=> 'author_photo_6',
					'value' 		=> '',
					'description'	=> __( "Author Photo", "invicta_dictionary" ),
				),
				array(
					'type'			=> 'textarea',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __('Testimonial Text', 'invicta_dictionary' ),
					'param_name'	=> 'text_6',
					'value' 		=> ""
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'		=> __( 'Source Name', 'invicta_dictionary' ),
					'param_name'	=> 'source_name_6',
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'description'	=> __( 'Source URL', 'invicta_dictionary' ),
					'param_name'	=> 'source_url_6',
				),

			)
		) );
	
	}
		
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Person
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) { 
		
		vc_map( array(
				'name'          => __( 'Person', 'invicta_dictionary' ),
				'description'   => __( "Invicta Person", 'invicta_dictionary'),
				'base'          => 'invicta_person',
				'class'         => 'invicta_shortcode_person',
				'icon'          => 'icon-wpb-person',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'title',
						'heading'		=> __( 'Name', 'invicta_dictionary' ),
						'value'			=> '',
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'sub_title',
						'heading'		=> __( 'Department', 'invicta_dictionary' ),
						'value'			=> '',
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'excerpt',
						'heading'		=> __( 'Excerpt', 'invicta_dictionary' ),
						'value'			=> '',
					),
					array(
						'type'			=> 'attach_image',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'photo',
						'value' 		=> '',
						'heading'		=> __( 'Photo', 'invicta_dictionary' ),
						'description'	=> __( "Upload the person's photo. A square (1x1) photo is recommended.", 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'link_type',
						'heading'		=> __( "Link","invicta_dictionary" ),
						'value'			=> $link_types_pages,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'page_id',
						'description'	=> __( 'Where should the photo link to?', 'invicta_dictionary' ),
						'value'			=> $wp_pages,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('page')
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'url',
						'value'			=> 'http://',
						'description'	=> __( 'Where should the photo link to?', 'invicta_dictionary' ),
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('manually')
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'E-Mail', 'invicta_dictionary' ),
						'param_name'	=> 'email',
						'value'			=> '',
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'twitter',
						'value'			=> '',
						'heading'		=> __( 'Twitter', 'invicta_dictionary' ),
						'description'	=> __( 'Twitter URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'facebook',
						'value'			=> '',
						'heading'		=> __( 'Facebook', 'invicta_dictionary' ),
						'description'	=> __( 'Facebook URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'googleplus',
						'value'			=> '',
						'heading'		=> __( 'Google Plus', 'invicta_dictionary' ),
						'description'	=> __( 'Google Plus URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'linkedin',
						'value'			=> '',
						'heading'		=> __( 'LinkedIn', 'invicta_dictionary' ),
						'description'	=> __( 'LinkedIn URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'xing',
						'value'			=> '',
						'heading'		=> __( 'Xing', 'invicta_dictionary' ),
						'description'	=> __( 'Xing URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'dribbble',
						'value'			=> '',
						'heading'		=> __( 'Dribbble', 'invicta_dictionary' ),
						'description'	=> __( 'Dribbble URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'flickr',
						'value'			=> '',
						'heading'		=> __( 'Flickr', 'invicta_dictionary' ),
						'description'	=> __( 'Flickr URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'tumblr',
						'value'			=> '',
						'heading'		=> __( 'Tumblr', 'invicta_dictionary' ),
						'description'	=> __( 'Tumblr URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'skype',
						'value'			=> '',
						'heading'		=> __( 'Skype', 'invicta_dictionary' ),
						'description'	=> __( 'Skype Username', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'instagram',
						'value'			=> '',
						'heading'		=> __( 'Instagram', 'invicta_dictionary' ),
						'description'	=> __( 'Instagram URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'pinterest',
						'value'			=> '',
						'heading'		=> __( 'Pinterest', 'invicta_dictionary' ),
						'description'	=> __( 'Pinterest URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'foursquare',
						'value'			=> '',
						'heading'		=> __( 'Foursquare', 'invicta_dictionary' ),
						'description'	=> __( 'Foursquare URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'youtube',
						'value'			=> '',
						'heading'		=> __( 'Youtube', 'invicta_dictionary' ),
						'description'	=> __( 'Youtube URL', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'style',
						'heading'		=> __( 'Style', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Default', 'invicta_dictionary' ) => 'default',
							__( 'Condensed', 'invicta_dictionary' ) => 'condensed'
						)
					),
					$add_css_animation
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Letter
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
			'name'           => __( 'Letter', 'invicta_dictionary' ),
			'description'    => __( "Invicta Letter", 'invicta_dictionary'),
			'base'           => 'invicta_letter',
			'class'          => 'invicta_shortcode_letter',
			'icon'           => 'icon-wpb-letter',
			'category'       => __('Content', 'invicta_dictionary' ),
			'params'         => array(
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Title', 'invicta_dictionary' ),
					'param_name'	=> 'title',
					'description'	=> __( 'The title of the Letter', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'textarea_html',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __('Content', 'invicta_dictionary' ),
					'param_name'	=> 'content',
					'value' 		=> __( "<p>I am test text block. Click edit button to change this text.</p>", 'invicta_dictionary' ),
					'description'	=> __( 'The content of the Letter', 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Author Photo', 'invicta_dictionary' ),
					'param_name'	=> 'author_photo',
					'value' 		=> '',
					'description'	=> __( "Upload the author's photo. A square (1x1) photo is recommended.", 'invicta_dictionary' )
				),
				array(
					'type'			=> 'attach_image',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Author Signature', 'invicta_dictionary' ),
					'param_name'	=> 'author_signature',
					'value' 		=> '',
					'description'	=> __( "Upload the author's signature image.", 'invicta_dictionary' )
				)
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Portfolio
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$portfolio_categories = array();
		foreach ( get_terms( 'invicta_portfolio_category' ) as $category ) {
			$portfolio_categories[ $category->name ] = $category->term_id;
		}
		
		$portfolio_metadata = array(
			__( 'The project date', 'invicta_dictionary' ) 			=> 'date',
			__( 'The project categories', 'invicta_dictionary' ) 	=> 'categories',
			__( 'Nothing', 'invicta_dictionary' )					=> '-1',
		);
		
		$portfolio_linking = array(
			__( 'Open the single project page', 'invicta_dictionary' ) 				=> '1',
			__( 'Display the featured image in a lightbox', 'invicta_dictionary' ) 	=> '2'
		);
		
		vc_map( array(
				'name'          => __( 'Portfolio', 'invicta_dictionary' ),
				'description'   => __( "Invicta Portfolio", 'invicta_dictionary'),
				'base'          => 'invicta_portfolio',
				'class'         => 'invicta_shortcode_portfolio',
				'icon'          => 'icon-wpb-portfolio',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Number of items', 'invicta_dictionary' ),
						'param_name'	=> 'posts_per_page',
						'value'			=> 4,
						'description'	=> __( 'How many projects should be displayed?', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'filtered_categories',
						'value' 		=> $portfolio_categories,
						'heading'		=> __( 'Categories', 'invicta_dictionary' ),
						'description'	=> __( 'Which categories should be used for the portfolio?', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'linking',
						'heading'		=> __( "Link Handling","invicta_dictionary" ),
						'description'	=> __( 'What do you want to happen when a portfolio item is clicked?', 'invicta_dictionary' ),
						'value'			=> $portfolio_linking,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'metadata',
						'heading'		=> __( "Metadata","invicta_dictionary" ),
						'description'	=> __( 'What extra info do you want to show with the project title?', 'invicta_dictionary' ),
						'value'			=> $portfolio_metadata,
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Blog
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {

		$blog_categories = array();
		foreach ( get_categories() as $category ) {
			$blog_categories[ $category->name ] = $category->term_id;
		}
		
		vc_map( array(
				'name'          => __( 'Blog', 'invicta_dictionary' ),
				'description'   => __( "Invicta Blog Teasers", 'invicta_dictionary'),
				'base'          => 'invicta_blog',
				'class'         => 'invicta_shortcode_blog',
				'icon'          => 'icon-wpb-blog',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Number of items', 'invicta_dictionary' ),
						'param_name'	=> 'posts_per_page',
						'value'			=> 4,
						'description'	=> __( 'How many posts should be displayed?', 'invicta_dictionary' )
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'filtered_categories',
						'value' 		=> $blog_categories,
						'heading'		=> __( 'Categories', 'invicta_dictionary' ),
						'description'	=> __( 'Which categories should be used?', 'invicta_dictionary' )
					),
/*
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'linking',
						'heading'		=> __( "Link Handling","invicta_dictionary" ),
						'description'	=> __( 'What do you want to happen when a portfolio item is clicked?', 'invicta_dictionary' ),
						'value'			=> $portfolio_linking,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'metadata',
						'heading'		=> __( "Metadata","invicta_dictionary" ),
						'description'	=> __( 'What extra info do you want to show with the project title?', 'invicta_dictionary' ),
						'value'			=> $portfolio_metadata,
					),
*/
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Contacts
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Contacts', 'invicta_dictionary' ),
				'description'   => __( "Invicta Contacts Set", 'invicta_dictionary'),
				'base'          => 'invicta_contacts',
				'class'         => 'invicta_shortcode_contacts',
				'icon'          => 'icon-wpb-contacts',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Title', 'invicta_dictionary' ),
						'param_name'	=> 'title',
						'value'			=> '',
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Intro', 'invicta_dictionary' ),
						'param_name'	=> 'intro',
						'value'			=> '',
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Address', 'invicta_dictionary' ),
						'param_name'	=> 'address',
						'value'			=> '',
					),
					array(
						'type'			=> 'exploded_textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Phone', 'invicta_dictionary' ),
						'param_name'	=> 'phone',
						'value'			=> '',
						'description'	=> __( 'One per line', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'exploded_textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Mobile', 'invicta_dictionary' ),
						'param_name'	=> 'mobile',
						'value'			=> '',
						'description'	=> __( 'One per line', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'exploded_textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'E-Mail', 'invicta_dictionary' ),
						'param_name'	=> 'email',
						'value'			=> '',
						'description'	=> __( 'One per line', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'exploded_textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'URL', 'invicta_dictionary' ),
						'param_name'	=> 'url',
						'value'			=> '',
						'description'	=> __( 'One per line', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Google Map Link', 'invicta_dictionary' ),
						'param_name'	=> 'google_map',
						'value'			=> '',
						'description'	=> __( 'Link to your map. Visit <a href="http://maps.google.com/">Google maps</a> to find your address and then click "Link" button to obtain your map link.', 'invicta_dictionary' )
					)
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Timespan
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$times['0:00 / 12:00 H'] = 0;
		$times['0:30 / 12:30 H'] = 0.5;
		$times['1:00 H'] = 1;
		$times['1:30 H'] = 1.5;
		$times['2:00 H'] = 2;
		$times['2:30 H'] = 2.5;
		$times['3:00 H'] = 3;
		$times['3:30 H'] = 3.5;
		$times['4:00 H'] = 4;
		$times['4:30 H'] = 4.5;
		$times['5:00 H'] = 5;
		$times['5:30 H'] = 5.5;
		$times['6:00 H'] = 6;
		$times['6:30 H'] = 6.5;
		$times['7:00 H'] = 7;
		$times['7:30 H'] = 7.5;
		$times['8:00 H'] = 8;
		$times['8:30 H'] = 8.5;
		$times['9:00 H'] = 9;
		$times['9:30 H'] = 9.5;
		$times['10:00 H'] = 10;
		$times['10:30 H'] = 10.5;
		$times['11:00 H'] = 11;
		$times['11:30 H'] = 11.5;
		
		vc_map( array(
				'name'          => __( 'Timespan', 'invicta_dictionary' ),
				'description'   => __( "Invicta Timespan", 'invicta_dictionary'),
				'base'          => 'invicta_timespan',
				'class'         => 'invicta_shortcode_timespan',
				'icon'          => 'icon-wpb-timespan',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Title', 'invicta_dictionary' ),
						'param_name'	=> 'title',
						'value'			=> '',
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'begin',
						'heading'		=> __( "Begin","invicta_dictionary" ),
						'description'	=> __( 'At what time the period begin?', 'invicta_dictionary' ),
						'value'			=> $times,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'end',
						'heading'		=> __( "End","invicta_dictionary" ),
						'description'	=> __( 'At what time the period end?', 'invicta_dictionary' ),
						'value'			=> $times,
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Text', 'invicta_dictionary' ),
						'param_name'	=> 'text',
						'value'			=> __( 'We can meet you by appointment from <b>Monday</b> to <b>Friday</b> between 10:00 and 17:00', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'checkbox',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Animation', 'invicta_dictionary' ),
						'param_name'	=> 'animation',
						'value' 		=> array(
							__("Add animation to the timepsan", "invicta_dictionary" ) => "animated"
							)
					)
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - World Map
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$locations = array();
		
		foreach ( $invicta_countries as $country_id => $country_name ) {
			$countries[ $country_name ] = $country_id;
			$locations[ '<label for="locations-' . $country_id . '" class="world_location">' . $country_name . '</label>' ] = $country_id;
		}	
		
		vc_map( array(
				'name'          => __( 'World Map', 'invicta_dictionary' ),
				'description'   => __( "Invicta World Map", 'invicta_dictionary'),
				'base'          => 'invicta_world_map',
				'class'         => 'invicta_shortcode_world_map',
				'icon'          => 'icon-wpb-world_map',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'label_visibility',
						'heading'		=> __( 'Label Visibility', 'invicta_dictionary' ),
						'value'			=> array(
							__( "Always", 'invicta_dictionary' ) 			=> 'always',
							__( 'On Mouse Hover', 'invicta_dictionary' ) 	=> 'hover',
							__( 'Never', 'invicta_dictionary' ) 			=> 'never'
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Label Position Offset', 'invicta_dictionary' ),
						'description'	=> __( 'in pixels', 'invicta_dictionary' ),
						'param_name'	=> 'label_offset',
						'value'			=> 4,
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Initial Animation Timeout', 'invicta_dictionary' ),
						'description'	=> __( 'The delay (miliseconds) between each marker display', 'invicta_dictionary' ),
						'param_name'	=> 'initial_animation_timeout',
						'value'			=> 200,
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("Locations", "invicta_dictionary" ),
						'param_name'	=> 'locations',
						'value' 		=> $locations
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> '',
						'param_name'	=> 'label_positions',
						'value'			=> '',
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Europe Map
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$locations = array();
		
		foreach ( $invicta_countries_europe as $country_id => $country_name ) {
			$countries[ $country_name ] = $country_id;
			$locations[ '<label for="locations-' . $country_id . '" class="world_location">' . $country_name . '</label>' ] = $country_id;
		}	
		
		vc_map( array(
				'name'          => __( 'Europe Map', 'invicta_dictionary' ),
				'description'   => __( "Invicta Europe Map", 'invicta_dictionary'),
				'base'          => 'invicta_europe_map',
				'class'         => 'invicta_shortcode_europe_map',
				'icon'          => 'icon-wpb-europe_map',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'label_visibility',
						'heading'		=> __( 'Label Visibility', 'invicta_dictionary' ),
						'value'			=> array(
							__( "Always", 'invicta_dictionary' ) 			=> 'always',
							__( 'On Mouse Hover', 'invicta_dictionary' ) 	=> 'hover',
							__( 'Never', 'invicta_dictionary' ) 			=> 'never'
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Label Position Offset', 'invicta_dictionary' ),
						'description'	=> __( 'in pixels', 'invicta_dictionary' ),
						'param_name'	=> 'label_offset',
						'value'			=> 4,
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Initial Animation Timeout', 'invicta_dictionary' ),
						'description'	=> __( 'The delay (miliseconds) between each marker display', 'invicta_dictionary' ),
						'param_name'	=> 'initial_animation_timeout',
						'value'			=> 200,
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("Locations", "invicta_dictionary" ),
						'param_name'	=> 'locations',
						'value' 		=> $locations
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> '',
						'param_name'	=> 'label_positions',
						'value'			=> '',
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - USA Map
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$locations = array();
		
		foreach ( $invicta_countries_usa as $country_id => $country_name ) {
			$countries[ $country_name ] = $country_id;
			$locations[ '<label for="locations-' . $country_id . '" class="world_location">' . $country_name . '</label>' ] = $country_id;
		}	
		
		vc_map( array(
				'name'          => __( 'USA Map', 'invicta_dictionary' ),
				'description'   => __( "Invicta USA Map", 'invicta_dictionary'),
				'base'          => 'invicta_usa_map',
				'class'         => 'invicta_shortcode_usa_map',
				'icon'          => 'icon-wpb-usa_map',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'label_visibility',
						'heading'		=> __( 'Label Visibility', 'invicta_dictionary' ),
						'value'			=> array(
							__( "Always", 'invicta_dictionary' ) 			=> 'always',
							__( 'On Mouse Hover', 'invicta_dictionary' ) 	=> 'hover',
							__( 'Never', 'invicta_dictionary' ) 			=> 'never'
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Label Position Offset', 'invicta_dictionary' ),
						'description'	=> __( 'in pixels', 'invicta_dictionary' ),
						'param_name'	=> 'label_offset',
						'value'			=> 4,
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Initial Animation Timeout', 'invicta_dictionary' ),
						'description'	=> __( 'The delay (miliseconds) between each marker display', 'invicta_dictionary' ),
						'param_name'	=> 'initial_animation_timeout',
						'value'			=> 200,
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("Locations", "invicta_dictionary" ),
						'param_name'	=> 'locations',
						'value' 		=> $locations
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> '',
						'param_name'	=> 'label_positions',
						'value'			=> '',
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - ProgressBars
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
			'name'           => __( 'Progress Bars', 'invicta_dictionary' ),
			'description'    => __( "Invicta Progress Bars", 'invicta_dictionary'),
			'base'           => 'invicta_progressbars',
			'class'          => 'invicta_shortcode_progressbars',
			'icon'           => 'icon-wpb-progressbars',
			'category'       => __('Content', 'invicta_dictionary' ),
			'params'         => array(
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Title', 'invicta_dictionary' ),
					'param_name'	=> 'title',
					'value'			=> '',
				),
				array(
					"type"			=> "exploded_textarea",
					"holder"		=> "div",
					"class"			=> "",
					'heading'		=> __("Graphic values", "invicta_dictionary") ,
					'param_name'	=> 'graphic_values',
					'value' 		=> '90|Development,80|Design,70|Marketing',
					'description'	=> __('Input graph values here. Divide values with linebreaks (Enter). Example: 90|Development', "invicta_dictionary" )
				),
				array(
					'type'			=> 'textfield',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Units', 'invicta_dictionary' ),
					'param_name'	=> 'units',
					'description'	=> __('Enter measurement units (if needed) Eg. %, px, points, etc. Graph value and unit will be appended to the graph title.', "invicta_dictionary" )
				),
				array(
					'type'			=> 'checkbox',
					'holder'		=> 'div',
					'class'			=> '',
					'heading'		=> __( 'Animation', 'invicta_dictionary' ),
					'param_name'	=> 'animation',
					'value' 		=> array(
						__("Add animation to the progress bars", "invicta_dictionary" ) => "animated"
						)
				)
			)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Button
	== ------------------------------------------------------------------- ==
	*/

	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Button', 'invicta_dictionary' ),
				'description'   => __( "Invicta Button", 'invicta_dictionary'),
				'base'          => 'invicta_button',
				'class'         => 'invicta_shortcode_button',
				'icon'          => 'icon-wpb-button',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'label',
						'value'			=> __( 'Click me', 'invicta_dictionary' ),
						'heading'		=> __( 'Label', 'invicta_dictionary' ),
						'description'	=> __( 'The text that appears on the button', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'link_type',
						'heading'		=> __( "Button Link","invicta_dictionary" ),
						'value'			=> $link_types,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'page_id',
						'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_pages,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('page')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'post_id',
						'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_posts,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('post')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'project_id',
						'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_projects,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('project')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'photogallery_id',
						'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_photogalleries,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('photo_gallery')
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'url',
						'value'			=> 'http://',
						'description'	=> __( 'Where should the button link to?', 'invicta_dictionary' ),
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('manually')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'target',
						'heading'		=> __( 'Link Target', 'invicta_dictionary' ),
						'description'	=> __( 'Do you want to open the linked page in a new window?', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Open in same window', 'invicta_dictionary' ) 	=> '',
							__( 'Open in new window', 'invicta_dictionary' ) 	=> '_blank'
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'size',
						'heading'		=> __( 'Button Size', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the size of the button', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Small', 'invicta_dictionary' ) 	=> '',
							__( 'Medium', 'invicta_dictionary' ) 	=> 'medium',
							__( 'Large', 'invicta_dictionary' ) 	=> 'large'
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'color',
						'heading'		=> __( 'Button Color', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the color of the button', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Default', 'invicta_dictionary' ) 	=> '',
							__( 'Silver', 'invicta_dictionary' ) 	=> 'silver',
							__( 'Gold', 'invicta_dictionary' ) 		=> 'gold',
							__( 'Red', 'invicta_dictionary' ) 		=> 'red',
							__( 'Green', 'invicta_dictionary' ) 	=> 'green',
							__( 'Blue', 'invicta_dictionary' ) 		=> 'blue',
						)
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon',
						'value' 		=> $icons,
						'heading'		=> __( 'Button Icon', 'invicta_dictionary' ),
						'description'	=> __( 'Choose an icon to be displayed within the button', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_position',
						'heading'		=> __( 'Icon Position', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the position of the icon', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Before the Label', 'invicta_dictionary' ) 	=> 'left',
							__( 'After the Label', 'invicta_dictionary' ) => 'right',
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'alignment',
						'heading'		=> __( 'Button Alignment', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the alignment of the button', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Align Left (Default)', 'invicta_dictionary' ) 	=> 'left',
							__( 'Align Center', 'invicta_dictionary' ) 			=> 'center',
							__( 'Align Right', 'invicta_dictionary' ) 			=> 'right'
						)
					),
				)
		) );
			
	}	
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Call to Action
	== ------------------------------------------------------------------- ==
	*/

	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Call to Action', 'invicta_dictionary' ),
				'description'   => __( "Invicta Call to Action", 'invicta_dictionary'),
				'base'          => 'invicta_calltoaction',
				'class'         => 'invicta_shortcode_calltoaction',
				'icon'          => 'icon-wpb-button',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("[Text] Primary Line", "invicta_dictionary" ),
						'param_name'	=> 'primary_line',
						'value'			=> __( 'Call to action title', 'invicta_dictionary' )
					),
					array(
						"type"			=> "exploded_textarea",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("[Text] Primary Line Keywords", "invicta_dictionary") ,
						'param_name'	=> 'primary_line_keywords',
						'description'	=> __('Keywords that should be highlighted in primary line (one per line)', "invicta_dictionary" )
					),
					array(
						"type"			=> "textfield",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("[Text] Secondary Line", "invicta_dictionary" ),
						'param_name'	=> 'secondary_line',
						'value'			=> __( 'Call to action short description', 'invicta_dictionary' )
					),
					array(
						"type"			=> "exploded_textarea",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("[Text] Secondary Line Keywords", "invicta_dictionary" ),
						'param_name'	=> 'secondary_line_keywords',
						'description'	=> __( 'Keywords that should be highlighted in secondary line (one per line)', "invicta_dictionary" )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'label',
						'value'			=> __( 'Click me', 'invicta_dictionary' ),
						'heading'		=> __( '[Button] Label', 'invicta_dictionary' ),
						'description'	=> __( 'The text that appears on the button', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'link_type',
						'heading'		=> __( "[Button] Link","invicta_dictionary" ),
						'value'			=> $link_types,
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'page_id',
						'description'	=> __( '[Button] Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_pages,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('page')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'post_id',
						'description'	=> __( '[Button] Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_posts,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('post')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'project_id',
						'description'	=> __( '[Button] Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_projects,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('project')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'photogallery_id',
						'description'	=> __( '[Button] Where should the button link to?', 'invicta_dictionary' ),
						'value'			=> $wp_photogalleries,
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('photo_gallery')
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'url',
						'value'			=> 'http://',
						'description'	=> __( '[Button] Where should the button link to?', 'invicta_dictionary' ),
						'dependency'	=> array(
							'element' 		=> 'link_type',
							'value'			=> array('manually')
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'target',
						'heading'		=> __( '[Button] Link Target', 'invicta_dictionary' ),
						'description'	=> __( 'Do you want to open the linked page in a new window?', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Open in same window', 'invicta_dictionary' ) 	=> '',
							__( 'Open in new window', 'invicta_dictionary' ) 	=> '_blank'
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'size',
						'heading'		=> __( '[Button] Button Size', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the size of the button', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Small', 'invicta_dictionary' ) 	=> '',
							__( 'Medium', 'invicta_dictionary' ) 	=> 'medium',
							__( 'Large', 'invicta_dictionary' ) 	=> 'large'
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'color',
						'heading'		=> __( '[Button] Button Color', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the color of the button', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Default', 'invicta_dictionary' ) 	=> '',
							__( 'Silver', 'invicta_dictionary' ) 	=> 'silver',
							__( 'Gold', 'invicta_dictionary' ) 		=> 'gold',
							__( 'Red', 'invicta_dictionary' ) 		=> 'red',
							__( 'Green', 'invicta_dictionary' ) 	=> 'green',
							__( 'Blue', 'invicta_dictionary' ) 		=> 'blue',
						)
					),
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon',
						'value' 		=> $icons,
						'heading'		=> __( '[Button] Button Icon', 'invicta_dictionary' ),
						'description'	=> __( 'Choose an icon to be displayed within the button', 'invicta_dictionary' )
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon_position',
						'heading'		=> __( '[Button] Icon Position', 'invicta_dictionary' ),
						'description'	=> __( 'Choose the position of the icon', 'invicta_dictionary' ),
						'value'			=> array(
							__( 'Before the Label', 'invicta_dictionary' ) 	=> 'left',
							__( 'After the Label', 'invicta_dictionary' ) => 'right',
						)
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'heading'		=> __("Style", "invicta_dictionary" ),
						'param_name'	=> 'style',
						'value'			=> array(
							__( 'Style #1', 'invicta_dictionary' ) 	=> 'style_1',
							__( 'Style #2', 'invicta_dictionary' ) 	=> 'style_2',
							__( 'Style #3', 'invicta_dictionary' ) 	=> 'style_3',
							__( 'Style #4', 'invicta_dictionary' ) 	=> 'style_4',
							__( 'Style #5', 'invicta_dictionary' ) 	=> 'style_5'
							)
					),
					$add_css_animation
				)
		) );
			
	}	
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Social Links
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		vc_map( array(
				'name'          => __( 'Social Links', 'invicta_dictionary' ),
				'description'   => __( "Invicta Social Links", 'invicta_dictionary'),
				'base'          => 'invicta_sociallinks',
				'class'         => 'invicta_shortcode_sociallinks',
				'icon'          => 'icon-wpb-sociallinks',
				'category'      => __('Social', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Title', 'invicta_dictionary' ),
						'param_name'	=> 'title',
						'value'			=> '',
					),
					array(
						'type'			=> 'textarea',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Intro', 'invicta_dictionary' ),
						'param_name'	=> 'intro',
						'value'			=> '',
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'E-Mail', 'invicta_dictionary' ),
						'param_name'	=> 'email',
						'value'			=> '',
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'twitter',
						'value'			=> '',
						'heading'		=> __( 'Twitter', 'invicta_dictionary' ),
						'description'	=> __( 'Twitter URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'facebook',
						'value'			=> '',
						'heading'		=> __( 'Facebook', 'invicta_dictionary' ),
						'description'	=> __( 'Facebook URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'googleplus',
						'value'			=> '',
						'heading'		=> __( 'Google Plus', 'invicta_dictionary' ),
						'description'	=> __( 'Google Plus URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'linkedin',
						'value'			=> '',
						'heading'		=> __( 'LinkedIn', 'invicta_dictionary' ),
						'description'	=> __( 'LinkedIn URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'xing',
						'value'			=> '',
						'heading'		=> __( 'Xing', 'invicta_dictionary' ),
						'description'	=> __( 'Xing URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'dribbble',
						'value'			=> '',
						'heading'		=> __( 'Dribbble', 'invicta_dictionary' ),
						'description'	=> __( 'Dribbble URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'flickr',
						'value'			=> '',
						'heading'		=> __( 'Flickr', 'invicta_dictionary' ),
						'description'	=> __( 'Flickr URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'tumblr',
						'value'			=> '',
						'heading'		=> __( 'Tumblr', 'invicta_dictionary' ),
						'description'	=> __( 'Tumblr URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'skype',
						'value'			=> '',
						'heading'		=> __( 'Skype', 'invicta_dictionary' ),
						'description'	=> __( 'Skype Username', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'instagram',
						'value'			=> '',
						'heading'		=> __( 'Instagram', 'invicta_dictionary' ),
						'description'	=> __( 'Instagram URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'pinterest',
						'value'			=> '',
						'heading'		=> __( 'Pinterest', 'invicta_dictionary' ),
						'description'	=> __( 'Pinterest URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'foursquare',
						'value'			=> '',
						'heading'		=> __( 'Foursquare', 'invicta_dictionary' ),
						'description'	=> __( 'Foursquare URL', 'invicta_dictionary' )
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'param_name'	=> 'youtube',
						'value'			=> '',
						'heading'		=> __( 'Youtube', 'invicta_dictionary' ),
						'description'	=> __( 'Youtube URL', 'invicta_dictionary' )
					)
				)
		) );

	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Instagram Feed
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$instagram_auth = array();
		$instagram_auth['user_id'] = $smof_data['auth-instagram-user_id']; 
		$instagram_auth['access_token'] = $smof_data['auth-instagram-access_token']; 
			
		$num_instagrams = array();
		for ( $i = 1; $i <= 30; $i ++ ) { 
			$num_tweets[] = $i;
		}
		
		vc_map( array(
				'name'          => __( 'Instagram Feed', 'invicta_dictionary' ),
				'description'   => __( "Invicta Instagram Feed", 'invicta_dictionary'),
				'base'          => 'invicta_instagramfeed',
				'class'         => 'invicta_shortcode_instagramfeed',
				'icon'          => 'icon-wpb-instagramfeed',
				'category'      => __('Social', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Title', 'invicta_dictionary' ),
						'param_name'	=> 'title',
						'value'			=> '',
					),
					array(
						'type'			=> 'dropdown',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Number of Items', 'invicta_dictionary' ),
						'description'	=> __( 'How many entries do you want to display?', 'invicta_dictionary' ),
						'param_name'	=> 'count',
						'value'			=> $num_tweets
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'cache_timeout',
						'heading'		=> __( 'Cache Timeout', 'invicta_dictionary' ),
						'description'	=> __( 'For how long do you want to cache the items?', 'invicta_dictionary' ),
						'value'			=> array(
							__( "Don't cache items", 'invicta_dictionary' ) 	=> 0,
							__( '5 Minutes', 'invicta_dictionary' ) 			=> 5,
							__( '30 Minutes', 'invicta_dictionary' ) 			=> 30,
							__( '60 Minutes', 'invicta_dictionary' ) 			=> 60,
							__( '6 Hours', 'invicta_dictionary' ) 				=> 360,
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'User ID', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain the <strong>User ID</strong> you need to register this website on <a href="http://instagram.com/developer" target="_blank">Instagram\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'user_id',
						'value'			=> $instagram_auth['user_id'],
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Access Token', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain the <strong>Access Token</strong> you need to register this website on <a href="http://instagram.com/developer" target="_blank">Instagram\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'access_token',
						'value'			=> $instagram_auth['access_token'],
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Twitter Feed
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$twitter_auth = array();
		$twitter_auth['consumer_key'] = $smof_data['auth-twitter-consumer_key']; 
		$twitter_auth['consumer_secret'] = $smof_data['auth-twitter-consumer_secret']; 
		$twitter_auth['access_token'] = $smof_data['auth-twitter-access_token']; 
		$twitter_auth['access_token_secret'] = $smof_data['auth-twitter-access_token_secret']; 
			
		$num_tweets = array();
		for ( $i = 1; $i <= 10; $i ++ ) { 
			$num_tweets[] = $i;
		}
		
		vc_map( array(
				'name'          => __( 'Twitter Feed', 'invicta_dictionary' ),
				'description'   => __( "Invicta Twitter Feed", 'invicta_dictionary'),
				'base'          => 'invicta_twitterfeed',
				'class'         => 'invicta_shortcode_twitterfeed',
				'icon'          => 'icon-wpb-twitterfeed',
				'category'      => __('Social', 'invicta_dictionary' ),
				'params'        => array(
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Title', 'invicta_dictionary' ),
						'param_name'	=> 'title',
						'value'			=> '',
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Username', 'invicta_dictionary' ),
						'description'	=> __( 'The username of the account you want to display the tweets', 'invicta_dictionary' ),
						'param_name'	=> 'username',
						'value'			=> '',
					),
					array(
						'type'			=> 'dropdown',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Number of Tweets', 'invicta_dictionary' ),
						'description'	=> __( 'How many entries do you want to display?', 'invicta_dictionary' ),
						'param_name'	=> 'count',
						'value'			=> $num_tweets
					),
					array(
						"type"			=> "dropdown",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'cache_timeout',
						'heading'		=> __( 'Cache Timeout', 'invicta_dictionary' ),
						'description'	=> __( 'For how long do you want to cache the tweets?', 'invicta_dictionary' ),
						'value'			=> array(
							__( "Don't cache tweets", 'invicta_dictionary' ) 	=> 0,
							__( '5 Minutes', 'invicta_dictionary' ) 			=> 5,
							__( '30 Minutes', 'invicta_dictionary' ) 			=> 30,
							__( '60 Minutes', 'invicta_dictionary' ) 			=> 60,
							__( '6 Hours', 'invicta_dictionary' ) 				=> 360,
						)
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Consumer Key', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain your <strong>Consumer Key</strong> you need to register this website on <a href="https://dev.twitter.com/apps" target="_blank">Twitter\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'consumer_key',
						'value'			=> $twitter_auth['consumer_key'],
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Consumer Secret', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain your <strong>Consumer Secret</strong> you need to register this website on <a href="https://dev.twitter.com/apps" target="_blank">Twitter\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'consumer_secret',
						'value'			=> $twitter_auth['consumer_secret'],
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Access Token', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain your <strong>Access Token</strong> you need to register this website on <a href="https://dev.twitter.com/apps" target="_blank">Twitter\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'access_token',
						'value'			=> $twitter_auth['access_token'],
					),
					array(
						'type'			=> 'textfield',
						'holder'		=> 'div',
						'class'			=> '',
						'heading'		=> __( 'Access Token Secret', 'invicta_dictionary' ),
						'description'	=> __( 'To obtain your <strong>Access Token Secret</strong> you need to register this website on <a href="https://dev.twitter.com/apps" target="_blank">Twitter\'s Dev Center</a>', 'invicta_dictionary' ),
						'param_name'	=> 'access_token_secret',
						'value'			=> $twitter_auth['access_token_secret'],
					),
				)
		) );

	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Icon Tab
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
		
		vc_map( array(
				'name'          => __( 'Icon 4 Tab', 'invicta_dictionary' ),
				'description'   => __( "Invicta Icon 4 Tab", 'invicta_dictionary'),
				'base'          => 'invicta_icontab',
				'class'         => 'invicta_shortcode_icontab',
				'icon'          => 'icon-wpb-icontab',
				'category'      => __('Content', 'invicta_dictionary' ),
				'params'        => array(
					array(
						"type"			=> "checkbox",
						"holder"		=> "div",
						"class"			=> "",
						'param_name'	=> 'icon',
						'value' 		=> $icons,
						'description'	=> __( 'This icons are supposed to be added inside any Tab or Tour Section element,<br/>in order to display a icon near each tab navigation link.', 'invicta_dictionary' )
					),
				)
		) );
	
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Shortcode Mapping - Go Pricing Table
	== ------------------------------------------------------------------- ==
	*/
	
	if ( function_exists('vc_map') ) {
	
		$pricing_tables = array();
		$pricing_tables[] = '';
	
		// grab go pricing tables from database
		
		if ( function_exists('is_plugin_active') ) {
			if ( is_plugin_active( 'go_pricing/go_pricing.php' ) ) {
								
				$pricing_tables_data = get_option( GW_GO_PREFIX . 'tables' ); 
				if ( $pricing_tables_data ) {
					foreach ( $pricing_tables_data as $table ) {
						$pricing_tables[ $table['table-name'] ] = $table['table-id'];
					}
				}
				
			}
		}
		
		vc_map( array(
			'name'           => __( 'Pricing Table', 'invicta_dictionary' ),
			'description'    => __( "Place a Go Pricing Table", 'invicta_dictionary'),
			'base'           => 'invicta_gopricingtable',
			'class'          => 'invicta_shortcode_gopricingtable',
			'icon'           => 'icon-wpb-icontab',
			'category'       => __( 'Content', 'invicta_dictionary' ),
			'params'         => array(
				array(
					"type"			=> "dropdown",
					"holder"		=> "div",
					"class"			=> "",
					'param_name'	=> 'table_id',
					'heading'		=> __( 'Pricing Table', 'invicta_dictionary' ),
					'value'			=> $pricing_tables
				)
			)
		) );
		
	}

	
}

function invicta_visual_composer_extender_remove_elements() {
	
	if ( function_exists('vc_remove_element') ) {
	
		$elements = array(
			'vc_wp_recentcomments',
			'vc_wp_calendar',
			'vc_wp_tagcloud',
			'vc_wp_text',
			'vc_wp_posts',
			'vc_wp_meta',
			'vc_wp_links',
			'vc_wp_categories',
			'vc_wp_archives',
			'vc_wp_rss',
			'vc_progress_bar',
			'vc_pie',
			'vc_flickr',
			'vc_cta_button',
			'vc_cta_button2',
			'vc_button',
			'vc_button2',
			'vc_btn',
			'vc_widget_sidebar',
			'vc_posts_slider',
			'vc_teaser_grid',
			'vc_gallery',
			'vc_pinterest',
			'vc_googleplus',
			'vc_tweetmeme',
			'vc_facebook',
			'vc_message',
			'vc_images_carousel',
			'vc_posts_grid',
			'vc_carousel',
			'vc_custom_heading',
			'vc_icon',
			'vc_cta',
			'vc_basic_grid',
			'vc_media_grid',
			'vc_masonry_grid',
			'vc_masonry_media_grid',
			'vc_tta_pageable'
		);
		
		$elements = apply_filters( 'invicta_remove_visual_composer_default_elements', $elements );
		
		if ( is_array( $elements ) ) {
			foreach ( $elements as $element ) {
				vc_remove_element( $element );	
			}
		}
	
	}
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Shortcode Customization - Single Image
== ------------------------------------------------------------------- ==
*/
	
function vc_theme_after_vc_single_image( $atts, $content = null ) {

	foreach ( $atts as $key => $value ) {
		if ( $key == 'img_link_large' ) {
			if ( $value == 'yes' ) {
				wp_enqueue_script('invicta_fancybox');
			}
		}
	}
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Hide Settings Menu
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_menu', 'invicta_remove_visual_composer_settings_menu', 100 );

function invicta_remove_visual_composer_settings_menu() {
	remove_menu_page( 'vc-general' );
	remove_submenu_page('options-general.php', 'vc_settings');
}

/*
== ------------------------------------------------------------------- ==
== @@ Version Notices
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_notices', 'invicta_notice_wordpress_jscomposer_versions' );

function invicta_notice_wordpress_jscomposer_versions() {

	global $wp_version;
	
	// IF user have WordPress 3.9+ he must have VisualComposer 4+

	if ( version_compare( $wp_version, '3.9') >= 0 ) {
		if ( defined('WPB_VC_VERSION') ) {
			if ( version_compare(WPB_VC_VERSION, '4.0') < 0 ) {
				echo '<div class="update-nag">';	
				echo '<p>' . __( "<strong>Visual Composer needs to be updated</strong> because it is not compatible with the current version of WordPress.<br/>You can find the latest version of the plugin in the package you've downloaded from ThemeForest, under the resources/wp_plugins folder", 'invicta_dictionary' ) . '</p>';
				echo '</div>';
			}
		}
		
	}
	
	// IF user have Invicta 2.1+ he must have VisualComposer 4.3+
	
	$invicta_theme = wp_get_theme();
	$invicta_version = $invicta_theme->get('Version');
	
	if ( version_compare( $invicta_version, '2.1') >= 0 ) {
		if ( defined('WPB_VC_VERSION') ) {
			if ( version_compare(WPB_VC_VERSION, '4.3') < 0 ) {
				echo '<div class="update-nag">';	
				echo '<p>' . __( "<strong>Visual Composer needs to be updated</strong> because it is not compatible with the current version of Invicta.<br/>You can find the latest version of the plugin in the package you've downloaded from ThemeForest, under the resources/wp_plugins folder", 'invicta_dictionary' ) . '</p>';
				echo '</div>';
			}
		}
		
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Removing Visual Composer Predefined Layouts
== ------------------------------------------------------------------- ==
*/

add_filter( 'vc_load_default_templates', 'invicta_remove_default_vc_templates' );

if ( ! function_exists( 'invicta_remove_default_vc_templates' ) ) {
	
	function invicta_remove_default_vc_templates() {

		return array();
		
	}
	
}
	

/*
== ------------------------------------------------------------------- ==
== @@ Removing Post Teaser Metaboxes
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_init', 'invicta_removing_post_teaser_metabox', 4 );

if ( ! function_exists( 'invicta_removing_post_teaser_metabox' ) ) {

	function invicta_removing_post_teaser_metabox() {
		global $vc_teaser_box;
		remove_action( 'admin_init', array( $vc_teaser_box, 'jsComposerEditPage' ), 6 );
	}

}

/*
== ------------------------------------------------------------------- ==
== @@ Changing Parameters From Native Elements
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_init', 'invicta_changing_params_from_vc' );

if ( ! function_exists( 'invicta_changing_params_from_vc' ) ) {

	function invicta_changing_params_from_vc() {
		if ( function_exists( 'vc_remove_param' ) && function_exists( 'vc_add_param' ) && function_exists( 'vc_map_update' ) ) {
			
			// vc_single_image

			vc_remove_param( 'vc_single_image', 'border_color' );
			vc_remove_param( 'vc_single_image', 'img_link_target' );
			vc_remove_param( 'vc_single_image', 'style' );

			// vc_toggle

			vc_remove_param( 'vc_toggle', 'style' );
			vc_remove_param( 'vc_toggle', 'color' );
			vc_remove_param( 'vc_toggle', 'size' );

		}
	}

}

	
?>