// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.Newsletter = (function() {
    function Newsletter(ref) {
      this.ref = ref;
      this.getFieldById = __bind(this.getFieldById, this);
      this.showErrorsOnFields = __bind(this.showErrorsOnFields, this);
      this.onCommunicationClosed = __bind(this.onCommunicationClosed, this);
      this.onCommunicationOpened = __bind(this.onCommunicationOpened, this);
      this.testEmail = __bind(this.testEmail, this);
      this.testIsChecked = __bind(this.testIsChecked, this);
      this.testIsFilled = __bind(this.testIsFilled, this);
      this.onDataSaved = __bind(this.onDataSaved, this);
      this.saveData = __bind(this.saveData, this);
      this.onFormSubmit = __bind(this.onFormSubmit, this);
      this.onCheckboxFocus = __bind(this.onCheckboxFocus, this);
      this.onInputBlur = __bind(this.onInputBlur, this);
      this.onInputFocus = __bind(this.onInputFocus, this);
      this.form = this.ref.find('form');
      this.fields = this.form.find('.campi');
      this.submit_btn = this.form.find('input:submit');
      this.thanks = this.ref.find('>.feedback');
      this.inputs_array = [];
      this.checkboxes_array = [];
      this.elements = [];
      event_emitter.addListener('COMMUNICATION_OPENED', this.onCommunicationOpened);
      event_emitter.addListener('COMMUNICATION_CLOSED', this.onCommunicationClosed);
      this.setElements();
      this.setInteractions();
    }

    Newsletter.prototype.setElements = function() {
      var checkboxes, field, i, id, inputs, is_required, ref, textarea, _i, _j, _k, _ref, _ref1, _ref2, _results;
      inputs = this.fields.find('input:text');
      textarea = this.fields.find('textarea');
      for (i = _i = 0, _ref = textarea.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        inputs.push(textarea[i]);
      }
      for (i = _j = 0, _ref1 = inputs.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; i = 0 <= _ref1 ? ++_j : --_j) {
        ref = $(inputs[i]);
        field = ref.parent();
        id = ref.attr('name');
        is_required = ref.hasClass('js-required');
        ref.attr('data-default', ref.attr('value'));
        this.inputs_array.push({
          id: id,
          ref: ref,
          field: field,
          is_required: is_required
        });
      }
      checkboxes = this.fields.find('input:checkbox');
      _results = [];
      for (i = _k = 0, _ref2 = checkboxes.length; 0 <= _ref2 ? _k < _ref2 : _k > _ref2; i = 0 <= _ref2 ? ++_k : --_k) {
        ref = $(checkboxes[i]);
        field = ref.parent().parent();
        id = ref.attr('name');
        is_required = ref.hasClass('js-required');
        _results.push(this.checkboxes_array.push({
          id: id,
          ref: ref,
          field: field,
          is_required: is_required
        }));
      }
      return _results;
    };

    Newsletter.prototype.setInteractions = function() {
      var checkbox, i, input, _i, _j, _ref, _ref1;
      for (i = _i = 0, _ref = this.inputs_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        input = this.inputs_array[i].ref;
        input.live('focus', this.onInputFocus).live('blur', this.onInputBlur);
      }
      for (i = _j = 0, _ref1 = this.checkboxes_array.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; i = 0 <= _ref1 ? ++_j : --_j) {
        checkbox = this.checkboxes_array[i].ref;
        checkbox.change(this.onCheckboxFocus);
      }
      return this.form.bind('submit', this.onFormSubmit);
    };

    Newsletter.prototype.onInputFocus = function(e) {
      var field, input;
      input = $(e.currentTarget);
      if (input.val() === input.attr('data-default')) {
        input.val('');
      }
      field = this.getFieldById(input.attr('name'));
      if (field.hasClass('error')) {
        return field.removeClass('error');
      }
    };

    Newsletter.prototype.onInputBlur = function(e) {
      var input;
      input = $(e.currentTarget);
      if (input.val().replace(/\s+/g, '') === '') {
        return input.val(input.attr('data-default'));
      }
    };

    Newsletter.prototype.onCheckboxFocus = function(e) {
      var checkbox, field;
      checkbox = $(e.currentTarget);
      field = this.getFieldById(checkbox.attr('name'));
      if (field.hasClass('error')) {
        return field.removeClass('error');
      }
    };

    Newsletter.prototype.onFormSubmit = function(e) {
      var is_ok, ok_checked, ok_email, ok_filled;
      e.preventDefault();
      is_ok = false;
      ok_filled = this.testIsFilled();
      ok_checked = this.testIsChecked();
      if (ok_filled && ok_checked) {
        ok_email = this.testEmail('email');
        if (ok_email) {
          is_ok = true;
        }
      }
      if (is_ok) {
        return this.collectData();
      }
    };

    Newsletter.prototype.collectData = function() {
      var checkbox, data, i, input, val, _i, _j, _ref, _ref1;
      data = {};
      for (i = _i = 0, _ref = this.inputs_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        input = this.inputs_array[i];
        val = input.ref.val();
        if (val === input.ref.attr('data-default')) {
          val = '';
        }
        data[input.id] = val;
      }
      for (i = _j = 0, _ref1 = this.checkboxes_array.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; i = 0 <= _ref1 ? ++_j : --_j) {
        checkbox = this.checkboxes_array[i];
        data[checkbox.id] = checkbox.ref.is(':checked');
      }
      return this.saveData(data);
    };

    Newsletter.prototype.saveData = function(data) {
      var url;
      if (!window.is_communicating) {
        event_emitter.emitEvent('COMMUNICATION_OPENED');
        url = this.form.attr('data-send');
        return $.ajax({
          type: 'POST',
          url: url,
          data: data,
          dataType: "json",
          success: this.onDataSaved,
          error: (function() {
            return event_emitter.emitEvent('COMMUNICATION_CLOSED');
          })
        });
      }
    };

    Newsletter.prototype.onDataSaved = function(response) {
      event_emitter.emitEvent('COMMUNICATION_CLOSED');
      if (response.success === 1) {
        return this.onSuccess();
      } else {
        return this.onError(response.error, response.msg);
      }
    };

    Newsletter.prototype.onSuccess = function() {
      this.thanks.css({
        visibility: 'visible'
      });
      return this.form.css({
        visibility: 'hidden'
      });
    };

    Newsletter.prototype.onError = function(error, msg) {
      if ((error != null) && error.length > 0) {
        this.showErrorsOnFields(error);
      }
      if ((msg != null) && msg !== '') {
        return alert(msg);
      }
    };

    Newsletter.prototype.testIsFilled = function() {
      var i, input, is_filled, nchars, _i, _ref;
      is_filled = true;
      for (i = _i = 0, _ref = this.inputs_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        input = this.inputs_array[i];
        if (input.is_required) {
          nchars = input.ref.val().replace(/\s+/g, '').length;
          if (nchars === 0) {
            input.field.addClass('error');
            is_filled = false;
          }
          if (input.ref.val() === input.ref.attr('data-default')) {
            input.field.addClass('error');
            is_filled = false;
          }
        }
      }
      return is_filled;
    };

    Newsletter.prototype.testIsChecked = function() {
      var checkbox, i, is_checked, _i, _ref;
      is_checked = true;
      for (i = _i = 0, _ref = this.checkboxes_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        checkbox = this.checkboxes_array[i];
        if (checkbox.is_required) {
          if (!checkbox.ref.is(':checked')) {
            checkbox.field.addClass('error');
            is_checked = false;
          }
        }
      }
      return is_checked;
    };

    Newsletter.prototype.testEmail = function(id) {
      var email, is_correct, pattern;
      is_correct = false;
      email = this.fields.find("input[name=" + id + "]").val();
      pattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      if (pattern.test(email)) {
        is_correct = true;
      } else {
        this.getFieldById(id).addClass('error');
      }
      return is_correct;
    };

    Newsletter.prototype.onCommunicationOpened = function() {
      window.is_communicating = true;
      return this.submit_btn.addClass('disabled');
    };

    Newsletter.prototype.onCommunicationClosed = function() {
      window.is_communicating = false;
      return this.submit_btn.removeClass('disabled');
    };

    Newsletter.prototype.showErrorsOnFields = function(id_array) {
      var i, id, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = id_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        id = id_array[i];
        _results.push(this.getFieldById(id).addClass('error'));
      }
      return _results;
    };

    Newsletter.prototype.getFieldById = function(id) {
      var checkbox, field, i, input, _i, _j, _ref, _ref1;
      for (i = _i = 0, _ref = this.inputs_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        input = this.inputs_array[i];
        if (input.id === id) {
          field = input.field;
        }
      }
      for (i = _j = 0, _ref1 = this.checkboxes_array.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; i = 0 <= _ref1 ? ++_j : --_j) {
        checkbox = this.checkboxes_array[i];
        if (checkbox.id === id) {
          field = checkbox.field;
        }
      }
      return field;
    };

    return Newsletter;

  })();

}).call(this);
