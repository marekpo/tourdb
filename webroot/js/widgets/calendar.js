(function($) {
	var methods = {
		init: function(options) {
			var settings = {
			};

			return this.each(function(index, calendarElement) {
	
				var $this = $(this);

				$this.find('.title .previous a, .title .next a').click(function() {
					$(calendarElement).parent().load(this.href);
					return false;
				});

				$this.find('.slotcontainer').css({overflow: 'hidden'}).each(function() {
					var slotContainer = $(this);
					var slotScroller = slotContainer.find('.slotscroller');
					if(slotScroller.outerHeight(true) > $(this).outerHeight(true))
					{
						$(this).addClass('scrolls').addClass('scrolls')
							.before($('<div />').addClass('scrollup').click(function() {
								slotScroller.css({top: Math.min(0, parseInt(slotScroller.css('top').replace(/[^-\d\.]/g, '')) + 10) + 'px'});
							}))
							.after($('<div />').addClass('scrolldown').click(function() {
								slotScroller.css({top: Math.max(slotContainer.innerHeight() - slotScroller.outerHeight(true), parseInt(slotScroller.css('top').replace(/[^-\d\.]/g, '')) - 10) + 'px'});
							}));
					}
				});
			});
		}
	};

	$.fn.calendar = function(method) {
		if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		}
		else if(typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		}
		else {
			$.error('Method ' + method + ' does not exist on jQuery.calendar');
		}
	};
})(jQuery);