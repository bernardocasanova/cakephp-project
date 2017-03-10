<?php echo $this->element('radio/doctype');  ?>

<script>
    var roomJID = '<?php echo $radio["Radio"]["room_jid"]; ?>';
</script>

<?php if ($loggedIn): ?>

<script>
var scheduleUrl     = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "add_schedule", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var liveEditUrl     = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "live_edit", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var createAlbumUrl  = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "createAlbum", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var editAlbumUrl    = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "editAlbum", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var saveVideoUrl    = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "saveVideo", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var uploadAlbumUrl  = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "uploadImagesToAlbum", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var loadAlbumUrl    = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "loadAlbum", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var mainColorUrl    = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "update_main_color", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var addRowUrl       = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "add_row", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var deleteRowUrl    = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "delete_row", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
var responseDataUrl = '<?php echo $this->Html->url(array("controller" => "pages", "action" => "getResponseData", "plugin" => "radio", "radioSlug" => $this->params["radioSlug"])); ?>.json';
</script>

<?php endif; ?>

    <style>
    body {
        background: url("<?php echo $uploadsFolder . $radio['AttachmentBackground']['filename']; ?>") no-repeat fixed;
        background-size: cover;
    }
    </style>

    <body class="<?php echo $radio['Radio']['theme_soul']; ?>">

        <!-- FACEBOOK -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=280559398795233&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

        <div class="wrapper">

            <!-- HEADER -->
            <?php echo $this->element('radio/header'); ?>

            <div class="container clearfix">

                <!-- HEADING -->
                <?php echo $this->element('radio/heading'); ?>

                <!-- PAGER -->
                <?php echo $this->element('radio/pager'); ?>

                <!-- SLIDER -->
                <?php echo $this->element('radio/slider'); ?>

                <div class="clearfix">

                    <div class="wrapper">

                        <!-- NEWS -->
                        <?php echo $this->element('radio/news'); ?>

                        <!-- GALLERY -->
                        <?php echo $this->element('radio/gallery'); ?>

                        <!-- JS NEWS -->
                        <?php echo $this->element('radio/js-news'); ?>

                        <!-- TOP TEN -->
                        <?php echo $this->element('radio/top-ten'); ?>

                        <!-- MOST POPULAR ARTIST -->
                        <?php echo $this->element('radio/most-popular-artist'); ?>

                    </div>

                    <div class="sideBar">

                        <?php
                        $options = array(
                            'loggedIn'   => $loggedIn,
                            'width'      => 250,
                            'height'     => 250,
                            'model'      => 'Banner',
                            'field'      => 'sidebar',
                            'foreignKey' => isset($banners['sidebar'][0]['Banner']['id']) ? $banners['sidebar'][0]['Banner']['id'] : '',
                            'link'       => isset($banners['sidebar'][0]['Banner']['link']) ? $banners['sidebar'][0]['Banner']['link'] : '',
                            'data'       => isset($banners['sidebar'][0]) ? $banners['sidebar'][0] : ''
                        );

                        echo $this->Attachments->show($options);

                        
                        ?>

                        <!-- VOTING -->
                        <?php echo $this->element('radio/voting'); ?>

                        <?php
                        $options = array(
                            'loggedIn'   => $loggedIn,
                            'width'      => 250,
                            'height'     => 250,
                            'model'      => 'Banner',
                            'field'      => 'sidebar',
                            'foreignKey' => isset($banners['sidebar'][1]['Banner']['id']) ? $banners['sidebar'][1]['Banner']['id'] : '',
                            'link'       => isset($banners['sidebar'][1]['Banner']['link']) ? $banners['sidebar'][1]['Banner']['link'] : '',
                            'data'       => isset($banners['sidebar'][1]) ? $banners['sidebar'][1] : ''
                        );

                        echo $this->Attachments->show($options);
                        ?>

                        <?php
                        $options = array(
                            'loggedIn'   => $loggedIn,
                            'width'      => 250,
                            'height'     => 250,
                            'model'      => 'Banner',
                            'field'      => 'sidebar',
                            'foreignKey' => isset($banners['sidebar'][2]['Banner']['id']) ? $banners['sidebar'][2]['Banner']['id'] : '',
                            'link'       => isset($banners['sidebar'][2]['Banner']['link']) ? $banners['sidebar'][2]['Banner']['link'] : '',
                            'data'       => isset($banners['sidebar'][2]) ? $banners['sidebar'][2] : ''
                        );

                        echo $this->Attachments->show($options);
                        ?>

                    </div>

                </div>

                <!-- HOROSCOPE -->
                <?php echo $this->element('radio/horoscope'); ?>

                <!-- SOUNDCLOUD -->
                <?php if (isset($radio['Radio']['soundcloud']) && !empty($radio['Radio']['soundcloud'])): ?>
                <div class="soundcloud">
                    <center>
                        soundcloud
                    </center>
                    <iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/users/<?php echo $radio['Radio']['soundcloud']; ?>&amp;color=ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false"></iframe>
                </div>
                <?php endif; ?>

                <!-- BLOCKS -->
                <?php echo $this->element('radio/blocks'); ?>

                <!-- SCRIPTS -->
                <?php echo $this->element('radio/scripts'); ?>

                <!-- FACEBOOK -->
                <?php if (isset($radio['Radio']['facebook']) && !empty($radio['Radio']['facebook'])): ?>
                <div class="facebookBlock">
                    <center>
                        <div class="fb-like-box" data-href="<?php echo $radio['Radio']['facebook']; ?>" data-width="920" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="false"></div>
                    </center>
                </div>
                <?php endif; ?>

                <?php
                $options = array(
                    'loggedIn'   => $loggedIn,
                    'width'      => 728,
                    'height'     => 90,
                    'model'      => 'Banner',
                    'field'      => 'footer',
                    'foreignKey' => isset($banners['footer']['Banner']['id']) ? $banners['footer']['Banner']['id'] : '',
                    'link'       => isset($banners['footer']['Banner']['link']) ? $banners['footer']['Banner']['link'] : '',
                    'data'       => isset($banners['footer']) ? $banners['footer'] : ''
                );

                echo $this->Attachments->show($options);
                ?>

            </div>

            <!-- FOOTER -->
            <?php echo $this->element('radio/footer'); ?>

            <!-- NEWS MODAL -->
            <?php echo $this->element('radio/news-modal'); ?>


            <!-- GALLERY UPLOADS -->
            <div id="galleryUpload">
                <div class="layer"></div>
                <div class="miolo">
                    <div class="head clearfix">
                        <h3 class="left">
                            Criar álbum
                        </h3>
                        <div class="action right">
                            <button class="customColor" id="closeUploader">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="side">
                        <input type="text" class="albumName" placeholder="Nome do Álbum">
                    </div>
                    <div class="dropHolder">
                        <div class="clearfix">
                            <ul class="existingItem">
                                
                            </ul>
                            <ul class="dropzoneArea" data-adwidth="250" data-adheight="250"></ul>
                            <div class="dropInit">
                                <div class="customColor">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button id="saveAlbum" class="customBG" data-focus="create">
                        Salvar álbum
                    </button>
                </div>
            </div>
            
            <!-- GALLERY UPLOADS -->
            <div class="videoAdder">
                <div class="layer"></div>
                <div class="upper">
                    <h3>Adicionar vídeo</h3>
                    <form class="videoForm">
                        <label for="">URL do vídeo:</label>
                        <input type="text" placeholder="Ex: http://youtube.com/watch?v=kxopViU98Xo" id="videoURL">
                        <label for="">Selecione o tipo do vídeo:</label>
                        <span class="toggle2">
                            <input type="checkbox" class="toggle-input" id="videoType">
                            <label class="toggle2-switch" for="videoType"></label>
                        </span>
                        
                        <a href="javascript:void(0);" class="cancelApplyVideo">
                            Cancelar
                        </a>
                        
                        <button class="applyVideo customBG" type="submit">
                            Salvar vídeo
                        </button>
                    </form>
                </div>
            </div>

            <!-- CHAT -->
            <?php echo $this->element('radio/chat'); ?>

            <!-- CONFIGURATIONS / MANAGER -->
            <?php echo $this->element('radio/configurations'); ?>

        </div>
        
        <div id="loaderLayer" class="customBG">
            <div id="loader">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>

        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/vendor/jquery-1.11.1.min.js"><\/script>')</script>

        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.0.2/jquery.simpleWeather.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/easing.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/smoothzoom.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/smoothScroll.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/nniSlider.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/owl-carousel/owl.carousel.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/jquery.ticker.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/inject.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/nprogress.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/sweetalert.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/main.js"></script>

        <!-- START - Chat JS Files -->
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/flexible_styles.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/quickblox.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/strophe.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/strophe.muc.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/strophe.chatstates.js"></script>
<!--        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/jquery.timeago.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/libs/jquery.scrollTo-min.js"></script>

        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/config.js"></script>
<!--        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/smiles.js"></script>-->
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/js/helpers.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/chat/qbchatroom.js"></script>
        <!-- END - Chat JS Files -->
        
        <?php if ($loggedIn): ?>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/jquery.minicolors.min.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/dropzone.js"></script>
        <script type="text/javascript" src="<?php echo $this->webroot; ?>js/live.js"></script>
        <?php endif; ?>
        
            </body>

</html>
