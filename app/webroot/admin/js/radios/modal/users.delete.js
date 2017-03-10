$(function()
{
  var UserDeleteModal = admin.ModalFactory.create({
    type: 'delete',
    modal: '#userDeleteModal',
    btnModal: '.btn-delete-users',
    btnSubmit: '#userDeleteModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  UserDeleteModal.init();
});
