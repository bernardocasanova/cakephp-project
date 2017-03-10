$(function()
{
  var RadioDeleteModal = admin.ModalFactory.create({
    type: 'delete',
    modal: '#radioDeleteModal',
    btnModal: '.btn-delete-radios',
    btnSubmit: '#radioDeleteModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  RadioDeleteModal.init();
});
