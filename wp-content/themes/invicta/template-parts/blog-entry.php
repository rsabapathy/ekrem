<?php 

	global $smof_data;
		
	$post_format = get_post_format() ? get_post_format() : 'standard';
	
	$current_post['thumbnail'] 	= invicta_post_featured_image();
	$current_post['title'] 		= invicta_post_title();
	$current_post['content']	= ( ( $post->post_excerpt == '' ) || ( is_single() ) ) ? get_the_content( __("Read more", "invicta_dictionary") ) : get_the_excerpt();
	$current_post['date'] 		= get_the_date( $smof_data['blog-date_format'] );
	$current_post['before_meta'] = '';
	

	$current_post['show_title']				= true;
	$current_post['show_author']			= $smof_data['blog-metadata-author'];	
	$current_post['show_date'] 				= $smof_data['blog-metadata-date'];
	$current_post['show_categories'] 		= $smof_data['blog-metadata-categories'];
	$current_post['show_comments'] 			= $smof_data['blog-metadata-comments'];
	$current_post['show_tags'] 				= $smof_data['blog-metadata-tags'];
	$current_post['show_author'] 			= $smof_data['blog-metadata-author'];
	$current_post['show_author_details'] 	= $smof_data['blog-metadata-author_details'];
	
	$current_post = apply_filters( 'post-format-' . $post_format, $current_post );
	
	// add <br/> before the more-link
	preg_match_all( "/<a[^']*?class=\"more-link\"[^']*?>/", $current_post['content'], $matches );
	if ( ! empty( $matches[0] ) ) { 
		$more_link_html = $matches[0][0];
		$current_post['content'] = str_replace( $more_link_html, '<br />' . $more_link_html, $current_post['content'] );	
	}
	
	$current_post['content'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $current_post['content'] ));
	if ( ! empty( $current_post['before_meta'] ) ) {
		$current_post['before_meta'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $current_post['before_meta'] ));
	}
	
?>
<article id="post-<?php the_ID() ?>" <?php post_class('entry'); ?>>

	<div class="post_thumbnail">
		<?php echo $current_post['thumbnail']; ?>
	</div>
	
	<?php if ( $current_post['show_title'] ) : ?>
	<h2 class="post_title">
		<?php echo $current_post['title']; ?>
	</h2>
	<?php endif; ?>
	
	<div class="before_meta text_styles">
		<?php echo $current_post['before_meta']; ?>
	</div>
	
	<div class="post_meta">
		<div class="primary_meta">
		
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
			
			<?php if ( $current_post['show_categories'] ) : ?>
			<span class="meta">
				<i class="icon-tag"></i>
				<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
					<?php echo get_the_category_list(', '); ?>
				</span>
			</span>
			<?php endif; ?>
			
		</div>
		<div class="secondary_meta">
		
			<?php if ( $current_post['show_comments'] ) : ?>
				<?php if ( get_comments_number() != "0" || comments_open() ) : ?>
				<span class="meta">
					<i class="icon-comments"></i>
					<span class="inherit-color-on_children accentcolor-text-on_children-on_hover">
						<?php comments_popup_link(__('Leave a comment', 'invicta_dictionary'), __('1 Comment', 'invicta_dictionary'), __('% Comments', 'invicta_dictionary')); ?>
					</span>
				</span>
				<?php endif; ?>
			<?php endif; ?>
			
		</div>
		<div class="alignclear"></div>
	</div>
	
	<div class="post_text text_styles">
		<?php echo $current_post['content']; ?>
		<?php if ( is_single() ) { wp_link_pages(); } ?>
	</div>

	
	<?php if ( is_single() ) : ?>
	<div class="post_extras">
		
		<?php if ( $current_post['show_tags'] ) : ?>
		<div class="post_tags invicta_tags">
			<?php if ( has_tag() ) : ?>
				<strong>
					<?php _e('Tags','invicta_dictionary'); ?>:
				</strong>
				<span class="accentcolor-border-on_children accentcolor-background-on_children-on_hover">
					<?php the_tags('', ' '); ?>
				</span>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		
		<div class="post_sharing">
			<?php invicta_social_share_buttons(); ?>
		</div>
				
		<div class="alignclear"></div>
	</div>
	<?php endif; ?>
	
	<?php if ( is_single() ) : ?>
		<?php 
		if ( $current_post['show_author'] && $current_post['show_author_details'] ) {
			invicta_post_author();
		}
		?>
		<?php if ( $smof_data['blog-post_navigation'] ) {
			invicta_post_pagination();
		} ?>
		<?php comments_template(); ?>
	<?php endif; ?>
	
	<div class="clear"></div>
	
</article>