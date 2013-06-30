$('#image_modal').on('shown', function () {
	$('#image_modal').css('min-width', 300 + 'px');
	$('#image_modal').css('min-height', 300 + 'px');
	
	$('#image_modal').css('width', ($('#modal_image').width()+30) + 'px');
	$('#image_modal').css('height', ($('#modal_image').height()+100) + 'px');

	$('#image_modal').css('margin-left', '-' + ($('#image_modal').width() /2) + 'px');
	$('#image_modal').css('margin-top', '-' + ($('#image_modal').height() /2 +100) + 'px');
})