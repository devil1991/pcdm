class window.RailsShifter

  constructor: (@ref) ->

    @rail_1 = @ref.find '.rail-1'
    @rail_2 = @ref.find '.rail-2'

    @rail_1_el = @rail_1.find '.creative-vision'
    @rail_2_el = @rail_2.find '.the-designer'

    @images = @ref.find 'img'
    @images_tot = @images.length
    @images_loaded = 0

    @top = @rail_1.offset().top
    @is_enabled = false

    @rail_1.addClass 'shifter'
    @preloadImages()

  preloadImages: ->

    event_emitter.addListener 'IMAGE_LOADED', @onImageLoaded

    for i in [0...@images_tot]

      image = $ @images[i]
      src = image.attr 'src'

      preloader = new Image()
      preloader.onload = @onImageLoaded
      preloader.src = src

  onImageLoaded: =>

    @images_loaded++
    if @images_loaded is @images_tot
      @resetBreakpoints()
      @is_enabled = true

  resetBreakpoints: ->

    @breakpoint_1 = @rail_2_el.offset().top + .5 * @rail_2_el.height()
    @breakpoint_2 = @rail_1_el.offset().top - window.small_header_height

    @acc = @breakpoint_2 / (@breakpoint_2 - @breakpoint_1)

  onScroll: (val) =>

    #console.log val

    if @is_enabled

      if val > @breakpoint_1
        unless @rail_1.hasClass 'more-affracchievole' then @rail_1.addClass 'more-affracchievole'
        if val < @breakpoint_2
          @rail_1.css {top:"#{val - @acc * (val - @breakpoint_1)}px"}
      else
        if @rail_1.hasClass 'more-affracchievole'
          @rail_1.removeClass 'more-affracchievole'
          @rail_1.css {top:"#{@top}px"}

    # TODO: JS: gestire caso in cui non riesce a leggere passaggio da breakpoint2 (vedi scroll molto veloce) #

  onResize: => if @is_enabled then @resetBreakpoints()

