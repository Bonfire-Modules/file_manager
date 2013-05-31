<div class="admin-box">
        <h3><? echo lang('file_manager');?> - FTP Uppladdning</h3>

        <?php //echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions); ?>
	<?php 
	// icons -> https://github.com/teambox/Free-file-icons
	// dropbox api -> https://code.google.com/p/dropbox-php/wiki/Dropbox_API
	// use import folder in dropbox
	

	echo $handle = opendir(realpath(FCPATH).'/../application/modules/file_manager/ftp-upload//');
	if ($handle) {
		echo "Directory handle: $handle\n";
		echo "Entries:\n<br />\n<br />\n";

		/* This is the correct way to loop over the directory. */
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				echo "$entry\n<br />\n";
			}
		}
		closedir($handle);
	}
	?>
	<hr>
	<input type="checkbox" name="option1" value="test_value" checked> Radera uppladdade filer från 'ftp-upload'-katalog, efter att de lagts till
	<br />
	<br />
	<a href="#" class="btn btn-success"><i class="icon-ok icon-white">&nbsp;</i>&nbsp;Lägg till alla filer</a> <a class="btn btn-danger"><i class="icon-trash icon-white">&nbsp;</i>&nbsp;Radera alla filer</a>
</div>