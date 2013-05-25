<div class="admin-box">
        <h3>Available files for <?php echo $module_name; ?></h3>
	
	<table class="table table-striped">
                    <thead>
				<tr>
					<?php if ($this->auth->has_permission('File_Manager_test.Content.Delete') && isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th>ID</th>
					<th>File name</th>
					<th>Description</th>
					<th>Tags</th>
					<th>Related to table row</th>
				</tr>
			</thead>
			<?php if (isset($alias_records) && is_array($alias_records) && count($alias_records)) : ?>
			<tfoot>
				<?php if ($this->auth->has_permission('File_Manager_test.Content.Delete')) : ?>
				<tr>
					<td colspan="3">
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
					
					<td><?php echo $alias_record->id; ?></td>
        				<?php if ($this->auth->has_permission('file_manager.Content.Download')) : ?>
						<td>
                                                    <a target="_blank" href="<?php echo site_url(SITE_AREA .'/widget/file_manager/download/' . $alias_record->id); ?>"><?php echo $alias_record->file_name; ?></td>
					<?php else: ?>
                				<td><?php echo $alias_record->file_name; ?></td>
					<?php endif; ?>

					<td><?php echo $alias_record->description; ?></td>
					<td><?php echo $alias_record->tags; ?></td>
					<td><?php echo $alias_record->target_table_row_id; ?></td>
				</tr>
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td colspan="3">No records found that match your selection.</td>
				</tr>
			<?php endif; ?>
			</tbody>
		</table>
	
	
</div>

<!--
<pre><p>Test variables from <i>Modules::run('file_manager/widget/alias', $data);</i></p>-->
	<?php/*
	if(isset($test)) var_dump($test);
	if(isset($test2)) var_dump($test2);
	if(isset($test3)) var_dump($test3);
	*/?>
<!--</pre>-->