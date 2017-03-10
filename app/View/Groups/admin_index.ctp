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
    echo $this->element('admin/groups/modal_delete');
$this->end();

?>

<h3><?php echo $title; ?></h3>
<br />

<?php

$optionsCreateGroup = array(
    'Cadastrar grupo' => array(
        'controller' => 'groups',
        'action'     => 'create'
    )
);

echo $this->Buttons->add($optionsCreateGroup);

?>

<table class="table table-bordered datatable default-datatable">

    <thead>

        <tr class="replace-inputs">
            <th><?php echo __('grupo'); ?></th>
            <th><?php echo __('usuários') ?></th>
            <th><?php echo __('criado em'); ?></th>
            <th><?php echo __('modificado em'); ?></th>
            <th data-disable="true"></th>
        </tr>

        <tr>
            <th><?php echo __('Grupo'); ?></th>
            <th><?php echo __('Usuários') ?></th>
            <th><?php echo __('Criado em'); ?></th>
            <th><?php echo __('Modificado em'); ?></th>
            <th><?php echo __('Ações'); ?></th>
        </tr>

    </thead>

    <tbody>

        <?php foreach ($groups as $key => $row): ?>

        <tr class="odd gradeX">
            <td>
                <?php echo $row['Group']['name']; ?>
            </td>

            <td class="align-center">
                <span class="badge badge-info badge-roundless"><?php echo count($row['User']); ?></span>
            </td>

            <td class="align-center">
                <?php echo $this->Time->format('d/m/Y', $row['Group']['created']); ?>
            </td>

            <td class="align-center">
                <?php echo $this->Time->format('d/m/Y', $row['Group']['modified']); ?>
            </td>

            <td>
                <?php echo $this->Buttons->actions( $row, array('edit', 'delete') ); ?>
            </td>
        </tr>

        <?php endforeach; ?>

    </tbody>

    <tfoot>

        <tr>
            <th><?php echo __('Grupo'); ?></th>
            <th><?php echo __('Usuários') ?></th>
            <th><?php echo __('Criado em'); ?></th>
            <th><?php echo __('Modificado em'); ?></th>
            <th><?php echo __('Ações'); ?></th>
        </tr>

    </tfoot>

</table>

<?php echo $this->Buttons->add($optionsCreateGroup); ?>
