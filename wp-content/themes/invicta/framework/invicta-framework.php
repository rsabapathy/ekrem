<?php 

if ( ! defined('INVICTA_FMW_PATH') ) { define( 'INVICTA_FMW_PATH', get_template_directory() . '/framework/' ); }
if ( ! defined('INVICTA_FMW_URL') ) { define( 'INVICTA_FMW_URL', get_template_directory_uri() . '/framework/' ); }

require_once('theme-options/index.php');
require('sidebar-generator/index.php');
require('metabox-generator/index.php');

include_once('classes/social-links.php');
include_once('classes/breadcrumb.php');
include_once('classes/social-sharer-twitter.php');
include_once('classes/social-sharer-facebook.php');

include_once('functions/video-providers.php');
	
?>