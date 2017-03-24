// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.FilterDropdown = (function() {
    function FilterDropdown(ref, param) {
      this.ref = ref;
      this.param = param;
      this.closeList = __bind(this.closeList, this);
      this.openList = __bind(this.openList, this);
      this.onItemClick = __bind(this.onItemClick, this);
      this.onButtonClick = __bind(this.onButtonClick, this);
      this.disableFilter = __bind(this.disableFilter, this);
      this.enableFilter = __bind(this.enableFilter, this);
      this.initFilter = __bind(this.initFilter, this);
      this.btn = this.ref.find('dt');
      this.label = this.btn.find('span');
      this.list = this.ref.find('dd');
      this.item_template = $(this.list.find('>ul >li')[0]);
      this.value = '';
      this.dur = .8;
      this.initFilter();
    }

    FilterDropdown.prototype.initFilter = function(obj) {
      var array, el, i, item, link, _i, _ref;
      this.list.css({
        visibility: 'hidden',
        opacity: '0'
      });
      if (obj !== void 0) {
        this.updateLabel(obj.label);
        this.list.find('>ul >li').remove();
        array = obj.list;
        if (array.length > 0) {
          this.btn.removeClass('disabled');
          for (i = _i = 0, _ref = array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
            el = array[i];
            item = this.item_template.clone();
            link = item.find('>a');
            link.attr('data-value', el.value);
            link.text(el.label);
            this.list.find('>ul').append(item);
          }
        } else {
          this.btn.addClass('disabled');
        }
      }
      this.btn.removeClass('opened');
      this.is_opened = false;
      this.is_enabled = true;
      return this.setInteractions();
    };

    FilterDropdown.prototype.enableFilter = function() {
      return this.is_enabled = true;
    };

    FilterDropdown.prototype.disableFilter = function() {
      return this.is_enabled = false;
    };

    FilterDropdown.prototype.setInteractions = function() {
      this.btn.bind('click', this.onButtonClick);
      return this.list.find('>ul >li >a').bind('click', this.onItemClick);
    };

    FilterDropdown.prototype.onButtonClick = function(e) {
      e.preventDefault();
      if (!this.btn.hasClass('disabled')) {
        if (this.is_opened) {
          return this.closeList();
        } else {
          return this.openList();
        }
      }
    };

    FilterDropdown.prototype.onItemClick = function(e) {
      var item;
      e.preventDefault();
      if (this.is_enabled) {
        event_emitter.emitEvent('DISABLE_FILTERS');
        item = $(e.currentTarget);
        this.value = item.attr('data-value');
        this.updateLabel(item.text());
        return this.closeList(true);
      }
    };

    FilterDropdown.prototype.updateLabel = function(str) {
      return this.label.text(str);
    };

    FilterDropdown.prototype.openList = function() {
      var _this = this;
      if (this.is_enabled) {
        this.btn.addClass('opened');
        this.list.css({
          visibility: 'visible'
        });
        return TweenLite.to(this.list, this.dur, {
          css: {
            'opacity': '1'
          },
          ease: Power4.easeInOut,
          onComplete: (function() {
            return _this.is_opened = true;
          })
        });
      }
    };

    FilterDropdown.prototype.closeList = function(is_updating) {
      var _this = this;
      if (is_updating == null) {
        is_updating = false;
      }
      if (is_updating) {
        event_emitter.emitEvent('CLOSE_FILTERS', [this.param]);
      }
      this.btn.removeClass('opened');
      return TweenLite.to(this.list, this.dur, {
        css: {
          'opacity': '0'
        },
        ease: Power4.easeInOut,
        onComplete: (function() {
          _this.list.css({
            visibility: 'hidden'
          });
          _this.is_opened = false;
          if (is_updating) {
            return event_emitter.emitEvent('FILTER_UPDATED', [_this.param, _this.value]);
          }
        })
      });
    };

    return FilterDropdown;

  })();

}).call(this);
