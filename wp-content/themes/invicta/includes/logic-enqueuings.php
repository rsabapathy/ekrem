<?php 
	
add_action( 'wp_enqueue_scripts', 'invicta_enqueue_items' );
add_action( 'admin_enqueue_scripts', 'invicta_enqueue_items_admin' );

function invicta_enqueue_items() { 

	global $smof_data;
	
	$template_url = get_template_directory_uri();
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Scripts (js)
	== ------------------------------------------------------------------- ==
	*/
	
	// jQuery
	wp_enqueue_script('jquery');
	
	// html5shiv
	if( preg_match('/(?i)msie [1-8]/', $_SERVER['HTTP_USER_AGENT'] ) ) { // if IE<=8
	
		wp_register_script( 'html5shiv', $template_url . '/includes/libraries/html5shiv/html5shiv.js', array('jquery'), '', false );
		wp_enqueue_script( 'html5shiv' );
		
		wp_register_script( 'html5shiv_print', $template_url . '/includes/libraries/html5shiv/html5shiv-printshiv.js', array('jquery'), '', false );
		wp_enqueue_script( 'html5shiv_print' );

	}
	
	// Comment-Reply
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        wp_enqueue_script( 'comment-reply' );
    }
	
	// jQuery easing
    wp_register_script('invicta_jquery_easing', $template_url . '/scripts/jquery.easing.js', array('jquery'), '', true);
	wp_enqueue_script('invicta_jquery_easing');
	
	// theme stylesheet
    wp_register_script('invicta_script', $template_url . '/scripts/invicta.js', array('jquery'), '', true);
	wp_enqueue_script('invicta_script');
	
	// superfish menu
	wp_register_script('invicta_superfish', $template_url . '/scripts/jquery.superfish.js', array('jquery'), '', true);
	wp_enqueue_script('invicta_superfish');
	
	// isotope
	wp_register_script('invicta_isotope', $template_url . '/scripts/jquery.isotope.min.js', array('jquery'), '', true);
	wp_enqueue_script('invicta_isotope');
	
	// fitvids
	wp_register_script('invicta_fitvids', $template_url . '/scripts/jquery.fitvids.min.js', array('jquery'), '', true);
	wp_enqueue_script('invicta_fitvids');
	
	// flexslider
	wp_register_script('invicta_flexslider', get_template_directory_uri() . '/includes/libraries/flexslider/jquery.flexslider-min.js', array('jquery'), '', true);
	// wp_enqueue_script('invicta_flexslider'); // the flexslider will be enqueued only when necessary
	
	// fancybox
	wp_register_script('invicta_fancybox', get_template_directory_uri() . '/includes/libraries/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '', true);
	// wp_enqueue_script('invicta_fancybox'); // fancybox will be enqueued only when necessary
	
	// black and white
	wp_register_script('invicta_blackandwhite', get_template_directory_uri() . '/scripts/jquery.blackandwhite.js', array('jquery'), '', true);
	// wp_enqueue_script('invicta_blackandwhite'); // black & white will be enqueued only when necessary
	
	// transit
	wp_register_script('invicta_transit', $template_url . '/scripts/jquery.transit.js', array('jquery'), '', true);
	//wp_enqueue_script('invicta_transit'); // transit will be enqueued only when necessary
	
	// add2home
	if ( $smof_data['general-ios_homescreen_popup'] ) {
		wp_register_script( 'invicta_add2home', get_template_directory_uri() . '/includes/libraries/add2home/add2home.js', array('jquery'), '', true );
		wp_enqueue_script( 'invicta_add2home' );
	}
	
	// counters
	wp_register_script('invicta_counters', $template_url . '/includes/libraries/counter/jquery.counter.js', array('jquery'), '', true);
	//wp_enqueue_script('invicta_counters'); // transit will be enqueued only when necessary
	
	// visual composer
	wp_enqueue_script('wpb_composer_front_js');
	
	if ( STYLE_SWITCHER == true ) {
	
		// style switcher
		wp_register_script('invicta_styleswitcher', $template_url . '/scripts/invicta.styleswitcher.js', array('jquery'), '', true);
		wp_enqueue_script('invicta_styleswitcher');
		
		// jquery cookie
		wp_register_script('invicta_cookie', $template_url . '/scripts/jquery.cookie.js', array('jquery'), '', true);
		wp_enqueue_script('invicta_cookie');
		
		// mini colors
		wp_register_script('invicta_minicolors', $template_url . '/includes/libraries/mini-colors/jquery.minicolors.min.js', array('jquery'), '', true );
		wp_enqueue_script('invicta_minicolors');
	}
	
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Styles (css)
	== ------------------------------------------------------------------- ==
	*/
	
	// grid
	wp_register_style('invicta_grid_styles', $template_url . '/styles/grid.css', false, false, 'screen');
	wp_enqueue_style('invicta_grid_styles');
	
	// layout styles
	wp_register_style('invicta_invicta_styles', $template_url . '/styles/invicta.css', false, false, 'screen');
	wp_enqueue_style('invicta_invicta_styles');
	
	if ( is_child_theme() ) {
		wp_register_style('invicta_child_layout_styles', get_stylesheet_directory_uri() . '/style.css', false, false, 'screen');
		wp_enqueue_style('invicta_child_layout_styles');	
	}
	
	// fonts
	invicta_enqueue_font_family( $smof_data['typography-body-family'] );
	invicta_enqueue_font_family( $smof_data['typography-headings-family'] );
	invicta_enqueue_font_family( $smof_data['typography-menu-family'] );
	
	// font awesome
	wp_register_style('invicta_font_awesome', $template_url . '/includes/libraries/font_awesome/css/font-awesome.min.css', false, false, 'screen');
	wp_enqueue_style('invicta_font_awesome');
	
	// flexslider
	wp_register_style('invicta_flexslider', $template_url . '/includes/libraries/flexslider/flexslider.css', false, false, 'screen');
	wp_enqueue_style('invicta_flexslider');
	
	// fancybox
	wp_register_style('invicta_fancybox', $template_url . '/includes/libraries/fancybox/jquery.fancybox-1.3.4.css', false, false, 'screen');
	wp_enqueue_style('invicta_fancybox');
	
	// flags
	wp_register_style( 'invicta_flags', $template_url . '/styles/flags.css', false, false, 'screen' );
	wp_enqueue_style( 'invicta_flags' );
	
	// add2home
	if ( $smof_data['general-ios_homescreen_popup'] ) {
		wp_register_style( 'invicta_add2home', $template_url . '/includes/libraries/add2home/add2home.css', false, false, 'screen' );
		wp_enqueue_style( 'invicta_add2home' );
	}
	
	// counters
	wp_register_style( 'invicta_counters', $template_url . '/includes/libraries/counter/jquery.counter-analog.css', false, false, 'screen' );
	wp_enqueue_style( 'invicta_counters' );
	
	// visual composer
	wp_enqueue_style('js_composer_front');
	
	// dynamic styles
	if(is_multisite()) {
		$uploads = wp_upload_dir();
		wp_register_style('invicta_dynamic_styles', $uploads['baseurl'] . '/dynamic.css', false, false, 'screen');
	} else {
		wp_register_style('invicta_dynamic_styles', $template_url . '/styles/dynamic.css', false, false, 'screen');
	}
	wp_enqueue_style('invicta_dynamic_styles');
	
	if ( STYLE_SWITCHER == true ) {
		
		// style switcher
		wp_register_style('invicta_styleswitcher', $template_url . '/styles/invicta.styleswitcher.css', false, false, 'screen');
		wp_enqueue_style('invicta_styleswitcher');
	
		// mini colors
		wp_register_style( 'invicta_minicolors', $template_url . '/includes/libraries/mini-colors/jquery.minicolors.css', false, false, 'screen' );
		wp_enqueue_style( 'invicta_minicolors' );

	}
	
}

