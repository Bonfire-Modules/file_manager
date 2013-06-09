<?php
if(isset($file_manager_alias))
{
	$file_manager_alias = (array)$file_manager_alias;
}
$id = isset($file_manager_alias['id']) ? $file_manager_alias['id'] : '';
?>

<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal" name="alias_create_form"'); ?>
<fieldset>
	<div class="control-group <?php echo form_error('alias_override_file_name') ? 'error' : ''; ?>">
		<?php echo form_label('Override file name', 'alias_override_file_name', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="alias_override_file_name" type="text" name="alias_override_file_name" maxlength="255" value="<?php echo set_value('alias_override_file_name', isset($file_manager_alias['alias_override_file_name']) ? $file_manager_alias['alias_override_file_name'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('alias_override_file_name'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('alias_override_description') ? 'error' : ''; ?>">
		<?php echo form_label('Override description', 'alias_override_description', array('class' => "control-label") ); ?>
		<div class='controls'>
			<textarea id="alias_override_description" name="alias_override_description" rows="5" cols="80"><?php echo set_value('alias_override_description', isset($file_manager_alias['alias_override_description']) ? $file_manager_alias['alias_override_description'] : ''); ?></textarea>
			<span class="help-inline"><?php echo form_error('alias_override_description'); ?></span>
		</div>
	</div>
	
	<div class="control-group <?php echo form_error('alias_override_tags') ? 'error' : ''; ?>">
		<?php echo form_label('Override tags', 'alias_override_tags', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="alias_override_tags" type="text" name="alias_override_tags" maxlength="255" value="<?php echo set_value('alias_override_tags', isset($file_manager_alias['alias_override_tags']) ? $file_manager_alias['alias_override_tags'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('alias_override_tags'); ?></span>
		</div>
	</div>
	
	<div class="control-group <?php echo form_error('alias_override_public') ? 'error' : ''; ?>">
		<?php echo form_label('Override public', 'alias_override_public', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="alias_override_public" name="alias_override_public">
				<option value="0" <?php (isset($file_manager_alias['alias_override_public']) ? ' selected' : ''); ?>>No</option>
				<option value="1">Yes</option>
			</select>

			<span class="help-inline"><?php echo form_error('alias_override_public'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('alias_target_module') ? 'error' : ''; ?>">
		<?php echo form_label('Target module ' . lang('bf_form_label_required'), 'alias_target_module', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="alias_target_module" name="alias_target_module">
			<option value=''>None selected</option>

				<?php foreach($module_models as $module_name => $module) : ?>
					<?php $display_module_name = ucfirst(preg_replace('/_/', ' ', $module_name)); ?>
					<option value='<?php echo $module_name; ?>'<?php if(isset($_POST['alias_target_module']) && $_POST['alias_target_module'] == $module_name) echo ' selected'; ?>><?php echo $display_module_name; ?></option>
				<?php endforeach; ?>
			</select>
			<span class="help-inline"><?php echo form_error('alias_target_module'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('alias_target_model') ? 'error' : ''; ?>">
		<?php echo form_label('Target model', 'alias_target_model', array('class' => "control-label") ); ?>
		<div class='controls'>
			<select id="alias_target_model" name="alias_target_model">
				<option value=''>None selected</option>
				<?php foreach($module_models as $module_name => $module) : ?>
					<?php foreach($module['models'] as $model) : ?>
						<option value='<?php echo $model; ?>' class='<?php echo $module_name; ?>'<?php if(isset($_POST['alias_target_model']) && $_POST['alias_target_model'] == $model) echo ' selected'; ?>><?php echo substr(ucfirst(preg_replace('/_/', ' ', $model)), 0, -4); ?></option>
					<?php endforeach; ?>
				<?php endforeach; ?>
			</select>
			<span class="help-inline"><?php echo form_error('alias_target_model'); ?></span>
		</div>
	</div>

	<div class="control-group <?php echo form_error('alias_target_model_row_id') ? 'error' : ''; ?>">
		<?php echo form_label('Target model row id', 'alias_target_model_row_id', array('class' => "control-label") ); ?>
		<div class='controls'>
			<input id="alias_target_model_row_id" type="text" name="alias_target_model_row_id" maxlength="255" value="<?php echo set_value('alias_target_model_row_id', isset($file_manager_alias['alias_target_model_row_id']) ? $file_manager_alias['alias_target_model_row_id'] : ''); ?>"  />
			<span class="help-inline"><?php echo form_error('alias_target_model_row_id'); ?></span>
		</div>
	</div>

	<div class="form-actions">
		<br/><input type="submit" name="save_alias" class="btn btn-primary" value="Create alias" />
	</div>
</fieldset>
<?php echo form_close(); ?>