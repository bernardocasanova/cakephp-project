<?php

// Load page scripts dependencies.
$this->Html->script(array(
    // Plugins
    '/admin/js/jquery.dataTables.min.js',
    '/admin/js/datatables/TableTools.min.js',
    '/admin/js/dataTables.bootstrap.js',
    '/admin/js/datatables/jquery.dataTables.columnFilter.js',
    '/admin/js/datatables/lodash.min.js',
    '/admin/js/datatables/responsive/js/datatables.responsive.js',

    // View
    '/admin/js/radios/admin.modal-factory.js',
    '/admin/js/radios/datatables.init.js'
    ), array('block' => 'script')
);

// Load page css dependencies.
$this->Html->css(array(
    // Plugins
    '/admin/js/datatables/responsive/css/datatables.responsive.css',
    ), array('block' => 'css')
);

$this->append('modals');
    echo $this->element('admin/users/modal_delete');
    echo $this->element('admin/users/modal_activate');
    echo $this->element('admin/users/modal_deactivate');
$this->end();

?>

<h3><?php echo $title; ?></h3>
<br />

<?php

$optionsCreateUser = array(
    'Cadastrar usuário' => array(
        'controller' => 'users',
        'action'     => 'create'
    )
);

echo $this->Buttons->add($optionsCreateUser);

?>

<table class="table table-bordered datatable default-datatable">

    <thead>

        <tr class="replace-inputs">
            <th><?php echo __('e-mail'); ?></th>
            <th><?php echo __('status'); ?></th>
            <th><?php echo __('grupo'); ?></th>
            <th><?php echo __('criado em'); ?></th>
            <th><?php echo __('modificado em'); ?></th>
            <th data-disable="true"></th>
        </tr>

        <tr>
            <th><?php echo __('E-mail'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <th><?php echo __('Grupo'); ?></th>
            <th><?php echo __('Criado em'); ?></th>
            <th><?php echo __('Modificado em'); ?></th>
            <th><?php echo __('Ações'); ?></th>
        </tr>

    </thead>

    <tbody>

        <?php foreach ($users as $key => $row): ?>

        <tr class="odd gradeX">

            <td>
                <?php echo $row['User']['email']; ?>
            </td>

            <td class="align-center">
                <?php echo $this->Status->status($row['User']['status']); ?>
            </td>

            <td>
                <?php echo $row['Group']['name']; ?>
            </td>

            <td class="align-center">
                <?php echo $this->Time->format('d/m/Y', $row['User']['created']); ?>
            </td>

            <td class="align-center">
                <?php echo $this->Time->format('d/m/Y', $row['User']['modified']); ?>
            </td>

            <td>
                <?php
                $buttons = array('edit', 'delete');
                $buttons[] = ($row['User']['status']) ? 'deactivate' : 'activate';

                echo $this->Buttons->actions( $row, $buttons );
                ?>
            </td>
        </tr>

        <?php endforeach; ?>

    </tbody>

    <tfoot>

        <tr>
            <th><?php echo __('E-mail'); ?></th>
            <th><?php echo __('Status'); ?></th>
            <th><?php echo __('Grupo'); ?></th>
            <th><?php echo __('Criado em'); ?></th>
            <th><?php echo __('Modificado em'); ?></th>
            <th><?php echo __('Ações'); ?></th>
        </tr>

    </tfoot>

</table>

<?php echo $this->Buttons->add($optionsCreateUser); ?>
