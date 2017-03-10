<?php

// Load page scripts dependencies.
$this->Html->script(array(
    '/admin/js/jquery.validate.min.js',
    '/admin/js/radios/view/radios.edit.js'
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
                'action'     => 'update',
                'admin'      => true,
                $radio['Radio']['id']
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

                <div class="form-group">
                    <label class="col-sm-3 control-label">Radialista</label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('Owner.email', array(
                            'type'     => 'text',
                            'value'    => isset($radio['Owner']['email']) ? $radio['Owner']['email'] : '',
                            'disabled' => true
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
                            'value'                  => isset($radio['Radio']['name']) ? $radio['Radio']['name'] : '',
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
                                'value'                  => isset($radio['Radio']['slug']) ? $radio['Radio']['slug'] : '',
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
                            'value'                  => isset($radio['Radio']['domain']) ? $radio['Radio']['domain'] : '',
                            'class'                  => 'form-control domain',
                            'data-validate'          => 'maxlength[200]',
                            'data-message-maxlength' => __('O campo não pode ter mais de 200 caracteres.')
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

                <div id="streamingLists">

                    <?php foreach ($radio['Streaming'] as $key => $streaming): ?>

                    <div class="form-group">

                        <div class="col-sm-offset-1 col-sm-2">
                            <input name="data[Streaming][<?php echo $key; ?>][name]" value="<?php echo $streaming['name']; ?>" class="form-control" placeholder="nome do streaming" data-validate="required,maxlength[100]" data-message-required="Campo obrigatório." data-message-maxlength="O campo não pode ter mais de 100 caracteres." maxlength="100" type="text" id="StreamingName<?php echo $key; ?>">
                        </div>

                        <div class="col-sm-2">
                            <input name="data[Streaming][<?php echo $key; ?>][url]" value="<?php echo $streaming['url']; ?>" class="form-control" placeholder="url do streaming" data-validate="required,maxlength[200]" data-message-required="Campo obrigatório." data-message-maxlength="O campo não pode ter mais de 200 caracteres." maxlength="200" type="text" id="StreamingUr<?php echo $key; ?>">
                        </div>

                        <div class="col-sm-2">
                            <select name="data[Streaming][<?php echo $key; ?>][type]" class="form-control" data-validate="required" data-message-required="Campo obrigatório." id="StreamingType<?php echo $key; ?>" aria-invalid="false">
                                <option value="" disabled>tipo</option>
                                <?php foreach ($types as $type): ?>
                                <option value="<?php echo $type; ?>" <?php if ($type == $streaming['type']) echo 'selected'; ?>><?php echo $type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <input type="hidden" name="data[Streaming][<?php echo $key; ?>][id]" value="<?php echo $streaming['id']; ?>">
                            <button type="button" class="btn btn-red remove-streaming"><i class="entypo-trash"></i></button>
                        </div>

                    </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

        <div class="panel panel-primary" data-collapsed="0">

            <div class="panel-heading">
                <div class="panel-title">
                    <?php echo __('Link aplicativo android'); ?>
                </div>

                <div class="panel-options">
                    <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                </div>
            </div>

            <div class="panel-body">

                <div class="form-group">
                    <label class="col-sm-3 control-label">Link</label>

                    <div class="col-sm-3">
                        <?php
                        echo $this->Form->input('android_app', array(
                            'type'     => 'text',
                            'value'    => isset($radio['Radio']['android_app']) ? $radio['Radio']['android_app'] : '',
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

</div>
