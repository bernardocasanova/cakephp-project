<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> <!--<![endif]-->
    <head>
        <title><?php echo $radio['Radio']['name']; ?></title>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <meta name="viewport" content="width=640px, user-scalable=no">
        
        <link rel="icon" type="image/x-icon" href="<?php echo $uploadsFolder . $this->Attachments->fixFilename($radio['AttachmentFavicon']['filename'], 'web.'); ?>?t=32">

        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/radio/<?php echo $radio['Radio']['theme_file']; ?>">
        <link rel="stylesheet" href="<?php echo $this->webroot; ?>css/mobile.css">

        <script src="<?php echo $this->webroot; ?>js/vendor/modernizr-2.6.2.min.js"></script>

        <?php echo $this->element('radio/analytics'); ?>
        
        <style>
            #wheelDiv{
                width: 600px;
                height: 600px;
                margin: 0 auto;
            }
            text{
                color: #cccccc;
            }
            body > div { 
                -webkit-transition: all 1s ease-in-out; 
                -moz-transition: all 1s ease-in-out; 
                -ms-transition: all 1s ease-in-out; 
                -o-transition: all 1s ease-in-out; 
                transition: all 1s ease-in-out; 
            }
        </style>
        
    </head>

    <body class="<?php echo $radio['Radio']['theme_soul']; ?> load-complete">
        <div>
            <div class="loading">
                Carregando áudio
            </div>
            <div class="navbar">
                <a href="/?fromMobile=true" class="takeOff customColor">
                    <span class="customBorder"></span>
                    Sair
                </a>
                <div class="miniLogo"></div>
    <!--
                <button class="menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
    -->
            </div>
            
            <?php if(isset($radio['Radio']['android_app']) && !empty($radio['Radio']['android_app'])){ ?>
                <div id="AndroidPage">
                   
                    <h2>Oops!</h2>
                    
                    <p>
                        Detectamos que seu smartphone<br/>
                        poderá demorar a executar a <br/>
                        rádio.<br/>
                        Por favor baixe o nosso APP.
                    </p>
                    
                    <div id="androidLogo"></div>
                    
                    <a href="<?php echo $radio['Radio']['android_app']; ?>" id="androidLink">
                        Baixar aplicativo
                    </a>
                </div>
            <?php } ?>
               
               
               <div id="noAndroid">
                   <div id="audio_box"></div>

                    <div class="logo">
                        <?php
                        $options = array(
                            'loggedIn'   => false,
                            'width'      => 300,
                            'height'     => 170,
                            'noLink'     => true,
                            'model'      => 'Radio',
                            'field'      => 'logo',
                            'foreignKey' => $radio['Radio']['id'],
                            'data'       => $radio
                        );
                        echo $this->Attachments->show($options);
                        ?>
                    </div>

                    <div id="navWheel" data-wheelnav></div>

                    <div class="window load-transition">
                      <div class="page page-front">
                        <div class="cover load-transition load-transition-delay-1">
                          <div class="sound-bars">
                            <div class="bar wave-1"></div>
                            <div class="bar wave-2"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-2"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-10"></div>
                            <div class="bar wave-1"></div>
                            <div class="bar wave-2"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-1"></div>
                            <div class="bar wave-2"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-1"></div>
                            <div class="bar wave-2"></div>
                            <div class="bar wave-3"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                            <div class="bar wave-6"></div>
                            <div class="bar wave-7"></div>
                            <div class="bar wave-8"></div>
                            <div class="bar wave-9"></div>
                            <div class="bar wave-4"></div>
                            <div class="bar wave-5"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>

                <ul style="display:none;" class="streams">
                    <?php foreach ($radio['Streaming'] as $key => $streaming): ?>
                        <li data-sound="<?php echo $streaming['url']; ?>" data-name="<?php echo $streaming['name']; ?>" data-type="<?php echo $streaming['type']; ?>"></li>
                    <?php endforeach; ?>
                </ul>
            
        </div>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?php echo $this->webroot; ?>js/vendor/jquery-1.11.1.min.js"><\/script>')</script>
        <script src="<?php echo $this->webroot; ?>js/vendor/raphael.icons.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/vendor/raphael.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/vendor/wheelnav.js"></script>
        
        <script>
            
            $(document).ready(function() {
                
                var isMobile = {
                    Android: function() {
                        return navigator.userAgent.match(/Android/i);
                    }
                };

                if( isMobile.Android() ) {
                    $('#noAndroid').hide();
                    $('#AndroidPage').show();
                } else {
                    var audio = new Audio();
                    audio.controls = false;
                    audio.loop = true;
                    audio.autoplay = true;
                    document.getElementById('audio_box').appendChild(audio);

                    navWheel = new wheelnav("navWheel", null, 640, 640);
                    navWheel.clickModeRotate = false;
                    navWheel.spreaderRadius = navWheel.wheelRadius * 0.325;
                    navWheel.wheelRadius = navWheel.wheelRadius * 0.8;
                    navWheel.slicePathFunction = slicePath().DonutSlice;
                    navWheel.colors = new Array("#929292");
                    navWheel.markerEnable = true;
                    navWheel.markerPathFunction = markerPath().PieLineMarker;
                    navWheel.animatetime = 1000;
                    navWheel.animateeffect = "elastic"
                    navWheel.navAngle = 270;
                    navWheel.rotateRound = true;


                    navWheel.createWheel([icon.play, icon.ff, icon.stop, icon.rw]);
                    navWheel.navItems[0].navigateFunction = function () { startStreaming(); };
                    navWheel.navItems[1].navigateFunction = function () { changeStation('next'); };
                    navWheel.navItems[2].navigateFunction = function () { stopAudio(); };
                    navWheel.navItems[3].navigateFunction = function () { changeStation('prev'); };

                    var currentIndex = 0;
                    var streams = $('.streams li');
                    var data = streams.eq(currentIndex).data();

                    setStreaming(data);

                    function changeStation(trigger) {
                        trigger == 'prev' ? currentIndex-- : currentIndex++;
                        currentIndex == '-1' ? currentIndex = streams.length - 1 : true;
                        currentIndex == streams.length ? currentIndex = 0 : true;
                        data = streams.eq(currentIndex).data();
                        setStreaming();
                    }  

                    function setStreaming() {

                        audio.setAttribute('src', data.sound);
                        audio.setAttribute('type', data.type);
                        $('.window').removeClass('playing');
                        $('.loading').addClass('onload');
                        audio.addEventListener('canplay', startStreaming, false);

                    }

                    function startStreaming() {
                        audio.play();
                        audio.removeEventListener('canplay', startStreaming);
                        if (isPlaying(audio)) {
                            $('.window').addClass('playing');
                            $('.loading').removeClass('onload');
                            navWheel.navigateWheel(0);
                        }
                    }
                    function isPlaying(audelem) { return !audelem.paused; }
                    function stopAudio() {
                        $('.window').removeClass('playing');
                        audio.pause();
                    }

//                    function reorient(e) {
//                        var portrait = (window.orientation % 180 == 0);
//                        $("body > div").css("-webkit-transform", !portrait ? "rotate(-90deg)" : "");
//                    }
                    // window.onorientationchange = reorient;
                    // window.setTimeout(reorient, 0);
                
                }
                
            });
            
        </script>
        
    </body>

</html>
