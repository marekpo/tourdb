(function($) {
	var methods = {
		init: function(options) {
			var settings = {
					startDate: null,
					endDate: null,
					url: null
			};
			
			return this.each(function() {
				if(options) {
					$.extend(settings, options);
				}

				var $this = $(this),
					data = $this.data('adjacentTours');

				if(!data) {
					settings.startDate.change(methods.valueChanged.bind(this));
					settings.endDate.change(methods.valueChanged.bind(this));

					$(this).data('adjacentTours', settings);
				}
			});
		},
		valueChanged: function() {
			var data = $(this).data('adjacentTours');

			if(data.startDate.datepicker('getDate') != null && data.endDate.datepicker('getDate') != null)
			{
				methods.updateAdjacentTours.bind(this)();
			}
		},
		updateAdjacentTours: function() {
			var data = $(this).data('adjacentTours');
			var startDate = data.startDate.datepicker('getDate');
			var endDate = data.endDate.datepicker('getDate');
			var url = data.url + '/' + $.datepicker.formatDate('yy-mm-dd', startDate) + '/' + $.datepicker.formatDate('yy-mm-dd', endDate);

			$.ajax(url, {
				success: methods.ajaxSuccess.bind(this)
			});
		},
		ajaxSuccess: function(data, status, jqXHR) {
			$(this).html(data);
		}
	};

	$.fn.adjacentTours = function(method) {
		if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if(typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error('Method ' + method + ' does not exist on jQuery.adjacentTours');
		}
	};
})(jQuery);