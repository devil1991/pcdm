class window.CollectionDetails

	constructor: (@ref, @id_array, @is_dev) ->

		@loader = @ref.siblings '.loader'

		@img = @ref.find '.img-detail'
		@number_txt = @ref.find '.wrap-text .number'
		@collection_txt = @ref.find '.wrap-text .collection'
		@title_txt = @ref.find '.wrap-text .title'
		@description_txt = @ref.find '.wrap-text .description'

		@prev_btn = @ref.find 'a.previous'
		@next_btn = @ref.find 'a.next'
		@back_btn = @ref.find 'a.back'

		@callback_url = @ref.attr 'data-callback'

		@current_id
		@data = {}
		@img_ratio

		@setInteractions()
		event_emitter.addListener 'IMAGE_LOADED', @renderContents

	##############
	# INTERACTIONS
	##############

	setInteractions: ->

		@prev_btn.bind 'click', @onPrevClick
		@next_btn.bind 'click', @onNextClick
		@back_btn.bind 'click', @onBackClick

	onPrevClick: (e) =>

		e.preventDefault()
		btn = $ e.currentTarget
		unless btn.hasClass 'disabled' then @updateDetails -1

	onNextClick: (e) =>

		e.preventDefault()
		btn = $ e.currentTarget
		unless btn.hasClass 'disabled' then @updateDetails 1

	updateDetails: (dir) ->

		unless is_switching
			
			window.is_switching = true
			id = @id_array[@getCurrentIndex() + dir]
			event_emitter.emitEvent 'UPDATE_DETAILS', [id]

	getCurrentIndex: ->

		index = 0
		
		for i in [0...@id_array.length]
			if @id_array[i] is @current_id
				index = i

		return index

	########
	# UPDATE
	########

	updateContents: (id) =>

		@current_id = id
		@checkButtons()

		@unloadContents()

		@ref.css {visibility:'hidden'}
		@ref.show()
		@loader.show()

		@loadData()
	
	
	checkButtons: ->

		index = @getCurrentIndex()
		
		if index is 0
			@prev_btn.addClass 'disabled'
			if @next_btn.hasClass 'disabled' then @next_btn.removeClass 'disabled'
		else if index is @id_array.length - 1
			if @prev_btn.hasClass 'disabled' then @prev_btn.removeClass 'disabled'
			@next_btn.addClass 'disabled'
		else
			if @prev_btn.hasClass 'disabled' then @prev_btn.removeClass 'disabled'
			if @next_btn.hasClass 'disabled' then @next_btn.removeClass 'disabled'

	unloadContents: ->

		@img.attr 'src', ''

	loadData: ->

		if @is_dev
			data_path = '../public/json/product_details.json'
			$.getJSON data_path, @onDataLoaded
		else
			$.ajax {
			  type:'POST',
			  url:'/wp-admin/admin-ajax.php',
			  data:{action:'product_details', product_id:@current_id},
			  success:@onDataLoaded,
			  error:@onDataError
			}

	onDataLoaded: (json) =>

		@data = json.details
		@loadImage @data.img

	onDataError: =>

	loadImage: (src) ->

    if is_smartphone
    	src = src.replace(".jpg", "-mobile.jpg")
    @img.attr 'src', src

    preloader = new Image()
    preloader.onload = @onImageLoaded
    preloader.src = src

	onImageLoaded: ->

    ratio = @.width / @.height
    event_emitter.emitEvent 'IMAGE_LOADED', [ratio]

	renderContents: (@img_ratio) =>

		@loader.hide()

		@number_txt.html @data.number
		@collection_txt.html @data.collection
		@title_txt.html @data.title
		@description_txt.html @data.description

		@onResize()
		@ref.css {opacity:'0', visibility:'visible'}
		TweenLite.to @ref, 1, {css:{'opacity':'1'}, ease:Power4.easeInOut}

		window.is_switching = false

	########
	# REMOVE
	########

	onBackClick: (e) =>

		e.preventDefault()

		unless is_switching

			window.is_switching = true
			event_emitter.emitEvent 'SWITCH_TO_GRID'

	removeContents: =>

		TweenLite.to @ref, 1, {css:{'opacity':'0'}, ease:Power4.easeInOut, onComplete:@onContentsRemoved}

	onContentsRemoved: =>

		@ref.hide()
		event_emitter.emitEvent 'DETAILS_HIDDEN', [@current_id]

	########
	# RESIZE
	########

	onResize: (window_w, window_h) =>

		unless is_smartphone
			if window_w isnt undefined
				@ref.width window_w
				@ref.height window_h

			unless isNaN @img_ratio

				ref_w = @ref.width()
				ref_h = @ref.height()

				img_h = ref_w / @img_ratio
				if img_h > ref_h
				  img_w = ref_w
				else
				  img_w = ref_h * @img_ratio
				  img_h = ref_h
		
				@img.width img_w
				@img.height img_h
				@img.css {'margin-left':"#{-.5 * (img_w - ref_w)}px", 'margin-top':"#{-.5 * (img_h - ref_h)}px"}