function invicta_enqueue_items_admin() {
	
	$template_url = get_template_directory_uri();
	$screen = get_current_screen();
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Scripts (js)
	== ------------------------------------------------------------------- ==
	*/
	
	// theme admin script
	
	if ( $screen->id != 'tools_page_codestyling-localization/codestyling-localization') {
		wp_register_script('invicta_script', $template_url . '/scripts/invicta.admin.js', array('jquery'), '', true);
		wp_enqueue_script('invicta_script');
	}
	
	/*
	== ------------------------------------------------------------------- ==
	== @@ Styles (css)
	== ------------------------------------------------------------------- ==
	*/
	
	wp_register_style('invicta_admin_styles', $template_url . '/styles/invicta.admin.css', false, false, 'screen');
	wp_enqueue_style('invicta_admin_styles');
	
	// font awesome
	wp_register_style('invicta_font_awesome', $template_url . '/includes/libraries/font_awesome/css/font-awesome.min.css', false, false, 'screen');
	wp_enqueue_style('invicta_font_awesome');
	
}



function invicta_enqueue_font_family( $font_name ) {

	$google_web_fonts = invicta_get_google_web_fonts();
	
	if ( in_array( $font_name, $google_web_fonts ) ) {
		
		$font_id = 'googlefont_' . str_replace( ' ', '-', $font_name );
		
		$font_path = '';
		$font_path .= ( ! empty( $_SERVER['HTTPS'] ) ) ? 'https://' : 'http://';
		$font_path .= 'fonts.googleapis.com/css?family=';
		$font_path .= str_replace(' ', '+', $font_name);
		$font_path .= ':200,300,400,500,600,700,800,900,200italic,300italic,400italic,500italic,600italic,700italic,800italic,900italic';
		$font_path .= invicta_get_typography_options_subsets();
		
		wp_register_style( $font_id, $font_path );
    	wp_enqueue_style( $font_id );
		
	}
	
}

function invicta_get_typography_options_subsets() {
	
	global $smof_data;
	
	$subsets = array();
	
	$subsets[] = 'latin';
	
	if ( $smof_data['typography-subsets-latin_extended'] ) {
		$subsets[] = 'latin-ext';
	}
	
	if ( $smof_data['typography-subsets-cyrillic'] ) {
		$subsets[] = 'cyrillic';
	}
	
	if ( $smof_data['typography-subsets-cyrillic_extended'] ) {
		$subsets[] = 'cyrillic-ext';
	}
	
	if ( $smof_data['typography-subsets-greek'] ) {
		$subsets[] = 'greek';
	}
	
	if ( $smof_data['typography-subsets-greek_extended'] ) {
		$subsets[] = 'greek-ext';
	}
	
	if ( $smof_data['typography-subsets-khmer'] ) {
		$subsets[] = 'khmer';
	}
	
	if ( $smof_data['typography-subsets-vietnamese'] ) {
		$subsets[] = 'vietnamese';
	}
	
	if ( sizeof( $subsets ) > 0 ) {
		return '&subset=' . join($subsets, ',');	
	}
	else {
		return '';
	}
	
}

	
?>