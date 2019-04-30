#
# ScrollTrigger
#
# Adds a class to the body so that you can
# trigger things on scroll.
#
# Example: `html.scrolled #navigation`
#

class window.ScrollTrigger

	constructor: () ->
		@window = jQuery window
		@document = jQuery "html"
		@scrolled_class = "scrolled"
		@distance = 750 # the px distance at which the fixed menu is triggered
		@breakpoint = 1025 # the width above which this should function

		# we only want this to work if the user isn't on
		# a small screen, like a tablet or a phone
		if @window.width() >= @breakpoint
			# run on load
			@scroll_change()

			# run on scroll
			if typeof jQuery.throttle is 'function'
				@window.scroll jQuery.throttle( 100, @scroll_change )
			else
				@window.scroll @scroll_change

	scroll_change : (e) =>
		@window_top = @window.scrollTop()
		if @window_top >= @distance
			@document.addClass @scrolled_class
		else if @window_top <= 0
			@document.removeClass @scrolled_class
		else
			return false

new ScrollTrigger
