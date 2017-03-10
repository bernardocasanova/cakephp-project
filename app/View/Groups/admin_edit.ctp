<?php

// Load page scripts dependencies.
$this->Html->script(array(
    '/admin/js/jquery.validate.min.js',
    '/admin/js/radios/view/groups.create.js'
    ), array('block' => 'script')
);

?>

<h3><?php echo $title; ?></h3>
<br>

<div class="row">

    <div class="col-md-12">

        <?php
        $options = array(
            'role'       => 'form',
            'class'      => 'validate form-horizontal',
            'novalidate' => 'novalidate',
            'url'        => array(
                'controller' => 'groups',
                'action'     => 'update',
                'admin'      => true,
                $group['Group']['id']
            ),
            'inputDefaults' => array(
                'format' => array('input'),
                'label'  => false,
                'div'    => false,
                'class'  => 'form-control'
            )
        );

        echo $this->Form->create('Group', $options);
        ?>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Dados do grupo'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Nome'); ?></label>

                    <div class="col-sm-5">
                        <?php
                        echo $this->Form->input('name', array(
                            'value'                  => isset($group['Group']['name']) ? $group['Group']['name'] : '',
                            'data-validate'          => 'required,maxlength[100]',
                            'data-message-required'  => __('Campo obrigatório.'),
                            'data-message-maxlength' => __('O campo não pode ter mais de 100 caracteres.')
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Permissões'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="col-sm-12">

                    <div class="panel-group">

                        <?php foreach ($acos as $key => $parentAco): ?>

                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" href="#collapse-<?php echo $key; ?>" class="collapsed">
                                        <?php echo $parentAco['parentName']; ?>
                                    </a>
                                </h4>
                            </div>

                            <div id="collapse-<?php echo $key; ?>" class="panel-collapse collapse in">

                                <div class="panel-body">

                                    <ul class="list-unstyled">
                                        <?php foreach ($parentAco['permissions'] as $label):?>
                                        <li>
                                            <label>
                                                <input type="checkbox"
                                                    class="chck<?php echo $parentAco['parentName']; ?>"
                                                    name="data[Group][permissions][]"
                                                    value="<?php echo $parentAco['parentAlias']; ?>.<?php echo $label; ?>"
                                                    <?php if (in_array($label, $parentAco['allowed'])) echo 'checked'; ?>
                                                    > <?php echo $label; ?>
                                            </label>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <button type="button" class="btn btn-black btn-xs check-all" data-class=".chck<?php echo $parentAco['parentName']; ?>">Marcar</button>
                                    <button type="button" class="btn btn-black btn-xs uncheck-all" data-class=".chck<?php echo $parentAco['parentName']; ?>">Desmarcar</button>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-5">
                <button type="submit" class="btn btn-success"><?php echo __('Salvar'); ?></button>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>

    </div>

</div>
