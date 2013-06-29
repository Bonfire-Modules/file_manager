<div class="admin-box">
	<h3><?php echo lang('file_manager_file_browser'); ?></h3>

	<?php echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions, true, true, true, 'file_manager_files_model', 'callback_unlink_files', 'Content', false, 'id', 'ID'); ?>
</div>