$(function()
{
  var RadioDeactivateModal = admin.ModalFactory.create({
    type: 'deactivate',
    modal: '#radioDeactivateModal',
    btnModal: '.btn-deactivate-radios',
    btnSubmit: '#radioDeactivateModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  RadioDeactivateModal.init();
});
