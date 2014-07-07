<ul class="nav nav-pills">
        <li <?php echo $this->uri->segment(4) == '' ? 'class="active"' : '' ?>>
		
		<a href="<?php echo site_url(SITE_AREA .'/content/file_manager') ?>" id="list"><i class="icon-file"></i> <?php echo lang('file_manager_toolbar_title_index'); ?></a>
	</li>

        <li <?php echo $this->uri->segment(4) == 'list_aliases' ? 'class="active"' : '' ?>>
		<a href="<?php echo site_url(SITE_AREA .'/content/file_manager/list_aliases') ?>" id="list"><i class="icon-list"></i> <?php echo lang('file_manager_toolbar_title_alias'); ?></a>
	</li>

        <?php if ($this->auth->has_permission('File_manager.Content.Create')) : ?>
                <li <?php echo $this->uri->segment(4) == 'create' ? 'class="active"' : '' ?> >
                        <a href="<?php echo site_url(SITE_AREA .'/content/file_manager/create') ?>" id="create_new"><i class="icon-upload"></i> <?php echo lang('file_manager_toolbar_title_upload'); ?></a>
                </li>
	<?php endif; ?>
	<?php if ($this->auth->has_permission('File_manager.Content.Import')) : ?>
                <li <?php echo $this->uri->segment(4) == 'import' ? 'class="active"' : '' ?> >
                        <a href="<?php echo site_url(SITE_AREA .'/content/file_manager/import') ?>" id="create_new"><i class="icon-check"></i> <?php echo lang('file_manager_toolbar_title_import'); ?></a>
                </li>
	<?php endif; ?>
</ul>
