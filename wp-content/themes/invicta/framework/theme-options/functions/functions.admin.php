<?php
/**
 * SMOF Admin
 *
 * @package     WordPress
 * @subpackage  SMOF
 * @since       1.4.0
 * @author      Syamil MJ
 */


/**
 * Head Hook
 *
 * @since 1.0.0
 */
function of_head() { do_action( 'of_head' ); }

/**
 * Add default options upon activation else DB does not exist
 *
 * DEPRECATED, Class_options_machine now does this on load to ensure all values are set
 *
 * @since 1.0.0
 */
function of_option_setup()
{
	global $of_options, $options_machine;
	$options_machine = new Options_Machine($of_options);

	if (!of_get_options())
	{
		of_save_options($options_machine->Defaults);
	}
}

/**
 * Change activation message
 *
 * @since 1.0.0
 */
function optionsframework_admin_message() {

	//Tweaked the message on theme activate
	?>
    <script type="text/javascript">
    jQuery(function(){

    	var message = '<p><?php echo sprintf( __('This theme comes with an <a href="%s"">options panel</a> to configure settings. This theme also supports widgets, please visit the <a href="%s">widgets settings page</a> to configure them.', 'invicta_dictionary'), admin_url('admin.php?page=optionsframework'), admin_url('widgets.php')); ?></p>';

    	jQuery('.themes-php #message2').html(message);

    });
    </script>
    <?php

}

/**
 * Get header classes
 *
 * @since 1.0.0
 */
function of_get_header_classes_array()
{
	global $of_options;

	foreach ($of_options as $value)
	{
		if ($value['type'] == 'heading')
			$hooks[] = str_replace(' ','',strtolower($value['name']));
	}

	return $hooks;
}

/**
 * Get options from the database and process them with the load filter hook.
 *
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @return array
 */
function of_get_options($key = null, $data = null) {
	global $smof_data;

	do_action('of_get_options_before', array(
		'key'=>$key, 'data'=>$data
	));
	if ($key != null) { // Get one specific value
		$data = get_theme_mod($key, $data);
	} else { // Get all values
		$data = get_theme_mods();
	}
	$data = apply_filters('of_options_after_load', $data);
	if ($key == null) {
		$smof_data = $data;
	} else {
		$smof_data[$key] = $data;
	}
	do_action('of_option_setup_before', array(
		'key'=>$key, 'data'=>$data
	));
	return $data;

}

/**
 * Save options to the database after processing them
 *
 * @param $data Options array to save
 * @author Jonah Dahlquist
 * @since 1.4.0
 * @uses update_option()
 * @return void
 */

function of_save_options($data, $key = null) {
	global $smof_data;
    if (empty($data))
        return;
    do_action('of_save_options_before', array(
		'key'=>$key, 'data'=>$data
	));
	$data = apply_filters('of_options_before_save', $data);
	if ($key != null) { // Update one specific value
		if ($key == BACKUPS) {
			unset($data['smof_init']); // Don't want to change this.
		}
		set_theme_mod($key, $data);
	} else { // Update all values in $data
		foreach ( $data as $k=>$v ) {
			if (!isset($smof_data[$k]) || $smof_data[$k] != $v) { // Only write to the DB when we need to
				set_theme_mod($k, $v);
			} else if (is_array($v)) {
				foreach ($v as $key=>$val) {
					if ($key != $k && $v[$key] == $val) {
						set_theme_mod($k, $v);
						break;
					}
				}
			}
	  	}
	}
    do_action('of_save_options_after', array(
		'key'=>$key, 'data'=>$data
	));

}



function generate_options_css($newdata) {

	/** Define some vars **/
	$data = $newdata;
	$uploads = wp_upload_dir();
	$css_dir = get_template_directory() . '/styles/'; // Shorten code, save 1 call

	/** Save on different directory if on multisite **/
	if(is_multisite()) {
		$aq_uploads_dir = trailingslashit($uploads['basedir']);
	} else {
		$aq_uploads_dir = $css_dir;
	}

	/** Capture CSS output **/
	ob_start();
	require($css_dir . 'dynamic.php');
	$css = ob_get_clean();

	/** Write to dynamic.css file **/

	function _return_direct() { return 'direct'; } // some hosts needs to be forced to use the DIRECT filesystem method
	add_filter('filesystem_method', '_return_direct'); // some hosts needs to be forced to use the DIRECT filesystem method

	WP_Filesystem();

	remove_filter('filesystem_method', '_return_direct'); // some hosts needs to be forced to use the DIRECT filesystem method

	global $wp_filesystem;
	if ( ! $wp_filesystem->put_contents( $aq_uploads_dir . 'dynamic.css', $css, 0644) ) {
	    return true;
	}

}


/**
 * For use in themes
 *
 * @since forever
 */



$data = of_get_options();
if (!isset($smof_details))
	$smof_details = array();