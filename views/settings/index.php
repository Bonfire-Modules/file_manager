<div class="admin-box">
        <h3></h3>
<pre>
        /* SETTINGS */
	// Deny access to file and file-import folders via .htaccess (Y/N per folder)
	// Use permissions
	
	/* LATER */
	// Lock files when editing
	// Allow indexing file and import folders via .htaccess (Y/N per folder)
	// path to file-extention icons
</pre>        
        <?php //echo Modules::run('datatable/widget/index'); ?>

	<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading"><?php echo lang('file_manager_settings_please_fix_errors'); ?> :</h4>
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php
if(isset($settings_record))
{
	$settings_record = (array)$settings_record;
}

if(isset($ini_get))
{
	$ini_get = (array)$ini_get;
}
echo "<h2>Max upload filesize: ".$max_filesize ." Mb ";

$id = isset($id) ? $id : '';

?>
<a href="#" class="btn btn-small btn" rel="tooltip" data-placement="right" data-original-title="<strong>Max file-size (per file)</strong><br>upload_max_filesize: <?php echo $ini_get['upload_max_filesize']; ?><br>post_max_size: <?php echo $ini_get['post_max_size']; ?><br>(To change edit php configuration, php.ini)"><i class="icon-info-sign"></i> More info</a>
<h1 style="color: red;">Not yet implemented/not working</h1>
<div class="admin-box">
    <h3><?php echo lang('file_manager_settings_title'); ?></h3>
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
                <fieldset>
                        <div class="control-group <?php echo form_error('settings_files_path') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_settings_files_path'), 'settings_files_path', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                        <input id="settings" type="text" name="settings_files_path" maxlength="255" value="<?php echo set_value('files_path', isset($settings_record['files_path']) ? $settings_record['files_path'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('settings_files_path'); ?></span>
                                </div>
                        </div>
			
			<div class="control-group <?php echo form_error('settings_file_import') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_settings_file_import'), 'settings_file_import', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="settings_file_import" name="settings_file_import">
                                            <option value="1"<?php if(isset($settings_record['file_import']) && $settings_record['file_import'] == 1) echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($settings_record['file_import']) && $settings_record['file_import'] == 0) echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('settings_file_import'); ?></span>
                                </div>
                        </div>
			
			<div class="control-group <?php echo form_error('settings_icons') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_settings_file_import_path'), 'settings_icons', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                        <input id="settings" type="text" name="settings_file_import_path" maxlength="255" value="<?php echo set_value('file_import_path', isset($settings_record['file_import_path']) ? $settings_record['file_import_path'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('settings_file_import_path'); ?></span>
                                </div>
                        </div>
			
			<div class="control-group <?php echo form_error('settings_icons') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_settings_icons'), 'settings_file_import', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="settings_file_import" name="settings_icons>
                                            <option value="1"<?php if(isset($settings_record['icons']) && $settings_record['icons'] == 1) echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($settings_record['icons']) && $settings_record['icons'] == 0) echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('settings_icons'); ?></span>
                                </div>
                        </div>
			
			<div class="control-group <?php echo form_error('settings_thumbnails') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_settings_thumbnails'), 'settings_file_import', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="settings_file_import" name="settings_file_import">
                                            <option value="1"<?php if(isset($settings_record['file_import']) && $settings_record['file_import'] == 1) echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($settings_record['file_import']) && $settings_record['file_import'] == 0) echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('settings_file_import'); ?></span>
                                </div>
                        </div>		
                        

			<div class="form-actions">
				<br/>
				<input type="submit" name="save_settings" class="btn btn-primary" value="<?php echo lang('file_manager_save'); ?>" />

			</div>
    </fieldset>
    <?php echo form_close(); ?>

	
</div>
<script type="text/javascript">

</script>