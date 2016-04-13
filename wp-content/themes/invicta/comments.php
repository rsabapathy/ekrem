<?php 
	$show_pings = true;
?>
<?php 
// -------------------------------------------------------------------------------------
// @ Validate context
// -------------------------------------------------------------------------------------
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
	die ('Please do not load this page directly. Thanks!');	
}
?>
<?php 
// -------------------------------------------------------------------------------------
// @ Check if post is password protected
// -------------------------------------------------------------------------------------
if (post_password_required()) { 
	echo '<div class="password_protected">' . __('This post is password protected. Enter the password to view any comments.', 'invicta_dictionary') . '</div>';
	return;
}
?>
<?php 
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
// @ Comment Listing
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
?>
<?php if ( have_comments() ) : ?>
	<section id="comments" class="post_comments">
		<h3>
			<?php comments_number( __('No Responses', 'invicta_dictionary'), __( '1 Comment', 'invicta_dictionary'), __('% Comments', 'invicta_dictionary')); ?>
		</h3>
		<ol class="comments_loop">
		    <?php wp_list_comments('type=comment&callback=invicta_comments_list'); ?>
		</ol>
		<div class="comments_nav">
		    <div class="prev accentcolor-text-on_children">
		    	<?php previous_comments_link( '<i class="icon-long-arrow-left"></i> ' . __('Older Comments', 'invicta_dictionary') ); ?>
		    </div>
		    <div class="next accentcolor-text-on_children">
		    	<?php next_comments_link( __('Newer Comments', 'invicta_dictionary') . ' <i class="icon-long-arrow-right"></i>' ) ?>
		    	
		    </div>
	    </div>
	</section>
<?php else : // there are no comments ?>

	<?php if (comments_open()) : // Comments are open, but there are no comments yet.?>
	
	<?php else : // Comments are closed ?>
		
		<p class="commentsClosed">
			<?php //_e('Comments are closed.', 'invicta_dictionary'); ?>
		</p>
		
	<?php endif; ?>
	
<?php endif; ?>



<?php 
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
// @ Pings Listing
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
?>

<?php if ( $show_pings ) : ?>
	<?php if (have_comments() && count($wp_query->comments_by_type['pings']) > 0) : // there are comments to display ?>
		<section class="post_pings">
			<h3><?php _e('Trackbacks & Pingbacks', 'invicta_dictionary'); ?></h3>
			<ol class="pings_loop text_styles">
			    <?php wp_list_comments('type=pings&callback=invicta_pings_list'); ?>
			</ol>
		</section>
	<?php endif; ?>
<?php endif; ?>



<?php 
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
// @ Comment Form
// -------------------------------------------------------------------------------------
// -------------------------------------------------------------------------------------
?>

<?php if (comments_open()) : // if comments are open, show comment form ?>

	<section id="respond_form" class="comment_form text_styles">

		<?php
			
			$commenter = wp_get_current_commenter();
			$req = get_option( 'require_name_email' );
			$aria_req = ( $req ? ' ' : '' );
					
			$author = '<p>';
			$author .= '	<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="22" tabindex="1" class="' . $aria_req . '" />';
			$author .= '	<label for="author">' . __('Name', 'invicta_dictionary') . '</label>';
			if ($req) {
				$author .= ' <span class="accentcolor-text">*</span>';	
			}
			$author .= '</p>';
			
			$email = '<p>';
			$email .= '	<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="22" tabindex="2" class="' . $aria_req . '" />';
			$email .= '	<label for="email">' . __('Mail', 'invicta_dictionary') . '</label>';
			if ($req) {
				$email .= ' <span class="accentcolor-text">*</span>';	
			}
			$email .= '</p>';
			
			$url = '<p>';
			$url .= '	<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="22" tabindex="3" class="" />';
			$url .= '	<label for="author">' . __('Website', 'invicta_dictionary') . '</label>';
			$url .= '</p>';
			
			$comment_field = '<p>';
			$comment_field .= '		<textarea name="comment" id="comment" cols="50" rows="10" tabindex="4" class=" required"></textarea>';
			$comment_field .= '</p>';
			$comment_field .= '<p>';
			$comment_field .= '	<span class="legend">';
			$comment_field .= '		<span class="legend_required"><span class="accentcolor-text">*</span>' . __('Required fields', 'invicta_dictionary') . '</span>';
			$comment_field .= '		<span class="legend_invalid accentcolor-text"><i class="icon-warning-sign"></i>' . __('Please validate the required fields', 'invicta_dictionary') . '</span>';
			$comment_field .= '	</span>';
			$comment_field .= '</p>';
					
			$comments_args = array(
			    'fields' =>  array(
			    	'author' => $author,
			    	'email' => $email,
			    	'url' => $url
			    ),
			    'comment_field' => $comment_field,
				'comment_notes_before' => '',
				'comment_notes_after' => '',
			    'title_reply' => __('Leave a Comment', 'invicta_dictionary'),
			    'title_reply_to' => __('Leave a Reply to %s', 'invicta_dictionary'),
			    'cancel_reply_link' => __('Cancel reply', 'invicta_dictionary'),
			    'label_submit' => __('Submit', 'invicta_dictionary'),
			);
			
			comment_form($comments_args);

		?>	
		
		<script type="text/javascript">
			jQuery(document).ready(function($){ 
				$("form#commentform").invicta_validate_form(); 
			});
		</script>
		
	</section>

<?php endif; // if (comments_open() ?>