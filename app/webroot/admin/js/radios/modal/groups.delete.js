$(function()
{
  var GroupDeleteModal = admin.ModalFactory.create({
    type: 'delete',
    modal: '#groupDeleteModal',
    btnModal: '.btn-delete-groups',
    btnSubmit: '#groupDeleteModalBtnSubmit',
    shouldPost: false,
    callback: redirectToActionUri
  });

  GroupDeleteModal.init();
});
