
<p><?php echo anchor(SITE_AREA . '/content/file_manager/create', 'Go to upload form'); ?></p>
<p><?php echo anchor(SITE_AREA . '/content/file_manager', 'Go to File manager'); ?></p>


<?php if (validation_errors()) : ?>
        <div class="alert alert-block alert-error fade in ">
                <a class="close" data-dismiss="alert">&times;</a>
                <h4 class="alert-heading">Please fix the following errors :</h4>
                <?php echo validation_errors(); ?>
        </div>
<?php endif; ?>

<?php
if(isset($upload_data))
{
        $upload_information['id'] = $upload_data['database_row_id'];
        $upload_information['upload_data'] = json_encode($upload_data);
}
elseif(isset($_POST['save']))
{
        $upload_information = $_POST;
        $upload_data = json_decode($upload_information['upload_data'], true);
}

$id = isset($upload_information['id']) ? $upload_information['id'] : '';
?>

<ul>
	<?php foreach ($upload_data as $item => $value):?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
	<?php endforeach; ?>
</ul>


<div class="admin-box">
        <h3>Add information to file <?php echo $upload_information['id']; ?></h3>
        
        <?php echo form_open(SITE_AREA .'/content/file_manager/add_upload_information/' . $upload_information['id'], 'class="form-horizontal"'); ?>
        <input type="hidden" name="id" value="<?php echo set_value('id', isset($upload_information['id']) ? $upload_information['id'] : ''); ?>" />
        <input type="hidden" name="upload_data" value="<?php echo set_value('upload_data', isset($upload_information['upload_data']) ? $upload_information['upload_data'] : ''); ?>" />

        <fieldset>
                <div class="control-group <?php echo form_error('file_name') ? 'error' : ''; ?>">
                        <?php echo form_label('File name', 'file_name', array('class' => "control-label") ); ?>
                        <div class='controls'>
                                <input id="file_name" type="text" name="file_name" maxlength="255" value="<?php echo set_value('file_name', isset($upload_information['file_name']) ? $upload_information['file_name'] : ''); ?>"  />
                                <span class="help-inline"><?php echo form_error('file_name'); ?></span>
                        </div>
                </div>
                <div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
                        <?php echo form_label('Description', 'description', array('class' => "control-label") ); ?>
                        <div class='controls'>
                               <input id="description" type="text" name="description" maxlength="255" value="<?php echo set_value('description', isset($upload_information['description']) ? $upload_information['description'] : ''); ?>"  />
                                <span class="help-inline"><?php echo form_error('description'); ?></span>
                        </div>
                </div>
                <div class="control-group <?php echo form_error('tags') ? 'error' : ''; ?>">
                        <?php echo form_label('Tags', 'tags', array('class' => "control-label") ); ?>
                        <div class='controls'>
                               <input id="tags" type="text" name="tags" maxlength="255" value="<?php echo set_value('tags', isset($upload_information['tags']) ? $upload_information['tags'] : ''); ?>"  />
                                <span class="help-inline"><?php echo form_error('tags'); ?></span>
                        </div>
                </div>
                <div class="control-group <?php echo form_error('public') ? 'error' : ''; ?>">
                        <?php echo form_label('Public', 'public', array('class' => "control-label") ); ?>
                        <div class='controls'>
                               <input id="public" type="text" name="public" maxlength="1" value="<?php echo set_value('public', isset($upload_information['public']) ? $upload_information['public'] : ''); ?>"  />
                                <span class="help-inline"><?php echo form_error('public'); ?></span>
                        </div>
                </div>

                <div class="form-actions">
                        <br/>
                        <input type="submit" name="save" class="btn btn-primary" value="Save information" />
                        or <?php echo anchor(SITE_AREA .'/content/file_manager', lang('file_manager_cancel'), 'class="btn btn-warning"'); ?>
                </div>
        </fieldset>
        <?php echo form_close(); ?>
</div>
