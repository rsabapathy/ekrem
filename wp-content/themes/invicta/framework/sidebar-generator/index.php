<?php
	
if ( ! class_exists('invicta_sidebar_generator') ) {

	class invicta_sidebar_generator {
		
		private $paths = array();
		private $custom_sidebars = array();
		private $database_field = '';
		private $nonce_id = 'invicta_del_sidebar_nonce';
		private $title = '';
		
		function __construct() {
			
			$this->paths['javascript'] 	= INVICTA_FMW_URL . 'sidebar-generator/assets/scripts.js';
			$this->paths['styles'] 		= INVICTA_FMW_URL . 'sidebar-generator/assets/styles.css';
			$this->database_field 		='_invicta_custom_sidebars';
			
			add_action( 'load-widgets.php', array( &$this, 'load_assets' ), 5 );
			add_action( 'widgets_init', array( &$this, 'register_custom_sidebars' ), 1000 );
			add_action( 'wp_ajax_invicta_ajax_delete_custom_sidebar', array( &$this, 'delete_sidebar_area') );
			
		}
		
		function load_assets() {
			
			add_action( 'admin_print_scripts', array( &$this, 'render_new_widget_form' ) );
			add_action( 'load-widgets.php', array( &$this, 'add_sidebar_area' ), 100 );
			
			wp_enqueue_script( 'invicta_sidebar_generator', $this->paths['javascript'] );
			wp_enqueue_style( 'invicta_sidebar_generator', $this->paths['styles'] );
			
		}
		
		function render_new_widget_form() {
		
			$new_ui_class = '';
			try {
				global $wp_version;
				if ( version_compare( $wp_version, '3.8') >= 0 ) {
					$new_ui_class = ' new_3_8_ui';
				}
			}
			catch( Exception $e ) {	
			}
			
			$nonce_hidden_field = '<input type="hidden" name="invicta_del_sidebar_nonce" value="' . wp_create_nonce( $this->nonce_id ) . '" />';
			
			echo "\n<script type='text/html' id='invicta_add_sidebar_form'>";
			echo "\n	<div class='invicta_add_sidebar_form" . $new_ui_class . "'>";
			echo "\n		<form method='POST'>";
			echo "\n			<h3>" . __("Custom Sidebars", "invicta_dictionary") . "</h3>";
			echo "\n			<input type='text' name='invicta_new_sidebar_name' value='' placeholder='" . __("Enter the name of the new Sidebar", "invicta_dictionary") . "' />";
			echo "\n			<input type='submit' value='" . __("Create Sidebar", "invicta_dictionary") . "' class='button button-primary center' />";
			echo "\n			" . $nonce_hidden_field;
			echo "\n		</form>";
			echo "\n	</div>";
			echo "\n</script>\n";
			
			
		}
		
		function add_sidebar_area() {
			
			if ( ! empty( $_POST['invicta_new_sidebar_name'] ) ) {
				
				$this->custom_sidebars = get_option( $this->database_field );
				$sidebar_name = $this->get_secure_sidebar_name( $_POST['invicta_new_sidebar_name'] );
				
				if ( empty( $this->custom_sidebars ) ) {
					$this->custom_sidebars = array( $sidebar_name );
				}
				else {
					$this->custom_sidebars = array_merge( $this->custom_sidebars, array( $sidebar_name ) );
				}
				
				update_option( $this->database_field, $this->custom_sidebars );
				wp_redirect( admin_url( 'widgets.php' ) );
				die();
				
			}
			
		}
		
		function delete_sidebar_area() {
						
			check_ajax_referer($this->nonce_id);
			
			if ( ! empty( $_POST['sidebar_name'] ) ) {
				
				$sidebar_name = stripcslashes( $_POST['sidebar_name'] );
				$this->custom_sidebars = get_option( $this->database_field );
				
				if ( ( $key = array_search( $sidebar_name, $this->custom_sidebars ) ) !== false ) {
	
					unset( $this->custom_sidebars[ $key ] );
					update_option( $this->database_field, $this->custom_sidebars );
					echo 'success';
					
				}
				
			}
			
			die();
			
		}
		
		function register_custom_sidebars() {
			
			if ( empty( $this->custom_sidebars ) ) {
				$this->custom_sidebars = get_option( $this->database_field );
			}
			
			$args = array(
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h3 class="widget_title">',
				'after_title' 	=> '</h3>',
				);
			
			if ( is_array( $this->custom_sidebars) ) {
				foreach ( $this->custom_sidebars as $sidebar ) {
					
					$args['id']    = sanitize_title_with_dashes( $sidebar );
					$args['name']  = $sidebar;
					$args['class'] = 'invicta-custom';
					
					register_sidebar( $args );
					
				}
			}
			
		}
		
		function get_secure_sidebar_name( $name ) {
			
			if ( empty( $GLOBALS['wp_registered_sidebars'] ) ) {
				return $name;
			}
						
			$taken_sidebar_names = $this->get_taken_sidebar_names();
						
			if ( in_array( $name, $taken_sidebar_names ) ) {
				
				$counter = substr( $name, -1 );
				$new_name = '';
				
				if ( ! is_numeric( $counter ) ) {
					$new_name = $name . " 1";
				}
				else {
					$new_name = substr( $name, 0, -1 ) . ( (int) $counter + 1 );
				}
				
				$name = $this->get_secure_sidebar_name( $new_name );
				
			}
			
			return $name;
			
		}
		
		function get_taken_sidebar_names() {
			
			// sidebars created by the common wordpress method
			$common_taken_sidebar_names = array(); 
			foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
				$common_taken_sidebar_names[] = $sidebar['name'];
			}
			
			// sidebars created by the generator (this own class)
			$custom_taken_sidebar_names = array(); 
			if ( empty( $this->custom_sidebars ) ) {
				$custom_taken_sidebar_names = array();
			}
			else {
				$custom_taken_sidebar_names = $this->custom_sidebars;
			}
			
			$taken_sidebar_names = array_merge( $common_taken_sidebar_names, $custom_taken_sidebar_names );
			
			return $taken_sidebar_names;
			
		}
		
	}
	
}
	
?>