<?php 

function invicta_get_google_web_fonts() {

	$fonts = array(
		'Alice',
		'Allerta',
		'Allura',
		'Antic',
		'Bad Script',
		'Bangers',
		'Bitter',
		'Bree',
		'Cardo',
		'Carme',
		'Cookie',
		'Coustard',
		'Gruppo',
		'Damion',
		'Dancing Script',
		'Droid Sans',
		'Droid Serif',
		'Fjord One',
		'Inconsolata',
		'Josefin Sans',
		'Kameron',
		'Kaushan Script',
		'Kreon',
		'Lobster',
		'Lato',
		'Mate SC',
		'Mako',
		'Merriweather',
		'Metrophobic',
		'Muli',
		'Nobile',
		'News Cycle',
		'Open Sans',
		'Orbitron',
		'Oswald',
		'Pacifico',
		'Podkova',
		'PT Sans',
		'Quattrocento',
		'Questrial',
		'Quicksand',
		'Raleway',
		'Salsa',
		'Terminal Dosis',
		'Tenor Sans',
		'Ubuntu',
		'Varela Round',
		'Vollkorn',
		'Yellowtail',
	);
	
	$fonts = apply_filters( 'invicta_google_web_fonts', $fonts);
	
	return $fonts;
	
}

function invicta_get_os_native_fonts() {
	
	$fonts = array(
		'Arial',
		'Arial Black',
		'Comic Sans MS',
		'Courier New',
		'Georgia',
		'Impact',
		'Times New Roman',
		'Trebuchet MS',
		'Verdana'
	);
	
	$fonts = apply_filters( 'invicta_os_native_fonts', $fonts);
	
	return $fonts;
	
}
	
?>