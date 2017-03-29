class window.Collection

	constructor: (@grid_ref, @details_ref) ->

		@is_dev = @grid_ref.hasClass 'js-dev'
		@category = @grid_ref.attr 'data-category'
		init_id = @grid_ref.attr 'data-init-id'

		@w = $ window
		@wrapper = $ '#wrapper'
		@header = @grid_ref.find '.header-product-grid'
		@boxes = @grid_ref.find '.item'

		@items_array = []
		@items_tot
		@current_id = if init_id? and init_id isnt '' then init_id else ''
		@details
		@scroll_offset = 1000
		window.is_switching = false

		event_emitter.addListener 'SWITCH_TO_DETAILS', @switchToDetails
		event_emitter.addListener 'UPDATE_DETAILS', @updateDetails
		event_emitter.addListener 'SWITCH_TO_GRID', @switchToGrid
		event_emitter.addListener 'DETAILS_HIDDEN', @onDetailsHidden

		@setGrid()
		@setDetails()

		@has_history = false
		@prev_state_id = 'home'
		unless @is_dev then @setHistory()

	#########
	# HISTORY
	#########

	setHistory: ->

		if !History.enabled then return false
		#console.log "-------- inizialiting history ---------"

		@has_history = true

		History.Adapter.bind window, 'statechange', @onHistoryStateChange
		History.replaceState {state:'home'}, '', "/#{@category}"

		# verificare comportamento online
		# usare classe js-dev su grid per istanziare o meno history (stesso se history non è enabled...)
		# usare data-init-id per capire se è inizializzato a id

		if @current_id isnt '' then event_emitter.emitEvent 'SWITCH_TO_DETAILS'

	onHistoryStateChange: =>

		#console.log "-------- state changing --------"
		State = History.getState()
		#History.log "history log --> ", State.data, State.title, State.url

		state_id = State.data.state
		#console.log 'state --> ', state_id

		if state_id isnt @prev_state_id
			@prev_state_id = state_id
			if state_id is 'home'
				@hideDetails()
			else
				if @wrapper.hasClass 'detail-on'
					@showDetails()
				else
					@dismantleGrid()
			event_emitter.emitEvent 'UPDATE_SHARING_DATA', [State.url]

	switchToDetails: =>

		if @has_history
			History.pushState {state:@current_id}, '', "/#{@category}/#{@current_id}"
			event_emitter.addListener 'SWITCH_TO_GRID', @switchToGrid
		else
			@dismantleGrid()

	updateDetails: (id) =>

		@current_id = id

		if @has_history
			History.pushState {state:@current_id}, '', "/#{@category}/#{@current_id}"
			event_emitter.addListener 'SWITCH_TO_GRID', @switchToGrid
		else
			@showDetails()

	switchToGrid: =>

		if @has_history
			History.pushState {state:'home'}, '', "/#{@category}"
			event_emitter.addListener 'SWITCH_TO_DETAILS', @switchToDetails
		else
			@hideDetails()

	######
	# GRID
	######

	setGrid: ->

		for i in [0...@boxes.length]

			box = $ @boxes[i]
			offset = box.offset().top

			items = box.find 'a'

			for j in [0...items.length]

				item = $ items[j]
				id = item.attr 'data-id'

				@items_array.push {id:id, ref:item, offset:offset}

				item.bind 'click', @onItemClick

		@items_tot = @items_array.length

	onItemClick: (e) =>

		e.preventDefault()

		unless is_switching

			window.is_switching = true

			item = $ e.currentTarget
			@current_id = item.attr 'data-id'

			event_emitter.emitEvent 'SWITCH_TO_DETAILS'

	dismantleGrid: ->

		current_index = @getCurrentIndex()

		for i in [0...@items_tot]
			item = @items_array[i].ref
			delay = Math.min(Math.max(.25 * (current_index - i), 0), 1.75)
			#delay = .25 * (@items_tot - 1 - i)
			TweenLite.to item, 1, {css:{'opacity':'0'}, delay:delay, ease:Power4.easeInOut}

		TweenLite.to @header, 2, {css:{'opacity':'0'}, ease:Power4.easeInOut}

		scroll_val = Math.max(@w.scrollTop() - @scroll_offset, 0)
		TweenLite.to window, 2, {scrollTo:{y:scroll_val}, ease:Power4.easeInOut, onComplete:@showDetails}
		#TweenLite.to window, 2, {scrollTo:{y:0}, ease:Power4.easeInOut, onComplete:@showDetails}

	rebuildGrid: ->

		current_index = @getCurrentIndex()

		for i in [0...@items_tot]
			item = @items_array[i].ref
			delay = Math.min(Math.max(.25 * (i + 5 - current_index), 0), 1.75)
			#delay = .25 * i
			TweenLite.to item, 1, {css:{'opacity':'1'}, delay:delay, ease:Power4.easeInOut}

		TweenLite.to @header, 2, {css:{'opacity':'1'}, ease:Power4.easeInOut}

		scroll_val = @getScrollById()
		@w.scrollTop Math.max(scroll_val - @scroll_offset, 0)
		TweenLite.to window, 2, {scrollTo:{y:scroll_val}, ease:Power4.easeInOut, onComplete:(-> window.is_switching = false)}
		#TweenLite.to window, 2, {scrollTo:{y:@getScrollById()}, ease:Power4.easeInOut, onComplete:(-> window.is_switching = false)}

	getScrollById: ->

		offset = 0

		for i in [0...@items_tot]
			item = @items_array[i]
			if item.id is @current_id
				offset = item.offset
				break

		return offset

	getCurrentIndex: ->

		index = 0

		for i in [0...@items_tot]
			item = @items_array[i]
			if item.id is @current_id
				index = i

		return index

	#########
	# DETAILS
	#########

	setDetails: ->

		id_array = []
		for i in [0...@items_tot]
			id = @items_array[i].id
			id_array.push id

		@details = new CollectionDetails @details_ref, id_array, @is_dev

	showDetails: =>

		unless @wrapper.hasClass 'detail-on'
			@w.scrollTop 0
			@wrapper.addClass 'detail-on'
			@grid_ref.hide()

		@details.updateContents @current_id

	hideDetails: ->

		@details.removeContents()

	onDetailsHidden: (id) =>

		@current_id = id

		@wrapper.removeClass 'detail-on'
		@grid_ref.show()

		@rebuildGrid()

	########
	# RESIZE
	########

	onResize: (window_w, window_h) =>

		if @details then @details.onResize window_w, window_h
