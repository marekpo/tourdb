TourDB = {};

TourDB.Tours = {
	Form: {
		switchDifficulty: function(event) {
			var activeTourTypes = [];
			
			$('#tourtypes input[type=checkbox]:checked').each(function(index, element) {
				activeTourTypes.push('.diff-' + $(this).next().text().toLowerCase());
			});

			var activeDifficulties = $('.difficulty-select > div').filter(activeTourTypes.join());

			if(activeDifficulties.length == 0) {
				$('.difficulty-select').parent().children('label').hide();
			} else {
				$('.difficulty-select').parent().children('label').show();
			}

			$('.difficulty-select > div').hide()
				.filter(function(index) { return !$(this).is(activeTourTypes.join()); })
				.find('input[type=checkbox]').attr('checked', false);
			activeDifficulties.show();
		},
		openTourCalendar: function(event) {
			var url = this.href;
			var calendar = $('#formTourCalendar');

			if(calendar.length == 0) {
				calendar = $('<div id="formTourCalendar" style="display: hidden" />').appendTo('body');
			}

			calendar.load(url, {}, function(responseText, status, request) {
				calendar.dialog({ width: 'auto', draggable: false, modal: true, resizable: false, title: event.data.title });
			});

			return false;
		}
	}
};

TourDB.Util = {
	confirmationDialog: function(event) {
		var url = this.href;
		var confirmDialogId = event.data.id;
		var confirmDialogElement = $(confirmDialogId);

		if(confirmDialogElement.length == 0) {
			confirmDialogElement = $('<div id="' + confirmDialogId + '" style="display: hidden" />').appendTo('body');
		}

		confirmDialogElement.load(url, {}, function(responseText, status, request) {
			confirmDialogElement.dialog({ width: 464, draggable: false, modal: true, resizable: false, title: event.data.title });
		});

		event.preventDefault();
	}
};