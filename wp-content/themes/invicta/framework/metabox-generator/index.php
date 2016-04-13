<?php 
	
if ( ! class_exists('invicta_metabox') ) {
	
	class invicta_metabox {
	
		private $id;
		private $title;
		private $post_types;
		private $context;
		private $priority;
		private $fields;
		
		private $nonce;
		
		static $prefix = '_invicta_';
		
		function __construct( $metabox ) {
			
			if ( ! is_admin() ) {
				return;
			}

			$this->id 			= $metabox['id'];
			$this->title 		= $metabox['title'];
			$this->post_types 	= $metabox['post_types'];
			$this->context 		= $metabox['context'];
			$this->priority 	= $metabox['priority'];
			$this->fields 		= $metabox['fields'];
			$this->nonce 		= $metabox['id'] . '_metabox_nonce';
			
			add_action( 'add_meta_boxes', array( &$this, 'add_metabox') );
			add_action( 'save_post', array( &$this, 'save_metabox' ) );
			
		}
		
		function add_metabox() {
		
			foreach ( $this->post_types as $post_type ) {

				add_meta_box( 
					$this->id, 
					$this->title, 
					array(&$this,'render_metabox'), 
					$post_type, 
					$this->context, 
					$this->priority
					);
				
			}
			
		}
		
		function render_metabox() {
			
			global $post;
			
			echo '<div class="custom_metabox">';
			echo '<input type="hidden" name="' . $this->nonce . '" value="' . wp_create_nonce( $this->nonce ) . '" />';
			
			foreach ( $this->fields as $field ) {
								
				$current_value = get_post_meta( $post->ID, $field['id'], true );
				$current_value_array = get_post_meta ($post->ID, $field['id'], false );
				
				if ( empty( $current_value ) && ! sizeof( $current_value_array ) ) {
					if ( isset( $field['default'] ) ) {
						$current_value = $field['default']; // set default value
					}
				}
				
				echo '<div>';
				echo 	'<p class="title">' . $field['name'] . '</p>';
				include( 'field-templates/' . $field['type'] . '.php' );
				echo '</div>';
				
			}
			
			echo '</div>';

			
		}
		
		function save_metabox( $post_id ) {
			
			// don't save if nonce doesn't match
			if ( ! isset( $_POST[ $this->nonce ] ) || ! wp_verify_nonce( $_POST[ $this->nonce ], $this->nonce ) ) {
				return $post_id;
			}
			
			// don't save if wp is doing an autosave
			// because autosave doesn't deals with metaboxes
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
				return $post_id;
			}
			
			// don't save if current user doesn't have permissions
			if ( $_POST['post_type'] == 'post' ) {
				if ( ! current_user_can( 'edit_post', $post_id) ) {
					return $post_id;
				}
				elseif ( ! current_user_can( 'edit_page', $post_id) ) {
					return $post_id;
				}
			}
			
			// save
			foreach ( $this->fields as $field ) {
			
				if ( $field['type'] != 'image-preview' ) {

					$id = $field['id'];
					
					$value = $_POST[ $id ];
					
					if ( is_array( $value ) ) {
						$value = join( ',', $value );
					}
					else {
						$value = sanitize_text_field( $value );	
					}
					
					if ( ! empty( $value ) ) {
						update_post_meta( $post_id, $id, $value );
					}
					else {
						delete_post_meta( $post_id, $id );
					}
				
				}
			}
			
		}
		
	}
	
}
	
?>