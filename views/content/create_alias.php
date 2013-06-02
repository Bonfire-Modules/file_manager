<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading">Please fix the following errors :</h4>

		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>
<?php
if(isset($file_manager_test))
{
	$file_manager_test = (array)$file_manager_test;
}
$id = isset($file_manager_test['id']) ? $file_manager_test['id'] : '';
?>

<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
<fieldset>
	<div class="control-group <?php echo form_error('file_manager_test_name') ? 'error' : ''; ?>">
		<?php echo form_label('Name'. lang('bf_form_label_required'), 'file_manager_test_name', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="file_manager_test_name" type="text" name="file_manager_test_name" maxlength="255" value="<?php echo set_value('file_manager_test_name', isset($file_manager_test['file_manager_test_name']) ? $file_manager_test['file_manager_test_name'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('file_manager_test_name'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('file_manager_test_description') ? 'error' : ''; ?>">
		<?php echo form_label('Description', 'file_manager_test_description', array('class' => "control-label") ); ?>
		<div class='controls'>
			<?php echo form_textarea( array( 'name' => 'file_manager_test_description', 'id' => 'file_manager_test_description', 'rows' => '5', 'cols' => '80', 'value' => set_value('file_manager_test_description', isset($file_manager_test['file_manager_test_description']) ? $file_manager_test['file_manager_test_description'] : '') ) )?>
			<span class="help-inline"><?php echo form_error('file_manager_test_description'); ?></span>
		</div>
	</div>
	
	<b>Continue here, add inputs for tags, override_name, targets etc.</b>
	<br /><br /><br /><br /><br />


	<div class="form-actions">
		<br/><input type="submit" name="save" class="btn btn-primary" value="Create File Manager-Test" />
		or <?php echo anchor(SITE_AREA .'/content/file_manager_test', lang('file_manager_test_cancel'), 'class="btn btn-warning"'); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>