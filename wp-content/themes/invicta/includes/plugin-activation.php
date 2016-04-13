<?php

require_once('libraries/tgm-plugin-activation/class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'invicta_register_required_plugins' );

function invicta_register_required_plugins() {

	$plugins = array(

		array(
			'name' 					=> 'Visual Composer',
			'slug'					=> 'js_composer',
			'source'				=> get_template_directory() . '/includes/libraries/wp-plugins/js_composer.zip',
			'required'				=> true,
			'version'				=> ''
		),

		array(
			'name' 					=> 'Revolution Slider',
			'slug'					=> 'revslider',
			'source'				=> get_template_directory() . '/includes/libraries/wp-plugins/revslider.zip',
			'required'				=> true,
			'version'				=> '',
		),

		array(
			'name' 					=> 'Go Pricing Tables',
			'slug'					=> 'go_pricing',
			'source'				=> get_template_directory() . '/includes/libraries/wp-plugins/go_pricing.zip',
			'required'				=> true,
			'version'				=> '',
		),

		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => true,
        ),

	);

	$theme_text_domain = 'invicta_dictionary';

	$config = array(
		'domain'       		=> $theme_text_domain,         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', $theme_text_domain ),
			'menu_title'                       			=> __( 'Install Plugins', $theme_text_domain ),
			'installing'                       			=> __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', $theme_text_domain ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', $theme_text_domain ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', $theme_text_domain ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', $theme_text_domain ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}


/*
== ------------------------------------------------------------------- ==
== @@ Plugin First Time Adjustments
== ------------------------------------------------------------------- ==
*/

add_action( 'admin_init', 'invicta_plugin_first_time_adjustment' );

function invicta_plugin_first_time_adjustment() {

	$option_id = 'invicta_plugin_initial_settings_changed';

	// this should only happen once

	if ( get_option( $option_id ) ) {
		return;
	}
	else {

		// RevSlider: remove product activation notice
		update_option('revslider-valid-notice', 'false');

		// add flag to the database to grant this only happens once
		update_option( $option_id, '1' );

	}

}

?>