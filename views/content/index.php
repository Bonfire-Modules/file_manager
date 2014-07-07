<?php 
if ($error_messages !== false) : ?>
	<?php foreach($error_messages as $message) : ?>
		<div class="alert alert-block alert<?php echo $message['message_type']; ?> fade in ">
			<a class="close" data-dismiss="alert">&times;</a>
			<p><?php echo $message['message']; ?></p>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<!--<pre>-->
<?php

//var_dump($datatableData);

?>
<!--</pre>-->

<?php

$num_columns	= 8;
$can_delete	= $this->auth->has_permission('File_Manager.Content.Delete');
$can_edit	= $this->auth->has_permission('File_Manager.Content.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

?>


<div class="admin-box">
	<h3><?php echo lang('file_manager_admin_box_title_index'); ?></h3>

	<?php //echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions, true, true, true, 'file_manager_files_model', 'callback_unlink_files', 'Content', false, 'id', 'ID', false); ?>

<!--	<select name="delete_has_aliases" id="delete_has_aliases" style="position: relative; top: -36px; left: 180px;">
		<option value="1">Don't delete files with aliases</option>
		<option value="0">Delete files and aliases</option>
	</select>-->
	
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class="table table-striped">
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class="column-check"><input class="check-all" type="checkbox" /></th>
					<?php endif;?>
					
					<th><?php echo lang('file_manager_table_field_file_name'); ?></th>
					<th><?php echo lang('file_manager_table_field_thumbnail'); ?></th>
					<th><?php echo lang('file_manager_table_field_description'); ?></th>
					<th><?php echo lang('file_manager_table_field_tags'); ?></th>
					<th><?php echo lang('file_manager_table_field_public'); ?></th>
					<th><?php echo lang('file_manager_table_field_extension'); ?></th>
					<th><?php echo lang('file_manager_table_field_sha1_checksum'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">
						<?php echo lang('bf_with_selected'); ?>
						<input type="submit" name="delete" id="delete-me" class="btn btn-danger" value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('file_manager_testing_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class="column-check"><input type="checkbox" name="checked[]" value="<?php echo $record->id; ?>" /></td>
					<?php endif;?>
					
				<?php if ($can_edit) : ?>
					<td><?php echo anchor(SITE_AREA . '/content/file_manager/edit/' . $record->id, '<span class="icon-pencil"></span>' .  $record->file_name); ?></td>
				<?php else : ?>
					<td><?php e($record->file_name); ?></td>
				<?php endif; ?>
					<td><?php echo $record->thumbnail; ?></td>
					<td><?php e($record->description) ?></td>
					<td><?php e($record->tags) ?></td>
					<td><?php e($record->public) ?></td>
					<td><?php echo $record->extension; ?></td>
					<td><?php echo $record->sha1_checksum; ?></td>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan="<?php echo $num_columns; ?>">No records found that match your selection.</td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php echo form_close(); ?>
	
</div>