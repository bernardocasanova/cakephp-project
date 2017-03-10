'use strict';

var admin = admin || {};

(function($, win) {

  var Modal = function(options) {
    // Required options
    this.$modal     = $(options.modal);
    this.$btnModal  = $(options.btnModal);
    this.$btnSubmit = $(options.btnSubmit);
    this.$btnClose  = options.btnClose ? $(options.btnClose) : null;

    this.type       = options.type;
    this.formModal  = options.formModal || null;
    this.callback   = options.callback || null;
    this.shouldPost = options.shouldPost === undefined ? true : options.shouldPost;
    this.method     = options.method || 'GET';
    this.onClose    = options.onClose || null;

    this.onAjaxSuccessMessage = options.onAjaxSuccessMessage || 'Ação realizada com sucesso';
    this.onAjaxErrorMessage   = options.onAjaxErrorMessage || 'Ocorreu um erro, tente novamente';
  };

  Modal.prototype.init = function() {
    // Bind stuff
    this.bindModalHideEvent();
    this.bindClickOnModalBtn();
    this.unlockBtnSubmit();
  };

  /*--------------------------------------------
  |                   Submit UI
   --------------------------------------------*/

  Modal.prototype.lockBtnSubmit = function() {
    this.$btnSubmit.attr('disabled', true);
  };

  Modal.prototype.unlockBtnSubmit = function() {
    this.$btnSubmit.attr('disabled', false);
  };

  Modal.prototype.bindClickOnSubmit = function() {
    var _this = this;

    this.$btnSubmit.on('click', function(e) {
      _this.handleSubmitClick();
    });
  };

  Modal.prototype.unbindClickOnSubmit = function() {
    this.$btnSubmit.unbind('click');
  };

  /*--------------------------------------------
  |                   Close UI
   --------------------------------------------*/

  Modal.prototype.bindClickOnClose = function() {
    if (this.$btnClose) {
      var _this = this;

      this.$btnClose.on('click', function(e) {
        _this.handleCloseClick();
      });
    }
  };

  Modal.prototype.unbindClickOnClose = function() {
    if (this.$btnClose) {
      this.$btnClose.unbind('click');
    }
  };

  Modal.prototype.handleCloseClick = function() {};

  /*--------------------------------------------
  |               Modal button UI
   --------------------------------------------*/

  Modal.prototype.bindClickOnModalBtn = function() {
    var _this = this;

    this.$btnModal.on('click', function(e) {
      e.preventDefault();
      _this.handleClickOnModalBtn(this);
    });
  };

  Modal.prototype.handleClickOnModalBtn = function(element) {
    this.$btnModal = $(element);
    this.$modal.modal();

    this.bindClickOnSubmit();
    this.bindClickOnClose();
  };

  /*--------------------------------------------
  |                 Hide modal
   --------------------------------------------*/

  Modal.prototype.bindModalHideEvent = function() {
    var _this = this;

    this.$modal.on('hidden.bs.modal', function() {
      _this.handleModalHideEvent();
    });
  };

  Modal.prototype.unbindModalHideEvent = function() {
    this.$modal.unbind('hidden.bs.modal');
  };

  Modal.prototype.handleModalHideEvent = function() {
    if (this.onClose) {
      this.onClose();
    }

    this.unbindClickOnSubmit();
    this.unbindClickOnClose();
  };



  /*--------------------------------------------
  |                Delete Modal
   --------------------------------------------*/

  var DeleteModal = function(options) {
      Modal.call(this, options);
  };

  DeleteModal.prototype = Object.create( Modal.prototype );

  DeleteModal.prototype.handleSubmitClick = function() {
    var _this     = this,
        btnData   = _this.$btnModal.data();

    _this.lockBtnSubmit();

    if (!_this.shouldPost) {
      if (_this.callback !== null) {
        _this.callback(_this);
      }

      _this.unlockBtnSubmit();
      _this.$modal.modal('hide');

      return;
    }

    $.ajax({
      type: _this.method,
      url: btnData.actionUri,
      success: admin.api.defaultAjaxSuccess(function(res) {
        admin.api.loader.hide(function() {
          if (res.data.httpStatusCode == 200) {
            admin.utils.notification.flash('success', _this.onAjaxSuccessMessage);

            _this.$btnModal.parent().parent().remove();
          }  else {
            admin.utils.notification.flash('error', _this.onAjaxErrorMessage);
          }

          _this.unlockBtnSubmit();
          _this.$modal.modal('hide');
        });
      })
    });
  };

  /*--------------------------------------------
  |                Update Modal
   --------------------------------------------*/

  var UpdateModal = function(options) {
      Modal.call(this, options);
  };

  UpdateModal.prototype = Object.create( Modal.prototype );

  UpdateModal.prototype.handleSubmitClick = function() {
    var _this     = this,
        btnData   = _this.$btnModal.data();

    _this.lockBtnSubmit();

    if (!_this.shouldPost) {
      if (_this.callback !== null) {
        _this.callback(_this);
      }

      _this.unlockBtnSubmit();
      _this.$modal.modal('hide');

      return;
    }

    _this.lockBtnSubmit();

    $.ajax({
      type: _this.method,
      url: btnData.actionUri,
      success: admin.api.defaultAjaxSuccess(function(res) {
        admin.api.loader.hide(function() {
          if (res.data.httpStatusCode == 200) {
            // TODO: use a better way to update table and show notification
            window.location.reload();
          }  else {
            admin.utils.notification.flash('error', _this.onAjaxErrorMessage);
          }

          _this.unlockBtnSubmit();
          _this.$modal.modal('hide');
        });
      })
    });
  };

  /*--------------------------------------------
  |                Create Modal
   --------------------------------------------*/

  var CreateModal = function(options) {
      Modal.call(this, options);
  };

  CreateModal.prototype = Object.create( Modal.prototype );

  CreateModal.prototype.handleSubmitClick = function() {

    var _this     = this,
        btnData   = _this.$btnModal.data(),
        data      = $(_this.formModal).serialize();

    _this.lockBtnSubmit();

    if (!$(_this.formModal).valid()) {
      return;
    }

    if (!_this.shouldPost) {
      if (_this.callback !== null) {
        _this.callback($(_this.formModal).serializeObject());
      }

      _this.unlockBtnSubmit();
      _this.$modal.modal('hide');

      return;
    }

    $.ajax({
      type: _this.method,
      url: btnData.actionUri + '.json',
      data: data,
      success: admin.api.defaultAjaxSuccess(function(res) {
        admin.api.loader.hide(function() {
          if (res.status == 'ok') {
            admin.utils.notification.flash('success', _this.onAjaxSuccessMessage);

            if (_this.callback !== null) {
              _this.callback(res);
            }

          }  else {
            admin.utils.notification.flash('error', _this.onAjaxErrorMessage);
          }

          _this.unlockBtnSubmit();
          _this.$modal.modal('hide');
        });
      })
    });
  };

  /*--------------------------------------------
  |                Modal Factory
   --------------------------------------------*/

  var ModalFactory = function() {};

  ModalFactory.prototype.create = function(params) {
    switch (params.type) {
      case 'delete':
        this.modalClass = DeleteModal;
        break;

      case 'activate':
        this.modalClass = UpdateModal;
        break;

      case 'deactivate':
        this.modalClass = UpdateModal;
        break;

      case 'create':
        this.modalClass = CreateModal;
        break;
    }

    return new this.modalClass(params);
  };

  admin.ModalFactory = new ModalFactory();

})(jQuery, window);

function redirectToActionUri(that)
{
  window.location.href = $(that.$btnModal).data('actionUri');
}

$.fn.serializeObject = function()
{
  var o = {};
  var a = this.serializeArray();

  $.each(a, function()
  {
    if (o[this.name] !== undefined) {
      if (!o[this.name].push) {
        o[this.name] = [o[this.name]];
      }
      o[this.name].push(this.value || '');
    } else {
      o[this.name] = this.value || '';
    }
  });

  return o;
};
