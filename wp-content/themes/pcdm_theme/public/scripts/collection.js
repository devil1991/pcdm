// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.Collection = (function() {
    function Collection(grid_ref, details_ref) {
      var init_id;
      this.grid_ref = grid_ref;
      this.details_ref = details_ref;
      this.onResize = __bind(this.onResize, this);
      this.onDetailsHidden = __bind(this.onDetailsHidden, this);
      this.showDetails = __bind(this.showDetails, this);
      this.onItemClick = __bind(this.onItemClick, this);
      this.switchToGrid = __bind(this.switchToGrid, this);
      this.updateDetails = __bind(this.updateDetails, this);
      this.switchToDetails = __bind(this.switchToDetails, this);
      this.onHistoryStateChange = __bind(this.onHistoryStateChange, this);
      this.is_dev = this.grid_ref.hasClass('js-dev');
      this.category = this.grid_ref.attr('data-category');
      init_id = this.grid_ref.attr('data-init-id');
      this.wrapper = $('#wrapper');
      this.header = this.grid_ref.find('.header-product-grid');
      this.boxes = this.grid_ref.find('.item');
      this.items_array = [];
      this.items_tot;
      this.current_id = (init_id != null) && init_id !== '' ? init_id : '';
      this.details;
      window.is_switching = false;
      event_emitter.addListener('SWITCH_TO_DETAILS', this.switchToDetails);
      event_emitter.addListener('UPDATE_DETAILS', this.updateDetails);
      event_emitter.addListener('SWITCH_TO_GRID', this.switchToGrid);
      event_emitter.addListener('DETAILS_HIDDEN', this.onDetailsHidden);
      this.setGrid();
      this.setDetails();
      this.has_history = false;
      this.prev_state_id = 'home';
      if (!this.is_dev) {
        this.setHistory();
      }
    }

    Collection.prototype.setHistory = function() {
      if (!History.enabled) {
        return false;
      }
      this.has_history = true;
      History.Adapter.bind(window, 'statechange', this.onHistoryStateChange);
      History.replaceState({
        state: 'home'
      }, '', "/" + this.category);
      if (this.current_id !== '') {
        return event_emitter.emitEvent('SWITCH_TO_DETAILS');
      }
    };

    Collection.prototype.onHistoryStateChange = function() {
      var State, state_id;
      State = History.getState();
      state_id = State.data.state;
      console.log('state --> ', state_id);
      if (state_id !== this.prev_state_id) {
        this.prev_state_id = state_id;
        if (state_id === 'home') {
          this.hideDetails();
        } else {
          if (this.wrapper.hasClass('detail-on')) {
            this.showDetails();
          } else {
            this.dismantleGrid();
          }
        }
        return event_emitter.emitEvent('UPDATE_SHARING_DATA', [State.url]);
      }
    };

    Collection.prototype.switchToDetails = function() {
      if (this.has_history) {
        History.pushState({
          state: this.current_id
        }, '', "/" + this.category + "/" + this.current_id);
        return event_emitter.addListener('SWITCH_TO_GRID', this.switchToGrid);
      } else {
        return this.dismantleGrid();
      }
    };

    Collection.prototype.updateDetails = function(id) {
      this.current_id = id;
      if (this.has_history) {
        History.pushState({
          state: this.current_id
        }, '', "/" + this.category + "/" + this.current_id);
        return event_emitter.addListener('SWITCH_TO_GRID', this.switchToGrid);
      } else {
        return this.showDetails();
      }
    };

    Collection.prototype.switchToGrid = function() {
      if (this.has_history) {
        History.pushState({
          state: 'home'
        }, '', "/" + this.category);
        return event_emitter.addListener('SWITCH_TO_DETAILS', this.switchToDetails);
      } else {
        return this.hideDetails();
      }
    };

    Collection.prototype.setGrid = function() {
      var box, i, id, item, items, j, offset, _i, _j, _ref, _ref1;
      for (i = _i = 0, _ref = this.boxes.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        box = $(this.boxes[i]);
        offset = box.offset().top;
        items = box.find('a');
        for (j = _j = 0, _ref1 = items.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; j = 0 <= _ref1 ? ++_j : --_j) {
          item = $(items[j]);
          id = item.attr('data-id');
          this.items_array.push({
            id: id,
            ref: item,
            offset: offset
          });
          item.bind('click', this.onItemClick);
        }
      }
      return this.items_tot = this.items_array.length;
    };

    Collection.prototype.onItemClick = function(e) {
      var item;
      e.preventDefault();
      if (!is_switching) {
        window.is_switching = true;
        item = $(e.currentTarget);
        this.current_id = item.attr('data-id');
        return event_emitter.emitEvent('SWITCH_TO_DETAILS');
      }
    };

    Collection.prototype.dismantleGrid = function() {
      var delay, i, item, _i, _ref;
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        item = this.items_array[i].ref;
        delay = .25 * (this.items_tot - 1 - i);
        TweenLite.to(item, 1, {
          css: {
            'opacity': '0'
          },
          delay: delay,
          ease: Power4.easeInOut
        });
      }
      TweenLite.to(this.header, 2, {
        css: {
          'opacity': '0'
        },
        ease: Power4.easeInOut
      });
      return TweenLite.to(window, 2, {
        scrollTo: {
          y: 0
        },
        ease: Power4.easeInOut,
        onComplete: this.showDetails
      });
    };

    Collection.prototype.rebuildGrid = function() {
      var delay, i, item, _i, _ref;
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        item = this.items_array[i].ref;
        delay = .25 * i;
        TweenLite.to(item, 1, {
          css: {
            'opacity': '1'
          },
          delay: delay,
          ease: Power4.easeInOut
        });
      }
      TweenLite.to(this.header, 2, {
        css: {
          'opacity': '1'
        },
        ease: Power4.easeInOut
      });
      return TweenLite.to(window, 2, {
        scrollTo: {
          y: this.getScrollById()
        },
        ease: Power4.easeInOut,
        onComplete: (function() {
          return window.is_switching = false;
        })
      });
    };

    Collection.prototype.getScrollById = function() {
      var i, item, offset, _i, _ref;
      offset = 0;
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        item = this.items_array[i];
        if (item.id === this.current_id) {
          offset = item.offset;
        }
      }
      return offset;
    };

    Collection.prototype.setDetails = function() {
      var i, id, id_array, _i, _ref;
      id_array = [];
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        id = this.items_array[i].id;
        id_array.push(id);
      }
      return this.details = new CollectionDetails(this.details_ref, id_array, this.is_dev);
    };

    Collection.prototype.showDetails = function() {
      if (!this.wrapper.hasClass('detail-on')) {
        this.wrapper.addClass('detail-on');
        this.grid_ref.hide();
      }
      return this.details.updateContents(this.current_id);
    };

    Collection.prototype.hideDetails = function() {
      return this.details.removeContents();
    };

    Collection.prototype.onDetailsHidden = function(id) {
      this.current_id = id;
      this.wrapper.removeClass('detail-on');
      this.grid_ref.show();
      return this.rebuildGrid();
    };

    Collection.prototype.onResize = function(window_w, window_h) {
      if (this.details) {
        return this.details.onResize(window_w, window_h);
      }
    };

    return Collection;

  })();

}).call(this);
