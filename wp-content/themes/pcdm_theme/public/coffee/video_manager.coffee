class window.VideoManager

	constructor: (@ref) ->

		@items = @ref.find '.item-video'

		if @items.length > 0

			@video_array = []
			@dur = 1

			# TODO: JS - trovare alternativa a funzione globale (event ha solo 1 emit...) #
			window.onVideoReady = @onVideoReady
			#event_emitter.addListener 'VIDEO_READY', @onVideoReady
			event_emitter.addListener 'VIDEO_FINISH', @onVideoFinish

			@setVideoArray()
			@setInteractions()

	######
	# INIT
	######

	setVideoArray: ->

		for i in [0...@items.length]
			item = $ @items[i]
			play_text = item.find '.wrap-more .more'
			video = item.find '.wrap-video'
			cover = video.find '.link-video'
			play_ico = cover.find '.ico-video'
			close = video.find '.close'
			vimeo = video.find '.js-vimeo'
			id = vimeo.attr 'id'
			instance = new VimeoPlayer vimeo
			obj = {id:id, instance:instance, is_ready:true, is_enabled:true, play_text:play_text, play_ico:play_ico, cover:cover, close:close}
			@video_array.push obj

		# console.log @video_array

	setInteractions: (id) ->

		for i in [0...@video_array.length]
			video = @video_array[i]
			id = video.id
			video.play_text.attr('data-id', id).bind 'click', @onLinkClick
			video.cover.attr('data-id', id).bind 'click', @onLinkClick
			video.close.attr('data-id', id).bind 'click', @onCloseClick

	onLinkClick: (e) =>

		e.preventDefault()
		id = $(e.currentTarget).attr 'data-id'
		video = @getVideoById id
		if video.is_ready then @openVideo id

	onCloseClick: (e) =>

		e.preventDefault()
		id = $(e.currentTarget).attr 'data-id'
		video = @getVideoById id
		@closeVideo id

	##############
	# OPEN / CLOSE
	##############

	openVideo: (id) ->

		video = @getVideoById id
		if video.is_enabled
			video.is_enabled = false
			video.play_text.css {visibility:'hidden'}
			TweenLite.to video.cover, @dur, {css:{'opacity':'0'}, ease:Power4.easeInOut, onComplete:@onVideoOpened, onCompleteParams:[video]}

	onVideoOpened: (video) =>

		video.cover.hide()
		video.instance.play()
		video.is_enabled = true

	closeVideo: (id) ->

		video = @getVideoById id
		if video.is_enabled
			video.is_enabled = false
			video.instance.stop()
			video.cover.show()
			TweenLite.to video.cover, @dur, {css:{'opacity':'1'}, ease:Power4.easeInOut, onComplete:@onVideoClosed, onCompleteParams:[video]}

	onVideoClosed: (video) =>

		video.instance.reset()
		video.play_text.css {visibility:'visible'}
		video.is_enabled = true

	########
	# EVENTS
	########

	onVideoReady: (id) =>

		video = @getVideoById id
		video.play_text.css {visibility:'visible'}
		video.play_ico.css {visibility:'visible'}
		video.is_ready = true

	onVideoFinish: (id) =>

		@closeVideo id

	#######
	# UTILS
	#######

	getVideoById: (id) ->

		index = 0

		for i in [0...@video_array.length]
			video = @video_array[i]
			if video.id is id
				index = i
				break

		video = @video_array[index]
		return video
