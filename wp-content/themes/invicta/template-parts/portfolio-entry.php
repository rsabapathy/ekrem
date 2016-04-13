<?php 

	global $smof_data;
	global $invicta_portfolio_metadata_type;
	global $invicta_portfolio_linking_type;
	
	$project_info = invicta_get_portfolio_entry_details( false, false, $invicta_portfolio_linking_type, $invicta_portfolio_metadata_type );
		
?>
<article id="project-<?php the_ID(); ?>" <?php post_class('entry' . $project_info['category_slugs']); ?>>

	<a href="<?php echo $project_info['link'] ?>" class="project_thumbnail invicta_hover_effect">
		<span class="element">
			<?php echo $project_info['thumbnail']; ?>
		</span>
		<span class="mask">
			<span class="caption">
				<span class="title">
					<?php if ( $invicta_portfolio_linking_type == 2 ) : ?>
					<i class="icon-zoom-in"></i>
					<?php else : ?>
					<i class="icon-link"></i>
					<?php endif; ?>
				</span>
			</span>
		</span>
	</a>
	
	<div class="meta">
		<div class="title">
			<?php echo $project_info['title']; ?>
		</div>
		<?php if ( $project_info['metadata'] ) : ?>
		<div class="description">
			<span><?php echo $project_info['metadata']; ?></span>
		</div>
		<?php endif; ?>
	</div>

</article>