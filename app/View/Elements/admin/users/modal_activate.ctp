<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/users.activate.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="userActivateModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"><?php echo __('Ativar usuário'); ?></h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 align-center">
                        <div class="alert alert-info">
                            <strong>Dica!</strong> Ativar o usuário irá reestabelecer os acessos dele.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="align-center col-md-12">
                        <p>Tem certeza que deseja ativar o usuário?</p>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="userActivateModalBtnSubmit" class="btn btn-success"><?php echo __('Ativar'); ?></button>

            </div>

        </div>

    </div>

</div>
