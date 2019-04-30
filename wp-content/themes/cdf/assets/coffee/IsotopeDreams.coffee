#
# Dreams Type Isotope and filters
# 
# Filter functionality for the Dreams page.
# Allows the user to filter dreams by a custom taxonomy.
#

# console.clear()

class window.DreamsIsotope

  constructor: () ->
    @items = jQuery('.dreams-teaser-masonry')
    @container = jQuery('body.post-type-archive-dreams .site-content')
    @item = jQuery('.teaser-dreams')
    @divisor = 3
    @filterui = jQuery('.dream-filters__actions')
    @clear_filter = jQuery('.dream-filters__clear')

    if @filterui.length
      # Trigger the filter
      jQuery('.dream-filters__actions a:not(.dream-filters__clear)').on 'click', (e) =>
        @cat = jQuery(e.target).data 'dream-type'
        jQuery('.dream-filters__actions a:not(.dream-filters__clear)').removeClass 'is-active'
        jQuery(e.target).addClass 'is-active'
        @isotope_item_filtering()
        @clear_filter.addClass 'is-needed'
        return false

      # Clear the applied filter
      @clear_filter.on 'click', (e) =>
        @clear_filter.removeClass 'is-needed'
        jQuery('.dream-filters__actions a:not(.dream-filters__clear)').removeClass 'is-active'
        # Run the isotope filter reset
        @clear_filters()
        return false

    if @items.length
      # activate on load
      jQuery(window).load @render_masonry()
      # trigger if resized
      jQuery(window).resize @render_masonry()

  # the main Isotope function
  render_masonry : () =>
    @items.imagesLoaded =>
      @items.isotope =>
        itemSelector: @item
        layoutMode: 'masonry'
        resizable: false
        masonry:
          columnWidth: @container.width() / @divisor

  # Isotpe item filtering
  isotope_item_filtering : (e) =>
    if @cat
      @match = @container.find 'article[data-filter-post-cat*=' + @cat + ']'
      console.log @match.length
    else
      @match = @container.find 'article'
      console.log @match.length
    
    # Filter the isotope items
    if @items.length
      @items.isotope
        filter: @match

  # Clear the set filter
  clear_filters : (e) =>
    # Reset the filter on the isotope items
    if @items.length
      @items.isotope
        filter: '*'

new DreamsIsotope