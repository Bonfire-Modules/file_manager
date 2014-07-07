<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading"><?php echo lang('file_manager_alias_please_fix_errors'); ?> :</h4>
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php
if(isset($alias_record))
{
	$alias_record = (array)$alias_record;
	if(!isset($_POST['alias_target_module'])) $_POST['alias_target_module'] = $alias_record['target_module'];
	if(!isset($_POST['alias_target_model'])) $_POST['alias_target_model'] = $alias_record['target_model'];
}

$id = isset($id) ? $id : '';

?>


<div class="admin-box">
    <h3><?php echo lang('file_manager_alias_edit_header'); ?></h3>
    
	<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
                <fieldset>
                        <div class="control-group <?php echo form_error('alias_override_file_name') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_table_field_alias_override_file_name'), 'alias_override_file_name', array('class' => "control-label") ); ?>
                                <?php echo form_label(lang('file_manager_alias_override_file_name'), 'alias_override_file_name', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                        <input id="alias_override_file_name" type="text" name="alias_override_file_name" maxlength="255" value="<?php echo set_value('override_file_name', isset($alias_record['override_file_name']) ? $alias_record['override_file_name'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('alias_override_file_name'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('alias_override_description') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_alias_override_description'), 'alias_override_description', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <textarea id="alias_override_description" name="alias_override_description"><?php echo set_value('override_description', isset($alias_record['override_description']) ? $alias_record['override_description'] : ''); ?></textarea>
                                <span class="help-inline"><?php echo form_error('alias_override_description'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('alias_override_tags') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_alias_override_tags'), 'alias_override_tags', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <input id="alias_override_tags" type="text" name="alias_override_tags" maxlength="255" value="<?php echo set_value('override_tags', isset($alias_record['override_tags']) ? $alias_record['override_tags'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('alias_override_tags'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('alias_override_public') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_alias_override_public'), 'alias_override_public', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="alias_override_public" name="alias_override_public">
                                            <option value=""<?php if(isset($alias_record['override_public']) && $alias_record['override_public'] == "") echo " selected"; ?>><?php echo lang('file_manager_none_selected'); ?></option>
                                            <option value="1"<?php if(isset($alias_record['override_public']) && $alias_record['override_public'] == "1") echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($alias_record['override_public']) && $alias_record['override_public'] == "0") echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('alias_override_public'); ?></span>
                                </div>
                        </div>
			<div class="control-group <?php echo form_error('alias_target_module') ? 'error' : ''; ?>">
				<?php echo form_label(lang('file_manager_alias_target_module').' ' . lang('bf_form_label_required'), 'alias_target_module', array('class' => "control-label") ); ?>
				<div class='controls'>
					<select id="alias_target_module" name="alias_target_module">
					<option value=''><?php echo lang('file_manager_none_selected'); ?></option>

						<?php foreach($module_models as $module_name => $module) : ?>
							<?php $display_module_name = ucfirst(preg_replace('/_/', ' ', $module_name)); ?>
							<option value='<?php echo $module_name; ?>'<?php if(isset($_POST['alias_target_module']) && $_POST['alias_target_module'] == $module_name) echo ' selected'; ?>><?php echo $display_module_name; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="help-inline"><?php echo form_error('alias_target_module'); ?></span>
				</div>
			</div>

			<div class="control-group <?php echo form_error('alias_target_model') ? 'error' : ''; ?>">
				<?php echo form_label(lang('file_manager_alias_target_model'), 'alias_target_model', array('class' => "control-label") ); ?>
				<div class='controls'>
					<select id="alias_target_model" name="alias_target_model">
						<option value=''>None selected</option>
						<?php foreach($module_models as $module_name => $module) : ?>
							<?php foreach($module['models'] as $model) : ?>
								<option value='<?php echo $model; ?>' class='<?php echo $module_name; ?>'<?php if(isset($_POST['alias_target_model']) && $_POST['alias_target_model'] == $model) echo ' selected'; ?>><?php echo $model; ?></option>
							<?php endforeach; ?>
						<?php endforeach; ?>
					</select>
					<span class="help-inline"><?php echo form_error('alias_target_model'); ?></span>
				</div>
			</div>
			<div class="control-group <?php echo form_error('alias_target_model_row_id') ? 'error' : ''; ?>">
				<?php echo form_label(lang('file_manager_alias_target_model_row_id'), 'alias_target_model_row_id', array('class' => "control-label") ); ?>
				<div class='controls'>
					<select id="alias_target_model_row_id" name="alias_target_model_row_id">
						<option value=''>None selected</option>
						<?php //foreach($module_models as $module_name => $module) : ?>
							<?php //foreach($module['models'] as $model) : ?>
								<option value='asd' class='testing_model'>test</option>
							<?php //endforeach; ?>
						<?php //endforeach; ?>
					</select>
					<span class="help-inline"><?php echo form_error('alias_target_model_row_id'); ?></span>
				</div>
			</div>

			<div class="form-actions">
				<br/>
				<input type="submit" name="save_alias" class="btn btn-primary" value="<?php echo lang('file_manager_save'); ?>" />
				<?php echo lang('file_manager_or'); ?> <?php echo anchor(SITE_AREA .'/content/file_manager/' . (($file_id === false) ? 'list_aliases' : ('edit/' . $file_id)), lang('file_manager_cancel'), 'class="btn btn-warning"'); ?>
			</div>
    </fieldset>
    <?php echo form_close(); ?>
</div>

<?php
if(isset($alias_record['target_model_row_id']))
{
	echo '<div id="' . $alias_record['target_model_row_id'] . '" class="target_model_row_id">&nbsp;</div>';
}
?>
