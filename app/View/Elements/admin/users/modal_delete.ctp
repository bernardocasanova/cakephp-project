<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/users.delete.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="userDeleteModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title">Deletar usuário</h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger align-center">
                            <strong>Aviso!</strong> Todos os dados relacionados ao usuário serão deletados e não haverá como recuperá-los.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info align-center">
                            <strong>Dica!</strong> O usuário pode ser desativado em vez de deletado. Assim, futuramente ele pode ser reativado!
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="userDeleteModalBtnSubmit" class="btn btn-danger"><?php echo __('Deletar'); ?></button>

            </div>

        </div>

    </div>

</div>
