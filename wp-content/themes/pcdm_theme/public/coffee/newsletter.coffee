class window.Newsletter

	constructor: (@ref) ->

		@form = @ref.find 'form'
		@fields = @form.find '.campi'
		@submit_btn = @form.find 'input:submit'
		@thanks = @ref.find '>.feedback'

		@inputs_array = []
		@checkboxes_array = []
		@elements = []

		event_emitter.addListener 'COMMUNICATION_OPENED', @onCommunicationOpened
		event_emitter.addListener 'COMMUNICATION_CLOSED', @onCommunicationClosed

		@setElements()
		@setInteractions()

	######
	# INIT
	######

	setElements: ->

		inputs = @fields.find 'input:text'
		textarea = @fields.find 'textarea'

		inputs.push textarea[i] for i in [0...textarea.length]

		for i in [0...inputs.length]
			ref = $ inputs[i]
			field = ref.parent()
			id = ref.attr 'name'
			is_required = ref.hasClass 'js-required'
			ref.attr 'data-default', ref.attr 'value'
			@inputs_array.push {id:id, ref:ref, field:field, is_required:is_required}

		checkboxes = @fields.find 'input:checkbox'
		for i in [0...checkboxes.length]
			ref = $ checkboxes[i]
			field = ref.parent().parent()
			id = ref.attr 'name'
			is_required = ref.hasClass 'js-required'
			@checkboxes_array.push {id:id, ref:ref, field:field, is_required:is_required}

	##############
	# INTERACTIONS
	##############

	setInteractions: ->

		for i in [0...@inputs_array.length]
			input = @inputs_array[i].ref
			input.live('focus', @onInputFocus).live('blur', @onInputBlur)

		for i in [0...@checkboxes_array.length]
			checkbox = @checkboxes_array[i].ref
			checkbox.change @onCheckboxFocus
		
		@form.bind 'submit', @onFormSubmit

	onInputFocus: (e) =>

		input = $ e.currentTarget
		input.val '' if input.val() is input.attr 'data-default'
		field = @getFieldById(input.attr 'name')
		if field.hasClass 'error' then field.removeClass 'error'

	onInputBlur: (e) =>

		input = $ e.currentTarget
		input.val(input.attr 'data-default') if input.val().replace(/\s+/g, '') is ''

	onCheckboxFocus: (e) =>

		checkbox = $ e.currentTarget
		field = @getFieldById(checkbox.attr 'name')
		if field.hasClass 'error' then field.removeClass 'error'

	########
	# SUBMIT
	########

	onFormSubmit: (e) =>

		e.preventDefault()

		is_ok = false

		ok_filled = @testIsFilled()
		ok_checked = @testIsChecked()
		if ok_filled and ok_checked
			ok_email = @testEmail 'email'
			if ok_email then is_ok = true

		if is_ok then @collectData()

	######
	# DATA
	######

	collectData: ->

		data = {}

		for i in [0...@inputs_array.length]
			input = @inputs_array[i]
			val = input.ref.val()
			if val is input.ref.attr 'data-default' then val = ''
			data[input.id] = val

		for i in [0...@checkboxes_array.length]
			checkbox = @checkboxes_array[i]
			data[checkbox.id] = checkbox.ref.is(':checked')

		@saveData data

	saveData: (data) =>

		unless window.is_communicating

			#console.log 'SENDING -> ', data

			event_emitter.emitEvent 'COMMUNICATION_OPENED'

			url = @form.attr 'data-send'

			$.ajax {
			  type: 'POST',
			  url: url,
			  data: data,
			  dataType: "json",
			  success:@onDataSaved,
			  error:(-> event_emitter.emitEvent 'COMMUNICATION_CLOSED')
			}

	onDataSaved: (response) =>

		#console.log 'RECEIVED -> ', response

		event_emitter.emitEvent 'COMMUNICATION_CLOSED'
		if response.success is 1 then @onSuccess() else @onError response.error, response.msg

	##########
	# FEEDBACK
	##########

	onSuccess: ->		

		@thanks.css {visibility:'visible'}
		@form.css {visibility:'hidden'}
	
	onError: (error, msg) ->

		if error? and error.length > 0 then @showErrorsOnFields error
		if msg? and msg isnt '' then alert msg

	##############
	# CLIENT TESTS
	##############

	testIsFilled: =>

		is_filled = true

		for i in [0...@inputs_array.length]
			input = @inputs_array[i]
			if input.is_required
				nchars = input.ref.val().replace(/\s+/g, '').length
				if nchars is 0
					input.field.addClass 'error'
					is_filled = false
				if input.ref.val() is input.ref.attr 'data-default'
					input.field.addClass 'error'
					is_filled = false

		return is_filled

	testIsChecked: =>

		is_checked = true

		for i in [0...@checkboxes_array.length]
			checkbox = @checkboxes_array[i]
			if checkbox.is_required
				if !checkbox.ref.is(':checked')
					checkbox.field.addClass 'error'
					is_checked = false

		return is_checked

	testEmail: (id) =>

		is_correct = false

		email = @fields.find("input[name=#{id}]").val()
		pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		
		if pattern.test email
			is_correct = true
		else
			@getFieldById(id).addClass 'error'

		return is_correct

	###############
	# COMMUNICATION
	###############

	onCommunicationOpened: => 

		window.is_communicating = true
		@submit_btn.addClass 'disabled'

	onCommunicationClosed: => 

		window.is_communicating = false
		@submit_btn.removeClass 'disabled'

	############
	# ERROR MGMT
	############

	showErrorsOnFields: (id_array) =>

		for i in [0...id_array.length]
			id = id_array[i]
			@getFieldById(id).addClass 'error'

	getFieldById: (id) =>

		for i in [0...@inputs_array.length]
			input = @inputs_array[i]
			if input.id is id then field = input.field

		for i in [0...@checkboxes_array.length]
			checkbox = @checkboxes_array[i]
			if checkbox.id is id then field = checkbox.field

		return field

