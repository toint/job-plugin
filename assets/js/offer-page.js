"use strict";

jQuery(document).ready(function($) {
    $('#map-viet-nam').vectorMap({
		map: 'vietnam',
		regionsSelectable: true,
		regionsSelectableOne: true,
		
		
		regionStyle: {
			initial: {
				fill: "white"
			},
			selected: {
				fill: "red"
		  }
		},
		onRegionClick: function (e, code) {
			var map = $('#map-viet-nam').vectorMap('get', 'mapObject');
			$('#placeCode').val(code);
			$('#placeName').val(map.getRegionName(code));
			$('#vector-map-modal').dialog('close');
		},
		onRegionTipShow: function (e, el, code) {
			
		}
	});

	var left,top;
	$('#map-viet-nam').vectorMap('get', 'mapObject').container.mousemove(function(e){
		left = e.pageX - 40;
		top = e.pageY - 60;
	});

	$('#vector-map-modal').dialog({
		autoOpen: false,
		width: 350,
		height: 500,
		buttons: [{
			text: 'Close',
			click: function() {
				$(this).dialog('close');
			}
		}]
	});

	$('#btnPlace').click(function() {
		$('#vector-map-modal').dialog('open');
	});
	
	$('#salary').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_salary',
					nonce: ajax_var.nonce,
					name: request.term
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			return true;
		}
	});
	
	$('#jobType').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_job_type',
					nonce: ajax_var.nonce,
					name: request.term
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			return true;
		}
	});
	
	$('#jobActivity').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_job_activity',
					nonce: ajax_var.nonce,
					name: request.term
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			$('#jobActivity').val(ui.item.name);
			
			return true;
		}
	});
	
	$('#jobActivity').on('keydown', function(event) {
		if (13 == event.which) {
			var txt = $('#jobActivity').val();
			if ($.trim(txt) != '') {
			
				var id = Date.now();
				var html = '<li class="list-group-item" id="list-job-activity-item-'+ id +'">';
				html += '<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group(\'list-job-activity-'+ id + '\')">';
				html += lang.label_delete;
				html += '</a></span>';
				html += txt;
				html += '<input type="hidden" name="arrJobActivityName[]" value="'+ txt +'" /></li>';
				
				$('#list-job-activity').append(html);
			}
			
			$('#jobActivity').val('');
		}
	});
	
	$('#itSkill').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_it_skill',
					name: request.term,
					nonce: ajax_var.nonce
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			$('#itSkill').val(ui.item.name);
			return true;
		}
	});
	
	$('#itSkill').on('keydown', function(event) {
		if (13 == event.which) {
			var txt = $('#itSkill').val();
			if ($.trim(txt) != '') {
			
				var id = Date.now();
				var html = '<li class="list-group-item" id="list-itSkills-item-'+ id +'">';
				html += '<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group(\'list-itSkills-item-'+ id + '\')">';
				html += lang.label_delete;
				html += '</a></span>';
				html += txt;
				html += '<input type="hidden" name="arrItSkill[]" value="'+ txt +'" /></li>';
				
				$('#list-itSkills').append(html);
			}
			
			$('#itSkill').val('');
		}
	});
	

	$('#languages').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_language',
					name: request.term,
					nonce: ajax_var.nonce
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			$('#languages').val(ui.item.name);
			return true;
		}
	});
	
	$('#languages').on('keydown', function(event) {
		if (13 == event.which) {
			var txt = $('#languages').val();
			if ($.trim(txt) != '') {
			
				var id = Date.now();
				var html = '<li class="list-group-item" id="list-languages-item-'+ id +'">';
				html += '<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group(\'list-languages-item-'+ id + '\')">';
				html += lang.label_delete;
				html += '</a></span>';
				html += txt;
				html += '<input type="hidden" name="arrLanguages[]" value="'+ txt +'" /></li>';
				
				$('#list-languages').append(html);
			}
			
			$('#languages').val('');
		}
	});
	

	$('#humanSkill').autocomplete({
		source: function(request, response) {
			$.ajax({
				url: ajax_var.url,
				method: 'POST',
				dataType: 'json',
				data: {
					action: 'autocomplete_human_skill',
					name: request.term,
					nonce: ajax_var.nonce
				},
				success: function(data) {
					response(data);
				},
				error: function(err) {
					
				}
			});
		},
		minLength: 1,
		select: function(event, ui) {
			$('#humanSkill').val(ui.item.name);
			return true;
		}
	});
	
	$('#humanSkill').on('keydown', function(event) {
		if (13 == event.which) {
			var txt = $('#humanSkill').val();
			if ($.trim(txt) != '') {
				var id = Date.now();
				var html = '<li class="list-group-item" id="list-human-skill-item-'+ id +'">';
				html += '<span class="badge"><a href="javascript:void(0);" onclick="remove_list_group(\'list-human-skill-item-'+ id + '\')">';
				html += lang.label_delete;
				html += '</a></span>';
				html += txt;
				html += '<input type="hidden" name="arrHumanSkill[]" value="'+ txt +'" /></li>';
				
				$('#list-human-skill').append(html);
			}
			
			$('#humanSkill').val('');
		}
	});
	
	$('#postDate').datepicker();
	
	$('#btnSaveDraft').on('click', function() {
		$('#frmNewOffer').submit();
	});
	
	$('#btnSave').on('click', function() {
		$('#frmNewOffer').submit();
	});
});

function remove_list_group(childId) {
	jQuery('#' + childId).remove();
}