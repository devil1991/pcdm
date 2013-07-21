// Generated by CoffeeScript 1.6.3
(function() {
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  window.FilteredGrid = (function() {
    function FilteredGrid(ref) {
      this.ref = ref;
      this.onDataError = __bind(this.onDataError, this);
      this.onDataLoaded = __bind(this.onDataLoaded, this);
      this.updateFilters = __bind(this.updateFilters, this);
      this.closeFilters = __bind(this.closeFilters, this);
      this.disableFilters = __bind(this.disableFilters, this);
      this.enableFilters = __bind(this.enableFilters, this);
      this.onFilterUpdated = __bind(this.onFilterUpdated, this);
      this.resetFilters = __bind(this.resetFilters, this);
      this.is_dev = this.ref.hasClass('js-dev');
      this.filters = this.ref.find('.wrap-filter');
      this.reset = this.ref.find('a.clear');
      this.grid = this.ref.find('.js-grid');
      this.items = this.grid.find('.item');
      this.cols = 4;
      event_emitter.addListener('ENABLE_FILTERS', this.enableFilters);
      event_emitter.addListener('DISABLE_FILTERS', this.disableFilters);
      event_emitter.addListener('CLOSE_FILTERS', this.closeFilters);
      if (this.filters.length > 0) {
        this.filters_tot = this.filters.length;
        this.filters_array = [];
        this.setFilters();
      }
      this.reset.bind('click', this.resetFilters);
      this.items_tot = this.items.length;
      this.items_array = [];
      this.setItems();
    }

    FilteredGrid.prototype.setFilters = function() {
      var i, instance, param, ref, _i, _ref, _results;
      event_emitter.addListener('FILTER_UPDATED', this.onFilterUpdated);
      _results = [];
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        ref = $(this.filters[i]);
        param = ref.attr('data-filter');
        instance = new FilterDropdown(ref, param);
        _results.push(this.filters_array.push({
          param: param,
          value: '',
          instance: instance
        }));
      }
      return _results;
    };

    FilteredGrid.prototype.resetFilters = function() {
      var i, is_enabled, _i, _ref;
      is_enabled = true;
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        if (this.filters_array[i].instance.is_enabled === false) {
          is_enabled = false;
        }
      }
      if (is_enabled) {
        this.disableFilters();
        return this.loadData(true);
      }
    };

    FilteredGrid.prototype.onFilterUpdated = function(param, value) {
      return this.loadData();
    };

    FilteredGrid.prototype.enableFilters = function() {
      var i, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        _results.push(this.filters_array[i].instance.enableFilter());
      }
      return _results;
    };

    FilteredGrid.prototype.disableFilters = function() {
      var i, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        _results.push(this.filters_array[i].instance.disableFilter());
      }
      return _results;
    };

    FilteredGrid.prototype.closeFilters = function(param) {
      var filter, i, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        filter = this.filters_array[i].instance;
        if (filter.is_opened && filter.param !== param) {
          _results.push(filter.closeList());
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };

    FilteredGrid.prototype.updateFilters = function(show_array) {
      var filter, i, j, obj, param, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = show_array.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        obj = show_array[i];
        param = obj['filter'];
        _results.push((function() {
          var _j, _ref1, _results1;
          _results1 = [];
          for (j = _j = 0, _ref1 = this.filters_tot; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; j = 0 <= _ref1 ? ++_j : --_j) {
            filter = this.filters_array[j];
            if (filter.param === param) {
              _results1.push(filter.instance.initFilter(obj));
            } else {
              _results1.push(void 0);
            }
          }
          return _results1;
        }).call(this));
      }
      return _results;
    };

    FilteredGrid.prototype.setItems = function() {
      var i, id, ref, _i, _ref, _results;
      _results = [];
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        ref = $(this.items[i]);
        id = ref.attr('data-id');
        this.items_array.push({
          id: id,
          ref: ref
        });
        if ((i + 1) % this.cols === 0) {
          _results.push(ref.addClass('last'));
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };

    FilteredGrid.prototype.updateItems = function(show_array) {
      var cnt, delay, i, id, item, j, _i, _j, _ref, _ref1, _results;
      for (i = _i = 0, _ref = this.items_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        this.items_array[i].ref.removeClass('last').hide();
      }
      cnt = 0;
      delay = 0;
      _results = [];
      for (i = _j = 0, _ref1 = show_array.length; 0 <= _ref1 ? _j < _ref1 : _j > _ref1; i = 0 <= _ref1 ? ++_j : --_j) {
        id = show_array[i];
        _results.push((function() {
          var _k, _ref2, _results1;
          _results1 = [];
          for (j = _k = 0, _ref2 = this.items_tot; 0 <= _ref2 ? _k < _ref2 : _k > _ref2; j = 0 <= _ref2 ? ++_k : --_k) {
            item = this.items_array[j];
            if (item.id === id) {
              if ((cnt + 1) % this.cols === 0) {
                item.ref.addClass('last');
              }
              item.ref.css({
                opacity: '0'
              }).show();
              TweenLite.to(item.ref, 1, {
                css: {
                  'opacity': '1'
                },
                delay: delay,
                ease: Power4.easeInOut
              });
              cnt++;
              _results1.push(delay += .25);
            } else {
              _results1.push(void 0);
            }
          }
          return _results1;
        }).call(this));
      }
      return _results;
    };

    FilteredGrid.prototype.loadData = function(is_reset) {
      var data_path, filter, i, obj, _i, _ref;
      if (is_reset == null) {
        is_reset = false;
      }
      obj = {
        action: 'press'
      };
      for (i = _i = 0, _ref = this.filters_tot; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
        filter = this.filters_array[i];
        obj[filter.param] = is_reset ? '' : filter.instance.value;
      }
      console.log(obj);
      if (this.is_dev) {
        data_path = '../public/json/press.json';
        return $.getJSON(data_path, this.onDataLoaded);
      } else {
        return $.ajax({
          type: 'POST',
          url: '/wp-admin/admin-ajax.php',
          data: obj,
          success: this.onDataLoaded,
          error: this.onDataError
        });
      }
    };

    FilteredGrid.prototype.onDataLoaded = function(json) {
      if (this.filters.length > 0) {
        this.updateFilters(json.filters);
      }
      this.updateItems(json.items);
      return this.enableFilters();
    };

    FilteredGrid.prototype.onDataError = function() {
      return this.enableFilters();
    };

    return FilteredGrid;

  })();

}).call(this);
