<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field">
	<select name="<?php echo $field['id']; ?>" id="<?php echo $field['id']; ?>">
	<?php foreach ( $field['options'] as $key => $value ) : ?>
		<option <?php selected( $current_value, $key ) ?>' value="<?php echo $key; ?>"><?php echo $value; ?></option>
	<?php endforeach; ?>
	</select>
</p>
