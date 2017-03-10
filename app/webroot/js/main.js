var sync1, sync2;

$(document).ajaxStart(NProgress.start);
$(document).ajaxStop(NProgress.done);

$(document).ready(function()
{
    var currentPlay = 0;
    currentPlay = currentPlay + autoplay;
    console.log(autoplay);
    nniSlider();
    
    // Funções do player
    var audio = new Audio();
    // audio.source = 'http://suaradio2.dyndns.ws:10342/stream';
    audio.controls = false;
    audio.loop = true;
    document.getElementById('audio_box').appendChild(audio);
    
    // var canvas
    //  ,  ctx
    //  ,  source
    //  ,  context
    //  ,  analyser
    //  ,  fbc_array
    //  ,  bars
    //  ,  bar_x
    //  ,  bar_width
    //  ,  bar_height;

    // initPlayer();

    // function initPlayer()
    // {
    //     context = new AudioContext();
    //     analyser = context.createAnalyser();
    //     canvas = document.getElementById('analyser_render');
    //     ctx = canvas.getContext('2d');
    //     source = context.createMediaElementSource(audio);
    //     console.log(source);
    //     source.connect(analyser);
    //     analyser.connect(context.destination);
    //     frameLooper();
    // }

    // function frameLooper()
    // {
    //     var barColor;

    //     if($('body').hasClass('dark')) {
    //         barColor = '#21252b';
    //     } else {
    //         barColor = '#ffffff';
    //     }

    //     window.requestAnimationFrame(frameLooper);

    //     fbc_array = new Uint8Array(analyser.frequencyBinCount);
    //     analyser.getByteFrequencyData(fbc_array);
    //     ctx.clearRect(0, 0, canvas.width, canvas.height);
    //     ctx.fillStyle = barColor;
    //     bars = 7;
    //     for (var i = 0; i < bars; i++) {
    //         bar_x = i * 45;
    //         bar_width = 28;
    //         bar_height = -(fbc_array[i] / 10 * 5.3);
    //         ctx.fillRect(bar_x, canvas.height, bar_width, bar_height);
    //     }
    // }

    

    $('.header button.play').click(function(){
        currentPlay++;
        $(this).find('i').each(function()
        {
            if($(this).hasClass('fa-play')){
                if($(this).parent().hasClass('aac')) {
                    $('#flashContent #main').appendTo('#flashContent');
                }
                $(this).removeClass('fa-play').addClass('fa-pause');
                $('#bars').addClass('playing');
                audio.play();
            }
            else {
                if($(this).parent().hasClass('aac')) {
                    $('#flashContent #main').remove();
                }
                $(this).removeClass('fa-pause').addClass('fa-play');
                $('#bars').removeClass('playing');
                audio.pause();
            }
        });
    });

    $('button#changeRadio').click(function()
    {
        $('.choiseRadio .contenido').toggleClass('show');
    });

    $('.choiseRadio .contenido a').click(setStreaming);

    var data = $('.choiseRadio .contenido a').first().data();
    var musicName,
        audioType2,
        radioName;
    
    setStreaming(null, data);
    //musicName = data.sound;
    radioName = data.name;
    audioType2 = $('#audio_box').data('type');
    
//    if(autoplay == 1){
//    } else {
//    }

    function setStreaming(e, data)
    {

        if (data === undefined) {
            musicName = $(this).data('sound');
            radioName = $(this).data('name');
            audioType2 = $(this).data('type');
        } else {
            musicName = data.sound;
            radioName = data.name;
            audioType2 = $('#audio_box').data('type');
        }
        
        if(audioType2 == 'AAC') {
            
            $('.header button.play').addClass('aac');
            
            audio.pause();
            
            var url = 'http://50.7.66.10:10376/stream';
            
            var object = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" id="main" align="middle" height="72" width="280">';
				object += '<param name="FlashVars" value="url='+ musicName +'&amp;equalizercolor=ffffff&amp;backgroundColor=D5471F">';
				object += '<param name="movie" value="/swf/player.swf">';
				object += '<param name="quality" value="high">';
				object += '<param name="bgcolor" value="#EFEFEF">';
				object += '<param name="play" value="true">';
				object += '<param name="loop" value="true">';
				object += '<param name="wmode" value="window">';
				object += '<param name="scale" value="showall">';
				object += '<param name="menu" value="true">';
				object += '<param name="devicefont" value="false">';
				object += '<param name="salign" value="">';
				object += '<param name="allowScriptAccess" value="sameDomain">';
                object += '<!--[if !IE]>-->';
                object += '<object type="application/x-shockwave-flash" data="/swf/player.swf" width="280" height="72">';
                object += '<param name="FlashVars" value="url='+ musicName +'&equalizercolor=ffffff&backgroundColor=D5471F">';
                object += '<param name="movie" value="RegionMapModeler.swf" />';
                object += '<param name="quality" value="high" />';
                object += '<param name="bgcolor" value="#EFEFEF" />';
                object += '<param name="play" value="true" />';
                object += '<param name="loop" value="true" />';
                object += '<param name="wmode" value="window" />';
                object += '<param name="scale" value="showall" />';
                object += '<param name="menu" value="true" />';
                object += '<param name="devicefont" value="false" />';
                object += '<param name="salign" value="" />';
                object += '<param name="allowScriptAccess" value="sameDomain" />';
                object += '<!--<![endif]-->';
                object += '<a href="http://www.adobe.com/go/getflash">';
                object += '<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />';
                object += '</a>';
                object += '<!--[if !IE]>-->';
                object += '</object>';
                object += '<!--<![endif]-->';
                object += '</object>';
            
            
        
            $('#flashContent').html(object);
            
            if(currentPlay > 0) {
                $('#bars').addClass('playing');
            } else {
                $('#flashContent #main').remove();
            }
        } else {
            
            $('.header button.play').addClass('aac');
            
            $('#bars').removeClass('playing');

            audio.setAttribute('src', musicName);
            audio.setAttribute('type', audioType2);
            
        }
        

        $('.header .wichStation p span').text(radioName);
        if(currentPlay > 0) {
            $('.header button.play').find('i').each(function(){
                $(this).removeClass('fa-play').addClass('fa-pause');
            });
            audio.addEventListener('canplaythrough', startStreaming, false);
        }
    }

    function startStreaming() {
        $('#bars').addClass('playing');

        audio.play();
        audio.removeEventListener('canplaythrough', startStreaming);
    }

    Ps.initialize(document.getElementById('day00'));
    Ps.initialize(document.getElementById('day01'));
    Ps.initialize(document.getElementById('day02'));
    Ps.initialize(document.getElementById('day03'));
    Ps.initialize(document.getElementById('day04'));
    Ps.initialize(document.getElementById('day05'));
    Ps.initialize(document.getElementById('day06'));
    Ps.initialize(document.getElementById('chatScroll'));
    
    
    $('form#formContactTopTen').submit(function(e){
        e.preventDefault();

        $.post($(e.currentTarget).attr('action')+'.json', $(e.currentTarget).serialize(), function(response) {
            console.log(response);
            if (response.status == 'error') {
                swal("Erro ao enviar seu pedido!", 'Por favor tente novamente', "error");
            } else {
                swal("Pedido enviado com sucesso!", 'Em breve seu som sera tocado, fique ligado!', "success");
                $('.topTen').toggleClass('asker');
            }
        },
        'json');

        return false;
    });
    
    var mySVGsToInject = document.querySelectorAll('img.signo');

    SVGInjector(mySVGsToInject);
    
    // Previsão do tempo
    var cidade = $('#weather').data('cidade')
     ,  estado = $('#weather').data('estado');

    $.simpleWeather(
    {
        woeid: '2357536',
        location: cidade + ', ' + estado,
        unit: 'c',
        success: function(weather)
        {
            html  = '<ul>';
            html += '<li>Hoje em </li>';
            html += '<li class="region customColor">' + weather.city + ', ' + weather.region + '</li>';
            html += '<li> <i class="customColor icon-' + weather.code + '"></i></li>';
            html += '<li class="temp customColor">' + weather.temp + '&deg;</li>';
            html += '</ul>';

            $("#weather").html(html);
        },
        error: function(error)
        {
          $("#weather").html('<p>'+error+'</p>');
        }
    });



    // Ação de páginas do menu
    $('.menu li div.pageOpener').click(function()
    {
        var eq = $(this).parent().index();
        
        if($(this).parent().hasClass('open')) {
            $(this).parent().removeClass('open');
            closePages();
        } else {
            $('.menu li').removeClass('open');

            $(this).parent().addClass('open');

            closePages();

            $('.pages .page').eq(eq).stop().slideDown('300');
        }
        
    });

    var closeBt = '<a href="javascript:void(0);" class="closeBt customBG"><i class="fa fa-plus"></i></a>';

    $('.pages').append(closeBt);
    $('.pages .closeBt, .closeMe button').click(closePages);

    function closePages()
    {
        $('.pages .page').slideUp();
    }

    $('.promoInit').click(promoInit);
    $('.canceller').click(promoCloser);

    

    // Sliders por toda a page, o lot of slider
    sync1 = $("#mainSlider");
    sync2 = $("#thumbSlider");

    sync1.owlCarousel(
    {
        singleItem  : true,
        slideSpeed  : 200,
        navigation  : false,
        mouseDrag   : false,
        pagination  : false,
        afterAction : syncPosition,
        responsiveRefreshRate : 200,
    });

    sync2.owlCarousel(
    {
        pagination : false,
        singleItem : false,
        responsiveRefreshRate : 100,
        afterInit : function(el)
        {
            var items = el.find(".owl-item")
             ,  length = items.length
             ,  theWidth = 94 * items.length;

            $('#thumbSlider').width(theWidth + 'px');
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el)
    {
        var current = this.currentItem;

        $("#thumbSlider")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced");

        if($("#thumbSlider").data("owlCarousel") !== undefined) {
            center(current);
        }
    }

    $("#thumbSlider").on("click", ".owl-item", function(e)
    {
        e.preventDefault();

        var number = $(this).data("owlItem");

        sync1.trigger("owl.goTo", number);
    });

    function center(number)
    {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems
         ,  num = number
         ,  found = false;

        for (var i in sync2visible)
        {
            if (num === sync2visible[i]) {
                found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length-1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length+2)
            }
            else
            {
                if((num - 1) === -1) {
                    num = 0;
                }

                sync2.trigger("owl.goTo", num);
            }
        } else if(num === sync2visible[sync2visible.length-1]) {
            sync2.trigger("owl.goTo", sync2visible[1]);
        } else if(num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1);
        }
    }
    
    $('.mainScontrols').click(function() {
        if($(this).hasClass('next')) {
            $("#mainSlider").data('owlCarousel').next();
        } else {
            $("#mainSlider").data('owlCarousel').prev();
        }
    });

    $("#novidadeSlider").owlCarousel(
    {
        singleItem : true,
        slideSpeed : 200,
        navigation : false,
        pagination : false
    });

    var newSlider = $("#novidadeSlider").data('owlCarousel');

    $('#nPrev').click(function()
    {
        newSlider.prev();
    });

    $('#nNext').click(function()
    {
        newSlider.next();
    });

    $('#bannerPrev').click(function()
    {
        banner.prev();
    });

    $('#bannerNext').click(function()
    {
        banner.next();
    });

    $('#signos').owlCarousel(
    {
        singleItem : true,
        navigation : false,
        pagination : false
    });

    var horoscopo = $("#signos").data('owlCarousel');

    $('#signoPrev').click(function()
    {
        horoscopo.prev();
    })

    $('#signoNext').click(function()
    {
        horoscopo.next();
    })

    // Modal de Novidades
    $('#novidadeSlider a, #novidadePage .item').click(function() {
        var elem = $(this);
        openNovidadesModal(elem);
    });
    

    $('#closeModal, .layer').click(function()
    {
        $('body').removeAttr('style');
        $('.modal').fadeOut('fast', function()
        {
            // $('.modal .imageHolder').addClass('animated fadeInLeft faster');
            // $('.modal .contentHolder').addClass('animated fadeInRight faster');

            $('.modal .imageHolder').removeClass('animated fadeInLeft faster');
            $('.modal .contentHolder').removeClass('animated fadeInRight faster');

            $('.modal .imageHolder').addClass('hidden');
            $('.modal .contentHolder').addClass('hidden');
        });
    });

    // Galeria de fotos/vídeos
    $('.galleryImage').smoothZoom(
    {
        zoominSpeed  : '100',
        zoomoutSpeed : '100',
        closeButton  : true,
        showCaption  : false
    });

    // Galeria de fotos/vídeos na página de galeria
    $('.netFlocos ul').each(netFlocosInit);
    
    var netFlocos
     ,  intervalId = null;

    $('.netFlocos button').on('mouseover', function()
    {
        netFlocos = $(this).parent().find('ul');

        var theFunction = $(this).data('function')
         ,  parentWidth = $(this).parent().width()
         ,  left = netFlocos.data('left')
         ,  nfWidth = netFlocos.width()
         ,  diference = parentWidth - nfWidth;

        animaMe();

        intervalId = setInterval(animaMe, 20);

        function animaMe()
        {
            if(theFunction == 'prev' && left < 0)
            {
                left += 10;
                netFlocos.css(
                {
                    '-webkit-transform': 'translateX(' + left + 'px)',
                    '-moz-transform': 'translateX(' + left + 'px)',
                    '-ms-transform': 'translateX(' + left + 'px)',
                    '-o-transform': 'translateX(' + left + 'px)',
                    'transform': 'translateX(' + left + 'px)'
                });

                netFlocos.data('left', left);
            }

            if(theFunction == 'next' && left > diference)
            {
                left -= 10;
                netFlocos.css(
                {
                    '-webkit-transform': 'translateX(' + left + 'px)',
                    '-moz-transform': 'translateX(' + left + 'px)',
                    '-ms-transform': 'translateX(' + left + 'px)',
                    '-o-transform': 'translateX(' + left + 'px)',
                    'transform': 'translateX(' + left + 'px)'
                });

                netFlocos.data('left', left);
            }
        }
    })
    .on('mouseleave', function()
    {
        clearInterval(intervalId);
    });

    // Efeito de "placar" na página de programação

    var words = $('.word')
     ,  placars = $('.nniPlacar>div>div');
    placars.addClass('nope behind');

    var wordArray = []
     ,  currentWord = 0
     ,  today = new Date()
     ,  weekday = today.getDay();

    for (var i = 0; i < words.length; i++) {
      splitLetters(words[i]);
    }

    function changeWord(weekday)
    {
      var cw = wordArray[currentWord]
       ,  nw = wordArray[weekday];

      for (var i = 0; i < cw.length; i++) {
        animateLetterOut(cw, i);
      }

      for (var i = 0; i < nw.length; i++)
      {
        nw[i].className = 'letter behind';
        nw[0].parentElement.style.opacity = 1;
        animateLetterIn(nw, i);
      }

      currentWord = weekday;
    }

    function selectMenu(weekday)
    {
        $('.prog li').removeClass('current');
        $('.prog li').eq(weekday).addClass('current');
    }

    function selectPlacar(day)
    {
        var nope = $('.nniPlacar>div').eq(day).find('.nope');
        nope.parent().addClass('choosen');

        nope.each(function(i)
        {
            var element = $(this);

            setTimeout(function()
            {
                element.removeClass('behind');
                element.addClass('in current');
            }, i * 100);
        });
    }

    function unselectPlacar(day)
    {
        var nope = $('.nniPlacar>div').eq(day).find('.nope');

        nope.parent().removeClass('choosen');
        nope.each(function(i)
        {
            var element = $(this);

            setTimeout(function()
            {
                element.removeClass('in current');
                element.addClass('behind');
            }, i * 100);
        });
    }

    function combo(day)
    {
        changeWord(day);
        selectMenu(day);
        selectPlacar(day);
    }

    function animateLetterOut(cw, i)
    {
        setTimeout(function()
        {
            cw[i].className = 'letter out';

            setTimeout(function()
            {
                cw[i].parentElement.style.opacity = 0;
            }, 350);
        }, i * 80);
    }

    function animateLetterIn(nw, i)
    {
        setTimeout(function()
        {
            nw[i].className = 'letter in';
        }, 340 + (i * 80));
    }

    function splitLetters(word)
    {
        var letters = []
         ,  content = word.innerHTML;
        word.innerHTML = '';

        for (var i = 0; i < content.length; i++)
        {
            var letter = document.createElement('span');
            letter.className = 'letter';
            letter.innerHTML = content.charAt(i);
            word.appendChild(letter);
            letters.push(letter);
        }

        wordArray.push(letters);
    }

    combo(weekday);

    $('.prog li').click(function()
    {
        var day = $(this).index();

        if (day != currentWord)
        {
            unselectPlacar(currentWord);
            combo(day);
        }
    });

    // Plugin de animação do RSS
    $('#js-news').ticker();

    smoothScroll();

    // Votação
    $('#formPoll').on('submit', function(e)
    {
        e.preventDefault();

        var action = $(this).attr('action')
          , data = $(this).serialize();

        $.post(action, data, function(response)
        {
            if (response.response.status == 'success') {
                $('#formPoll').hide();
                $('#resultsPoll').show().html(response.response.data.results);
            }
        });
    });

    // Contato
    $('#formContact').on('submit', function(e)
    {
        e.preventDefault();

        var action = $(this).attr('action')
          , data = $(this).serialize();

        $.post(action, data, function(response)
        {
            console.log(response);
            if (response.response.status == 'success') {
                swal("Mensagem enviada com sucesso!", "success");
                $('#formContact #reset').click();
            }

            if (response.response.status == 'error') {
                alert(response.response.message || 'Ocorreu um erro ao tentar enviar seu comentário, tente novamente!');
            }
        });
    });
    
    $('#hed').click(function() {
        $('#chat').toggleClass('chatting');
        $('#chat input').focus();
    });
    
    $('#topToggler').click(function() {
        
        $('.topTen').toggleClass('asker');
        
    });
    
});


