<div class="admin-box">
        <h3><? echo lang('file_manager');?> - <? echo lang('file_manager_import_files');?></h3>
        <?php echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions); ?>
	<?php 
	// dropbox api -> https://code.google.com/p/dropbox-php/wiki/Dropbox_API
	// use import folder in dropbox
	?>
	<hr>
	<input type="checkbox" name="option1" value="test_value" checked> <? echo lang('file_manager_import_delete_after_upload');?>
	<br />
	<br />
	<a href="#" class="btn btn-success"><i class="icon-ok icon-white">&nbsp;</i>&nbsp;<? echo lang('file_manager_import_selected_files');?></a> <a class="btn btn-danger"><i class="icon-trash icon-white">&nbsp;</i>&nbsp;<? echo lang('file_manager_import_empty_folder');?></a>
</div>