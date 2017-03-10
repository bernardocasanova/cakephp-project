$(function()
{
  var UserDeactivateModal = admin.ModalFactory.create({
    type: 'deactivate',
    modal: '#userDeactivateModal',
    btnModal: '.btn-deactivate-users',
    btnSubmit: '#userDeactivateModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  UserDeactivateModal.init();
});
