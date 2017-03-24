// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.Accordion = (function() {
    function Accordion(ref) {
      this.ref = ref;
      this.onToggleClick = __bind(this.onToggleClick, this);
      this.items = this.ref.find('.item-accordion');
      this.nitems = this.items.length;
      this.measures_array = [];
      this.duration = 1;
      this.getMeasures();
      this.setItems();
      this.ref.css({
        visibility: 'visible'
      });
    }

    Accordion.prototype.getMeasures = function() {
      var content, i, item, obj, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.nitems; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        item = $(this.items[i]);
        if (item.hasClass('js-no-content')) {
          obj = {
            h: 0,
            pt: 0,
            pb: 0
          };
        } else {
          content = item.find('.content-accordion');
          obj = {
            h: content.css('height'),
            pt: content.css('padding-top'),
            pb: content.css('padding-bottom')
          };
        }
        _results.push(this.measures_array.push(obj));
      }
      return _results;
    };

    Accordion.prototype.setItems = function() {
      var content, i, item, toggle, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.nitems; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        item = $(this.items[i]);
        content = item.find('.content-accordion');
        if (!item.hasClass('open')) {
          content.css({
            height: '0',
            'padding-top': '0',
            'padding-bottom': '0'
          });
        }
        if (item.hasClass('js-no-content')) {
          item.find('.open-accordion a .arrow').hide();
          if (content != null) {
            _results.push(content.css({
              height: '0',
              'padding-top': '0',
              'padding-bottom': '0'
            }));
          } else {
            _results.push(void 0);
          }
        } else {
          toggle = item.find('.open-accordion a');
          toggle.attr('data-num', i);
          _results.push(toggle.bind('click', this.onToggleClick));
        }
      }
      return _results;
    };

    Accordion.prototype.onToggleClick = function(e) {
      var item, num, toggle;
      e.preventDefault();
      toggle = $(e.currentTarget);
      num = toggle.attr('data-num');
      item = $(this.items[num]);
      if (item.hasClass('open')) {
        return this.closeItem(item);
      } else {
        return this.openItem(item);
      }
    };

    Accordion.prototype.openItem = function(item) {
      var content, m;
      this.closeItem(this.ref.find('.item-accordion.open'));
      item.addClass('open');
      content = item.find('.content-accordion');
      try {
        m = this.measures_array[item.index()];
        return TweenLite.to(content, this.duration, {
          css: {
            'height': m.h,
            'padding-top': m.pt,
            'padding-bottom': m.pb
          },
          delay: .2,
          ease: Power4.easeInOut
        });
      }
      catch(err) {
      }
    };

    Accordion.prototype.closeItem = function(item) {
      var content;
      content = $('.item-accordion.open .content-accordion');
      item.removeClass('open');
      if(content.length)
        return TweenLite.to(content, this.duration, {
          css: {
            'height': '0',
            'padding-top': '0',
            'padding-bottom': '0'
          },
          ease: Power4.easeInOut
        });
    };

    return Accordion;

  })();

}).call(this);
