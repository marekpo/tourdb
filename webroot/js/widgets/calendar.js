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
					if(slotScroller.outerHeight(true) > slotContainer.outerHeight(true))
					{
						slotContainer.before($('<div />').addClass('scrollbar').slider({
							orientation: 'vertical',
							value: 100,
							change: function(event, widget) {
								var maxScroll = slotContainer.prop('scrollHeight') - slotContainer.height();
								slotContainer.prop({scrollTop: Math.abs(widget.value - 100) * (maxScroll / 100) }, 1000);
							},
							slide: function(event, widget) {
								var maxScroll = slotContainer.prop('scrollHeight') - slotContainer.height();
								slotContainer.prop({scrollTop: Math.abs(widget.value - 100) * (maxScroll / 100) });
							}
						}));
					}
				});

				$this.find('.appointment').mouseover(function() {
					$this.find('.' + $(this).attr('class').replace(/.*(appointment[0-9a-z\-]{36}).*/i, '$1')).addClass('highlight');
				}).mouseout(function() {
					$this.find('.appointment').removeClass('highlight');
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