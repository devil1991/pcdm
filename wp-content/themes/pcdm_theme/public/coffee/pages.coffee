unless window.console then window.console = {log: ((obj) ->)}

$ ->

  window_ref = $ window

  ##################
  # USER AGENT CHECK
  ##################

  window.is_ie = $.browser.msie
  window.is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1
  window.is_mobile = if navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/Android/i) then true else false
  window.is_iphone = if navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPod/i) then true else false
  window.is_ipad = if navigator.userAgent.match(/iPad/i) then true else false
  window.is_android = if navigator.userAgent.match(/Android/i) then true else false

  phablet_breakpoint = 960
  smartphone_breakpoint = 560

  window.is_phablet = is_mobile and (window.screen.width < phablet_breakpoint)
  window.is_smartphone = is_mobile and (window.screen.width < smartphone_breakpoint)

  ###############
  # EVENT EMITTER
  ###############

  window.event_emitter = new EventEmitter()

  ###################
  # MOBILE EXCEPTIONS
  ###################

  # if is_mobile
  #   $('body').addClass 'mobile'

  ###############
  # IE MEDIAQUERY
  ###############

  if is_ie and $.browser.version < 9 then ie_mediaquery = new IEMediaquery()

  #############
  # HEADER MENU
  #############

  window.small_header_height = 120

  header_menu_ref = $ '.header'
  if header_menu_ref.length is 1
    header_menu = new HeaderMenu header_menu_ref

  #############
  # MOBILE MENU
  #############

  body_simulator_ref = $ '#body-simulator'
  if body_simulator_ref.length is 1
    mobile_menu = new MobileMenu body_simulator_ref

  #############
  # COLLECTIONS
  #############

  product_grid_ref = $ '.wrap-product-grid'
  product_details_ref = $ '.product-detail'
  if product_details_ref.length is 1 and product_details_ref.length is 1
    collection = new Collection product_grid_ref, product_details_ref

  ###############
  # RAILS SHIFTER
  ###############

  unless is_mobile
    if window_ref.width() > 1120
      rails_shifter_ref = $ '.js-rails-shifter'
      if rails_shifter_ref.length is 1
        rails_shifter = new RailsShifter rails_shifter_ref

  ##########
  # CAROUSEL
  ##########

  for carousel in $ '.wrap-carousel'
    carousel_ref = $ carousel
    new CarouselFull carousel_ref

  ###############
  # FILTERED GRID
  ###############

  filtered_grid_ref = $ '.js-filtered-grid'
  if filtered_grid_ref.length is 1
    filtered_grid = new FilteredGrid filtered_grid_ref

  ############
  # CHILD MGMT
  ############

  if is_ie and $.browser.version < 9

    for last_child_container in $ '.js-last-child'
      last_child = $(last_child_container).children().last()
      last_child.addClass 'last-child'

    fourth_children_container = $ '.js-fourth-children'
    if fourth_children_container.length > 0
      for i in [0...fourth_children_container.length]
        fourth_children = $(fourth_children_container[i]).children()
        for j in [0...fourth_children.length]
          if (j + 1) % 4 is 0
            fourth_child = $ fourth_children[j]
            fourth_child.addClass 'fourth-child'

  even_children_container = $ '.js-even-children'
  if even_children_container.length > 0
    for i in [0...even_children_container.length]
      even_children = $(even_children_container[i]).children()
      cnt = 0
      for j in [0...even_children.length]
        even_child = $ even_children[j]
        unless even_child.hasClass 'empty'
          if cnt % 2 is 1 then even_child.addClass 'even-child'
          cnt++

  ###########
  # COLUMNIST
  ###########

  columnist_ref = $ '.js-columnist'
  if columnist_ref.length is 1
    columnist = new Columnist columnist_ref

  ###########
  # ACCORDION
  ###########

  for accordion in $ '.accordion'
    accordion_ref = $ accordion
    new Accordion accordion_ref

  ###############
  # VIDEO MANAGER
  ###############

  video_list_ref = $ '.video-list'
  if video_list_ref.length is 1
    video_manager = new VideoManager video_list_ref

  #########
  # OVERLAY
  #########

  overlay_ref = $ '.wrap-overlay'

  if overlay_ref.length is 1

    newsletter = overlay_ref.find '.newsletter'
    if newsletter.length is 1 then new Newsletter newsletter

    $('.footer a.subscribe').bind 'click', ((e) =>
      e.preventDefault()
      overlay_ref.show()
    )
    overlay_ref.find('.close').bind 'click', ((e) =>
      e.preventDefault()
      overlay_ref.hide()
    )

  #####################
  # VERTICAL FIXED MENU
  #####################

  vfm_ref = $ '.js-vertical-fixed-menu'
  if vfm_ref.length is 1
    vertical_fixed_menu = new VerticalFixedMenu vfm_ref 

  #############
  # BACK TO TOP
  #############

  btt_ref = $ '.back-to-top'
  if btt_ref.length is 1
    back_to_top = new BackToTop btt_ref

  ################
  # SOCIAL SHARING
  ################

  # TODO: HTML - attribuire classe 'link' a oggetti social solo link #

  sharing_modules = $ '.js-sharing'
  if sharing_modules.length > 0
    for i in [0...sharing_modules.length]
      unless $(sharing_modules[i]).hasClass 'link'
        new SocialSharing $(sharing_modules[i])

  ################
  # GENERAL SCROLL
  ################

  onWindowScroll = =>
    # console.log 'scrolling!'
    # USAGE: if instance? then instance.onScroll()
    val = window_ref.scrollTop()
    if header_menu? then header_menu.onScroll val
    if rails_shifter? then rails_shifter.onScroll val
    if vertical_fixed_menu? then vertical_fixed_menu.onScroll val
    if back_to_top? then back_to_top.onScroll val

  window_ref.scroll onWindowScroll

  ################
  # GENERAL RESIZE
  ################

  onWindowResize = =>
    # console.log 'resizing!'
    # USAGE: if instance? then instance.onResize()
    window_w = window_ref.width()
    window_h = window_ref.height()
    if rails_shifter? then rails_shifter.onResize()
    if collection? then collection.onResize window_w, window_h
    if columnist? then columnist.onResize window_w, window_h
    if ie_mediaquery? then ie_mediaquery.onResize window_w
    if overlay_ref? then overlay_ref.height $(document).height()
    if back_to_top? then back_to_top.onResize window_h

  window_ref.resize onWindowResize
  onWindowResize()
