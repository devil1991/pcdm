class window.VimeoPlayer
	
	constructor: (@ref) ->

		@id = @ref.attr 'id'
		@iframe = @ref[0]
		@player = $f @iframe

		@player.addEvent 'ready', @onReady

	########
	# EVENTS
	########

	onReady: =>
		
		#@player.addEvent 'pause', @onPause
		@player.addEvent 'finish', @onFinish
		#@player.addEvent 'playProgress', @onPlayProgress

		onVideoReady @id
		#event_emitter.emitEvent 'VIDEO_READY', [@id]

	onPause: (id) => console.log "paused: #{id}"

	onFinish: (id) => event_emitter.emitEvent 'VIDEO_FINISH', [id]

	onPlayProgress: (data, id) => console.log "#{id} --> #{data.seconds}"

	##########
	# CONTROLS
	##########

	play: => @player.api 'play'

	stop: => @player.api 'pause'

	reset: => @player.api 'seekTo', '0'
		