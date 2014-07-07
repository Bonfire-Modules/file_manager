<div class="admin-box">
	<h3>Complete alias list</h3>

        <?php echo Modules::run('datatable/widget/display', $datatableData, $datatableOptions, true, true, true, 'file_manager_alias_model', null, null, false, 'id', null); ?>
</div>