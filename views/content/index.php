<?php 
if ($error_messages !== false) : ?>
	<?php foreach($error_messages as $message) : ?>
		<div class="alert alert-block alert<?php echo $message['message_type']; ?> fade in ">
			<a class="close" data-dismiss="alert">&times;</a>
			<p><?php echo $message['message']; ?></p>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

	<div class="admin-box">
	<h3><?php echo lang('file_manager_file_browser'); ?></h3>

	<?php echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions, true, true, true, 'file_manager_files_model', 'callback_unlink_files', 'Content', false, 'id', 'ID'); ?>
</div>