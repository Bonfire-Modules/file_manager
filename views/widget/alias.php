<?php if($display_header) : ?>
	<div class="admin-box">
		<h3>Available files for <?php if(isset($module_name)) echo $module_name; ?><?php echo (1) ? ', table row id: ' . 1 : ''; ?></h3>
<?php endif; ?>

<table class="table table-striped">
	<thead>
		<tr>
			<?php if ($this->auth->has_permission('File_Manager_test.Content.Delete') && isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
				<th class="column-check"><input class="check-all" type="checkbox" /></th>
			<?php endif; ?>

			<th>File name</th>
			<th>Description</th>
			<th>Tags</th>

			<?php if(1) : ?>
				<th>Target model</th>
				<th>Target model row id</th>
			<?php endif; ?>
		</tr>
	</thead>
	
	<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
		<tfoot>
			<?php if ($this->auth->has_permission('File_Manager_test.Content.Delete')) : ?>
				<tr>
					<td colspan="7">
						<?php echo lang('bf_with_selected') ?>
						<!--<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php //echo lang('bf_action_delete') ?>" onclick="return confirm('<?php //echo lang('file_manager_test_delete_confirm'); ?>')">-->
						(unlink only) (unlink and delete)
					</td>
				</tr>
			<?php endif;?>
		</tfoot>
	<?php endif; ?>

	<tbody>
		<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
			<?php foreach ($alias_records as $alias_record) : ?>
				<tr>
					<?php if ($this->auth->has_permission('File_Manager_test.Content.Delete')) : ?>
						<td><input type="checkbox" name="checked[]" value="<?php echo $alias_record->id ?>" /></td>
					<?php endif;?>

					<?php if ($this->auth->has_permission('file_manager.Content.Download')) : ?>
						<td><a target="_blank" href="<?php echo site_url(SITE_AREA .'/widget/file_manager/download/' . $alias_record->id); ?>"><?php echo (empty($alias_record->override_file_name)) ? $alias_record->file_name : $alias_record->override_file_name; ?></td>
					<?php else: ?>
						<td><?php echo (empty($alias_record->override_file_name)) ? $alias_record->file_name : $alias_record->override_file_name; ?></td>
					<?php endif; ?>

					<td><?php echo $alias_record->description; ?></td>
					<td><?php echo $alias_record->tags; ?></td>

					<?php if(1) : ?>
						<td><?php echo $alias_record->target_model; ?></td>
						<td><?php echo $alias_record->target_model_row_id; ?></td>
					<?php endif; ?>
				</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="7">No records found that match your selection.</td>
			</tr>
		<?php endif; ?>
	</tbody>
</table>

<?php if($display_header) : ?>
	</div>
<?php endif; ?>