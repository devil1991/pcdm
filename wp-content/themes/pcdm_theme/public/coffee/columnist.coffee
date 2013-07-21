class window.Columnist

  constructor: (@ref) ->

    @cols = parseInt(@ref.attr 'data-columns') or 3
    @items = @ref.find 'div .block'
    @images = @ref.find 'img'
    @loaded = 0
    @is_ready = false

    @preloadImages()

  preloadImages: ->

    for i in [0...@images.length]
      @setPreloader $(@images[i]).attr('src')

  setPreloader: (url) ->

    preloader = new Image()
    preloader.onload = @onImageLoaded
    preloader.src = url

  onImageLoaded: =>

    @loaded++
    if @loaded is @images.length
      @setItems()
      @is_ready = true

  setItems: ->

    matrix = []
    matrix.push [] for i in [0...@cols]

    for i in [0...@items.length]
      item = $ @items[i]
      col = Math.round((item.position().left / @ref.width()) * @cols)
      matrix[col].push item

    for i in [0...matrix.length]
      h = 0
      offset_top = matrix[i][0].position().top
      for j in [1...matrix[i].length]
        item_over = matrix[i][j - 1]
        item_under = matrix[i][j]
        expected_top = h + item_over.height() + parseInt(item_over.css 'margin-bottom') + 2 * parseInt(item_over.css 'border-top-width')
        delta = item_under.position().top - offset_top - expected_top
        item_under.css {'margin-top': "#{- delta}px"}
        h = expected_top

  onResize: => if @is_ready then @setItems()