function nniSlider() {
    
    $('.nni_prev').each(function() {
        $(this).off('click');
    });

    $('.nni_next').each(function() {
        $(this).off('click');
    });
    
    
    var speedy = 400;
    var bounce = 150;
    
    $('.nniSlider').each(nniStart);
    
    function nniStart() {
        var slider = $(this);
        var slideWidth = slider.find('.frame>ul>li').width();
        var slideHeight = slider.find('.frame>ul>li').height();
        var ul = slider.find('.frame>ul');
        var slideCount = slider.find('.frame>ul>li').length;
        var sliderUlWidth = slideCount * slideWidth;
        
        if(slideCount == 1) {
            slider.find('.nni_next').hide();
            slider.find('.nni_prev').hide();
        } else {
            slider.find('.nni_next').show();
            slider.find('.nni_prev').show();
        }
        
        slider.css({ width: slideWidth, height: slideHeight, left: '0' });
        
        slider.attr('data-width', slideWidth);
        
        if(slideCount > 1) {
        }
        ul.css({ width: sliderUlWidth, left: '0'});
	
    }
    
    
    
    
    
    
    function moveLeft(parent) {
        $slider = parent;
        $width = $slider.data('width');
        $ul = $slider.find('.frame>ul');
        $left = $slider.find('.frame>ul').css('left');
        $left = parseInt($left.replace('px', ''));
        
        $left += $width;
        
        if($left > '0') {
            $ul.animate({
                left: '50px'
            }, bounce, function() {
                $ul.animate({
                    left: '0'
                }, bounce);
            });
            return false;
        } else {
            $ul.animate({
                left: $left
            }, speedy);
            $slider.find('ul').attr('data-left', $left);
        }
    };

    function moveRight(parent) {
        $slider = parent;
        $width = $slider.data('width');
        $ul = $slider.find('.frame>ul');
        $li = $slider.find('.frame>ul>li');
        $total = $li.length - 1;
        $max = $total * $width * -1;
        $left = $slider.find('ul').css('left');
        $left = parseInt($left.replace('px', ''));
        
        $left -= $width;
        
        
        if($left < $max) {
            $BounceLeft = $max - 50;
            $ul.animate({
                left: $BounceLeft
            }, bounce, function() {
                $ul.animate({
                    left: $max
                }, bounce);
            });
            return false;
        } else {
            $ul.animate({
                left: $left
            }, speedy);
        }
        
    };
    
    $('.nni_prev').click(function () {
        var parent = $(this).parent();
        moveLeft(parent);
    });

    $('.nni_next').click(function () {
        var parent = $(this).parent();
        moveRight(parent);
    });

}

