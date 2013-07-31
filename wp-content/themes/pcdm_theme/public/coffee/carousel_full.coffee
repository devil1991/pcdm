class window.CarouselFull

  constructor: (@ref) ->

    @carousel_ref = @ref.find '.carousel'
    @items = @carousel_ref.find '> li'
    
    @counter_ref = @ref.find '.js-counter'
    @navigator_ref = @ref.find '.navigator'
    if @navigator_ref.length > 0
      @prev_btn = @navigator_ref.find '.previous'
      @next_btn = @navigator_ref.find '.next'
    @progress_ref = @navigator_ref.find '.text-counter'
    if @progress_ref.length > 0
      @progress_current = @progress_ref.find '.current'
      @progress_total = @progress_ref.find '.total'

    @current = 0
    @duration = 1.5
    @wait_timeout = 0
    @wait_duration = 5000
    @is_enabled = true

    @setElements()

    @has_counter = @has_navigator = @has_progress = @has_autoplay = false
    if @counter_ref.length > 0 then @setCounter()
    if @navigator_ref.length > 0 then @setNavigator()
    if @progress_ref.length > 0 then @setProgress()
    if @ref.hasClass('js-autoplay') then @setAutoPlay()

    unless is_mobile then @ref.bind 'dragstart', ((e) -> e.preventDefault())
    if @ref.hasClass('js-swipe') and @items.length > 1 then @ref.swipe {swipe:@onSwipe, threshold:100, allowPageScroll:'vertical'}

  ######
  # INIT
  ######

  setElements: ->

    @carousel_ref.css {width: "#{@items.length * 100}%"}

    for i in [0...@items.length]
      item = $ @items[i]
      item.css {width: "#{100 / @items.length}%"}

    first_item = $(@items[0]).clone()
    @carousel_ref.append first_item

    last_item = $(@items[@items.length - 1]).clone()
    last_item.insertBefore $(@items[0])

    @carousel_ref.css {left: '-100%'}

  #########
  # COUNTER
  #########

  setCounter: ->

    bullets = @counter_ref.find 'li'

    if bullets.length < 2
      @counter_ref.hide()
    else
      @has_counter = true
      for i in [0...bullets.length]
        bullet = $ bullets[i]
        bullets.bind 'click', @onCounterBulletClick
        link = bullet.find 'a'
        link.bind 'click', ((e) -> e.preventDefault())

  onCounterBulletClick: (e) =>

    e.preventDefault()

    if @is_enabled
      index = $(e.currentTarget).index()
      if index isnt @current
        delta = index - @current
        @moveSlider delta

  ###########
  # NAVIGATOR
  ###########

  setNavigator: ->

    if @items.length > 1 and @prev_btn.length > 0 and @next_btn.length > 0
      @has_navigator = true
      @prev_btn.bind 'click', ((e) => @onNavigatorBtnClick e, -1)
      @next_btn.bind 'click', ((e) => @onNavigatorBtnClick e, 1)
    else
      @navigator_ref.hide()

  onNavigatorBtnClick: (e, dir) =>

    e.preventDefault()
    if @is_enabled and !$(e.currentTarget).hasClass('disabled') then @moveSlider dir

  ##########
  # PROGRESS
  ##########

  setProgress: ->

    if @progress_current.length > 0 and @progress_total.length > 0
      @has_progress = true
      @progress_current.text @current + 1
      @progress_total.text @items.length

  ##########
  # AUTOPLAY
  ##########

  setAutoPlay: ->

    if @items.length > 1
      @has_autoplay = true
      @startAutoPlay()

  startAutoPlay: -> @wait_timeout = window.setTimeout @onWaitTimeout, @wait_duration

  stopAutoPlay: -> window.clearTimeout @wait_timeout

  onWaitTimeout: => if @is_enabled then @moveSlider 1

  #######
  # SWIPE
  #######

  onSwipe: (event, direction) =>

    if @is_enabled
      dir = if direction is 'left' then 1 else if direction is 'right' then -1
      @moveSlider dir

  ###########
  # ANIMATION
  ###########

  moveSlider: (delta) ->

    @is_enabled = false

    if @has_counter then @counter_ref.find('li a.active').toggleClass 'active'
    if @has_navigator then @navigator_ref.find('li a.disabled').toggleClass 'disabled'
    if @has_autoplay then @stopAutoPlay()
    
    @current = @current + delta
    TweenLite.to @carousel_ref, @duration, {css:{'left':"#{- 100 * (@current + 1)}%"}, ease:Power4.easeInOut, onComplete:@onSliderMoved}
    
  onSliderMoved: =>

    if @current is @items.length
      @current = 0
      @carousel_ref.css {left: '-100%'}
    else if @current is -1
      @current = @items.length - 1
      @carousel_ref.css {left: "#{- 100 * (@current + 1)}%"}

    if @has_counter then @counter_ref.find("li:eq(#{@current}) a").toggleClass 'active'
    if @has_navigator
      if @current is 0 then @prev_btn.addClass 'disabled'
      else if @current is @items.length - 1  then @next_btn.addClass 'disabled'
    if @has_progress then @progress_current.text @current + 1
    if @has_autoplay then @startAutoPlay()
    
    @is_enabled = true
