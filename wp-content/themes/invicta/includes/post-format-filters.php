<?php 
/*
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==

FUNCTIONS TITLE: 
	Invicta - Post Formats Filters
		
FUNCTIONS AUTHOR: 
	Oitentaecinco

FUNCTIONS INDEX:

	@@ Video Post Format
	@@ Audio Post Format
	@@ Link Post Format
	@@ Gallery Post Format
	@@ Image Post Format
	@@ Aside Post Format
	@@ Quote Post Format
	@@ Status Post Format

== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
== ------------------------------------------------------------------- ==
*/

/*
== ------------------------------------------------------------------- ==
== @@ Video Post Format
== ------------------------------------------------------------------- ==
*/

add_filter( 'post-format-video', 'invicta_postformat_filter_video' );

function invicta_postformat_filter_video( $current_post ) {
	
	$video_shortcode_token = '';
	$post_content = $current_post['content'];
	
	// check for videos embeded with the [video] shortcode (WP 3.6)
	
	if ( ! $video_shortcode_token ) {
	
		$pattern = get_shortcode_regex();
		preg_match( '/' . $pattern . '/s', $post_content, $match_video );

		if ( isset( $match_video[2] ) && is_array($match_video) && $match_video[2] == 'video' ) {
			$video_shortcode_token = $match_video[0];
		}
	
	}
	
	// check for videos embeded with the traditional-hyperlink-way
	
	if ( ! $video_shortcode_token ) {
		
		$post_content = preg_replace( '|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", $post_content );
		preg_match("!\[embed.+?\]|!", $post_content, $match_video );
		
		if ( ! empty( $match_video ) ) {
			$video_shortcode_token = $match_video[0];
		}
		
	}
	
	// extract video from content-field
	// and apply it to the thumbnail-field
	if ( $video_shortcode_token ) {
		
		global $wp_embed;
		
		$current_post['thumbnail'] = do_shortcode( $wp_embed->run_shortcode( $video_shortcode_token ) );
		$current_post['content'] = str_replace( $video_shortcode_token, '', $post_content );
		
	}
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Audio Post Format
== ------------------------------------------------------------------- ==
*/

add_filter( 'post-format-audio', 'invicta_postformat_filter_audio' );

function invicta_postformat_filter_audio( $current_post ) {
	
	$audio_shortcode_token = '';
	$post_content = $current_post['content'];
	
	// check for audios embeded with the [audio] shortcode (WP 3.6)
	
	if ( ! $audio_shortcode_token ) {
	
		$pattern = get_shortcode_regex();
		preg_match( '/' . $pattern . '/s', $post_content, $match_audio );

		if ( isset( $match_audio[2] ) && is_array($match_audio) && $match_audio[2] == 'audio' ) {
			$audio_shortcode_token = $match_audio[0];
		}
	
	}
	
	// check for audios embeded with the traditional-hyperlink-way
	
	if ( ! $audio_shortcode_token ) {
		
		$post_content = preg_replace( '|^\s*(https?://[^\s"]+)\s*$|im', "[embed]$1[/embed]", $post_content );
		preg_match("!\[embed.+?\]!", $post_content, $match_audio );
		
		if ( ! empty( $match_audio ) ) {
			$audio_shortcode_token = $match_audio[0];
		}
		
	}
	
	// extract audio from content-field
	// and apply it to the thumbnail-field
	if ( $audio_shortcode_token ) {
		
		global $wp_embed;
		
		$current_post['thumbnail'] = do_shortcode( $wp_embed->run_shortcode( $audio_shortcode_token ) );
		$current_post['content'] = str_replace( $audio_shortcode_token, '', $post_content );
		
	}
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Link Post Format
== ------------------------------------------------------------------- ==
*/

add_filter( 'post-format-link', 'invicta_postformat_filter_link' );

function invicta_postformat_filter_link( $current_post ) {

	$post_link = '';
	$post_content = $current_post['content'];
	
	$pattern1 	= '!^(https?|ftp)://(-\.)?([^\s/?\.#-]+\.?)+(/[^\s]*)?!';
	$pattern2 	= "!^\<a.+?<\/a>!";
	$pattern3 	= "!\<a.+?<\/a>!";	
	
	preg_match( $pattern1, $post_content , $links );
	if ( ! empty( $links[0] ) ) {
		$post_link = $links[0];
		$post_content = str_replace( $post_link, "", $post_content );
	}
	else {
		
		preg_match( $pattern2, $post_content, $links );
		if ( ! empty( $links[0] ) ) {
			$post_link = $links[0];
			$post_content = str_replace( $post_link, "", $post_content );
		}
		else {
		
			preg_match( $pattern3,  $post_content, $links );
			if( ! empty( $links[0] ) ) {
				$post_link = $links[0];
			}
		
		}
		
	}
	
	if ( $post_link ) {	
	
		// add css classes to the link
		
		$css_class = 'inherit-color accentcolor-text-on_hover';
		preg_match( '/class=".*?"/i', $post_link, $attr_class );
		if ( ! empty( $attr_class[0] ) ) {
			$post_link = str_replace( $attr_class[0], 'class="' . $css_class . '"', $post_link );
		}
		else {
			$post_link = str_replace( '<a ', '<a class="' . $css_class . '" ', $post_link );
		}
		
		preg_match( '/target=".*?"/i', $post_link, $attr_target );
		if ( ! empty( $attr_target[0] ) ) {
			$post_link = str_replace( $attr_target[0], 'target="_blank"', $post_link );
		}
		else {
			$post_link = str_replace( '<a ', '<a target="_blank" ', $post_link );
		}
		
		$current_post['title'] = $post_link;
		$current_post['content'] = $post_content;
		
	}
	
	if ( ! is_single() ) {
	
		// add hyperlink to date
	
		$date = '';
		$date .= '<a';
		$date .=	' href="' . get_permalink() . '"';
		$date .= 	' title="' . __("Permalink to", "invicta_dictionary") . ' ' . esc_attr( get_the_title() ) . '"';
		$date .= 	' rel="bookmark"';
		$date .= 	' class="inherit-color accentcolor-text-on_hover"';
		$date .= 	'>';
		$date .=		$current_post['date'];
		$date .= '</a>';
		
		$current_post['date'] = $date;
	
	}
	
	$current_post['show_author'] = false;
	$current_post['show_comments'] = false;
	$current_post['thumbnail'] = '';
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Gallery Post Format
== ------------------------------------------------------------------- ==
*/

add_filter( 'post-format-gallery', 'invicta_postformat_filter_gallery' );

function invicta_postformat_filter_gallery( $current_post ) {
	
	$gallery_shortcode_token = '';
	$post_content = $current_post['content'];
	
	
	// check for audios embeded with the [gallery] shortcode
	
	$pattern = get_shortcode_regex();
	preg_match( '/' . $pattern . '/s', $post_content, $match_gallery );
	
	if ( isset( $match_gallery[2] ) && is_array($match_gallery) && $match_gallery[2] == 'gallery' ) {
		
		$gallery_shortcode_token = $match_gallery[0];
				
	}
	
	// extract audio from content-field
	// and apply it to the thumbnail-field
	if ( $gallery_shortcode_token ) {
		
		$current_post['content'] = str_replace( $gallery_shortcode_token, '', $post_content );
		
		// replace the original [gallery] shortcode by a custom [invicta_gallery] shortcode
		if( strpos( $gallery_shortcode_token, 'invicta_' ) === false) {
			$gallery_shortcode_token = str_replace( "gallery" , 'invicta_gallery', $gallery_shortcode_token );
		}
		
		$current_post['thumbnail'] = do_shortcode( $gallery_shortcode_token );
		
	}
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Image Post Format
== ------------------------------------------------------------------- ==
*/

add_filter( 'post-format-image', 'invicta_postformat_filter_image' );

function invicta_postformat_filter_image( $current_post ) {
	
	global $post;

	$image_shortcode_token = '';
	$image_url = '';
	$post_content = $current_post['content'];
	
	
	// if there is no featured image specified
	// we will extract the first image found in the content
	
	if ( ! $current_post['thumbnail'] ) {
		
		
		// check if there is any image URL written in the content
		
		preg_match( "!^(https?(?://([^/?#]*))?([^?#]*?\.(?:jpg|gif|png)))!", $current_post['content'], $matches );
		if ( ! empty( $matches[0] ) && is_array( $matches ) ) {	
			$image_shortcode_token = $matches[0];
			$image_url = $matches[0];
		}
		
		// check if there is any <img> in the content
		else {
					
			preg_match( "!\<img.+? \/>!", $current_post['content'], $matches );
			if ( ! empty( $matches[0] ) && is_array( $matches ) ) {	
			
				$image_shortcode_token = $matches[0];
				
				// extract the image url
				preg_match('/(src)=("[^"]*")/i', $matches[0], $matches);
				if ( ! empty( $matches[0] ) && is_array( $matches ) ) {	
					$image_url = str_replace('"', '', $matches[2]);
				}
				
			}
			
		}
		
	}
	
	if ( $image_shortcode_token ) {
	
		// setup image html
		
		global $smof_data;
		global $content_width;
	
		$image_css = 'attachment-post-thumbnail wp-post-image';
		$hyperlink_css = 'image_hover_effect';
		
		$linked = ( is_single() ) ? false : true;
		$resize = true;
		$width = $content_width;
		$height = BLOG__PHOTO_HEIGHT;

		$resized_image_url = aq_resize( $image_url, $width, $height, true, true, false);
		
		if ( ! $resized_image_url ) {
			$resized_image_url = $image_url;	
		}
		
		// update $current_post object
	
		$current_post['content'] = str_replace( $image_shortcode_token, '', $post_content );	
		$current_post['thumbnail'] = '<img src="' . $resized_image_url . '" alt="' . esc_attr( get_the_title($post->ID) ) . '" class="' . $image_css . '" />';
		
		if ( ! is_single() ) {
			
			$html = '<a href="' . get_permalink($post->ID) . '" class="' . $hyperlink_css . ' invicta_hover_effect">';
			$html .=	'<span class="element">';
			$html .= 	    $current_post['thumbnail'];
			$html .=	'</span>';
			$html .= 	'<span class="mask">';
			$html .= 	'	<span class="caption">';
			$html .= 			'<span class="title">';
			$html .=				'<i class="icon-link"></i>';
			$html .=			'<span>';
			$html .=		'<span>';
			$html .= 	'</span>';
			$html .= '</a>';
			
			$current_post['thumbnail'] = $html;
			
		}
		
	}
	
	return $current_post;
	
}



/*
== ------------------------------------------------------------------- ==
== @@ Aside Post Format
== ------------------------------------------------------------------- ==
*/
	
add_filter( 'post-format-aside', 'invicta_postformat_filter_aside' );

function invicta_postformat_filter_aside( $current_post ) {
	
	$current_post['show_title'] 			= false;
	$current_post['show_author'] 			= false;
	$current_post['show_categories'] 		= false;
	$current_post['show_comments'] 			= false;
	$current_post['show_tags'] 				= false;
	$current_post['show_author'] 			= false;
	$current_post['show_author_details'] 	= false;
	
	$current_post['before_meta'] = $current_post['content'];
	$current_post['content'] = '';
	$current_post['thumbnail'] = '';
	
	if ( ! is_single() ) {
	
		// add hyperlink to date
	
		$date = '';
		$date .= '<a';
		$date .=	' href="' . get_permalink() . '"';
		$date .= 	' title="' . __("Permalink to", "invicta_dictionary") . ' ' . esc_attr( get_the_title() ) . '"';
		$date .= 	' rel="bookmark"';
		$date .= 	' class="inherit-color accentcolor-text-on_hover"';
		$date .= 	'>';
		$date .=		$current_post['date'];
		$date .= '</a>';
		
		$current_post['date'] = $date;
	
	}
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Quote Post Format
== ------------------------------------------------------------------- ==
*/
	
add_filter( 'post-format-quote', 'invicta_postformat_filter_quote' );

function invicta_postformat_filter_quote( $current_post ) {
	
	$current_post['show_title'] 	= false;
	$current_post['show_author'] 	= false;
	
	$content = '';
	
	// check if the content is a blockquote
	preg_match( "!<blockquote>(.*?)<\/blockquote>!s", $current_post['content'], $matches );
	if ( ! empty( $matches[1] ) && is_array( $matches ) ) {
		$content = $matches[1];
	}
	else {
		$content = $current_post['content'];
	}
	
	$current_post['before_meta'] = $content;
	$current_post['content'] = '';
	$current_post['thumbnail'] = '';
	
	if ( ! is_single() ) {
	
		// add hyperlink to date
	
		$date = '';
		$date .= '<a';
		$date .=	' href="' . get_permalink() . '"';
		$date .= 	' title="' . __("Permalink to", "invicta_dictionary") . ' ' . esc_attr( get_the_title() ) . '"';
		$date .= 	' rel="bookmark"';
		$date .= 	' class="inherit-color accentcolor-text-on_hover"';
		$date .= 	'>';
		$date .=		$current_post['date'];
		$date .= '</a>';
		
		$current_post['date'] = $date;
	
	}
	
	return $current_post;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Status Post Format
== ------------------------------------------------------------------- ==
*/
	
add_filter( 'post-format-status', 'invicta_postformat_filter_status' );

function invicta_postformat_filter_status( $current_post ) {
	
	$current_post['show_title'] 		= false;
	$current_post['show_categories'] 	= false;
	
	$current_post['before_meta'] = $current_post['content'];
	$current_post['content'] = '';
	$current_post['thumbnail'] = '';
	
	
	if ( ! is_single() ) {
	
		// add hyperlink to date
	
		$date = '';
		$date .= '<a';
		$date .=	' href="' . get_permalink() . '"';
		$date .= 	' title="' . __("Permalink to", "invicta_dictionary") . ' ' . esc_attr( get_the_title() ) . '"';
		$date .= 	' rel="bookmark"';
		$date .= 	' class="inherit-color accentcolor-text-on_hover"';
		$date .= 	'>';
		$date .=		__( 'Status on', 'invicta_dictionary' ) . ' ' . $current_post['date'];
		$date .= '</a>';
		
		$current_post['date'] = $date;
	
	}
	
	return $current_post;
	
}
	
?>