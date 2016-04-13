<?php 
	global $invicta_settings;
	$context = 'blog_list'; 
?>
<?php get_header(); ?>
<div class="invicta_canvas no_sidebar">
	<div class="main_column">

		<?php if ( have_posts() ) : ?>
		<section class="blog_loop<?php invicta_layout_class( 'blog_layout', 'list' ); ?>">
			<?php 
			while (have_posts()) { 
				the_post();
				$type = get_post_mime_type( $post->ID );
				$show_nav = false;
				?>
				<article id="post-<?php the_ID() ?>" <?php post_class('entry'); ?>>		
					<div class="post_text text_styles">
						<?php 
						
						switch ( $type ) {
							
							case 'image/jpeg':
							case 'image/gif':
							case 'image/png':
							case 'image/bmp':
							case 'image/tiff':
							case 'image/x-icon':
								$attachment_size = apply_filters( 'shape_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
								echo '<p>';							
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								echo '</p>';
								$show_nav = true;
								break;
								
							default:
								echo '<p>';
								echo 	'<i class="icon-paper-clip icon-4x"></i>';
								echo '</p>';
								echo '<p>';
								echo 	'<a href="' . wp_get_attachment_url(). '">' . get_the_title() . '</a>';
								echo '</p>';
								break;
							
						}
						
						if ( ! empty( $post->post_excerpt ) ) {
							the_excerpt();
                        }
						
						the_content();
						
						?>
					</div>
					
					<?php if ( $show_nav ) : ?>
					<div class="invicta_post_navigation">
						<?php 
						
							$previous_format = '';
							$previous_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
							$previous_format .= '%link';
							$previous_format .= '</span>';
						
							$previous_link = '';
							$previous_link .= '<cite class="accentcolor-text-on_children">';
							$previous_link .= '<i class="icon-long-arrow-left"></i> ';
							$previous_link .= __('Previous Attachment', 'invicta_dictionary');
							$previous_link .= '</cite>';
						
							$next_format = '';
							$next_format .= '<span class="accentcolor-text-on_children-on_hover inherit-color-on_children">';
							$next_format .= '%link';
							$next_format .= '</span>';
						
							$next_link = '';
							$next_link .= '<cite class="accentcolor-text-on_children">';
							$next_link .= __('Next Attachment', 'invicta_dictionary');
							$next_link .= ' <i class="icon-long-arrow-right"></i>';
							$next_link .= '</cite>';
							
						?>
						<div class="prev">
							<?php previous_image_link($previous_format, $previous_link); ?>
						</div>
						<div class="next">
							<?php next_image_link($next_format, $next_link); ?>
						</div>
						<div class="alignclear"></div>
					</div>
					<?php endif; ?>

					<?php //comments_template(); ?>
					
				</article>	   
				<?php 
			}
			?>
		</section>		
		<?php endif; ?>

	</div>
</div>
<?php get_footer(); ?>