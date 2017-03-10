<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/radios.delete.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="radioDeleteModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title">Deletar rádio?</h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger align-center">
                            <strong>Aviso!</strong> Todos os dados relacionados a rádio serão deletados e não haverá como recuperá-los.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info align-center">
                            <strong>Dica!</strong> A Rádio pode ser desativada em vez de deletada. Assim, futuramente ela pode ser reativada!
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="radioDeleteModalBtnSubmit" class="btn btn-danger"><?php echo __('Deletar'); ?></button>

            </div>

        </div>

    </div>

</div>
