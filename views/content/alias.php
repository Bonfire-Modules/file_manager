<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>

<table class="table table-striped">
	<thead>
		<tr>
			<th class="column-check"><input class="check-all" type="checkbox" /></th>
			<th><?php echo lang('file_manager_table_field_file_name'); ?></th>
			<th><?php echo lang('file_manager_table_field_description'); ?></th>
			<th><?php echo lang('file_manager_table_field_tags'); ?></th>
			<th><?php echo lang('file_manager_table_field_alias_target_module'); ?></th>
			<th><?php echo lang('file_manager_table_field_alias_target_model'); ?></th>
			<th><?php echo lang('file_manager_table_field_alias_target_model_row_id'); ?></th>
		</tr>
	</thead>
	<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
	<tfoot>
		<tr>
			<td colspan="7">
				<?php echo lang('bf_with_selected') ?>
				<input type="submit" name="delete_alias" class="btn btn-danger" id="delete-me" value="<?php echo lang('bf_action_delete') ?>" onclick="return confirm('<?php echo lang('file_manager_alias_delete_confirm'); ?>')">
			</td>
		</tr>
	</tfoot>
	<?php endif; ?>

	<tbody>
	<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
		<?php foreach ($alias_records as $alias_record) : ?>
			<tr>
				<td><input type="checkbox" name="checked[]" value="<?php echo $alias_record->id ?>" /></td>
				<td><?php echo '<a href="' . site_url(SITE_AREA .'/content/file_manager/alias_edit/' . $alias_record->file_id . '/' . $alias_record->id) . '">' . $alias_record->file_name . '</a>'; ?></td>
				<td><?php echo $alias_record->description; ?></td>
				<td><?php echo $alias_record->tags; ?></td>
				<td><?php echo $alias_record->target_module; ?></td>
				<td><?php echo $alias_record->target_model; ?></td>
				<td><?php echo $alias_record->target_model_row_id; ?></td>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="7"><?php echo lang('file_manager_alias_no_records'); ?></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>

<?php echo form_close(); ?>