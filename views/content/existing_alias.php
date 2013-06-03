<table class="table table-striped">
	<thead>
		<tr>
			<th>File name</th>
			<th>Override file name</th>
			<th>Target module</th>
			<th>Target table</th>
			<th>Target table row id</th>
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
			<td colspan="5">No records found that match your selection.</td>
		</tr>
	<?php endif; ?>
	</tbody>
</table>