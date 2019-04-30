(function() {
  var bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.ScrollTrigger = (function() {
    function ScrollTrigger() {
      this.scroll_change = bind(this.scroll_change, this);
      this.window = jQuery(window);
      this.document = jQuery("html");
      this.scrolled_class = "scrolled";
      this.distance = 750;
      this.breakpoint = 1025;
      if (this.window.width() >= this.breakpoint) {
        this.scroll_change();
        if (typeof jQuery.throttle === 'function') {
          this.window.scroll(jQuery.throttle(100, this.scroll_change));
        } else {
          this.window.scroll(this.scroll_change);
        }
      }
    }

    ScrollTrigger.prototype.scroll_change = function(e) {
      this.window_top = this.window.scrollTop();
      if (this.window_top >= this.distance) {
        return this.document.addClass(this.scrolled_class);
      } else if (this.window_top <= 0) {
        return this.document.removeClass(this.scrolled_class);
      } else {
        return false;
      }
    };

    return ScrollTrigger;

  })();

  new ScrollTrigger;

}).call(this);
