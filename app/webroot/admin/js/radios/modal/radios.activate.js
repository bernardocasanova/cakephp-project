$(function()
{
  var RadioActivateModal = admin.ModalFactory.create({
    type: 'activate',
    modal: '#radioActivateModal',
    btnModal: '.btn-activate-radios',
    btnSubmit: '#radioActivateModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  RadioActivateModal.init();
});
