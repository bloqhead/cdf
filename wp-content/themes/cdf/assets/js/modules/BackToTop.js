(function() {
  var ScrollToTop,
    bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  ScrollToTop = (function() {
    function ScrollToTop() {
      this.scroll_click = bind(this.scroll_click, this);
      this.scroll_check = bind(this.scroll_check, this);
      this.initial_check = bind(this.initial_check, this);
      this.window = jQuery(window);
      this.document = jQuery("body");
      this.btn = jQuery(".scroll-to-top");
      this.btn_hidden_class = "scroll-to-top--hidden";
      this.distance = 100;
      this.speed = 400;
      this.dreamsClass = "post-type-archive-dreams";
      if (jQuery("body").hasClass(this.dreamsClass)) {
        this.distance = 800;
      }
      if (typeof jQuery.throttle === 'function') {
        jQuery(window).scroll(jQuery.throttle(100, this.scroll_check));
      } else {
        jQuery(window).scroll(this.scroll_check);
      }
      this.btn.on("click", this.scroll_click);
      this.initial_check();
    }

    ScrollToTop.prototype.initial_check = function(e) {
      if (jQuery(window).scrollTop() > 0 && this.btn.hasClass(this.btn_hidden_class)) {
        return this.btn.removeClass(this.btn_hidden_class);
      } else {
        return this.btn.addClass(this.btn_hidden_class);
      }
    };

    ScrollToTop.prototype.scroll_check = function(e) {
      if (jQuery(window).scrollTop() > this.distance) {
        return this.btn.removeClass(this.btn_hidden_class);
      } else {
        return this.btn.addClass(this.btn_hidden_class);
      }
    };

    ScrollToTop.prototype.scroll_click = function(e) {
      return this.document.animate({
        scrollTop: 0
      }, this.speed);
    };

    return ScrollToTop;

  })();

  new ScrollToTop;

}).call(this);
