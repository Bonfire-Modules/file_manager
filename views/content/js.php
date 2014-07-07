// jQuery plugin: Chained selects
(function($)
{
	var current_target_model = 'dummy_value';
	$.fn.chained = function(parent_selector, options, target_model)
	{ 
		if(current_target_model == target_model)
		{
			return;
		}
		
		current_target_model = target_model;
		
		return this.each(function()
		{
			var self   = this;
			var backup = $(self).clone();
			
			$(parent_selector).each(function()
			{
				$(this).bind("change", function()
				{
					$(self).html(backup.html());
					var selected = "";
					$(parent_selector).each(function()
					{
						selected += "\\" + $(":selected", this).val();
					});

					selected = selected.substr(1);
					var first = $(parent_selector).first();
					var selected_first = $(":selected", first).val();

					$("option", self).each(function()
					{
						if (!$(this).hasClass(selected) && !$(this).hasClass(selected_first) && $(this).val() !== "")
						{
							$(this).remove();
						}                        
					});

					if (1 == $("option", self).size() && $(self).val() === "")
					{
						$(self).attr("disabled", "disabled");
					}
					else
					{
						$(self).removeAttr("disabled");
					}

					$(self).trigger("change");
				});

				if ( !$("option:selected", this).length )
				{
					$("option", this).first().attr("selected", "selected");
				}

				$(this).trigger("change");             
			});
		});
	};
})(jQuery);

// Custom jQuery ajax function for updating chained selects with dynamic value
function model_row_id_ajax_update()
{
	var previous_value;

	module = $('#alias_target_module').find('option:selected').val();
	model = $('#alias_target_model').find('option:selected').val();
	if(model == '') return;

	$.get(
		'<?php echo site_url(SITE_AREA . '/content/file_manager/get_alias_target_model_row_id_data'); ?>',
		{
			module: module,
			model: model
		},
		function(responseText)
		{
			$('#alias_target_model_row_id').find('option').remove();

			$('#alias_target_model_row_id')
				    .append($("<option></option>")
				    .attr("value", '')
				    .text('None selected'));

			$.each(responseText, function(key, value) {   
				$('#alias_target_model_row_id')
				    .append($("<option></option>")
				    .attr("value", key)
				    .attr("class", model)
				    .text(value));
			});
		},
		'json'
	).always(function()
	{
		$('#alias_target_model_row_id').chained('#alias_target_model', null, $('#alias_target_model').val());
		
		if($('.target_model_row_id'))
		{
			$('#alias_target_model_row_id option[value=' + $('.target_model_row_id').attr('id') + ']').attr('selected', 'selected');
		}
	});
}

// Initiate chained selects
if($('#alias_target_model'))
{
	$('#alias_target_model').chained('#alias_target_module');
	$('#alias_target_model_row_id').chained('#alias_target_model', null, 'start');

	$('#alias_target_model').change(function()
	{
		model_row_id_ajax_update();
	});

	<?php if(isset($call_model_row_id_ajax) && ($call_model_row_id_ajax === true)) : ?>
		(function ()
		{
			model_row_id_ajax_update();
		})();
	<?php endif; ?>
}

// Initiate modal window for displaying image files
if($('#image_modal'))
{
	$('#image_modal').on('shown', function () {
		$('#image_modal').css('min-width', 300 + 'px');
		$('#image_modal').css('min-height', 300 + 'px');

		$('#image_modal').css('width', ($('#modal_image').width()+30) + 'px');
		$('#image_modal').css('height', ($('#modal_image').height()+100) + 'px');

		$('#image_modal').css('margin-left', '-' + ($('#image_modal').width() /2) + 'px');
		$('#image_modal').css('margin-top', '-' + ($('#image_modal').height() /2 +100) + 'px');
	})
}

// Initiate tabs for content/edit view
if($('#myTab'))
{
	$(document).ready(function() {
		$('#myTab a[href="<?php echo (isset($active_tab)) ? $active_tab : '#edit_file'; ?>"]').tab('show');

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
}