TourDB_DragDrop = {
	addItem: function(item, name, inputName) {
		var itemId = item.attr('id').replace(/item-(.*)/, '$1');
		item.detach().appendTo($('#assoc-items-' + name));
		$('<input />').attr({
			type: 'hidden',
			name: inputName + '[]'
		}).val(itemId).appendTo($('#assoc-items-inputs-' + name));
	},

	removeItem: function(item, name) {
		var itemId = item.attr('id').replace(/item-(.*)/, '$1');
		item.detach().appendTo($('#all-items-' + name));
		$('#assoc-items-inputs-' + name).find('[value="' + itemId + '"]').remove();
	}
};