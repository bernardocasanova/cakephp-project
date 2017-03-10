<?php

// Load page scripts dependencies.
$this->Html->script(array(
    '/admin/js/jquery.validate.min.js',
    '/admin/js/radios/view/radios.create.js'
    ), array('block' => 'script')
);

?>
<script>
var newStreamingUrl = '<?php echo $this->Html->url(array("controller" => "radios", "action" => "streaming_html", "admin" => true)); ?>';
</script>

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
                'controller' => 'radios',
                'action'     => 'store',
                'admin'      => true
            ),
            'inputDefaults' => array(
                'format' => array('input'),
                'label'  => false,
                'div'    => false,
                'class'  => 'form-control'
            )
        );

        echo $this->Form->create('Radio', $options);
        ?>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Dono da rádio'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <strong>Cadastre um novo radialista ...</strong>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('E-mail'); ?></label>

                    <div class="col-sm-5">
                        <?php
                        echo $this->Form->input('User.email', array(
                            'required'               => false,
                            'data-validate'          => 'email,maxlength[255]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 255 caracteres.'),
                            'data-message-email'     => __('O e-mail informado é inválido.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Confirme o e-mail'); ?></label>

                    <div class="col-sm-5">
                        <?php
                        echo $this->Form->input('User.confirm_email', array(
                            'data-validate'          => 'email,maxlength[255],equalTo[#UserEmail]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 255 caracteres.'),
                            'data-message-email'     => __('O e-mail informado é inválido.'),
                            'data-message-equal-to'  => __('Os e-mails informados são diferentes.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Senha'); ?></label>

                    <div class="col-sm-2">
                        <?php
                        echo $this->Form->input('User.password', array(
                            'required'               => false,
                            'data-validate'          => 'minlength[6]',
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
                    <label class="col-sm-3 control-label"><?php echo __('Confirme a senha'); ?></label>

                    <div class="col-sm-2">
                        <?php
                        echo $this->Form->input('User.confirm_password', array(
                            'type'                  => 'password',
                            'data-validate'         => 'equalTo[#UserPassword]',
                            'data-message-equal-to' => __('As senhas informadas são diferentes.')
                        ));
                        ?>
                    </div>
                </div>

                <strong>... ou selecione um abaixo.</strong>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Radialista'); ?></label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('user_id', array(
                            'type'    => 'select',
                            'empty'   => 'Selecione um radialista',
                            'options' => $users
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Dados da rádio'); ?>
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
                            'autocomplete'           => 'off',
                            'data-validate'          => 'required,maxlength[100]',
                            'data-message-required'  => __('Campo obrigatório.'),
                            'data-message-maxlength' => __('O campo não pode ter mais de 100 caracteres.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Slug'); ?></label>

                    <div class="col-sm-3">

                        <div class="input-group">

                            <span class="input-group-btn">
                                <button class="btn btn-default unlock-slug" type="button"><i class="entypo-lock"></i></button>
                            </span>

                            <?php
                            echo $this->Form->input('slug', array(
                                'readonly'               => true,
                                'placeholder'            => __('nome-da-radio'),
                                'data-validate'          => 'required,maxlength[150]',
                                'data-message-required'  => __('Campo obrigatório.'),
                                'data-message-maxlength' => __('O campo não pode ter mais de 150 caracteres.'),
                            ));
                            ?>

                            <span class="input-group-addon">
                                .<?php echo Configure::read('radios.domain'); ?>
                            </span>

                        </div>

                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Domínio'); ?></label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('domain', array(
                            'class'                  => 'form-control domain',
                            'data-validate'          => 'maxlength[200]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 200 caracteres.')
                        ));
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label"><?php echo __('Template'); ?></label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('template', array(
                            'data-validate'         => 'required',
                            'data-message-required' => __('Campo obrigatório.'),
                            'type'    => 'select',
                            'empty'   => 'Selecione um template',
                            'options' => array(
                                'default'  => 'Padrão',
                                'churches' => 'Igreja'
                            )
                        ));
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Streamings'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">

                    <div class="col-sm-offset-1 col-sm-11">

                        <button type="button" id="addToStreamingList" class="btn btn-green btn-icon icon-left">
                            Adicionar Streaming
                            <i class="entypo-plus"></i>
                        </button>

                    </div>

                </div>

                <div id="streamingLists"></div>

            </div>

        </div>

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-5">
                <button type="submit" class="btn btn-success"><?php echo __('Cadastrar'); ?></button>
            </div>
        </div>

        <?php echo $this->Form->end(); ?>

    </div>

</div>
