<div class="admin-box">
        <h3><? echo lang('file_manager');?> - Import files</h3>
        <?php echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions); ?>
	<?php 
	// dropbox api -> https://code.google.com/p/dropbox-php/wiki/Dropbox_API
	// use import folder in dropbox
	?>
	<hr>
	<input type="checkbox" name="option1" value="test_value" checked> Radera uppladdade filer från 'file-import'-katalog, efter att de lagts till
	<br />
	<br />
	<a href="#" class="btn btn-success"><i class="icon-ok icon-white">&nbsp;</i>&nbsp;Importera markerade filer</a> <a class="btn btn-danger"><i class="icon-trash icon-white">&nbsp;</i>&nbsp;Radera alla filer</a>
</div>