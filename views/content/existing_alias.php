<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo lang('file_manager_file_name'); ?></th>
			<th><?php echo lang('file_manager_override_file_name'); ?></th>
			<th><?php echo lang('file_manager_target_module'); ?></th>
			<th><?php echo lang('file_manager_target_table'); ?></th>
			<th><?php echo lang('file_manager_target_table_row_id'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
		<?php foreach ($alias_records as $alias_record) : ?>
			<tr>
				<td><?php echo $alias_record->file_name; ?></td>
				<td><?php echo $alias_record->override_file_name; ?></td>
				<td><?php echo $alias_record->target_module; ?></td>
				<td><?php echo $alias_record->target_model; ?></td>
				<td><?php echo $alias_record->target_model_row_id; ?></td>
			</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr>
			<td colspan="5"><?php echo lang('file_manager_alias_no_records'); ?></td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>