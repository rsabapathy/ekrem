<?php

/*
== ------------------------------------------------------------------- ==
== @@ Fire PHP
== ------------------------------------------------------------------- ==
*/

/*
require_once('includes/libraries/firephp/fb.php');
$firephp = FirePHP::getInstance(true);
ob_start();
*/


/*
== ------------------------------------------------------------------- ==
== @@ Includes
== ------------------------------------------------------------------- ==
*/

// framework
include_once('framework/invicta-framework.php');

// libraries
include_once('includes/libraries/aqua-resizer/aq_resizer.php');
include_once('includes/libraries/codebird/codebird.php');

// logic
include_once('includes/logic-enqueuings.php');
include_once('includes/logic-layout.php');
include_once('includes/logic-hooks.php');
include_once('includes/logic-crossbrowsering.php');
include_once('includes/logic.php');
include_once('includes/frontend.php');
include_once('woocommerce/logic/index.php');

// posts
include_once('includes/post-types/pages.php');
include_once('includes/post-types/portfolio.php');
include_once('includes/post-types/photos.php');
include_once('includes/post-types/videos.php');

// widgets
include_once('includes/sidebars.php');
include_once('includes/widgets/latest-posts.php');
include_once('includes/widgets/popular-posts.php');
include_once('includes/widgets/combo-posts.php');
include_once('includes/widgets/contacts.php');
include_once('includes/widgets/twitter-feed.php');
include_once('includes/widgets/instagram-feed.php');
include_once('includes/widgets/social-links.php');

// shortcodes
include_once('includes/shortcodes/gallery.php');
include_once('includes/shortcodes/heading.php');
include_once('includes/shortcodes/letter.php');
include_once('includes/shortcodes/partners.php');
include_once('includes/shortcodes/iconbox.php');
include_once('includes/shortcodes/testimonial.php');
include_once('includes/shortcodes/progressbars.php');
include_once('includes/shortcodes/steps.php');
include_once('includes/shortcodes/counters.php');
include_once('includes/shortcodes/icon-tab.php');
include_once('includes/shortcodes/portfolio.php');
include_once('includes/shortcodes/timespan.php');
include_once('includes/shortcodes/contacts.php');
include_once('includes/shortcodes/social-links.php');
include_once('includes/shortcodes/button.php');
include_once('includes/shortcodes/twitter-feed.php');
include_once('includes/shortcodes/instagram-feed.php');
include_once('includes/shortcodes/person.php');
include_once('includes/shortcodes/testimonial-carousel.php');
include_once('includes/shortcodes/world-map.php');
include_once('includes/shortcodes/europe-map.php');
include_once('includes/shortcodes/usa-map.php');
include_once('includes/shortcodes/blog.php');
include_once('includes/shortcodes/call-to-action.php');
include_once('includes/shortcodes/go-pricing-table.php');

// misc
include_once('includes/fonts.php');
include_once('includes/flags.php');
include_once('includes/post-format-filters.php');
include_once('includes/plugin-activation.php');

include_once('includes/visual-composer.php'); 	// should be included after the shortcodes registering

/*
== ------------------------------------------------------------------- ==
== @@ Constants
== ------------------------------------------------------------------- ==
*/

define( 'BLOG__PHOTO_WIDTH', 960 );
define( 'BLOG__PHOTO_HEIGHT', 530 );

define( 'WIDGET__PHOTO_WIDTH', 120 );
define( 'WIDGET__PHOTO_HEIGHT', 120 );

define( 'PHOTO_GALLERY__PHOTO_WIDTH', 560 );
define( 'PHOTO_GALLERY__PHOTO_HEIGHT', 420 );

define( 'PORTFOLIO_LIST__PHOTO_WIDTH', 560 );
define( 'PORTFOLIO_LIST__PHOTO_HEIGHT', 420 );

define( 'PORTFOLIO_DETAILS__PHOTO_WIDTH', 960 );
define( 'PORTFOLIO_DETAILS__PHOTO_HEIGHT', 660 );

define( 'VIDEOS__PHOTO_WIDTH', 560 );
define( 'VIDEOS__PHOTO_HEIGHT', 420 );

define( 'STYLE_SWITCHER', false );

?>