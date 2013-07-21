class window.HeaderMenu

  constructor: (@ref) ->

    @logo = @ref.find '.logo'
    @dropdown_elements = @ref.find '.right-navigation .wrap-navbar .first-level >li.dropdown'

    @active_item
    @scroll_threshold = @ref.height()
    @logo_h = parseInt(@logo.css 'top') + @logo.height()
    @logo_speed = @logo_h / @ref.height()
    @small_h = window.small_header_height
    @is_small = false
    @dur = 1

    unless is_smartphone
      if @dropdown_elements.length > 0 then @setDropdownElements()

  setDropdownElements: ->

    for i in [0...@dropdown_elements.length]

      element = $ @dropdown_elements[i]
      dropdown = element.find '.wrap-dropdown-menu'

      element.attr 'data-height', dropdown.height()
      element.bind 'mouseenter', @onDropdownElementOver
      element.bind 'mouseleave', @onDropdownElementOut

      dropdown.hide()
      dropdown.css {opacity:'0', height:'0'}

      items = dropdown.find '.dropdown-menu >li >a'
      for j in [0...items.length]
        item = $ items[j]
        if @arrow_w is undefined then @arrow_w = item.find('.arrow-left').width()
        if item.hasClass 'active'
          @active_item = item
          item.bind 'click', ((e) -> e.preventDefault())
        unless item.hasClass 'active'
          item.bind 'mouseenter', @onDropdownItemOver
          item.bind 'mouseleave', @onDropdownItemOut

  onDropdownElementOver: (e) =>

    element = $ e.currentTarget
    dropdown = element.find '.wrap-dropdown-menu'
    dropdown.show()
    TweenLite.to dropdown, @dur, {css:{'opacity':'1', 'height':"#{element.attr 'data-height'}px"}, ease:Power4.easeInOut}

  onDropdownElementOut: (e) =>

    element = $ e.currentTarget
    dropdown = element.find '.wrap-dropdown-menu'
    TweenLite.to dropdown, @dur, {css:{'opacity':'0', 'height':'0'}, ease:Power4.easeInOut, onComplete:(-> dropdown.hide())}

  onDropdownItemOver: (e) =>

    item = $ e.currentTarget
    @moveItemArrows item, 1
    @moveItemArrows @active_item, -1

  onDropdownItemOut: (e) =>

    item = $ e.currentTarget
    @moveItemArrows item, -1
    @moveItemArrows @active_item, 1

  moveItemArrows: (item, dir) ->

    arrow_left = item.find '.arrow-left'
    arrow_right = item.find '.arrow-right'

    if dir > 0
      TweenLite.to arrow_left, .75 * @dur, {css:{'left':'0'}, ease:Power4.easeInOut}
      TweenLite.to arrow_right, .75 * @dur, {css:{'right':'0'}, ease:Power4.easeInOut}
    else
      TweenLite.to arrow_left, .75 * @dur, {css:{'left':"#{- @arrow_w}px"}, ease:Power4.easeInOut}
      TweenLite.to arrow_right, .75 * @dur, {css:{'right':"#{- @arrow_w}px"}, ease:Power4.easeInOut}

  onScroll: (val) =>

    unless is_mobile

      pos = Math.max(0, Math.min(val, @scroll_threshold))

      @logo.css {'margin-top':"#{- @logo_speed * pos}px"}

      if pos >= @scroll_threshold and !@is_small
        @is_small = true
        @ref.addClass 'header-small'
        @ref.css {top:"#{- @small_h}px"}
        TweenLite.to @ref, @dur, {css:{'top':'0'}, ease:Power4.easeInOut}
      else if pos < @scroll_threshold and @is_small
        @is_small = false
        TweenLite.to @ref, .5 * @dur, {css:{'top':"#{- @small_h}px"}, ease:Power4.easeIn, onComplete:(=> 
          @ref.removeClass 'header-small'
          @ref.css {top:"#{- @logo_h}px"}
          TweenLite.to @ref, .75 * @dur, {css:{'top':'0'}, ease:Power4.easeOut}
        )}
