(function($)
{
	var current_target_model = 'dummy_value';
	$.fn.chained = function(parent_selector, options, target_model)
	{ 
		if(current_target_model == target_model)
		{
			console.log('return from function');
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

$('#alias_target_model').chained('#alias_target_module');
$('#alias_target_model_row_id').chained('#alias_target_model', null, 'start');

(function () {
	var previous_value;

$('#alias_target_model').change(function()
{
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
		console.log('yeaah');
	});
});

})();