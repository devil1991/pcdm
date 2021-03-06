class window.MobileMenu

	constructor: (@ref) ->

		@w = $ window
		@aux = @ref.find '.aux-body-simulator'
		@sidebar = @ref.find '#mobile-sidebar'
		@header = @ref.find '.header >.fixed-mobile'
		@switch = @header.find '.open-nav'
		@close = @ref.find '.close-menu'
		@social = @ref.find '.nav-social'

		@dur = 1
		@is_enabled = true

		@setInteractions()

	setInteractions: ->

		@switch.bind 'click', @onSwitch
		@header.swipe {swipe:@onHeaderSwipe, threshold:150, allowPageScroll:'vertical'}
		@sidebar.swipe {swipe:@onSidebarSwipe, threshold:150, allowPageScroll:'vertical'}
		@close.bind 'click', @onSwitch
		@social.find('.label').bind 'click', ((e) => @social.find('>ul').toggleClass 'opened')

	onHeaderSwipe: (e, dir) => if dir is 'right' then @onSwitch()

	onSidebarSwipe: (e, dir) => if dir is 'left' then @onSwitch()

	onSwitch: (e) =>

		if e? then e.preventDefault()

		if @is_enabled
			@is_enabled = false

			if @aux.hasClass 'sidebar-open'
				@closeAux()
			else
				if @w.scrollTop() > 0
					TweenLite.to window, @dur, {scrollTo:{y:0}, ease:Power4.easeInOut, onComplete:@openAux}
				else
					@openAux()

	openAux: =>

		@aux.addClass 'sidebar-open'
		TweenLite.to @aux, @dur, {css:{'left':'0'}, ease:Power4.easeInOut, onComplete:(=>
			@close.show()
			@is_enabled = true
		)}

	closeAux: =>

		@close.hide()
		TweenLite.to @aux, @dur, {css:{'left':'-90%'}, ease:Power4.easeInOut, onComplete:(=>
			@aux.removeClass 'sidebar-open'
			@is_enabled = true
		)}
