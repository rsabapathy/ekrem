<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field radio">
	<?php foreach ( $field['options'] as $key => $value ) : ?>
		<label>
			<input type="radio" name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>_<?php echo $value; ?>" value="<?php echo $key; ?>" <?php checked($current_value, $key); ?> />
			<?php echo $value; ?>
		</label>

	<?php endforeach; ?>
</p>
