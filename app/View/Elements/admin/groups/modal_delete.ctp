<?php

// Load modal scripts dependencies.
$this->Html->script(array(
    '/admin/js/radios/modal/groups.delete.js'
    ), array('block' => 'script')
);

?>

<div class="modal fade" id="groupDeleteModal" aria-hidden="true" style="display: none;">

    <div class="modal-dialog" style="width: 40%;">

        <div class="modal-content">

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <h4 class="modal-title">Deletar grupo?</h4>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-danger align-center">
                            <strong>Aviso!</strong> O grupo será deletado e não será possível recuperá-lo. Para sua segurança, todos os usuários desse grupo serão vinculados a um grupo temporário sem nenhuma permissão de acesso.<br>
                            <strong>Não esqueça de editá-los!</strong>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __('Cancelar'); ?></button>
                <button type="button" id="groupDeleteModalBtnSubmit" class="btn btn-danger"><?php echo __('Deletar'); ?></button>

            </div>

        </div>

    </div>

</div>
