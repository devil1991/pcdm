class window.BackToTop

  constructor: (@btn) ->

    @w = $(window)

    # @bottom_on = @btn.css 'bottom'
    # @bottom_off = "#{- parseInt(@btn.css 'height')}px"
    @bottom_offset = 20
    @is_off = true

    #@btn.css {bottom: @bottom_off}
    @btn.bind 'click', @onBtnClick

  onBtnClick: (e) =>

    e.preventDefault()
    if @w.scrollTop() isnt 0
      TweenLite.to window, 1.5, {scrollTo:{y:0}, ease:Power4.easeInOut, onComplete:(=> @is_off = true)}
      TweenLite.to @btn, .5, {css:{opacity: '0'}, easing:Power4.easeOut}
      #TweenLite.to @btn, .3, {css:{bottom: @bottom_off}, easing:Power4.easeOut}

  onScroll: (val) =>

    if val isnt 0 and @is_off
      @is_off = false
      TweenLite.to @btn, .5, {css:{opacity: '1'}, easing:Power4.easeOut}
    else if val is 0 and !@is_off
      @is_off = true
      TweenLite.to @btn, .5, {css:{opacity: '0'}, easing:Power4.easeOut}

    # if val isnt 0 and @is_off
    #   @is_off = false
    #   TweenLite.to @btn, .5, {css:{bottom: @bottom_on}, easing:Power4.easeIn}
    # else if val is 0 and !@is_off
    #   @is_off = true
    #   TweenLite.to @btn, .3, {css:{bottom: @bottom_off}, easing:Power4.easeOut}

  onResize: (val) =>

    @btn.css {top: "#{val - @btn.height() - @bottom_offset}px"}