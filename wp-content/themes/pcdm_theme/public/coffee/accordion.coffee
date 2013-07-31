class window.Accordion

  constructor: (@ref) ->

    @items = @ref.find '.item-accordion'
    @nitems = @items.length
    @measures_array = []
    @duration = 1

    @getMeasures()
    @setItems()
    @ref.css {visibility:'visible'}

  getMeasures: ->

    for i in [0...@nitems]

      item = $ @items[i]
      if item.hasClass 'js-no-content'
        obj = {h: 0, pt: 0, pb: 0}
      else
        content = item.find '.content-accordion'
        obj = {h: content.css('height'), pt: content.css('padding-top'), pb: content.css('padding-bottom')}
      @measures_array.push obj

  setItems: ->

    for i in [0...@nitems]

      item = $ @items[i]

      content = item.find '.content-accordion'
      unless item.hasClass 'open' then content.css {height:'0', 'padding-top':'0', 'padding-bottom':'0'}

      if item.hasClass 'js-no-content'
        item.find('.open-accordion a .arrow').hide()
        if content? then content.css {height:'0', 'padding-top':'0', 'padding-bottom':'0'}
      else
        toggle = item.find '.open-accordion a'
        toggle.attr 'data-num', i
        toggle.bind 'click', @onToggleClick

  onToggleClick: (e) =>

    e.preventDefault()

    toggle = $ e.currentTarget
    num = toggle.attr 'data-num'
    item = $ @items[num]

    if item.hasClass 'open' then @closeItem item else @openItem item

  openItem: (item) ->

    @closeItem @ref.find('.item-accordion.open')

    item.addClass 'open'
    content = item.find '.content-accordion'
    m = @measures_array[item.index()]
    TweenLite.to content, @duration, {css:{'height':m.h, 'padding-top':m.pt, 'padding-bottom':m.pb}, delay:.2, ease:Power4.easeInOut}

  closeItem: (item) ->

    item.removeClass 'open'
    content = item.find '.content-accordion'
    TweenLite.to content, @duration, {css:{'height':'0', 'padding-top':'0', 'padding-bottom':'0'}, ease:Power4.easeInOut}

