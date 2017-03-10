<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Fetch meta tags -->
    <?php echo $this->fetch('meta'); ?>

    <title><?php echo (isset($title) ? $title . ' | Rádios 3.0 | Admin' : 'Radios | Admin'); ?></title>

    <!-- Common stylesheets -->
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-core.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-theme.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/neon-forms.css">
    <link rel="stylesheet" href="<?php echo $this->webroot; ?>admin/css/custom.css">

    <!-- Page stylesheets dependecies -->
    <?php echo $this->fetch('css'); ?>

    <script src="<?php echo $this->webroot; ?>admin/js/jquery-1.11.0.min.js"></script>

    <!--[if lt IE 9]><script src="<?php echo $this->webroot; ?>admin/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="page-body">

    <div class="page-container">

        <!-- sidebar menu -->
        <?php echo $this->element('admin/sidebar/menu'); ?>

        <!-- main content -->
        <div class="main-content">

            <?php echo $this->element('admin/topbar/menu', array('user' => $authenticatedUser)); ?>

            <?php echo $this->fetch('content'); ?>

        </div>

    </div>

    <!-- Fetch modals -->
    <?php echo $this->fetch('modals'); ?>

    <!-- Common scripts -->
    <script src="<?php echo $this->webroot; ?>admin/js/gsap/main-gsap.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/bootstrap.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/joinable.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/resizeable.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/toastr.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/neon-api.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/neon-custom.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/toastr.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/radios/admin-namespace.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/radios/admin.utils.js"></script>
    <script src="<?php echo $this->webroot; ?>admin/js/radios/admin.api.js"></script>

    <!-- Page scripts dependecies -->
    <?php echo $this->fetch('script'); ?>

    <!-- Notifications -->
    <?php echo $this->Session->flash('flash'); ?>

    <?php if ($this->Session->check('Message.auth')): ?>
    <script type="text/javascript">window.onload = function() { admin.utils.notification.flash('error', '<?php echo $this->Session->flash("auth"); ?>'); };</script>
    <?php endif; ?>

</body>
</html>