class window.VerticalFixedMenu

  constructor: (@ref) ->

    @w = $ 'window'

    @buttons = @ref.find '.js-vertical-fixed-menu-items >li >a'
    @sections_container = $ '.js-vertical-fixed-menu-sections'
    @sections = @sections_container.find '>div'

    @top = @ref.css 'top'
    @threshold = @sections_container.height() - @ref.height()

    @current_id = ''

    if is_mobile
      @ref.addClass 'no-fixed'
      @ref.css {top: '0px'}
      @ref.find('nav.shop-nav').css {visibility:'hidden'}

    @setInteractions()

  ########
  # SCROLL
  ########

  onScroll: (val) =>

    unless is_mobile
      if val > @threshold
        unless @ref.hasClass 'no-fixed'
          @ref.addClass 'no-fixed'
          @ref.css {top: "#{@threshold}px"}
      else
        if @ref.hasClass 'no-fixed'
          @ref.removeClass 'no-fixed'
          @ref.css {top: @top}

    for i in [0...@buttons.length]
      btn = $ @buttons[i]
      if val >= @getSectionTopByButton btn
        id = (btn.attr 'href').substring 1
    if id isnt @current_id
      @current_id = id
      @setButtonActive()

  #########
  # BUTTONS
  #########

  setInteractions: ->
    
    @buttons.bind 'click', @jumpToSection

  setButtonActive: ->

    for i in [0...@buttons.length]
      btn = $ @buttons[i]
      id = (btn.attr 'href').substring 1
      if id is @current_id
        btn.addClass 'current'
      else
        if btn.hasClass('current') then btn.removeClass 'current'

  #################
  # JUMP TO SECTION
  #################

  jumpToSection: (e) =>

    e.preventDefault()
    btn = $ e.currentTarget

    unless btn.hasClass 'active'
      target_top = @getSectionTopByButton btn
      if target_top isnt @w.scrollTop()
        TweenLite.to window, 2, {scrollTo:{y:target_top}, ease:Power4.easeInOut}

  getSectionTopByButton: (btn) ->

    section_id = (btn.attr 'href').substring 1
    section_ref = $ "##{section_id}"
    section_top = Math.floor section_ref.offset().top - small_header_height + 1
    if section_id is $(@sections[0]).attr 'id' then section_top = 0

    return section_top

  getSectionTopById: (id) ->

    section_ref = $ "##{id}"
    section_top = Math.floor section_ref.offset().top - small_header_height + 1
    if id is $(@sections[0]).attr 'id' then section_top = 0

    return section_top

