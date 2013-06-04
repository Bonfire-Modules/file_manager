(function($) {
    $.fn.chained = function(parent_selector, options) { 
        return this.each(function() {
            var self   = this;
            var backup = $(self).clone();
            $(parent_selector).each(function() {
                $(this).bind("change", function() {
                    $(self).html(backup.html());
                    var selected = "";
                    $(parent_selector).each(function() {
                        selected += "\\" + $(":selected", this).val();
                    });
                    selected = selected.substr(1);
                    var first = $(parent_selector).first();
                    var selected_first = $(":selected", first).val();
                    $("option", self).each(function() {
                        if (!$(this).hasClass(selected) && 
                            !$(this).hasClass(selected_first) && $(this).val() !== "") {
                                $(this).remove();
                        }                        
                    });
                    if (1 == $("option", self).size() && $(self).val() === "") {
                        $(self).attr("disabled", "disabled");
                    } else {
                        $(self).removeAttr("disabled");
                    }
                    $(self).trigger("change");
                });
                if ( !$("option:selected", this).length ) {
                    $("option", this).first().attr("selected", "selected");
                }
                $(this).trigger("change");             
            });
        });
    };
})(jQuery);

$('#alias_target_model').chained('#alias_target_module');