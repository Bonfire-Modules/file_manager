<?php echo form_open_multipart('admin/content/Bonfire-Filemanager/do_upload');?>
	<input type="file" name="userfile" multiple="multiple" size="20" />
	<br /><br />
	<input type="submit" value="upload" />
</form>

<p><?php echo anchor(SITE_AREA . '/content/Bonfire-Filemanager', 'Go to File manager'); ?></p>