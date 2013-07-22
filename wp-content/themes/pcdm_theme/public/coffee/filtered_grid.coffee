class window.FilteredGrid

	constructor: (@ref) ->

		@is_dev = @ref.hasClass 'js-dev'

		@filters = @ref.find '.wrap-filter'
		@reset = @ref.find 'a.clear'
		@grid =  @ref.find '.js-grid'
		@items = @grid.find '.item'

		@cols = 4

		event_emitter.addListener 'ENABLE_FILTERS', @enableFilters
		event_emitter.addListener 'DISABLE_FILTERS', @disableFilters
		event_emitter.addListener 'CLOSE_FILTERS', @closeFilters

		if @filters.length > 0
			@filters_tot = @filters.length
			@filters_array = []
			@setFilters()

		@reset.bind 'click', @resetFilters

		@items_tot = @items.length
		@items_array = []
		@setItems()

	#########
	# FILTERS
	#########

	setFilters: ->

		event_emitter.addListener 'FILTER_UPDATED', @onFilterUpdated

		for i in [0...@filters_tot]
			ref = $ @filters[i]
			param = ref.attr 'data-filter'
			instance = new FilterDropdown ref, param
			@filters_array.push {param:param, value:'', instance:instance}

	resetFilters: =>

		is_enabled = true

		for i in [0...@filters_tot]
			if @filters_array[i].instance.is_enabled is false then is_enabled = false

		if is_enabled
			@disableFilters()
			@loadData true

	onFilterUpdated: (param, value) =>

		@loadData()

	enableFilters: => @filters_array[i].instance.enableFilter() for i in [0...@filters_tot]

	disableFilters: => @filters_array[i].instance.disableFilter() for i in [0...@filters_tot]

	closeFilters: (param) =>

		for i in [0...@filters_tot]
			filter = @filters_array[i].instance
			if filter.is_opened and filter.param isnt param
				filter.closeList()

	updateFilters: (show_array) =>

		for i in [0...show_array.length]
			obj = show_array[i]
			param = obj['filter']
			for j in [0...@filters_tot]
				filter = @filters_array[j]
				if filter.param is param
					filter.instance.initFilter obj

	#######
	# ITEMS
	#######

	setItems: ->

		for i in [0...@items_tot]
			ref = $ @items[i]
			id = ref.attr 'data-id'
			@items_array.push {id:id, ref:ref}
			if (i + 1) % @cols is 0 then ref.addClass 'last'

	updateItems: (show_array) ->

		@items_array[i].ref.removeClass('last').hide() for i in [0...@items_tot]

		cnt = 0
		delay = 0
		for i in [0...show_array.length]
			id = show_array[i]
			for j in [0...@items_tot]
				item = @items_array[j]
				if item.id is id
					if (cnt + 1) % @cols is 0 then item.ref.addClass 'last'
					item.ref.css({opacity:'0'}).show()
					TweenLite.to item.ref, 1, {css:{'opacity':'1'}, delay:delay, ease:Power4.easeInOut}
					cnt++
					delay += .25

	######
	# DATA
	######

	loadData: (is_reset = false) ->

		obj = {action:'press'}
		for i in [0...@filters_tot]
			filter = @filters_array[i]
			obj[filter.param] = if is_reset then '' else filter.instance.value
		#console.log obj

		if @is_dev
			data_path = '../public/json/press.json'
			$.getJSON data_path, @onDataLoaded
		else
			$.ajax {
			  type:'POST',
			  url:'/wp-admin/admin-ajax.php',
			  data:obj,
			  success:@onDataLoaded,
			  error:@onDataError
			}

	onDataLoaded: (json) =>

		if @filters.length > 0 then @updateFilters json.filters
		@updateItems json.items

		@enableFilters()

	onDataError: => @enableFilters()

