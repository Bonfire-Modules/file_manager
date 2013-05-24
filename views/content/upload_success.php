<ul>
	<?php foreach ($upload_data as $item => $value):?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
	<?php endforeach; ?>
</ul>

<p><?php echo anchor(SITE_AREA . '/content/file_manager/create', 'Go to upload form'); ?></p>
<p><?php echo anchor(SITE_AREA . '/content/file_manager', 'Go to File manager'); ?></p>