function openNovidadesModal(elem) {
    
    var image = elem.data('image');
    var title = elem.data('title'); 
    var text  = elem.data('text'); 
    var id    = elem.attr('id');
    var idReplaced    = elem.attr('id').replace('the', '');
    var foreignKey = elem.data('foreignKey');

    $('.modal .imageHolder > div').data('foreignKey', foreignKey);
    $('.modal .imageHolder img').attr('src', image);
    $('.modal .contentHolder h2').text(title).data('foreignKey', foreignKey).data('novidadeId', id);
    $('.modal .contentHolder p.text').text(text).data('foreignKey', foreignKey).data('novidadeId', id);
    $('.modal .dense').attr('data-novidadeId', idReplaced);
    $('body').css({
        'overflow': 'hidden'
    });

    Ps.initialize(document.getElementById('middleWScroll'));

    $('.modal').fadeIn('fast', function()
    {
        $('.modal .imageHolder').addClass('animated fadeInLeft faster');
        $('.modal .imageHolder').removeClass('hidden');
        $('.modal .contentHolder').removeClass('hidden');
        $('.modal .contentHolder').addClass('animated fadeInRight faster');
    });
}

function promoInit()
{
    var theCore = $(this).parent('.core')
     ,  theBUtte = $(this)
     ,  theText = theCore.find('.textToBeMoved')
     ,  theForm = theCore.find('.formToBeMoved')
     ,  theSuccess = theCore.find('.messageToBeMoved');

    if(theCore.hasClass('waitingForTrigger'))
    {
        var form = theForm.find('form')
         ,  action = form.attr('action')
         ,  data = form.serialize();

        $.post(action, data, function(response)
        {
            if (response.response.status == 'success') {
                theForm.removeClass('animated fadeInRight');
                theForm.addClass('animated fadeOutRight');

                theCore.find('.promoInit').fadeOut();

                setTimeout(function()
                {
                    theSuccess.removeClass('hidden');
                    theSuccess.removeClass('animated fadeOutRight');
                    theSuccess.addClass('animated fadeInRight');
                }, 300);
            }
            if (response.response.status == 'error') {
                theForm.find('.alertMessage').html(response.response.message);
            }
        });
    }
    else
    {
        theCore.addClass('waitingForTrigger');
        theText.addClass('animated fadeOutRight');

        setTimeout(function()
        {
            theBUtte.text('Enviar');
            theCore.find('.canceller').show();
            theForm.removeClass('hidden');
            theForm.removeClass('animated fadeOutRight');
            theForm.addClass('animated fadeInRight');
        }, 300);
    }
}

function promoCloser() {
    var theCore = $(this).parent('.core')
     ,  theText = theCore.find('.textToBeMoved')
     ,  theForm = theCore.find('.formToBeMoved')
     ,  theSuccess = theCore.find('.messageToBeMoved');

    theCore.find('.promoInit').text('Participar!');
    theCore.find('.canceller').hide();
    theForm.removeClass('hidden');
    theForm.removeClass('animated fadeInRight');
    theForm.addClass('animated fadeOutRight');
    theCore.removeClass('waitingForTrigger');

    setTimeout(function()
    {
        theText.removeClass('animated fadeInRight');
        theText.removeClass('animated fadeOutRight');
        theText.addClass('animated fadeInRight');
    }, 300);

}

function netFlocosInit() {
    var deslizer = $(this),
        itemWidth = deslizer.find('li').width(),
        quanty = deslizer.find('li').length,
        nfWidth = quanty * itemWidth;
    if(quanty <= 5) {
        deslizer.parent().find('>button').hide();
    } else  {
        deslizer.parent().find('>button').show();
    }
    deslizer.width(nfWidth);
}


