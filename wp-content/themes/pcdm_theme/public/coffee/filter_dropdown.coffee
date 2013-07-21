class window.FilterDropdown

	constructor: (@ref, @param) ->

		@btn = @ref.find 'dt'
		@label = @btn.find 'span'
		@list = @ref.find 'dd'

		@item_template = $ @list.find('>ul >li')[0]

		@value = ''
		@dur = .8

		@initFilter()

	##########
	# SETTINGS
	##########

	initFilter: (obj) =>

		@list.css {visibility:'hidden', opacity:'0'}

		if obj isnt undefined
			@updateLabel obj.label
			@list.find('>ul >li').remove()
			array = obj.list
			if array.length > 0
				@btn.removeClass 'disabled'
				for i in [0...array.length]
					el = array[i]
					item = @item_template.clone()
					link = item.find '>a'
					link.attr 'data-value', el.value
					link.text el.label
					@list.find('>ul').append item
			else
				@btn.addClass 'disabled'

		@btn.removeClass 'opened'
		@is_opened = false
		@is_enabled = true

		@setInteractions()

	enableFilter: => @is_enabled = true

	disableFilter: => @is_enabled = false

	##############
	# INTERACTIONS
	##############

	setInteractions: ->

		@btn.bind 'click', @onButtonClick
		@list.find('>ul >li >a').bind 'click', @onItemClick

	onButtonClick: (e) =>

		e.preventDefault()
		unless @btn.hasClass 'disabled'
			if @is_opened then @closeList() else @openList()

	onItemClick: (e) =>

		e.preventDefault()

		if @is_enabled

			event_emitter.emitEvent 'DISABLE_FILTERS'

			item = $ e.currentTarget
			@value = item.attr 'data-value'
			@updateLabel item.text()
			@closeList true

	########
	# UPDATE
	########

	updateLabel: (str) -> @label.text str

	openList: =>

		if @is_enabled

			@btn.addClass 'opened'
			@list.css {visibility:'visible'}
			TweenLite.to @list, @dur, {css:{'opacity':'1'}, ease:Power4.easeInOut, onComplete:(=>
				@is_opened = true
			)}

	closeList: (is_updating = false) =>

		if is_updating then event_emitter.emitEvent 'CLOSE_FILTERS', [@param]

		@btn.removeClass 'opened'
		TweenLite.to @list, @dur, {css:{'opacity':'0'}, ease:Power4.easeInOut, onComplete:(=>
			@list.css {visibility:'hidden'}
			@is_opened = false
			if is_updating then event_emitter.emitEvent 'FILTER_UPDATED', [@param, @value]
		)}