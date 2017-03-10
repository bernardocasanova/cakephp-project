<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/radios.deactivate.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="radioDeactivateModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title"><?php echo __('Desativar rádio?'); ?></h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12 align-center">
                        <div class="alert alert-danger">
                            <strong>Aviso!</strong> Ao desativar a rádio você também irá bloquear os acessos futuros a ela.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="align-center col-md-12">
                        <p>Tem certeza que deseja desativar a rádio?</p>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="radioDeactivateModalBtnSubmit" class="btn btn-orange"><?php echo __('Desativar'); ?></button>

            </div>

        </div>

    </div>

</div>