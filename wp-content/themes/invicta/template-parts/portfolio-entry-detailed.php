<?php 

	global $smof_data;
	global $invicta_settings;
	
	$context = 'project';
	$project_info = invicta_get_portfolio_entry_details( true, true, null, null );
	
?>
<article id="project-<?php the_ID(); ?>" <?php post_class('entry ' . $project_info['layout'] ); ?>>

	<?php if ( $project_info['layout'] == 'condensed') : ?>	
	
		<!-- Condensed Layout -->
		<div class="section group">
		
			<div class="project_thumbnail col span_3_of_4">
				<?php echo $project_info['thumbnail']; ?>
			</div>

			<div class="project_info col span_1_of_4">
			
				<?php if ( $project_info['content'] ) : ?>
				<div class="project_text">
		
					<div class="widget">
										
						<div class="project_description text_styles">
							<?php echo $project_info['content']; ?>
							<?php if ( is_single() ) { wp_link_pages(); } ?>
						</div>
					
					</div>
			
				</div>
				<?php endif; ?>
				
				<div class="project_meta">
			
					<div class="widget">
						
						<h3 class="widget_title"><?php _e( 'Project Details', 'invicta_dictionary' ); ?></h3>
						
						<?php if ( $smof_data['portfolio-metadata-client'] && $project_info['client'] ) : ?>
							<div class="meta">
								<label><?php _e( 'Client', 'invicta_dictionary' ); ?>: </label>
								<?php echo $project_info['client']; ?>
							</div>
						<?php endif; ?>
						
						<?php if ( $smof_data['portfolio-metadata-date'] && $project_info['date'] ) : ?>
							<div class="meta">
								<label><?php _e( 'Date', 'invicta_dictionary' ); ?>: </label>
								<?php echo $project_info['date']; ?>
							</div>
						<?php endif; ?>
						
						<?php if ( $smof_data['portfolio-metadata-categories'] && $project_info['categories'] ) : ?>
							<div class="meta">
								<label><?php _e( 'Category', 'invicta_dictionary' ); ?>: </label>
								<?php echo $project_info['categories']; ?>
							</div>
						<?php endif; ?>
						
						<?php if ( $smof_data['portfolio-metadata-price'] && $project_info['price'] ) : ?>
							<div class="meta">
								<label><?php _e( 'Price', 'invicta_dictionary' ); ?>: </label>
								<?php echo $project_info['price']; ?>
							</div>
						<?php endif; ?>
						
						<?php if ( $project_info['extra_field_value'] ) : ?>
							<div class="meta">
								<label><?php echo $project_info['extra_field_key']; ?>: </label>
								<?php echo $project_info['extra_field_value']; ?>
							</div>
						<?php endif; ?>
						
					</div>
				
					<div class="widget project_skills">
						
						<?php if ( $smof_data['portfolio-metadata-skills'] && $project_info['skills'] ) : ?>
						
						<h3 class="widget_title"><?php _e( 'Project Skills', 'invicta_dictionary' ); ?></h3>
						
						<ul>
							<?php foreach ( $project_info['skills'] as $skill ) : ?>
							<li>
								<?php echo $skill->name; ?>
							</li>
							<?php endforeach; ?>
						</ul>
						
						<?php endif; ?>
						
					</div>
				
					<?php if ( $project_info['social'] ) : ?>
					<div class="widget project_sharer">
						<h3 class="widget_title"><?php _e( 'Sharing', 'invicta_dictionary' ); ?></h3>
						<?php invicta_social_share_buttons('portfolio'); ?>
					</div>
					<?php endif; ?>
					
					<?php if ( $smof_data['portfolio-metadata-launch'] && $project_info['url'] ) : ?>
					<div class="widget">
						<?php 
							$button_shortcode = '[invicta_button';
							$button_shortcode .= ' label="' . __( 'Launch Project', 'invicta_dictionary' ) . '"';
							$button_shortcode .= ' url="' . esc_url( $project_info['url'] ) . '"';
							$button_shortcode .= ' target="_blank"';
							$button_shortcode .= ']';
							echo do_shortcode( $button_shortcode ); 
						?>
					</div>
					<?php endif; ?>
			
				</div> <!-- .project_meta -->
				
				<div class="alignclear"></div>
			
			</div>
		
		</div>
	
	<?php else : ?>
	
		<!-- Extended Layout -->
		<div>

			<div class="project_thumbnail">
				<?php echo $project_info['thumbnail']; ?>
			</div>
			
			<div class="project_info">
			
				<div class="section group">
			
					<div class="project_text col span_3_of_4">
			
						<h2 class="project_title">
							<?php _e( 'Project Description', 'invicta_dictionary' ); ?>
						</h2>
					
						<div class="project_description text_styles">
							<?php echo $project_info['content']; ?>
							<?php if ( is_single() ) { wp_link_pages(); } ?>
						</div>
				
					</div>
					
					<div class="project_meta col span_1_of_4">
				
						<div class="widget">
							
							<h3 class="widget_title"><?php _e( 'Project Details', 'invicta_dictionary' ); ?></h3>
							
							<?php if ( $smof_data['portfolio-metadata-client'] && $project_info['client'] ) : ?>
								<div class="meta">
									<label><?php _e( 'Client', 'invicta_dictionary' ); ?>: </label>
									<?php echo $project_info['client']; ?>
								</div>
							<?php endif; ?>
							
							<?php if ( $smof_data['portfolio-metadata-date'] && $project_info['date'] ) : ?>
								<div class="meta">
									<label><?php _e( 'Date', 'invicta_dictionary' ); ?>: </label>
									<?php echo $project_info['date']; ?>
								</div>
							<?php endif; ?>
							
							<?php if ( $smof_data['portfolio-metadata-categories'] && $project_info['categories'] ) : ?>
								<div class="meta">
									<label><?php _e( 'Category', 'invicta_dictionary' ); ?>: </label>
									<?php echo $project_info['categories']; ?>
								</div>
							<?php endif; ?>
							
							<?php if ( $smof_data['portfolio-metadata-price'] && $project_info['price'] ) : ?>
								<div class="meta">
									<label><?php _e( 'Price', 'invicta_dictionary' ); ?>: </label>
									<?php echo $project_info['price']; ?>
								</div>
							<?php endif; ?>
							
							<?php if ( $project_info['extra_field_value'] ) : ?>
								<div class="meta">
									<label><?php echo $project_info['extra_field_key']; ?>: </label>
									<?php echo $project_info['extra_field_value']; ?>
								</div>
							<?php endif; ?>
							
						</div>
					
						<div class="widget project_skills">
							
							<?php if ( $smof_data['portfolio-metadata-skills'] && $project_info['skills'] ) : ?>
							
							<h3 class="widget_title"><?php _e( 'Project Skills', 'invicta_dictionary' ); ?></h3>
							
							<ul>
								<?php foreach ( $project_info['skills'] as $skill ) : ?>
								<li>
									<?php echo $skill->name; ?>
								</li>
								<?php endforeach; ?>
							</ul>
							
							<?php endif; ?>
							
						</div>
					
						<?php if ( $project_info['social'] ) : ?>
						<div class="widget project_sharer">
							<h3 class="widget_title"><?php _e( 'Sharing', 'invicta_dictionary' ); ?></h3>
							<?php invicta_social_share_buttons('portfolio'); ?>
						</div>
						<?php endif; ?>
						
						<?php if ( $smof_data['portfolio-metadata-launch'] && $project_info['url'] ) : ?>
						<div class="widget">
							<?php 
								$button_shortcode = '[invicta_button';
								$button_shortcode .= ' label="' . __( 'Launch Project', 'invicta_dictionary' ) . '"';
								$button_shortcode .= ' url="' . esc_url( $project_info['url'] ) . '"';
								$button_shortcode .= ' target="_blank"';
								$button_shortcode .= ']';
								echo do_shortcode( $button_shortcode ); 
							?>
						</div>
						<?php endif; ?>
				
					</div> <!-- .project_meta -->
				
				</div>
				
				<div class="alignclear"></div>
			
			</div>
		
		</div>
	
	<?php endif; ?>
	
	<?php
	if ( $smof_data['portfolio-project_navigation'] ) {
		invicta_post_pagination(); 
	}
	?>

</article>