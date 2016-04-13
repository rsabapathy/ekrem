<?php 
	
class invicta_social_sharer_facebook {
	
	private $url;
	
	function __construct( $args = array() ) {
		
		extract( wp_parse_args($args, array(
			'url' => ''
		)) );
		
		$this->url = $url;
		
	}
	
	function get_html() {
		
		$output = '<div class="invicta_social_sharer">';
		
		$output .= '<div';
		$output .= 		' class="fb-like"';
		if ( $this->url ) {
			$output .= 	' data-href="' . $this->url . '"'; 
		}
		$output .=	' data-width="250"';
		$output .=	' data-layout="button_count"';
		$output .=	' data-show-faces="false"';
		$output .=	' data-send="false"';
		$output .= '>';
		$output .= '</div>';
		
		$output .= $this->get_script();
		
		$output .= '</div>';
		
		return $output;
		
	}
	
	private function get_script() {
		
		$language = str_replace( '-', '_', get_bloginfo('language') );
		
		$script_src = "<div id='fb-root'></div><script>(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) return;  js = d.createElement(s); js.id = id;  js.src = '//connect.facebook.net/%s/all.js#xfbml=1'; fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>";

		$script = sprintf( $script_src, $language );
		
		return $script;
		
	}
	
}	
	
?>