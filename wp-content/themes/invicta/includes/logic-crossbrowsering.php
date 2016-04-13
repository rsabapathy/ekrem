<?php 

add_filter('wp_head', 'invicta_lt_ie9_css');

function invicta_lt_ie9_css() {
?>

<!--[if lt IE 9]>
<style type="text/css" media="screen">

	/* IE hack to avoid HALO Effect in IE8*/
	.tp-caption img {
		background:none\9;
		filter:progid:DXImageTransform.Microsoft.AlphaImageLoader();
	}
	
	.wpb_content_element.wpb_single_image img {
		width: inherit;
		height: auto;
		max-width: 100%;
	}
	
	img { width:inherit; max-width:100%; height:auto; }
	
	.page_header .logo a { width:100%; }
	.page_header .logo img { height:100%; }
	
	.woocommerce span.onsale, 
	.woocommerce-page span.onsale {
		right:0;
		top:0;
		width:80px;
		}
	
</style>
<![endif]-->

<?php 	
}

?>