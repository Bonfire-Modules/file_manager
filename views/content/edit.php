<?php if (validation_errors()) : ?>
	<div class="alert alert-block alert-error fade in ">
		<a class="close" data-dismiss="alert">&times;</a>
		<h4 class="alert-heading"><?php echo lang('file_manager_please_fix_errors'); ?> :</h4>
		<?php echo validation_errors(); ?>
	</div>
<?php endif; ?>

<?php
if(isset($file_record)) $file_record = (array)$file_record;
$id = isset($id) ? $id : '';
?>

<?php if(in_array($file_record['extension'], array("png", "jpg", "bmp", "gif"))) : ?>
	<?php // Modal window ?>
	<div id="imageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="imageModalLabel"><?php echo lang('file_manager_showing_image_in_org_size'); ?></h3>
	</div>
	<div class="modal-body">
		<p><img src="../thumbnail/<?php echo $file_record['id']; ?>" width="300" height="300" alt="" /></p>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo lang('file_manager_close'); ?></button>
	</div>
	</div>
<?php endif; ?>

<ul class="nav nav-tabs" id="myTab">
	<li><a href="#edit_file" data-toggle="tab">Edit file</a></li>
	<li><a href="#view_alias" data-toggle="tab">View aliases</a></li>
	<li><a href="#create_alias" data-toggle="tab">Create alias</a></li>
</ul>

<div class="tab-content">
	<div class="tab-pane" id="edit_file">
		<div class="admin-box">
			<h3><?php echo lang('file_manager_edit_header'); ?></h3>

			<?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
				<fieldset>

					<?php if(in_array($file_record['extension'], array("png", "jpg", "bmp", "gif"))) : ?>
						<div class="control-group">
							<?php echo form_label('Thumbnail', '', array('class' => "control-label") ); ?>
							<div class='controls'>
								<a href="#imageModal" role="button" data-toggle="modal">
									<img src="../thumbnail/<?php echo $file_record['id']; ?>" style="background-color: #FFFFFF;" width="128" height="128" alt="" />
								</a>
							</div>
						</div>
					<?php endif; ?>

					<div class="control-group <?php echo form_error('file_name') ? 'error' : ''; ?>">
						<?php echo form_label(lang('file_manager_file_name'), 'file_name', array('class' => "control-label") ); ?>
						<div class='controls'>
							<input id="file_name" type="text" name="file_name" maxlength="255" value="<?php echo set_value('file_name', isset($file_record['file_name']) ? $file_record['file_name'] : ''); ?>"  />
							<span class="help-inline"><?php echo form_error('file_name'); ?></span>
						</div>
					</div>
					<div class="control-group <?php echo form_error('description') ? 'error' : ''; ?>">
						<?php echo form_label(lang('file_manager_description'), 'description', array('class' => "control-label") ); ?>
						<div class='controls'>
							<textarea id="description" name="description"><?php echo set_value('description', isset($file_record['description']) ? $file_record['description'] : ''); ?></textarea>
							<span class="help-inline"><?php echo form_error('description'); ?></span>
						</div>
					</div>
					<div class="control-group <?php echo form_error('tags') ? 'error' : ''; ?>">
						<?php echo form_label(lang('file_manager_tags'), 'tags', array('class' => "control-label") ); ?>
						<div class='controls'>
							<input id="tags" type="text" name="tags" maxlength="255" value="<?php echo set_value('tags', isset($file_record['tags']) ? $file_record['tags'] : ''); ?>"  />
							<span class="help-inline"><?php echo form_error('tags'); ?></span>
						</div>
					</div>
					<div class="control-group <?php echo form_error('public') ? 'error' : ''; ?>">
						<?php echo form_label(lang('file_manager_public'), 'public', array('class' => "control-label") ); ?>
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
						<input type="submit" name="save" class="btn btn-primary" value="<?php echo lang('file_manager_save'); ?>" />
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
	</div>

	<div class="tab-pane" id="view_alias">
		<div class="admin-box">
			<h3><?php echo lang('file_manager_alias'); ?></h3>

			<?php Template::block('alias', 'content/alias', array('alias_records' => $alias_records, 'from_tabs' => true)); ?>
		</div>
	</div>

	<div class="tab-pane" id="create_alias">
		<div class="admin-box">
			<h3><?php echo lang('file_manager_create_alias'); ?></h3>

			<?php Template::block('create_alias', 'content/create_alias'); ?>
		</div>
	</div>
</div>