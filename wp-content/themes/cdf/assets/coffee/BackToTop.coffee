#
# ScrollToTop
#

class ScrollToTop

  constructor: () ->
    @window = jQuery window
    @document = jQuery "body"
    @btn = jQuery ".scroll-to-top"
    @btn_hidden_class  = "scroll-to-top--hidden"
    @distance = 100
    @speed = 400
    @dreamsClass = "post-type-archive-dreams"

    # if we're on the Dreams archive, let's increase
    # the distance a bit
    if jQuery("body").hasClass @dreamsClass
      @distance = 800

    # run on scroll (looks for debounce and includes a failsafe if debounce isn't present)
    if typeof jQuery.throttle is 'function'
      jQuery(window).scroll jQuery.throttle 100, @scroll_check
    else
      jQuery(window).scroll @scroll_check

    # bind the scroll_click to a button
    @btn.on "click", @scroll_click

    # check the button status on page load
    @initial_check()
    

  initial_check : (e) =>
    # check to see if we are at the top on page 
    # load/reload or if they are scrolled down
    if jQuery(window).scrollTop() > 0 and @btn.hasClass @btn_hidden_class
      @btn.removeClass @btn_hidden_class
    else
      @btn.addClass @btn_hidden_class

  scroll_check : (e) =>
    if jQuery(window).scrollTop() > @distance
      @btn.removeClass @btn_hidden_class
    else
      @btn.addClass @btn_hidden_class

  scroll_click : (e) =>
    @document.animate { scrollTop: 0 }, @speed

new ScrollToTop
