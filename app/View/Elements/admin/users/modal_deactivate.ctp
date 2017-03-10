<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/users.deactivate.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="userDeactivateModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"><?php echo __('Desativar usuário'); ?></h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 align-center">
                        <div class="alert alert-danger">
                            <strong>Aviso!</strong> Ao desativar o cliente você também irá bloquear os acessos futuros dele.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="align-center col-md-12">
                        <p>Tem certeza que deseja desativar o usuário?</p>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="userDeactivateModalBtnSubmit" class="btn btn-orange"><?php echo __('Desativar'); ?></button>

            </div>

        </div>

    </div>

</div>