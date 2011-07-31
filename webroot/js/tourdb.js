TourDB = {};

TourDB.Tours = {
	Form: {
		switchDifficulty: function(event) {
			var activeTourTypes = [];
			
			$('#tourtypes input[type=checkbox]:checked').each(function(index, element) {
				activeTourTypes.push('.diff-' + $(this).next().text().toLowerCase());
			});

			$('.difficulty-select > div').hide()
				.filter(activeTourTypes.join()).show()
				.end().filter(function(index) { return !$(this).is(activeTourTypes.join()); })
					.find('input[type=checkbox]').attr('checked', false);
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