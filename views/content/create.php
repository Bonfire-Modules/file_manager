<?php echo form_open_multipart('admin/content/file_manager/do_upload');?>
	<input type="file" name="userfile" multiple="multiple" size="20" />
	<br /><br />
	<input type="submit" value="upload" />
</form>

<p><?php echo anchor(SITE_AREA . '/content/file_manager', 'Go to File manager'); ?></p>