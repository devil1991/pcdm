class window.IEMediaquery

  constructor: () ->

    @html = $ 'html'

    @limit_max = 1679
    @limit_middle = 1279
    @limit_min = 1023

  onResize: (w) =>

    # brakpoints
    if w > @limit_max
      @html.addClass 'ie-max'
    else
      if @html.hasClass 'ie-max' then @html.removeClass 'ie-max'

    if @limit_max > w > @limit_middle
      @html.addClass 'ie-mid'
    else
      if @html.hasClass 'ie-mid' then @html.removeClass 'ie-mid'

    if @limit_middle > w > @limit_min
      @html.addClass 'ie-tablet'
    else
      if @html.hasClass 'ie-tablet' then @html.removeClass 'ie-tablet'