<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading">Please fix the following errors :</h4>

		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>
<?php
if(isset($file_manager_alias))
{
	$file_manager_alias = (array)$file_manager_alias;
}
$id = isset($file_manager_alias['id']) ? $file_manager_alias['id'] : '';
?>

<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
<fieldset>
	<div class="control-group <?php echo form_error('file_manager_alias_name') ? 'error' : ''; ?>">
		<?php echo form_label('Override file name', 'file_manager_alias_override_file_name', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="file_manager_alias_override_file_name" type="text" name="file_manager_alias_override_file_name" maxlength="255" value="<?php echo set_value('file_manager_alias_override_file_name', isset($file_manager_alias['file_manager_alias_override_file_name']) ? $file_manager_alias['file_manager_alias_name'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('file_manager_alias_override_file_name'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('file_manager_alias_description') ? 'error' : ''; ?>">
		<?php echo form_label('Description', 'file_manager_alias_description', array('class' => "control-label") ); ?>
		<div class='controls'>
			<?php echo form_textarea( array( 'name' => 'file_manager_alias_description', 'id' => 'file_manager_alias_description', 'rows' => '5', 'cols' => '80', 'value' => set_value('file_manager_alias_description', isset($file_manager_alias['file_manager_alias_description']) ? $file_manager_alias['file_manager_alias_description'] : '') ) )?>
			<span class="help-inline"><?php echo form_error('file_manager_alias_description'); ?></span>
		</div>
	</div>
	
	<div class="control-group <?php echo form_error('file_manager_alias_tags') ? 'error' : ''; ?>">
		<?php echo form_label('Tags', 'file_manager_alias_tags', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="file_manager_alias_tags" type="text" name="file_manager_alias_tags" maxlength="255" value="<?php echo set_value('file_manager_alias_tags', isset($file_manager_alias['file_manager_alias_tags']) ? $file_manager_alias['file_manager_alias_tags'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('file_manager_alias_tags'); ?></span>
		</div>
	</div>
	
	<div class="control-group <?php echo form_error('file_manager_alias_public') ? 'error' : ''; ?>">
		<?php echo form_label('Public ' . lang('bf_form_label_required'), 'file_manager_alias_public', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="file_manager_alias_public" name="file_manager_alias_public">
				<option value="0" <?php (isset($file_manager_alias['file_manager_alias_public']) ? ' selected' : ''); ?>>No</option>
				<option value="1">Yes</option>
			</select>

			<span class="help-inline"><?php echo form_error('file_manager_alias_public'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('file_manager_alias_target_module') ? 'error' : ''; ?>">
		<?php echo form_label('Target module ' . lang('bf_form_label_required'), 'file_manager_alias_target_module', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="file_manager_alias_target_module" name="file_manager_alias_target_module">
			<option value=''>None selected</option>

				<?php foreach($module_models as $module_name => $module) : ?>
					<?php $display_module_name = ucfirst(preg_replace('/_/', ' ', $module_name)); ?>
					<option value="<?php echo $module_name; ?>"><?php echo $display_module_name; ?></option>
				<?php endforeach; ?>
			</select>
			<span class="help-inline"><?php echo form_error('file_manager_alias_target_module'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('file_manager_alias_target_model') ? 'error' : ''; ?>">
		<?php echo form_label('Target model', 'file_manager_alias_target_model', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="file_manager_alias_target_model" name="file_manager_alias_target_model">
				<option value=''>None selected</option>
				<?php foreach($module_models as $module_name => $module) : ?>
					<?php if(!is_array($module['models'])): ?>
						<option value=''>Missing models</option>
					<?php elseif(is_array($module['models']) && count($module['models']) > 1) : ?>
						<?php foreach($module['models'] as $model) : ?>
							<option value='<?php echo $model; ?>' class='<?php echo $module_name; ?>'><?php echo substr(ucfirst(preg_replace('/_/', ' ', $model)), 0, -4); ?></option>
						<?php endforeach; ?>
					<?php else : ?>
						<option value='<?php echo substr($module['models'][0], 0, -4); ?>' class='<?php echo $module_name; ?>'><?php echo substr(ucfirst(preg_replace('/_/', ' ', $module['models'][0])), 0, -4); ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
			<span class="help-inline"><?php echo form_error('file_manager_alias_target_model'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('file_manager_alias_target_table_row_id') ? 'error' : ''; ?>">
		<?php echo form_label('Target table row id', 'file_manager_alias_target_table_row_id', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="file_manager_alias_target_table_row_id" type="text" name="file_manager_alias_target_table_row_id" maxlength="255" value="<?php echo set_value('file_manager_alias_target_table_row_id', isset($file_manager_alias['file_manager_alias_target_table_row_id']) ? $file_manager_alias['file_manager_alias_target_table_row_id'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('file_manager_alias_target_table_row_id'); ?></span>
		</div>
	</div>

	<div class="form-actions">
		<br/><input type="submit" name="save" class="btn btn-primary" value="Create File Manager-Test" />
		or <?php echo anchor(SITE_AREA .'/content/file_manager', lang('file_manager_alias_cancel'), 'class="btn btn-warning"'); ?>
	</div>
</fieldset>
<?php echo form_close(); ?>