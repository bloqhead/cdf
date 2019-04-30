(function() {
  var bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.DreamsIsotope = (function() {
    function DreamsIsotope() {
      this.clear_filters = bind(this.clear_filters, this);
      this.isotope_item_filtering = bind(this.isotope_item_filtering, this);
      this.render_masonry = bind(this.render_masonry, this);
      this.items = jQuery('.dreams-teaser-masonry');
      this.container = jQuery('body.post-type-archive-dreams .site-content');
      this.item = jQuery('.teaser-dreams');
      this.divisor = 3;
      this.filterui = jQuery('.dream-filters__actions');
      this.clear_filter = jQuery('.dream-filters__clear');
      if (this.filterui.length) {
        jQuery('.dream-filters__actions a:not(.dream-filters__clear)').on('click', (function(_this) {
          return function(e) {
            _this.cat = jQuery(e.target).data('dream-type');
            jQuery('.dream-filters__actions a:not(.dream-filters__clear)').removeClass('is-active');
            jQuery(e.target).addClass('is-active');
            _this.isotope_item_filtering();
            _this.clear_filter.addClass('is-needed');
            return false;
          };
        })(this));
        this.clear_filter.on('click', (function(_this) {
          return function(e) {
            _this.clear_filter.removeClass('is-needed');
            jQuery('.dream-filters__actions a:not(.dream-filters__clear)').removeClass('is-active');
            _this.clear_filters();
            return false;
          };
        })(this));
      }
      if (this.items.length) {
        jQuery(window).load(this.render_masonry());
        jQuery(window).resize(this.render_masonry());
      }
    }

    DreamsIsotope.prototype.render_masonry = function() {
      return this.items.imagesLoaded((function(_this) {
        return function() {
          return _this.items.isotope(function() {
            return {
              itemSelector: _this.item,
              layoutMode: 'masonry',
              resizable: false,
              masonry: {
                columnWidth: _this.container.width() / _this.divisor
              }
            };
          });
        };
      })(this));
    };

    DreamsIsotope.prototype.isotope_item_filtering = function(e) {
      if (this.cat) {
        this.match = this.container.find('article[data-filter-post-cat*=' + this.cat + ']');
        console.log(this.match.length);
      } else {
        this.match = this.container.find('article');
        console.log(this.match.length);
      }
      if (this.items.length) {
        return this.items.isotope({
          filter: this.match
        });
      }
    };

    DreamsIsotope.prototype.clear_filters = function(e) {
      if (this.items.length) {
        return this.items.isotope({
          filter: '*'
        });
      }
    };

    return DreamsIsotope;

  })();

  new DreamsIsotope;

}).call(this);
