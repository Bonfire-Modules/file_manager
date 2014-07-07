<?php if($display_header) : ?>
	<div class="admin-box">
		<h3>Available files for <?php if(isset($target_module)) echo $target_module; ?></h3>
<?php endif; ?>

<table class="table table-striped">
	<thead>
		<tr>
			<th>File name</th>
			<th>Description</th>
			<th>Tags</th>
			<th>Target model</th>
			<th>Target model row id</th>
		</tr>
	</thead>
	<tbody>
		<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
			<?php foreach ($alias_records as $alias_record) : ?>
				<tr>
					<td><?php echo $alias_record->file_name; ?></td>
					<td><?php echo $alias_record->description; ?></td>
					<td><?php echo $alias_record->tags; ?></td>
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

<?php if($display_header) : ?>
	</div>
<?php endif; ?>