"use strict";

jQuery(document).ready(function($) {
    //--ADMIN
	$('#btnUpdateCompany').click(function() {
		$('#frmCompany').submit();
    });

    $('#businessTypeSearch').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_company_type',
					nonce: ajax_var.nonce,
					name: request.term
				},
				success: function(data) {
					response(data);
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			$('#businessTypeSearch').val(ui.item.value);
			$('#businessId').val(ui.item.id);
			return false;
		}
    });
    
    $('#businessTypeSearch').on('keydown', function(event) {
        if (13 == event.which) {
            var txt = $('#businessTypeSearch').val();
            var businessId = $('#businessId').val();
            if ($.trim(txt) !== '') {
                if ($.trim(businessId) == '') {
                    businessId = txt;
                }
                $('#list-business-type').append('<a href="javascript:void(0);" class="list-group-item item-business-type">' + txt +'<input type="hidden" name="businessNames[]" value="'+ txt +'" /><input type="hidden" name="businessIds[]" value="' + businessId +'" /></a>');
                $('#businessTypeSearch').val('');
                $('#businessId').val('');
            }
        }
        return;
    });

    $('#list-business-type').on('click', 'a', function() {
        $('#list-business-type > a').removeClass('active');
        $(this).addClass('active');
        $('#businessChoised').val($(this).text());
    });
    $('#list-business-type').on('click', '.active', function() {
        //alert($(this).text());
        $(this).removeClass('active');
        $('#businessChoised').val('');
    });
});