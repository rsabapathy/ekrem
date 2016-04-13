<?php 

/*
== ------------------------------------------------------------------- ==
== @@ Get Thumbnail from external (youtube or vimeo) video
== ------------------------------------------------------------------- ==
*/

function invicta_get_thumbnail_from_external_video( $video_url ) {
	
	if ( invicta_is_youtube_url( $video_url ) ) {
		return invicta_get_thumbnail_from_youtube_video( $video_url );
	}
	elseif ( invicta_is_vimeo_url( $video_url ) ) {
		return invicta_get_thumbnail_from_vimeo_video( $video_url );
	}
	else {
		return '';
	}
	
}
	
/*
== ------------------------------------------------------------------- ==
== @@ Get Thumbnail from Youtube video
== ------------------------------------------------------------------- ==
*/

function invicta_get_thumbnail_from_youtube_video( $video_url ) {
	
	$thumbnail_url = '';
	
	try {
	
		$video_id = invicta_extract_video_id_from_youtube_video_url( $video_url );
		$youtube_api_url = 'http://img.youtube.com/vi/%s/0.jpg';
		$youtube_api_url = sprintf( $youtube_api_url, $video_id );
		
		$thumbnail_url = $youtube_api_url;
	
	} catch (Exception $e) {}
	
	return $thumbnail_url;
	
}


/*
== ------------------------------------------------------------------- ==
== @@ Get Thumbnail from Vimeo video
== ------------------------------------------------------------------- ==
*/

function invicta_get_thumbnail_from_vimeo_video( $video_url ) {
	
	$thumbnail_url = '';
	
	try {
	
		$video_id = invicta_extract_video_id_from_vimeo_video_url( $video_url );
		$vimeo_api_url = 'http://vimeo.com/api/v2/video/%s.json';
		$vimeo_api_url = sprintf( $vimeo_api_url, $video_id );
		
		$response = wp_remote_get( $vimeo_api_url );
		$response_data = json_decode( $response['body'], true );
		
		$thumbnail_url = $response_data[0]['thumbnail_large'];
	
	} catch (Exception $e) {}
	
	return $thumbnail_url;
	
}

/*
== ------------------------------------------------------------------- ==
== @@ Extract video ID from Youtube URL
== ------------------------------------------------------------------- ==
*/

function invicta_extract_video_id_from_youtube_video_url( $video_url ) {
	
        $regexstr = '~
            # Match Youtube link and embed code
            (?:                             # Group to match embed codes
                (?:<iframe [^>]*src=")?     # If iframe match up to first quote of src
                |(?:                        # Group to match if older embed
                    (?:<object .*>)?      	# Match opening Object tag
                    (?:<param .*</param>)*  # Match all param tags
                    (?:<embed [^>]*src=")?  # Match embed tag to the first quote of src
                )?                          # End older embed code group
            )?                              # End embed code groups
            (?:                             # Group youtube url
                https?:\/\/                 # Either http or https
                (?:[\w]+\.)*                # Optional subdomains
                (?:                         # Group host alternatives.
                youtu\.be/                  # Either youtu.be,
                | youtube\.com              # or youtube.com
                | youtube-nocookie\.com     # or youtube-nocookie.com
                )                           # End Host Group
                (?:\S*[^\w\-\s])?           # Extra stuff up to VIDEO_ID
                ([\w\-]{11})                # $1: VIDEO_ID is numeric
                [^\s]*                      # Not a space
            )                               # End group
            "?                              # Match end quote if part of src
            (?:[^>]*>)?                     # Match any extra stuff up to close brace
            (?:                             # Group to match last embed code
                </iframe>                 	# Match the end of the iframe
                |</embed></object>          # or Match the end of the older embed
            )?                              # End Group of last bit of embed code
            ~ix';
 
        preg_match( $regexstr, $video_url, $matches );
 
        return $matches[1];
        
}

/*
== ------------------------------------------------------------------- ==
== @@ Extract video ID from Vimeo URL
== ------------------------------------------------------------------- ==
*/

function invicta_extract_video_id_from_vimeo_video_url( $video_url ) {
	
        $regexstr = '~
            # Match Vimeo link and embed code
            (?:<iframe [^>]*src=")?     # If iframe match up to first quote of src
            (?:                         # Group vimeo url
                https?:\/\/             # Either http or https
                (?:[\w]+\.)*            # Optional subdomains
                vimeo\.com              # Match vimeo.com
                (?:[\/\w]*\/videos?)?   # Optional video sub directory this handles groups links also
                \/                      # Slash before Id
                ([0-9]+)                # $1: VIDEO_ID is numeric
                [^\s]*                  # Not a space
            )                           # End group
            "?                          # Match end quote if part of src
            (?:[^>]*></iframe>)?        # Match the end of the iframe
            (?:<p>.*</p>)?              # Match any title information stuff
            ~ix';
 
        preg_match( $regexstr, $video_url, $matches );
 
        return $matches[1];
        
}

/*
== ------------------------------------------------------------------- ==
== @@ Check if URL is from Youtube
== ------------------------------------------------------------------- ==
*/

function invicta_is_youtube_url( $video_url ) {
	return ( preg_match('/youtu\.be/i', $video_url) || preg_match('/youtube\.com\/watch/i', $video_url) );
}

/*
== ------------------------------------------------------------------- ==
== @@ Check if URL is from Vimeo
== ------------------------------------------------------------------- ==
*/

function invicta_is_vimeo_url( $video_url ) {
	return ( preg_match('/vimeo\.com/i', $video_url ) );
}
	
?>