$(document).ready(function() {
	$('#myTab a[href="<?php echo $active_tab; ?>"]').tab('show');

	// Remember active tab if user refreshes the page, using a db entry in settings
	var active_tab;
	$('#myTab').click(function(edit_tabs)
	{
		// Indirect call to get_active_tab model function, sets active_tab setting
		$.get(
			'<?php echo site_url(SITE_AREA . '/content/file_manager/get_active_tab'); ?>',
			{
				active_tab: edit_tabs.target.hash
			},
			'data'
		);
	});
});