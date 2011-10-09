(function($) {
	var methods = {
		init: function(options) {
			var settings = {
				collapsed: false
			};

			return this.each(function(index, fieldsetElement) {
				if(options) {
					$.extend(settings, options);
				}

				var $this = $(this);

				$this.addClass('collapsible').addClass((settings.collapsed ? 'collapsed' : 'expanded'));

				$('legend', this).click(function() {
					if($this.hasClass('collapsed')) {
						$this.removeClass('collapsed').addClass('expanded');
					}
					else if($this.hasClass('expanded')) {
						$this.removeClass('expanded').addClass('collapsed');
					}
				});
			});
		}
	};

	$.fn.collapsibleFieldset = function(method) {
		if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if(typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error('Method ' + method + ' does not exist on jQuery.collapsibleFieldset');
		}
	};
})(jQuery);