"use strict";

jQuery(document).ready(function($) {
	
	var tblNewOffer = $('#tblNewOffer').DataTable({
		"ajax": {
			"url": ajax_var.url,
			"type": 'POST',
			"dataType": 'json',
			"data": {
				"action": 'action_load_all_offer',
				"nonce": ajax_var.nonce
			},
			"dataSrc": ""
		},
		"paging": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"columns": [
			{data: 'title'},
			{data: 'place_text'},
			{data: 'level'},
			{data: 'posted_date'},
			{data: 'status_name'},
			{
				data: 'id',
				render: function(data){
				return ('<button type="button" class="btn btn-link" onclick="edit_new_offer('+ data +')">' + lang.label_edit + '</button><button type="button" class="btn btn-link" onclick="delete_new_offer('+ data +')">' + lang.label_delete + '</button>');
				}
			}
		]
	});
	
});

function edit_new_offer(id) {
	window.location.href = admin_url.url + "?page=offer_page&id=" + id;
}

function delete_new_offer(id) {
	
}