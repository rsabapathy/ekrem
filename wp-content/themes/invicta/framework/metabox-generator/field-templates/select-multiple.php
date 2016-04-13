<?php $current_value = explode(',', $current_value); ?>
<?php if ( isset( $field['description'] ) && ! empty( $field['description'] ) ) : ?>
	<cite><?php echo $field['description']; ?></cite>
<?php endif; ?>
<p class="field">
	<select name="<?php echo $field['id']; ?>[]" id="<?php echo $field['id']; ?>"  multiple="multiple">
	<?php foreach ( $field['options'] as $key => $value ) : ?>
		<option <?php selected( true, in_array( $key, $current_value )) ?>' value="<?php echo $key; ?>"><?php echo $value; ?></option>
	<?php endforeach; ?>
	</select>
</p>
