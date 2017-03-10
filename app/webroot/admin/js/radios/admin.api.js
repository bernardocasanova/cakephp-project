'use strict';

var admin = admin || {};

var APIModule = (function($, win) {

  var module = {};

  var _ajaxSetup = function() {
    $.ajaxSetup({
      cache: false,
      error: function(jqObj, textStatus, errorThrown) {
        module.defaultAjaxError(jqObj, textStatus, errorThrown);
      }
    });
  };

  module.initialize = function() {
    _ajaxSetup();
  };

  module.defaultAjaxSuccess = function(callback) {
    var _this = this;

    return function(response) {
      if (response && callback) {
        if (typeof(response) === 'string') {
          response = JSON.parse(response);
        }

        callback(response);
      }
    };
  };

  module.defaultAjaxError = function(jqObj, textStatus, errorThrown) {
    this.loader.hide();

    if (console && console.log) {
      console.log(jqObj, textStatus, errorThrown);
    }
  };

  module.loader = {
    show: function(callback) {
      show_loading_bar({
        pct: 40 + Math.round(Math.random() * 30),
        finish: function(pct) {
          if (callback) {
            callback(pct);
          }
        }
      });
    },

    hide: function(callback) {
      show_loading_bar({
        pct: 100,
        delay: 1.5,
        finish: function(pct) {
          if (callback) {
            callback();
          }
        }
      });
    }
  };

  admin.api = module;

  $(win).ready(function() {
    admin.api.initialize();
  });

})(jQuery, window);
