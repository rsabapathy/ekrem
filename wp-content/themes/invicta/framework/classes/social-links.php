<?php 

class invicta_social_links {

	private $before_html;
	private $after_html;
	private $target;
	private $show_text;
	private $data;

	public function __construct( $args ) {
			
		extract(shortcode_atts(array(
			'before_html' 	=> '<div class="social_links accentcolor-text-on_children-on_hover inherit-color-on_children">',
			'after_html' 	=> '</div>',
			'target'		=> '_blank',
			'show_text' 	=> 0,
			'data'			=> null
		), $args));	
		
		$this->before_html = $before_html;
		$this->after_html = $after_html;
		$this->target = $target;
		$this->show_text = $show_text;
		$this->data = array();
		
		$structure_data = $this->get_structure_data();
		
		foreach ( $data as $dataitem ) {
			foreach ( $structure_data as $structure_dataitem ) {
				if ( $dataitem['id'] == $structure_dataitem['id'] ) {
					$item = $structure_dataitem;
					$dataitem['url'] = preg_replace('#^https?://#', '', $dataitem['url']);
					$item['url'] = ( $item['pattern'] != '' ) ? str_replace('{*}', $dataitem['url'], $item['pattern']) : $dataitem['url'];
					$item['text'] = ( isset($dataitem['text']) ) ? $dataitem['text'] : $item['text']; 
					$item['tooltip'] = ( isset($dataitem['tooltip']) ) ? $dataitem['tooltip'] : $item['tooltip']; 
					$item['target'] = ( isset($dataitem['target']) ) ? $dataitem['target'] : $item['target']; 

					if ( $item['id'] != 'skype' ) {
						$item['url'] = esc_url( $item['url'] );
					}

					array_push($this->data, $item);
				}
			}
		}
		
	}
	
	private function get_structure_data() {
		
		$dataset = array(
			array(
				'id' 			=> 'twitter',
				'icon_class'	=> 'icon-twitter',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Twitter', 'invicta_dictionary'),
				'tooltip'		=> __('Twitter', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'facebook',
				'icon_class'	=> 'icon-facebook',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Facebook', 'invicta_dictionary'),
				'tooltip'		=> __('Facebook', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'googleplus',
				'icon_class'	=> 'icon-google-plus',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Google Plus', 'invicta_dictionary'),
				'tooltip'		=> __('Google Plus', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'linkedin',
				'icon_class'	=> 'icon-linkedin',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('LinkedIn', 'invicta_dictionary'),
				'tooltip'		=> __('LinkedIn', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'xing',
				'icon_class'	=> 'icon-xing',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Xing', 'invicta_dictionary'),
				'tooltip'		=> __('Xing', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'dribbble',
				'icon_class'	=> 'icon-dribbble',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Dribbble', 'invicta_dictionary'),
				'tooltip'		=> __('Dribbble', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'flickr',
				'icon_class'	=> 'icon-flickr',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Flickr', 'invicta_dictionary'),
				'tooltip'		=> __('Flickr', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'tumblr',
				'icon_class'	=> 'icon-tumblr',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Tumblr', 'invicta_dictionary'),
				'tooltip'		=> __('Tumblr', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'skype',
				'icon_class'	=> 'icon-skype',
				'url'			=> '',
				'target' 		=> '_self',
				'text' 			=> __('Skype', 'invicta_dictionary'),
				'tooltip'		=> __('Skype', 'invicta_dictionary'),
				'pattern'		=> "skype:{*}?call"
			),
			array(
				'id' 			=> 'email',
				'icon_class'	=> 'icon-envelope',
				'url'			=> '',
				'target' 		=> '_self',
				'text' 			=> __('Email', 'invicta_dictionary'),
				'tooltip'		=> __('Email', 'invicta_dictionary'),
				'pattern'		=> "mailto:{*}"
			),
			array(
				'id' 			=> 'url',
				'icon_class'	=> 'icon-link',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('URL', 'invicta_dictionary'),
				'tooltip'		=> __('URL', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'instagram',
				'icon_class'	=> 'icon-instagram',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Instagram', 'invicta_dictionary'),
				'tooltip'		=> __('Instagram', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'pinterest',
				'icon_class'	=> 'icon-pinterest',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Pinterest', 'invicta_dictionary'),
				'tooltip'		=> __('Pinterest', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'foursquare',
				'icon_class'	=> 'icon-foursquare',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Foursquare', 'invicta_dictionary'),
				'tooltip'		=> __('Foursquare', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'youtube',
				'icon_class'	=> 'icon-youtube',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('Youtube', 'invicta_dictionary'),
				'tooltip'		=> __('Youtube', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			),
			array(
				'id' 			=> 'feed',
				'icon_class'	=> 'icon-rss',
				'url'			=> '',
				'target' 		=> '_blank',
				'text' 			=> __('RSS Feed', 'invicta_dictionary'),
				'tooltip'		=> __('RSS Feed', 'invicta_dictionary'),
				'pattern'		=> "http://{*}"
			)
		);
		
		return $dataset;
		
	}
	
	public function print_html() {
		
		echo $this->get_html();
		
	}
	
	public function get_html() {
	
		$output = '';
		
		if ( sizeof( $this->data ) > 0 ) {
			$output .= $this->before_html;
			foreach ($this->data as $dataitem) {			
				$output .= '<a href="' . $dataitem['url'] . '" target="' . $dataitem['target'] . '" title="' . esc_attr( $dataitem['tooltip'] ) . '">';
				$output .= '<i class="' . esc_attr( $dataitem['icon_class'] ) . '"></i>';
				if ( $this->show_text) {
					$output .= $dataitem['text'];
				}
				$output .= '</a>';
			}	
			
			$output = apply_filters( 'invicta_social_links_extras', $output);
			
			$output .= $this->after_html;
		}
		
		return $output;
		
	}
	
}

?>