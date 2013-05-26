<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading">Please fix the following errors :</h4>
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php
if(isset($file_record))
{
	$file_record = (array)$file_record;
}
$id = isset($id) ? $id : '';
?>


<div class="admin-box">
    <h3>File Manager Edit view</h3>
    
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
                <fieldset>
                        <div class="control-group <?php echo form_error('file_name') ? 'error' : ''; ?>">
                                <?php echo form_label('File name', 'file_name', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                        <input id="file_name" type="text" name="file_name" maxlength="255" value="<?php echo set_value('file_name', isset($file_record['file_name']) ? $file_record['file_name'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('file_name'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
                                <?php echo form_label('Description', 'description', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <textarea id="description" name="description"><?php echo set_value('description', isset($file_record['description']) ? $file_record['description'] : ''); ?></textarea>
                                <span class="help-inline"><?php echo form_error('description'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('tags') ? 'error' : ''; ?>">
                                <?php echo form_label('Tags', 'tags', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <input id="tags" type="text" name="tags" maxlength="255" value="<?php echo set_value('tags', isset($file_record['tags']) ? $file_record['tags'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('tags'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('public') ? 'error' : ''; ?>">
                                <?php echo form_label('Public', 'public', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="public" name="public">
                                            <option value="1"<?php if(isset($file_record['public']) && $file_record['public'] == 1) echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($file_record['public']) && $file_record['public'] == 0) echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('public'); ?></span>
                                </div>
                        </div>

			<div class="form-actions">
				<br/>
				<input type="submit" name="save" class="btn btn-primary" value="Edit File" />
				or <?php echo anchor(SITE_AREA .'/content/file_manager', lang('file_manager_cancel'), 'class="btn btn-warning"'); ?>

				<?php if ($this->auth->has_permission('File_Manager.Content.Delete')) : ?>
					or <button type="submit" name="delete" class="btn btn-danger" id="delete-me" onclick="return confirm('<?php echo lang('file_manager_file_delete_confirm'); ?>')">
					<i class="icon-trash icon-white">&nbsp;</i>&nbsp;<?php echo lang('file_manager_file_delete_record'); ?>
					</button>
				<?php endif; ?>
			</div>
    </fieldset>
    <?php echo form_close(); ?>

</div>

<?php Template::block('existing_alias', 'content/existing_alias', array('alias_records' => $alias_records)); ?>

<div class="admin-box">
	<h3>Create alias</h3>
	
</div>