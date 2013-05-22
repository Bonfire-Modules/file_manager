<ul>
	<?php foreach ($upload_data as $item => $value):?>
		<li><?php echo $item;?>: <?php echo $value;?></li>
	<?php endforeach; ?>
</ul>

<p><?php echo anchor(SITE_AREA . '/content/upload/create', 'Go to upload form'); ?></p>
<p><?php echo anchor(SITE_AREA . '/content/upload', 'Go to File manager'); ?></p>