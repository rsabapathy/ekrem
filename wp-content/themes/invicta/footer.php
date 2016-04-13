<?php 

	global $smof_data; 
	
	$show_dummy_widgets = true;
	if ( isset( $smof_data['footer-hide_dummy_widgets'] ) ) {
		$show_dummy_widgets = ! $smof_data['footer-hide_dummy_widgets'];
	}

	wp_reset_query();	

?>

				</div> <!-- .page_body -->
				
				<footer class="page_footer">
								
					<div class="widgets">
						<div class="invicta_canvas">
						
							<?php 
								$num_columns = $smof_data['footer-columns'];
								
								$default_widgets_ids = array(5,7,6);
								$default_widget_id_index = 0;
							?>
							
							<div class="section group">
							
							<?php for( $i = 1; $i <= $num_columns; $i ++ ) : ?>
								<div class="col span_1_of_<?php echo $num_columns; ?>">
									<?php 
									if ( function_exists('dynamic_sidebar') ) {
										if ( ! dynamic_sidebar( 'Footer Sidebar ' . $i ) ) { 
											
											// if there is no sidebar or widgets
											// dummy widgets will be displayed to maintain the layout
											
											if ( $show_dummy_widgets ) {
	
												invicta_manual_widget( $default_widgets_ids[ $default_widget_id_index++ ] );
												
												if ( $default_widget_id_index >= sizeof( $default_widgets_ids ) ) {
													$default_widget_id_index = 0;
												}
											
											}
											else {
												echo '&nbsp;';
											}
											
										}
									}
									?>
								</div>
							<?php endfor; ?>
							
							</div>				
					
						</div>
					</div>
					
					<?php if ( $smof_data['footer-socket'] ) : ?>
					<div class="socket accentcolor-border">
						<div class="invicta_canvas">
							<div class="copyrights">
								<?php echo $smof_data['footer-copyright']; ?>
							</div>
							<div class="navigation">
								<?php invicta_page_menu('footer_menu'); ?>
							</div>
						</div>
					</div>
					<?php endif; ?>
				
				</footer>
	
			</div> <!-- .canvas -->
		
		</div> <!-- .body_background -->
		
		<?php echo invicta_custom_javascript(); ?>
	
		<?php wp_footer(); ?>
	</body>
	
</html>