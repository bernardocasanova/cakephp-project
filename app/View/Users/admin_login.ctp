<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Login | Rádios 3.0 | Admin</title>

    <!-- Common stylesheets -->
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/custom.css">

    <script src="<?php echo $this->webroot; ?>admin/js/jquery-1.11.0.min.js"></script>
    <script>$.noConflict();</script>

    <!--[if lt IE 9]><script src="<?php echo $this->webroot; ?>admin/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="page-body login-page login-form-fall">

    <script type="text/javascript">
    var attemptUrl = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'attempt', 'admin' => true)); ?>";
    </script>

    <div class="login-container">

        <div class="login-header login-caret">

            <div class="login-content">

                <?php
                echo $this->Html->image('/admin/images/logo-radios-3.png', array(
                    'width'  => '140',
                    'height' => '35'
                ));
                ?>

                <p class="description">Para acessar essa área, faça seu login!</p>

                <div class="login-progressbar-indicator">
                    <h3>43%</h3>
                    <span>verificando...</span>
                </div>

            </div>

        </div>

        <div class="login-progressbar">
            <div></div>
        </div>

        <div class="login-form">

            <div class="login-content">

                <?php if ($this->Session->check('Message.auth')): ?>

                <div class="form-login-error" style="display: block; height: auto;">
                    <h3>Acesso negado</h3>
                    <p><?php echo $this->Session->flash('auth', array('element' => 'simple_flash')); ?></p>
                </div>

                <?php else: ?>

                <div class="form-login-error">
                    <h3>Acesso negado</h3>
                    <p>Informe corretamente seu <strong>e-mail</strong> e <strong>senha</strong></p>
                </div>

                <?php endif; ?>

                <form method="post" role="form" id="formLogin">

                    <div class="form-group">

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-user"></i>
                            </div>

                            <input type="text" class="form-control" name="email" id="email" placeholder="E-mail" autocomplete="off" />
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="entypo-key"></i>
                            </div>

                            <input type="password" class="form-control" name="password" id="password" placeholder="Senha" autocomplete="off" />
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block btn-login">
                            <i class="entypo-login"></i>
                            Acessar
                        </button>
                    </div>

                </form>


<!--                 <div class="login-bottom-links">

                    <a href="<?php echo $this->Html->url(array(
                        'controller' => 'users',
                        'action'     => 'forgot_password',
                        'admin'      => true
                    )) ?>" class="link">Esqueceu sua senha?</a>

                </div> -->

            </div>

        </div>

    </div>

    <!-- Common scripts -->
    <script src="<?php echo $this->webroot; ?>admin/js/gsap/main-gsap.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/bootstrap.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/joinable.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/resizeable.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/neon-api.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/neon-custom.js"></script>

    <!-- Needed for login -->
    <script src="<?php echo $this->webroot; ?>admin/js/jquery.validate.min.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/neon-login.js"></script>

    <!-- Notifications -->
    <?php echo $this->Session->flash('flash'); ?>

</body>
</html>