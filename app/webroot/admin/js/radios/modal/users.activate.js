$(function()
{
  var UserActivateModal = admin.ModalFactory.create({
    type: 'activate',
    modal: '#userActivateModal',
    btnModal: '.btn-activate-users',
    btnSubmit: '#userActivateModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  UserActivateModal.init();
});
