<?php 

	global $smof_data;
		
	$post_format = get_post_format() ? get_post_format() : 'standard';
	
	$current_post['thumbnail'] 	= invicta_post_featured_image();
	$current_post['title'] 		= invicta_post_title();
	$current_post['content']	= get_the_excerpt();
	$current_post['content'] 	.= ' <a href="' . get_permalink($post->ID) .'">' . __(' Continue Reading', 'invicta_dictionary' ) . '</a>';
	$current_post['date'] 		= get_the_date( $smof_data['blog-date_format'] );
	$current_post['before_meta'] = '';
	
	$current_post['show_title']				= true;
	$current_post['show_author']			= $smof_data['blog-metadata-author'];	
	$current_post['show_date'] 				= $smof_data['blog-metadata-date'];
	$current_post['show_categories'] 		= $smof_data['blog-metadata-categories'];
	$current_post['show_comments'] 			= $smof_data['blog-metadata-comments'];
	$current_post['show_author'] 			= $smof_data['blog-metadata-author'];
	
	$current_post = apply_filters( 'post-format-' . $post_format, $current_post );
	
	$current_post['content'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $current_post['content'] ));
	if ( ! empty( $current_post['before_meta'] ) ) {
		$current_post['before_meta'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $current_post['before_meta'] ));
	}
	
?>
<article id="post-<?php the_ID() ?>" <?php post_class('entry'); ?>>

	<div class="post_thumbnail">
		<?php echo $current_post['thumbnail']; ?>
	</div>
	
	<div class="post_info">
	
		<h2 class="post_title">
			<?php echo $current_post['title']; ?>
		</h2>
		
		<div class="post_meta">
		
			<?php if ( $current_post['show_author'] ) : ?>
			<span class="meta">
				<i class="icon-user"></i>
				<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
					<?php the_author_posts_link(); ?>
				</span>
			</span>
			<?php endif; ?>
		
			<?php if ( $current_post['show_date'] ) : ?>
			<span class="meta">
				<i class="icon-time"></i>
				<?php echo $current_post['date']; ?>
			</span>
			<?php endif; ?>
			
		</div>
		
		<div class="post_text">
			<?php echo $current_post['content']; ?>
		</div>
	
	</div>
	
	<div class="clear"></div>
	
</article>