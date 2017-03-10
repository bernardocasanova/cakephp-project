<?php

// Load page scripts dependencies.
$this->Html->script(array(
    '/admin/js/jquery.validate.min.js',
    '/admin/js/radios/view/users.create.js'
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
                'controller' => 'users',
                'action'     => 'update',
                'admin'      => true,
                $user['User']['id']
            ),
            'inputDefaults' => array(
                'format' => array('input'),
                'label'  => false,
                'div'    => false,
                'class'  => 'form-control'
            )
        );

        echo $this->Form->create('User', $options);
        ?>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Dados de acesso'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('E-mail'); ?></label>

                    <div class="col-sm-5">
                        <?php
                        echo $this->Form->input('email', array(
                            'value'    => isset($user['User']['email']) ? $user['User']['email'] : '',
                            'disabled' => true
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Grupo</label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('group_id', array(
                            'type'                  => 'select',
                            'empty'                 => 'Selecione',
                            'options'               => $groups,
                            'default'               => $user['User']['group_id'],
                            'data-validate'         => 'required',
                            'data-message-required' => __('Campo obrigatório.'),
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Dados pessoais'); ?>
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
                        echo $this->Form->input('Profile.first_name', array(
                            'value' => isset($user['Profile']['first_name']) ? $user['Profile']['first_name'] : '',
                            'data-validate'          => 'maxlength[100]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 100 caracteres.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Sobrenome'); ?></label>

                    <div class="col-sm-5">
                        <?php
                        echo $this->Form->input('Profile.last_name', array(
                            'value' => isset($user['Profile']['last_name']) ? $user['Profile']['last_name'] : '',
                            'data-validate'          => 'maxlength[100]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 100 caracteres.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Telefone'); ?></label>

                    <div class="col-sm-2">
                        <?php
                        echo $this->Form->input('Profile.phone', array(
                            'value'                  => isset($user['Profile']['phone']) ? $user['Profile']['phone'] : '',
                            'data-validate'          => 'maxlength[20]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 20 caracteres.')
                        ));
                        ?>
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

    <div class="col-md-12">

        <?php echo $this->Form->create('User', $options); ?>

        <div class="panel panel-primary panel-collapse" data-collapsed="1">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Alterar senha'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Nova senha'); ?></label>

                    <div class="col-sm-2">
                        <?php
                        echo $this->Form->input('password', array(
                            'data-validate'          => 'required,minlength[6]',
                            'data-message-required'  => __('Campo obrigatório.'),
                            'data-message-minlength' => __('A senha deve conter no mínimo 6 caracteres.')
                        ));
                        ?>
                    </div>

                    <div class="col-sm-1">
                        <button type="button" id="btnShowPassword" class="form-control btn btn-default hide-password">
                            <i class="glyphicon glyphicon-eye-close"></i>
                        </button>
                    </div>

                    <div class="col-sm-2">
                        <input type="button" class="form-control btn-info" id="btnGenPassword" value="Gerar senha">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Confirme a nova senha'); ?></label>

                    <div class="col-sm-2">
                        <?php
                        echo $this->Form->input('confirm_password', array(
                            'type'                  => 'password',
                            'data-validate'         => 'required,equalTo[#UserPassword]',
                            'data-message-required' => __('Campo obrigatório.'),
                            'data-message-equal-to' => __('As senhas informadas são diferentes.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <button type="submit" class="btn btn-success"><?php echo __('Alterar senha'); ?></button>
                    </div>
                </div>

            </div>

        </div>

        <?php echo $this->Form->end(); ?>

    </div>

</div>
