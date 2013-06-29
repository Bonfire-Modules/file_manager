<?php if (validation_errors()) : ?>
        <div class="alert alert-block alert-error fade in ">
                <a class="close" data-dismiss="alert">&times;</a>
                <h4 class="alert-heading"><?php echo lang('file_manager_please_fix_errors'); ?></h4>
                <?php echo validation_errors(); ?>
        </div>
<?php endif; ?>

<?php Template::block('file_exists'); ?>

<?php
if(isset($file_data))
{
	$add_upload_information = array(
		'file_name'		=> $file_data['file_name'],
		'description'		=> $file_data['description'],
		'tags'			=> $file_data['tags'],
		'public'		=> $file_data['public'],
		'id'			=> $file_data['database_row_id'],
		'file_data_array'	=> json_encode($file_data_array)
	);
}
elseif(isset($_POST['save']))
{
        $add_upload_information = $_POST;
        $file_data_array = json_decode($add_upload_information['file_data_array'], true);
}

$id = isset($add_upload_information['id']) ? $add_upload_information['id'] : '';

?>

<div class="row" style="margin: 0px;">
	<div class="span5" style="width: 530px; margin: 0px;">
		<div class="admin-box">
			<h3><?php echo lang('file_manager_file_information'); ?></h3>

			<table class="table table-striped">
				<thead>
					<tr>
						<th><?php echo lang('file_manager_property'); ?></th>
						<th><?php echo lang('file_manager_value'); ?></th>
					</tr>
				</thead>
				<tbody>
						<?php //foreach($display_values as $name => $value_index): ?>
						<tr>
							<td><?php //echo $name; ?></td>
							<td><?php //echo $file_data[$value_index]; ?></td>
						</tr>
						<?php //endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

        <div class="span7" style="margin: 0px;">
        <div class="admin-box" style="margin-right: 0px;">
                <h3><?php echo lang('file_manager_add_information_to_file'); ?> <?php echo $add_upload_information['id']; ?></h3>

                <?php echo form_open(SITE_AREA .'/content/file_manager/add_upload_information/' . $add_upload_information['id'], 'class="form-horizontal"'); ?>
                <input type="hidden" name="id" value="<?php echo set_value('id', isset($add_upload_information['id']) ? $add_upload_information['id'] : ''); ?>" />
                <input type="hidden" name="db_current_file_id" value="<?php echo set_value('db_current_file_id', isset($add_upload_information['db_current_file_id']) ? $add_upload_information['db_current_file_id'] : ''); ?>" />
                <input type='hidden' name='file_data_array' value='<?php echo set_value("file_data_array", isset($add_upload_information["file_data_array"]) ? $add_upload_information["file_data_array"] : ""); ?>' />

                <fieldset>
                        <div class="control-group <?php echo form_error('file_name') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_file_name'), 'file_name', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                        <input id="file_name" type="text" name="file_name" maxlength="255" value="<?php echo set_value('file_name', isset($add_upload_information['file_name']) ? $add_upload_information['file_name'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('file_name'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_description'), 'description', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <textarea id="description" name="description"><?php echo set_value('description', isset($add_upload_information['description']) ? $add_upload_information['description'] : ''); ?></textarea>
                                <span class="help-inline"><?php echo form_error('description'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('tags') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_tags'), 'tags', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                       <input id="tags" type="text" name="tags" maxlength="255" value="<?php echo set_value('tags', isset($add_upload_information['tags']) ? $add_upload_information['tags'] : ''); ?>"  />
                                        <span class="help-inline"><?php echo form_error('tags'); ?></span>
                                </div>
                        </div>
                        <div class="control-group <?php echo form_error('public') ? 'error' : ''; ?>">
                                <?php echo form_label(lang('file_manager_public'), 'public', array('class' => "control-label") ); ?>
                                <div class='controls'>
                                    <select id="public" name="public">
                                            <option value="1"<?php if(isset($add_upload_information['public']) && $add_upload_information['public'] == 1) echo " selected"; ?>><?php echo lang('file_manager_yes'); ?></option>
                                            <option value="0"<?php if(isset($add_upload_information['public']) && $add_upload_information['public'] == 0) echo " selected"; ?>><?php echo lang('file_manager_no'); ?></option>
                                    </select>
                                        <span class="help-inline"><?php echo form_error('public'); ?></span>
                                </div>
                        </div>

                        <div class="form-actions">
                                <br/>
                                <input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('file_manager_save_information'); ?>" />
                                <?php echo lang('file_manager_or'); ?> <?php echo anchor(SITE_AREA .'/content/file_manager', lang('file_manager_cancel'), 'class="btn btn-warning"'); ?>
                        </div>
                </fieldset>
                <?php echo form_close(); ?>
                </div>
        </div>
</div>
