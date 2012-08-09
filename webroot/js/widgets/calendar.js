(function($) {
	var methods = {
		init: function(options) {

			if(options == undefined) {
				options = {};
			}

			options.ajax = options.ajax == undefined ? true : options.ajax;

			console.log(options);

			return this.each(function(index, calendarElement) {
	
				var $this = $(this);

				if(options.ajax) {
					$this.find('.title .previous a, .title .next a').click(function() {
						$(calendarElement).parent().load(this.href);
						return false;
					});
				}

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
								slotContainer.prop({scrollTop: Math.abs(widget.value - 100) * (maxScroll / 100) });
							},
							slide: function(event, widget) {
								var maxScroll = slotContainer.prop('scrollHeight') - slotContainer.height();
								slotContainer.prop({scrollTop: Math.abs(widget.value - 100) * (maxScroll / 100) });
							}
						}));
					}
				});

				$this.find('.event').mouseover(function() {
					var appointmentId = $(this).attr('class').replace(/.*event([0-9a-z\-]{36}).*/i, '$1');
					$this.find('.event' + appointmentId).addClass('highlight');

					var popup = $('body .popup' + appointmentId);

					if(popup.length == 0)
					{
						popup = $('.popup', this).detach()
							.addClass('popup' + appointmentId)
							.addClass('ui-widget-content')
							.appendTo('body');
					}

					var offset = {
						top: $(this).offset().top + 20,
						left: $(this).offset().left + ($(this).width() / 2 - popup.width() / 2)
					};

					if(offset.top + popup.height() > window.innerHeight)
					{
						offset.top = $(this).offset().top - 13 - popup.height();
					}

					popup.css({display: 'block'}).offset(offset);
				}).mouseout(function() {
					$this.find('.event').removeClass('highlight');
					$('.popup').css({display: 'none'});
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