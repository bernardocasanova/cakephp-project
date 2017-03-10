<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <title><?php echo $radio['Radio']['name']; ?></title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <link rel="icon" type="image/x-icon" href="<?php echo $uploadsFolder . $this->Attachments->fixFilename($radio['AttachmentFavicon']['filename'], 'web.'); ?>?t=32">
        
        <?php // $asd = $_get[]?>
       
        
        <?php $fromMobile = isset($_GET["fromMobile"]) ? $_GET["fromMobile"] = 'true' : $_GET["fromMobile"] = 'false'; ?>
        
        <?php if($fromMobile == 'false') { ?>
            <script>
                var isMobile = {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    },
                    BlackBerry: function() {
                        return navigator.userAgent.match(/BlackBerry/i);
                    },
                    iOS: function() {
                        return navigator.userAgent.match(/iPhone|iPod/i);
                    },
                    Opera: function() {
                        return navigator.userAgent.match(/Opera Mini/i);
                    },
                    Windows: function() {
                        return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
                    },
                    any: function() {
                        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                    }
                };
                if( isMobile.any() ) window.location = "/mobile";
                var autoplay = <?php 
                        if(isset($radio["Radio"]["autoplay"]) && !empty($radio["Radio"]["autoplay"])){
                            echo $radio["Radio"]["autoplay"];
                        }else{
                            echo '0';
                        }
                                         
                    ?>
                ;
//                var autoplay = '';
            </script>

        <?php } ?>
        
        <meta name="viewport" content="width=940, user-scalable=yes">
        
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/normalize.min.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/main.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/perfect-scrollbar.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/animate.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/radio/<?php echo $radio['Radio']['theme_file']; ?>">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/smoothzoom.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/nniSlider.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/ticker-style.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/nprogress.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/vendor/owl-carousel/owl.carousel.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/vendor/owl-carousel/owl.theme.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/vendor/owl-carousel/owl.transitions.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/sweetalert.css">

<!--        <link rel="stylesheet" href="<?php echo $this->webroot; ?>js/chat/qbchatroom.css">-->

        <?php if ($loggedIn): ?>
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/jquery.minicolors.css">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/dropzone.css">
        <?php endif; ?>

        <script src="<?php echo $this->webroot; ?>js/vendor/modernizr-2.6.2.min.js"></script>

        <style>
            div#player { width:65px; height:45px; position:absolute; top:6px; left:0; }
            div#player > canvas { width:65px; height:45px; float:left; }
        </style>


        <?php echo $this->element('radio/analytics'); ?>
    </head>