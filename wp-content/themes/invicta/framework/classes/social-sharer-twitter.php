<?php 
	
class invicta_social_sharer_twitter {

	static $link_url = 'https://twitter.com/share';
	static $link_class = 'twitter-share-button';
	static $link_text = 'Tweet';
	
	private $url;
	private $text;
	private $via;
	private $count;
	private $recommend;
	private $hashtag; 		// csv of tags
	private $language;
	private $alignment;
	
	function __construct( $args = array() ) {
		
		extract( wp_parse_args($args, array(
			'url' => '',
			'text' => '',
			'via' => '',
			'count' => true,
			'recommend' => '',
			'hashtag' => '',
			'language' => '',
			'alignment' => 'right'
		)) );
		
		$this->url = $url;
		$this->text = $text;
		$this->via = $via;
		$this->count = $count;
		$this->recommend = $recommend;
		$this->hashtag = $hashtag;
		$this->language = $language;
		$this->alignment = $alignment;
		
	}
	
	function get_html() {
	
		$output = '<div class="invicta_social_sharer">';
	
		$output .= '<a';
		$output .= 		' href="' . self::$link_url . '"';
		$output .= 		' class="' . self::$link_class . '"';
		$output .= 		' data-align="' . $this->alignment . '"';		
		
		if ( $this->url ) {
			$output .= 	' data-url="' . $this->url . '"'; 
		}
		
		if ( $this->text ) {
			$output .= 	' data-text="' . $this->text . '"'; 
		}
		
		if ( $this->via ) {
			$output .= 	' data-via="' . $this->via . '"'; 
		}
		
		if ( $this->count == false ) {
			$output .=	' data-count="none"';
		}
		
		if ( $this->recommend ) {
			$output .=	' data-related="' . $this->recommend . '"';
		}
		
		if ( $this->hashtag ) {
			$output .= 	' data-hashtags="' . $this->hashtag . '"';
		}
		
		if ( $this->language ) {
			$output .= 	' data-lang="' . $this->language . '"';
		}
		
		$output .= '>';
		$output .= self::$link_text;
		$output .= '</a>';
		
		$output .= $this->get_script();
		
		$output .= '</div>';
		
		return $output;
		
	}
	
	private function get_script() {
		
		return "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>";
		
	}
	
}	
	
?>