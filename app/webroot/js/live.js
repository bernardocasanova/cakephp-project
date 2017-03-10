$(document).ready(function()
{
    var primalContent = null;

    $('body').addClass('live');
    
    $('button.fractionAdder').click(addFraction);

    // Caixa de informações
    $('#gearStick').click(function()
    {
        $('#gearStick').removeClass('open');

        setTimeout(function()
        {
            $('#gearBox').addClass('open');
        }, 300);
    });

    $('#setStick').click(function()
    {
        $('#gearBox').removeClass('open');

        setTimeout(function()
        {
            $('#gearStick').addClass('open');
        }, 300);
    });

    $('#gearBox h3').click(function()
    {
        var id = $(this).data('tab');

        if ($(this).hasClass('current'))
        {
            $(this).removeClass('current');
            $('.section#' + id).slideUp();
        }
        else
        {
            $(this).addClass('current');
            $('.section#' + id).slideDown();
        }
    });

    $('.colorPicker').minicolors(
    {
        change: function(hex)
        {
            themer(hex, false);
        }
    });

    $('.colorPicker').focusin(function()
    {
        $(this).addClass('focused');
    });

    $('.colorPicker').focusout(function()
    {
        $(this).removeClass('focused');

        $.post(mainColorUrl, { mainColor: $(this).val() });
    });

    $('.colorPalete li').each(function()
    {
        var bgColor = $(this).data('color');

        $(this).css(
        {
            'background-color': bgColor
        });
    });

    $('.colorPalete li').click(function()
    {
        var hex = $(this).data('color');
        themer(hex);
    });

    $('.themeColor li').click(function()
    {
        var soul = $(this).data('soul');

        if (soul == 'dark') {
            $('body').removeClass('white').addClass('dark');
        } else if (soul == 'white') {
            $('body').removeClass('dark').addClass('white');
        }

        submitChanges(soul, this);

        // frameLooper();
    });
    
    
    $('#promoAdder').click(addPromo);
    
    function addPromo() {

        var parent = $(this).parent();
        var model = $(this).data('model');

        var params = {
            model  : model,
            action : "create",
            type   : "promotion",
            name   : "Nome da promoção",
            title  : "Titulo da promoção",
            description : "Descricao da promoção",
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == 'success'){
                var promo  = '<li>'
                promo +=    '<h3 class="liveT" data-field="name" data-model="' + model + '" data-foreign-key="' + response.response.data.id + '">' + params.name + '</h3>';
                promo +=    '<div class="core">';
                promo +=        '<div class="image">';
                promo +=            '<div class="dense d260-360 customColor no-link" data-adwidth="260" data-adheight="360" data-model="' + model + '" data-field="promotion" data-foreign-key="' + response.response.data.id + '"><div class="imageUploadHolder"></div><div class="editLayer"><div><ul class="clearfix"><li class="image"><a href="javascript:void(0);"><i class="fa fa-cloud-upload fa-2x"></i><span>Enviar IMG</span></a><div class="toltip customBG hidden">Tamanho da imagem 260x360</div></li><li class="delete"><a href="javascript:void(0);"><i class="fa fa-trash-o fa-2x"></i><span>Excluir</span></a></li></ul></div></div><img src="http://placehold.it/260x360" alt=""></div></div>';
                promo +=        '<div class="text-right">';
                promo +=            '<div class="textToBeMoved">';
                promo +=                '<h4 class="liveT" data-model="' + model + '" data-field="title" data-foreign-key="' + response.response.data.id + '">' + params.title + '</h4>';
                promo +=                '<p class="liveT" data-model="' + model + '" data-field="description" data-foreign-key="' + response.response.data.id + '">' + params.description + '</p>';
                promo +=            '</div>';
                promo +=            '<div class="formToBeMoved hidden">';
                promo +=                '<h4>Preencha os seus dados para participar</h4>';
                promo +=                '<form class="form-promotion" action="/new-participant.json">';
                promo +=                    '<input name="name" placeholder="Seu nome" type="text">';
                promo +=                    '<input name="email" placeholder="Seu e-mail" type="text">';
                promo +=                    '<div class="clearfix">';
                promo +=                        '<input name="phone" placeholder="Telefone" class="halfInp" type="text">';
                promo +=                        '<input name="cellphone" placeholder="Celular" class="halfInp right" type="text">';
                promo +=                   ' </div>';
                promo +=                    '<input name="promotion_id" value="' + response.response.data.id + '" type="hidden">';
                promo +=                    '<!-- <div class="checksquare">';
                promo +=                        '<input name="accept" class="needTerm" id="StoreUserTerms" type="checkbox">';
                promo +=                        '<label for="StoreUserTerms"></label>';
                promo +=                    '</div>';
                promo +=                    '<span class="fakelabel">Aceito os termos de uso</span> -->';
                promo +=                    '<span class="alertMessage"></span>';
                promo +=                '</form>';
                promo +=            '</div>';
                promo +=            '<div class="messageToBeMoved hidden">';
                promo +=                '<h4>Suas informações foram salvas com sucesso!</h4>';
                promo +=            '</div>';
                promo +=        '</div>';
                promo +=        '<a href="javascript:void(0);" class="canceller">cancelar</a>';
                promo +=        '<a href="javascript:void(0);" class="customBG promoInit">Participar!</a>';
                promo +=        '<button class="deletePromo"><i class="fa fa-times"></i></button>';
                promo +=    '</div>';
                promo +='</li>';
                
                $('.promotion .promoCore').prepend(promo);
                
                updateQueries();
                
                nniSlider();
            }
        });
    }

    $('.deletePromo').click(deletePromo);

    function deletePromo() 
    {
        var element = $(this).parent().parent();
        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreignKey')
        };
        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
            }
        });

        nniSlider();
    }

    $('.btnSchedule').click(function()
    {
        var weekDay = $(this).data('weekDay')
         ,  parent = $(this).parent();

        $.post(scheduleUrl, { weekDay: weekDay }, function(response)
        {
            var html = ''
             ,  schedule = response.response.data;

            html += '<div class="nope in current">';
            html +=    '<i class="fa fa-clock-o fa-2x"></i>';
            html +=    ' <p class="bolder">';
            html +=       '<span class="liveT" data-model="Schedule" data-field="initial_hour" data-foreign-key="' + schedule.foreignKey + '">';
            html +=          schedule.initialHour;
            html +=       '</span>';
            html +=       ' às ';
            html +=       '<span class="liveT" data-model="Schedule" data-field="final_hour" data-foreign-key="' + schedule.foreignKey + '">';
            html +=          schedule.finalHour;
            html +=       '</span>';
            html +=    '</p>';
            html +=    ' <p class="bolder">/</p> ';
            html +=    '<p class="lighter liveT" data-model="Schedule" data-field="name" data-foreign-key="' + schedule.foreignKey + '">';
            html +=       'Programação';
            html +=    '</p>';
            html += '</div>';

            $(html).insertBefore(parent);

            $(parent).parent().find('.liveT')
                .on('dblclick', allowEdit)
                .on('focus', liveFocusHandler)
                .on('blur', saveMe)
                .on('keydown', liveKeyDownHandler)
                .on('keypress', liveKeyPressHandler)
                .on('keyup', liveKeyUpHandler);
        });
    });

    $('.dense').each(function()
    {
        var adWidth = $(this).data('adwidth')
         ,  adHeight = $(this).data('adheight')
         ,  model = $(this).data('model')
         ,  foreignKey = $(this).data('foreignKey')
         ,  link = ''
         ,  sizeText;

        if ($(this).hasClass('d468-60')) {
            sizeText = '';
        } else {
            sizeText = 'Tamanho da imagem';
        }

        if ($(this).has('> a').length) {
            link = $(this).find('> a').attr('href');
        }

        var layerDense = '';

        layerDense = '<div class="imageUploadHolder"></div>';
        layerDense += '<div class="editLayer">';
            layerDense += '<div>';
                layerDense += '<ul class="clearfix">';
                    layerDense += '<li class="image">';
                        layerDense += '<a href="javascript:void(0);"><i class="fa fa-cloud-upload fa-2x"></i><span>Enviar IMG</span></a>';
                        layerDense += '<div class="toltip customBG hidden">';
                            layerDense += sizeText;
                            layerDense += ' ';
                            layerDense += adWidth;
                            layerDense += 'x';
                            layerDense += adHeight;
                        layerDense += '</div>';
                    layerDense += '</li>';

        if (!$(this).hasClass('no-link')) {
                    layerDense += '<li class="link">';
                        layerDense += '<a href="javascript:void(0);"><i class="fa fa-link fa-2x"></i><span>Link</span></a>';
                        layerDense += '<div class="toltip customBG hidden">';
                            layerDense += '<input type="text" class="liveT" data-model="' + model + '" data-field="link" data-foreign-key="' + foreignKey + '" placeholder="http://" value="' + link + '"/>';
                        layerDense += '</div>';
                    layerDense += '</li>';
        }

        if (!$(this).hasClass('daBanner')) {
                    layerDense += '<li class="delete">';
                        layerDense += '<a href="javascript:void(0);"><i class="fa fa-trash-o fa-2x"></i><span>Excluir</span></a>';
                    layerDense += '</li>';
        }
                layerDense += '</ul>';
            layerDense += '</div>';
        layerDense += '</div>';

        if ($(this).hasClass('daBanner')) {
            layerDense += '<div class="deleter">';
                layerDense += '<button class="deleteMyFather customBG" data-model="' + model + '" data-foreign-key="' + foreignKey + '"><i class="fa fa-trash-o"></i></button>';
            layerDense += '</div>';
        }

        if ($(this).hasClass('d32-32')) {
            layerDense = '<div class="imageUploadHolder"></div>';
        }

        $(this).prepend(layerDense);
    });

    
    function addFraction() {
        
        var focus = $(this).data('focus');
        var html;
        var parent = $(this).parent();
        var whereToInsert = parent.find('.frame>ul>li:first-child');
        var model = $(this).data('model');

        if(focus == 'eventos') {
            var params = {
                model  : model,
                action : "create",
                type   : "fraction",
                focus  : focus,
                name   : "Nome do Show",
                hour   : "19:00",
                date   : "2015-09-21",
                local  : "Nome do local"
            };
        }

        if(focus == 'novidades') {
            var params = {
                model  : model,
                action : "create",
                type   : "fraction",
                focus  : focus,
                title  : "Titulo",
                description   : "Descricao",
            };
        }

        if(focus == 'locutores') {
            var params = {
                model  : model,
                action : "create",
                type   : "fraction",
                focus  : focus,
                name   : "Nome do Locutor",
            };
        }

        $.post(liveEditUrl, params, function(response){

            if(response.response.status == 'success'){

                if(focus == 'locutores') {
                    html = '<div class="item" data-model="' + model + '" data-foreign-key="' + response.response.data.id + '">';
                    html += '<div class="speakerAvatar">';
                    html += '<div class="dense d150-140 customColor no-link" data-adwidth="150" data-adheight="140" data-model="Announcer" data-field="announcer" data-foreign-key="' + response.response.data.id + '">';
                    html += '<div class="imageUploadHolder">';
                    html += '</div>';
                    html += '<div class="editLayer">';
                    html += '<div>';
                    html += '<ul class="clearfix">';
                    html += '<li class="image"><a href="javascript:void(0);"><i class="fa fa-cloud-upload fa-2x"></i><span>Enviar IMG</span></a><div class="toltip customBG hidden">Tamanho da imagem 150x140</div></li>';
                    html += '<li class="delete"><a href="javascript:void(0);"><i class="fa fa-trash-o fa-2x"></i><span>Excluir</span></a></li>';
                    html += '</ul>';
                    html += '</div>';
                    html += '</div><img src="http://placehold.it/150x140"></div></div>';
                    html += '<p class="liveT" data-model="Announcer" data-field="name" data-foreign-key="' + response.response.data.id + '">' + params.name + '</p>';
                    html += '<button class="deleteFraction"><i class="fa fa-times"></i></button>';
                    html += '</div>';
                }
                
                if(focus == 'eventos') {
                    html = '<div class="item" data-model="' + model + '" data-foreign-key="' + response.response.data.id + '">';
                    html += '<div class="speakerAvatar">';
                    html += '<div class="dense d150-140 customColor no-link" data-adwidth="150" data-adheight="140" data-model="Event" data-field="event" data-foreign-key="' + response.response.data.id + '">';
                    html += '<div class="imageUploadHolder"></div>';
                    html += '<div class="editLayer"><div>';
                    html += '<ul class="clearfix">';
                    html += '<li class="image"><a href="javascript:void(0);"><i class="fa fa-cloud-upload fa-2x"></i><span>Enviar IMG</span></a><div class="toltip customBG hidden">Tamanho da imagem 150x140</div></li>';
                    html += '<li class="delete"><a href="javascript:void(0);"><i class="fa fa-trash-o fa-2x"></i><span>Excluir</span></a></li>';
                    html += '</ul>';
                    html += '</div>';
                    html += '</div>';
                    html += '<img src="http://placehold.it/150x140">';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="dating">';
                    html += '<div class="effect customBG"></div>';
                    html += '<div class="texture"></div>';
                    html += '<div class="dateHolder">';
                    html += '<div class="dayHolder">21</div>';
                    html += '<div class="monthHolder">SET</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="info">';
                    html += '<div>';
                    html += '<div class="nome liveT" data-model="Event" data-field="name" data-foreign-key="' + response.response.data.id + '">' + params.name + '</div>';
                    html += '<div class="local clearfix">';
                    html += '<div>';
                    html += '<b>Local:</b>';
                    html += '</div>';
                    html += '<div class="liveT" data-model="Event" data-field="local" data-foreign-key="' + response.response.data.id + '">' + params.local + '</div>';
                    html += '</div>';
                    html += '<div class="hora clearfix">';
                    html += '<div>';
                    html += '<b>Hora:</b>';
                    html += '</div>';
                    html += '<div class="liveT" data-model="Event" data-field="hour" data-foreign-key="' + response.response.data.id + '">' + params.hour + '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '<button class="deleteFraction"><i class="fa fa-times"></i></button>';
                    html += '</div>';
                }
                
                if(focus == 'novidades') {
                    html = '<div class="item" data-model="' + model + '" id="news' + response.response.data.id + '" data-image="http://placehold.it/450x500" data-title="Título de novidade" data-text="Texto de novidade" data-foreign-key="' + response.response.data.id + '">';
                    html += '<div class="speakerAvatar">';
                    html += '<img src="http://placehold.it/150x140">';
                    html += '</div>';
                    html += '<p>' + params.title + '</p>';
                    html += '<button class="deleteFraction"><i class="fa fa-times"></i></button>';
                    html += '</div>';

                    html2 = '<li class="item link">';
                        html2 += '<a href="javascript:void(0);" id="thenews' + response.response.data.id + '" data-image="http://placehold.it/450x500" data-title="Titulo" data-text="Descricao" data-foreign-key="' + response.response.data.id + '">';
                            html2 += '<p class="customColor">' + params.title + '</p>';
                            html2 += '<img src="http://placehold.it/535x160">';
                        html2 += '</a>';
                    html2 += '</li>';

                    $("#novidadeSlider").data('owlCarousel').addItem(html2);
                }

                var muchPerBlock = whereToInsert.find('.item').length;
                
                if(muchPerBlock >= '3') {
                    whereToInsert.parent().prepend('<li></li>');
                    parent.find('.frame>ul>li:first-child').append(html);
                    nniSlider();
                } else {
                    whereToInsert.prepend(html);
                }
                
                var itemWidth = -550;
                var theMuch = parent.find('.frame>ul>li').length -1;

                var newLeft = 0;

                parent.find('.frame>ul').css({
                    left: newLeft
                });
                
                updateQueries();
                updateFractions();
                
                var newElm = parent.find('.frame>ul>li:first-child>.item:first-child');
                
                if(focus == 'novidades') {
                    openNovidadesModal(newElm);
                    newElm.click(function() {
                        var elemo = $(this);
                        
                        openNovidadesModal(elemo);
                    });
                }
            }
        });
    }

    $('.deleteProg').click(deleteProg);

    function deleteProg()
    {
        var element = $(this).parents('.nope.in.current');

        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreignKey')
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
            }
        });

        return false;
    }

    $('.deleteFraction').click(deleteFraction);

    function deleteFraction()
    {
        var element = $(this).parents('.item');
        
        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreignKey')
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
                
                updateFractions();
                
                nniSlider();
            }
        });
        
        return false;
    }   
    
    function denseActionColors()
    {
        if ($(this).hasClass('customColor'))
        {
            $(this).removeClass('customColor');
            $('.toltip').addClass('hidden');
            $('.dense').removeClass('uploading');
        }
        else
        {
            $('.editLayer li a').removeClass('customColor');
            $('.toltip').addClass('hidden');
            $('.dense').removeClass('uploading');
            $(this).addClass('customColor');
            $(this).parent('li').find('.toltip').removeClass('hidden');
        }
    }

    function denseImageDelete()
    {
        if (confirm('Tem certeza que deseja excluir este item?')) {
            deleteImage(this);
        }
    }

    Dropzone.autoDiscover = false;
    var myDropzone = null;

    function dropStarter()
    {
        if (myDropzone !== null) {
            myDropzone.destroy();
            $('.dropzone').remove();
        }

        $parents = $(this).parents('.dense');
        $parents.prepend('<form method="post" class="dropzone"></form>');

        var whereToPut = $parents.find('.imageUploadHolder'),
            dataW      = $parents.data('adwidth'),
            dataH      = $parents.data('adheight');

        var params = {
            model      : $parents.data('model'),
            field      : $parents.data('field'),
            action     : 'update',
            foreignKey : $parents.data('foreignKey')
        };

        $element = $(this);
        $parents.addClass('uploading');

        myDropzone = new Dropzone('.dropzone',
        {
            url: liveEditUrl,
            thumbnailWidth: dataW,
            thumbnailHeight: dataH,
            maxFiles: 1,
            acceptedFiles: 'image/*',
            params: params,
            previewsContainer: whereToPut,
            success: function(elem)
            {
                console.log(elem);
                var response = $.parseJSON(elem.xhr.response).response;

                $element.parents('.dense').find('.dz-preview').addClass('dz-success');
                $('.editLayer li a').removeClass('customColor');
                $('.toltip').addClass('hidden');

                $('.dropzone').remove();

                setTimeout(function()
                {
                    if (response.status == 'success')
                    {
                        var src = $parents.find('.dz-image img').attr('src');

                        if ($parents.find('> img').length == 1) {
                            $parents.find('> img').attr('src', src);
                        } else if($parents.find('> a > img').length == 1) {
                            $parents.find('> a > img').attr('src', src);
                        } else {
                            $parents.append('<img src="' + src + '">');
                        }

                        if($parents.data('model') == 'News'){
                            var genericId = $('.modal .dense').data('novidadeid');
                            var banner = response.data.files.banner;
                            var web = response.data.files.web;
                            var modal = response.data.files.modal;
                            var target = $('#' + genericId);

                            target.data('image', modal);
                            target.find('.speakerAvatar img').attr('src', web + '?' + Math.random());
                            $('#the' + genericId).find('img').attr('src', banner + '?' + Math.random());
                        }

                        if($parents.data('model') == 'Slider'){
                            var idSlider = $parents.parents('.owl-item').index();
                            var thumb = $('#thumbSlider .owl-item').eq(idSlider);
                            thumb.find('.item').css({
                                'background': 'url("'+ response.data.files.thumb +'") center center',
                                'background-size': 'cover'
                            });
                        }
                    }
                    
                    myDropzone.removeAllFiles();
                    $parents.removeClass('uploading');

                }, 1500);
            },
            error: function()
            {
                myDropzone.removeAllFiles();
                $('.dropzone').remove();

                $parents.find('form').remove();
                $element.parents('.dense').find('.dz-preview').addClass('dz-error');

                setTimeout(function()
                {
                    $parents.removeClass('uploading');
                }, 1500);
            },
            accept: function(file, done)
            {   
                var element = $('.dense .imageUploadHolder .dz-image img');
                var height;
                var width;

                element.load(function(){

                    height = $(this).height();
                    width  = $(this).width();
                    
                    if(file.type == "image/gif"){
                        if(dataW < file.width || dataH < file.height){
                            done("Invalid dimenions");
                            swal("Tamanho incorreto!", 'Tamanho precisa ser: ' + dataW + ' x ' + dataH + '', "error");
                        }else if(dataW > file.width || dataH > file.height){
                            done("Invalid dimenions");
                            swal("Tamanho incorreto!", 'Tamanho precisa ser: ' + dataW + ' x ' + dataH + '', "error");
                        }else{
                            done();
                        }
                    }else{
                        if(width < dataW || height < dataH){
                            done("Invalid dimenions");
                            swal("Tamanho incorreto!!", 'Tamanho minimo precisa ser: ' + dataW + ' x ' + dataH + '', "error");
                        }else{
                            done();
                        }
                    }
                });
            }
        });
    }

    Ps.initialize(document.getElementById('gearBox'));

    $('#addScript').on('click', addScript);

    function addScript()
    {
        var template  = "<div data-index='{index}'>";
            template += "    <button class=\"removeScript\"><i class=\"fa fa-times\"></i></button>";
            template += "    <h3>Script {index}</h3>";
            template += "    <textarea class='liveT' data-model='Script' data-field='script' data-foreign-key=''>Insira aqui seu script</textarea>";
            template += "</div>";

        var lastDiv = $(this).parent().find('div').last()
         ,  lastIndex = Number($(lastDiv).data('index')) || 0;

        var updatedTemplate = template.replace(/{index}/g, lastIndex + 1);

        $(updatedTemplate).insertBefore(this);

        $(this).parent().find('div').last().find('.liveT')
            .on('dblclick', allowEdit)
            .on('focus', liveFocusHandler)
            .on('blur', saveMe)
            .on('keydown', liveKeyDownHandler)
            .on('keypress', liveKeyPressHandler)
            .on('keyup', liveKeyUpHandler);

            updateQueries(); 
    }
    
    function removeScript()
    {
        var element = $(this).parent();
        var key = element.data('key');

        if(element.find('textarea').attr('data-foreign-key') != ''){
            var params = {
                model      : element.find('textarea').data('model'),
                action     : 'delete',
                foreignKey : element.find('textarea').attr('data-foreign-key')
            };

            $.post(liveEditUrl, params, function(response){
                element.remove();
                $('.scripts').find('#cripta'+key).remove();
            });
        }else{
            element.remove();
        }
    }

    function liveFocusHandler(e)
    {
        primalContent = getValue(this);
    }

    function liveKeyDownHandler(e)
    {
        var code = (e.keyCode ? e.keyCode : e.which);

        if (code === 13) {
            return false;
        }
    }

    function liveKeyPressHandler(e)
    {
        var code = (e.keyCode || e.which);

        if (code === 13) {
            return false;
        }
    }

    function liveKeyUpHandler(e)
    {
        var code = (e.keyCode ? e.keyCode : e.which);

        if (code === 13) {
            $(this).blur();
            return false;
        }
    }

    function allowEdit()
    {
        $(this).attr(
        {
            'aria-label': 'Insira um texto',
            'contenteditable': true,
            'spellcheck': false
        }).focus();
    }

    function deleteImage(that)
    {
        $parents = $(that).parents('.dense');

        var params = {
            model      : $parents.data('model'),
            field      : $parents.data('field'),
            files      : true,
            action     : 'delete',
            foreignKey : $parents.data('foreignKey'),
        };

        $.post(liveEditUrl, params, function(response)
        {
            if (response.response.status == 'success') {
                
                if(params.model == 'News') {
                    var newsId = $parents.data('novidadeid');
                    
                    $('#' + newsId).find('img').attr('src', 'http://placehold.it/150x140');
                    $('#the' + newsId).find('img').attr('src', 'http://placehold.it/535x160');
                    
                }
                $parents.find('> img, > a').remove();
            }
        });
    }

    function saveMe()
    {
        var currentContent = getValue(this);
        
        if ($(this).prop("tagName") != 'INPUT' && currentContent.length == 0)
        {
            alert('O campo não pode ficar vazio.');
            $(this).focus();
            return false;
        }

        $(this).removeAttr('contenteditable');

        if (primalContent == currentContent) {
            return false;
        }

        submitChanges(currentContent, this);

        // Se for dentro da modal
        if ($(this).hasClass('innerModal'))
        {
            if ($(this).prop("tagName") == 'H2')
            {
                var novidadeId = $(this).data('foreign-key');
                $('#novidadeSlider #thenews' + novidadeId).data('title', currentContent).find('p').text(currentContent);
                $('#novidadePage .item#news' + novidadeId).data('title', currentContent).find('p').text(currentContent);
            }
            else if ($(this).prop("tagName") == 'P')
            {
                var novidadeId = $(this).data('novidadeId');
                $('#novidadeSlider #thenews' + novidadeId).data('text', currentContent);
                $('#novidadePage .item#news' + novidadeId).data('text', currentContent);
            }
        }

        return true;
    }

    function submitChanges(currentContent, that)
    {
        var data   = $(that).data();
        data.value  = currentContent;
        data.action = (data.foreignKey == '') ? 'create' : 'update';
        // data.type = 'script';
        console.log(data);
        $.post(liveEditUrl, data, function(response)
        {
            console.log(response);

            if (response.response.status == 'error') {
                $(that).text(primalContent);
            }

            if (response.response.status == 'success') {

                if(data.field == "script"){
                    if(data.action == "create"){
                        var length = $('.scripts').find('div').length + 1;
                        var htmlScript = '<div id="cripta' + length + '">' + currentContent + '</div>';
                        $('.scripts').append(htmlScript);
                        $('.edit-scripts>div').last().find('.liveT').attr('data-foreign-key', response.response.data.id);
                    }else if(data.action == "update"){
                        $('.scripts').find('#cripta'+data.key).html(currentContent);
                    }
                }

                $(that).data('foreignKey', response.response.data.fk);
            }
        })
        .fail(function()
        {
            if ($(that).is('input')) {
                $(that).val(primalContent);
            } else {
                $(that).text(primalContent);
            }
        });
    }

    function getValue(that)
    {
        var array = ['INPUT', 'SELECT', 'TEXTAREA'];

        if (array.indexOf($(that).prop("tagName")) == -1) {
            return $(that).text();
        }

        return $(that).val();
    }

    function themer(hex, sendPost)
    {
        $('.customBG').css({'background-color': hex});
        $('.customColor').css({'color': hex});
        $('.dcustomColor').css({'border-color': hex});

        if (sendPost === undefined || sendPost) {
            saveMainColor(hex);
        }
    }

    function saveMainColor(hex)
    {
        $.post(mainColorUrl, { mainColor: hex });
    }

    var gallUploader = $('#galleryUpload .dropzone');

    $('#closeUploader, #galleryUpload .layer').click(function()
    {
        $(this).parents('#galleryUpload').fadeOut('medium');
        $('.dropzone').remove();
    });

    $('.openGalleryTest').click(function()
    {
        var c = 0;
        
        $('.existingItem li, .dropzoneArea li').each(function() {
            $(this).remove();
        });

        $('.albumName').val('');

        $('#galleryUpload').fadeIn('medium');

        $('#galleryUpload .dropInit>div').prepend('<form method="post" class="dropzone"></form>');

        $parents = $(this).parents('.dense');
        
        var whereToPut = $('.dropzoneArea'),
            dataW      = $('.dropzoneArea').data('adwidth'),
            dataH      = $('.dropzoneArea').data('adheight');
        
        var params = {
            model   : 'Gallery',
            field   : 'gallery',
            action  : 'update',
        };

        gallUploader = new Dropzone('.dropzone',
        {
            params: params,
            maxFiles: null,
            maxFilesize: 50,
            maxThumbnailFilesize: 10,
            url: uploadAlbumUrl,
            parallelUploads: 200,
            uploadMultiple: true,
            thumbnailWidth: null,
            thumbnailHeight: null,
            autoProcessQueue: false,
            acceptedFiles: 'image/*',
            previewsContainer: whereToPut,
            previewTemplate: '<li class="upItem"><div><button data-dz-remove><i class="fa fa-times"></i></button><img data-dz-thumbnail /><div class="uProgress"><span class="customBG" data-dz-uploadprogress></span></div></div></li>',
            success: function(file, response)
            {
                console.log(response);
                var imagesArray = $(".photos .images");
                var imagesGalleryArray = $(".netFlocos .galleryPager");
                var urlImage = response.response.data.response_data.files[c].web;

                urlImage = urlImage.replace('web.','');

                if(c == 0){
                    var contentGallery = '<li class="albumGallery" data-model="Gallery" data-foreign-key="' + response.response.data.albumId + '">';
                            contentGallery += '<a href="' + urlImage + '" data-kind="image">';
                                contentGallery += '<img src="' + response.response.data.response_data.files[c].web + '" alt="" class="galleryImage" data-smoothzoom="' + response.response.data.albumName + '">';
                            contentGallery += '</a>';
                            contentGallery += '<button class="removeAlbun galleryActions customBG"><i class="fa fa-trash-o"></i></button>';
                            contentGallery += '<button class="editAlbun galleryActions customBG"><i class="fa fa-pencil"></i></button>';
                        contentGallery += '</li>';

                    var content = '<li>';
                            content += '<a href="' + urlImage + '" data-kind="image">';
                                content += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="thumb' + response.response.data.albumName + '">';
                            content += '</a>';
                        content += '</li>';

                    imagesArray.find('li:last-child').remove();
                    imagesArray.prepend(content);

                    imagesGalleryArray.prepend(contentGallery);
                }else{
                    var html = '<a href="' + urlImage + '" data-kind="image">';
                            html += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="' + response.response.data.albumName + '">';
                        html += '</a>';

                    var html2 = '<a href="' + urlImage + '" data-kind="image">';
                            html2 += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="thumb' + response.response.data.albumName + '">';
                        html2 += '</a>';

                    imagesGalleryArray.find('li:first-child').append(html);
                    imagesArray.find('li:first-child').append(html2);
                }

                updateQueries();
                c++;
            },
            complete: function()
            {
                updateQueries();
                gallUploader.destroy();
                $('.dropzone').remove();
            },
        });
    });

    $('#saveAlbum').click(function() {

        var focus = $(this).data('focus');

        if(focus == 'edit'){

            var data = {
                name : $('.albumName').val(),
                id   : $('.albumGallery').data('foreign-key')
            };

            $.post(editAlbumUrl, data, function(response) {
                if (response.status == 'success') {
                    console.log(response);
                    console.log(gallUploaderEdit.files);
                    gallUploaderEdit.processQueue();
                }
            });

        }else if(focus == 'create'){

            var data = {
                name : $('.albumName').val(),
            };

            $.post(createAlbumUrl, data, function(response) {
                if (response.status == 'success') {
                    gallUploader.processQueue();
                }
            });
        }

        $(this).parents('#galleryUpload').fadeOut('medium');

    });

    function removeAlbun() 
    {
        var element = $(this).parents('.albumGallery');
        
        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreignKey')
        };
        console.log(element);
        console.log(params);
        $.post(liveEditUrl, params, function(response){
            console.log(response);
            if(response.response.status == "success"){
                element.remove();
            }
        });
        
        return false;
    }

    function editAlbun()
    {   
        
        $('.existingItem li, .dropzoneArea li').each(function() {
            $(this).remove();
        });

        $('.albumName').val('');

        var element = $(this).parents('.albumGallery');

        var params2 = {
            model      : element.data('model'),
            action     : 'update',
            foreignKey : element.data('foreignKey')
        };

        $.post(loadAlbumUrl, params2, function(response){
            console.log(response);
            if(response.response.status == 'success'){

                var albumName = response.response.data.Gallery.name;

                $('.albumName').val(albumName);
                $('#galleryUpload h3').text('Editar Album');

                $.each(response.response.data.AttachmentGallery, function(key, value){

                    var content = '<li class="imageAlbum" data-foreign-key="' + value.id + '" data-model="Attachment">';
                        content += '<div>';
                            content += '<button class="deleteImage"><i class="fa fa-times"></i></button>';
                            content += '<img src="/media/uploads/' + value.filename + '" alt=""/>';
                        content += '</div>';
                    content += '</li>';

                    $('.existingItem').append(content);
                });

            }

            updateQueries();
        });

        var c = 0;

        $('#galleryUpload').fadeIn('medium');

        $('#galleryUpload .dropInit>div').prepend('<form method="post" class="dropzone"></form>');

        $('#saveAlbum').attr('data-focus', 'edit');

        var whereToPut = $('.dropzoneArea');
        
        var params3 = {
            model   : 'Gallery',
            field   : 'gallery',
            action  : 'update',
        };
        console.log(params3);
        gallUploaderEdit = new Dropzone('.dropzone',
        {
            maxFiles: null,
            params: params3,
            url: uploadAlbumUrl,
            parallelUploads: 200,
            uploadMultiple: true,
            thumbnailWidth: null,
            thumbnailHeight: null,
            acceptedFiles: 'image/*',
            previewsContainer: whereToPut,
            previewTemplate: '<li class="upItem"><div><button data-dz-remove><i class="fa fa-times"></i></button><img data-dz-thumbnail /><div class="uProgress"><span class="customBG" data-dz-uploadprogress></span></div></div></li>',
            success: function(file, response)
            {
                console.log(response);
                var imagesArray = $(".photos .images");
                var imagesGalleryArray = $(".netFlocos .galleryPager");
                var urlImage = response.response.data.response_data.files[c].web;

                urlImage = urlImage.replace('web.','');

                if(c == 0){
                    var contentGallery = '<li class="albumGallery" data-model="Gallery" data-foreign-key="' + response.response.data.albumId + '">';
                            contentGallery += '<a href="' + urlImage + '" data-kind="image">';
                                contentGallery += '<img src="' + response.response.data.response_data.files[c].web + '" alt="" class="galleryImage" data-smoothzoom="' + response.response.data.albumName + '">';
                            contentGallery += '</a>';
                            contentGallery += '<button class="removeAlbun galleryActions customBG"><i class="fa fa-trash-o"></i></button>';
                            contentGallery += '<button class="editAlbun galleryActions customBG"><i class="fa fa-pencil"></i></button>';
                        contentGallery += '</li>';

                    var content = '<li>';
                            content += '<a href="' + urlImage + '" data-kind="image">';
                                content += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="thumb' + response.response.data.albumName + '">';
                            content += '</a>';
                        content += '</li>';

                    imagesArray.find('li:last-child').remove();
                    imagesArray.prepend(content);

                    imagesGalleryArray.prepend(contentGallery);
                }else{
                    var html = '<a href="' + urlImage + '" data-kind="image">';
                            html += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="' + response.response.data.albumName + '">';
                        html += '</a>';

                    var html2 = '<a href="' + urlImage + '" data-kind="image">';
                            html2 += '<img src="' + response.response.data.response_data.files[c].thumb + '" alt="" class="galleryImage" data-smoothzoom="thumb' + response.response.data.albumName + '">';
                        html2 += '</a>';

                    imagesGalleryArray.find('li:first-child').append(html);
                    imagesArray.find('li:first-child').append(html2);
                }
                updateQueries();
                c++;
            },
            error: function(response){
                console.log(response);
            },
            accept: function(file, done)
            {   
                var element = $('.dense .imageUploadHolder .dz-image img');
                var height;
                var width;
                element.load(function(){
                    height = $(this).height();
                    width  = $(this).width();
                    if(width < dataW || height < dataH){
                        done("Invalid dimenions");
                        swal("Tamanho incorreto!", 'Tamanho minimo precisa ser: ' + dataW + ' x ' + dataH + '', "error");
                    }else{
                        done();
                    }
                });
            }
        });
    }

    $('.deleteImage').click(deleteImageAlbum);

    function deleteImageAlbum() 
    {
        var element = $(this).parents('.imageAlbum');

        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreignKey'),
        };
        console.log(params);
        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
            }
        });
        
        return false;
    }
    
    $('#addSlider').click(newSlider);

    function newSlider()
    {
        var data = {
            model : 'Slider',
            fields : {
                title: 'Título do slider'
            }
        };

        $.post(addRowUrl, data, function(response)
        {
            if (response.response.status == 'success') {
                var content = '<li class="item">';
                        content += '<div class="dense d940-294 customColor no-link daBanner" data-adwidth="940" data-adheight="294" data-model="Slider" data-field="slider" data-foreign-key="' + response.response.data.foreignKey + '">';
                            content += '<div class="imageUploadHolder"></div>';
                            content += '<div class="editLayer">';
                                content += '<div>';
                                    content += '<ul class="clearfix">';
                                        content += '<li class="image">';
                                            content += '<a href="javascript:void(0);">';
                                                content += '<i class="fa fa-cloud-upload fa-2x"></i>';
                                                content += '<span>Enviar IMG</span>';
                                            content += '</a>';
                                        content += '</li>';
                                    content += '</ul>';
                                content += '</div>';
                            content += '</div>';
                            content += '<img src="http://placehold.it/940x295" alt="">';
                            content += '<div class="deleter">'
                                content += '<button class="deleteMyFather customBG" data-model="Slider" data-foreign-key="' + response.response.data.foreignKey + '"><i class="fa fa-trash-o"></i></button>';
                            content += '</div>';
                        content += '</div>';
                        content += '<div class="labelContent">';
                            content += '<span class="liveT" data-model="Slider" data-field="title" data-foreign-key="' + response.response.data.foreignKey + '">' + data.fields.title + '</span>';
                        content += '</div>';
                    content += '</li>';

                var thumb = '<li class="item" style="background: url(\'http://placehold.it/94x85\') center center; background-size: cover;"></li>'

                $("#mainSlider").data('owlCarousel').addItem(content, 0);
                $("#thumbSlider").data('owlCarousel').addItem(thumb, 0);

                updateQueries();
            }
        });
    }

    function deleteBannerItem()
    {
        var eq = $(this).parents('.owl-item').index(),  
            data = $(this).data();

        swal(
        {
          title: "Excluir?",
          text: "Você não poderá desfazer esta ação!",
          type: "warning",
          showCancelButton: true,
          confirmButtonText: "Cancelar",
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Sim, excluir.",
          closeOnConfirm: false
        },
        function()
        {
            if (data.foreignKey == '') {
                $("#mainSlider").data('owlCarousel').removeItem(eq);
                $("#thumbSlider").data('owlCarousel').removeItem(eq);

                swal("Excluído", 'Excluído com sucesso!', "success");

                return;
            }

            $.post(deleteRowUrl, data, function(response)
            {
                if (response.response.status == 'success') {
                    $("#mainSlider").data('owlCarousel').removeItem(eq);
                    $("#thumbSlider").data('owlCarousel').removeItem(eq);

                    swal("Excluído", response.response.message, "success");
                }
            });
        });
    }

    $('#thang').click(manageHoroscope);
    $('#autoplay').click(manageAutoplay);

    function manageAutoplay()
    {
        var element = $(this);
        var value;

        if(element.is(':checked')){
            value = 1
        }else{
            value = 0;
        }

        var params = {
            model      : 'Radio',
            field      : 'autoplay',
            action     : 'update',
            value      : value,
            foreignKey : element.data('model-id')
        };
        console.log(params);
        $.post(liveEditUrl, params, function(response){
            console.log(response);
        });
    }

    function manageHoroscope()
    {
        var element = $(this);
        var value;
        var horoscope = $('.horoscopo');

        if(element.is(':checked')){
            value = 1
        }else{
            value = 0;
        }

        var params = {
            model      : 'Radio',
            field      : 'horoscope',
            action     : 'update',
            value      : value,
            foreignKey : element.data('model-id')
        };
        console.log(params);
        $.post(liveEditUrl, params, function(response){
            if(response.response.status == 'success'){
                if(value == 1){
                    horoscope.show();
                }
                if(value == 0){
                    horoscope.hide();
                }   
            }
        });
    }
    
    function updateFractions() {
        
        $('.fractionFather').each(function() {
            
            var father = $(this);
            
            $(this).find('.item').each(function() {
                $(this).appendTo('.fractionHolder');
            });
            
            father.find('li').remove();
            father.append('<li></li>');
            
            var count = 0;
            
            $('.fractionHolder .item').each(function(e) {
                
                var lastItem = father.find('>li:last-child');
                
                if(count == 0) {
                    $(this).appendTo(lastItem);
                    count++;
                }else if(count < 3){
                    $(this).appendTo(lastItem);
                    count++;
                }else{
                    father.append('<li></li>');
                    lastItem = father.find('>li:last-child');
                    $(this).appendTo(lastItem);
                    count = 1;
                }
                
            });
        });
        
        nniSlider();
        
    }
    
    updateFractions();

    $('.videoForm').submit(function(e)
    {
        var element = $(this);
        var url  = element.find('input#videoURL').val();
        var toggle = $('#videoType');
        
        if (toggle.is(':checked')) {
            var type = 'vimeo';
        } else {
            var type = 'youtube';
        }

        var id = url.split("=");
            id = id[1];


        var params = {
            'url'  : url,
            'type' : type
        };
        
        function ValidUrl(str) {

          var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
          '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
          '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
          '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
          '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
          '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
          if(!pattern.test(str)) {
              
              swal("Link incorreto!", 'Você precisa cadastrar a URL completa do vídeo', "error");
              
            return false;

          } else {

                $.post(saveVideoUrl, params, function(response){
                    console.log(response);
                    if(response.status == 'success'){

                        if(type == 'youtube') {
                            thumbURL = 'http://img.youtube.com/vi/' + id + '/maxresdefault.jpg';
                        }

                        if(type == 'vimeo') {
                            thumbURL = 'http://i.vimeocdn.com/video/' + id + '.jpg';
                        }

                        var videoItem = '<li style="background: url(' + thumbURL + ') center center; background-size: cover;">';
                        videoItem += '<a href="' + id + '" data-kind="' + type + '">';
                        videoItem += '<img src="' + thumbURL + '" alt="" data-smoothzoom="' + id + '" class="galleryImage" style="opacity: 0;" height="190" width="190">';
                        videoItem += '</a>';
                        videoItem += '<div class="playButton"><div><i class="fa fa-play-circle-o fa-3x customColor"></i></div></div>';
                        videoItem += '<button class="removeVideo galleryActions customBG"><i class="fa fa-trash-o"></i></button>';
                        videoItem += '</li>';

                        $('ul.videoSlider').prepend(videoItem);
                        $('.videoSlider ul li:last-child').remove();
                        $('.videoSlider ul').prepend(videoItem);

                        updateQueries();

                        resetAddVideo();

                    }
                });
            return true;
          }
        }
        
        ValidUrl(url);

        return false;
    });

    function removeVideo()
    {
        var element = $(this).parents('li.videoItem');

        var params = {
            model      : 'Video',
            action     : 'delete',
            foreignKey : element.attr('data-foreign-key'),
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
            }
        });
        
        return false;
    }

    function addVideo() {
        $('.videoAdder').fadeIn();
        // var id = 'gy1B3agGNxw';
        // var type = 'youtube';
        // var thumbURL = 'youtube';
    }
    
    function resetAddVideo() {
        $('.videoAdder').fadeOut();
        $('.videoAdder input').val('');
    }

    $('.addNewVideo').on('click', addVideo);
        
    $('.cancelApplyVideo').on('click', resetAddVideo);
    
    $('.addDense').click(function() {

        var parent = $(this).parent();
        var whereToInsert = parent.find('.frame>ul>li:last-child');
        var model = $(this).data('model');

        var params = {
            model  : 'Banner',
            action : "create",
            type   : "banner",
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == 'success'){
                console.log(response);
                var blockDense = '<div class="dense d300-300 customColor" data-adwidth="300" data-adheight="300" data-model="Banner" data-field="block" data-foreign-key="' + response.response.data.id + '">';
                    blockDense += '<div class="imageUploadHolder"></div>';
                    blockDense += '<div class="editLayer"><div>';
                    blockDense += '<ul class="clearfix">';
                    blockDense += '<li class="image"><a href="javascript:void(0);"><i class="fa fa-cloud-upload fa-2x"></i><span>Enviar IMG</span></a><div class="toltip customBG hidden">Tamanho da imagem 300x300</div></li>';
                    blockDense += '<li class="link"><a href="javascript:void(0);"><i class="fa fa-link fa-2x"></i><span>Link</span></a><div class="toltip customBG hidden"><input class="liveT" data-model="Banner" data-field="link" data-foreign-key="' + response.response.data.id + '" placeholder="http://" value="" type="text"></div></li>';
                    blockDense += '<li class="delete"><a href="javascript:void(0);"><i class="fa fa-trash-o fa-2x"></i><span>Excluir</span></a></li>';
                    blockDense += '</ul>';
                    blockDense += '</div>';
                    blockDense += '</div>';
                    blockDense += '<img src="http://placehold.it/300x300" alt="">';
                    blockDense += '<button class="deleteBlock customBG" data-model="Banner" data-foreign-key="' + response.response.data.id + '"><i class="fa fa-trash-o"></i></button>';
                    blockDense += '</div>';
                
                $('.threeBlocksAsside').append(blockDense);

                updateQueries();
            }
        });
    });
    
    function deleteBlocks() {
        var element = $(this).parent('.dense');
        
        var params = {
            model      : element.data('model'),
            action     : 'delete',
            foreignKey : element.data('foreign-key')
        };

        $.post(liveEditUrl, params, function(response){
            if(response.response.status == "success"){
                element.remove();
            }
        });
        
        return false;
    }
    
    function updateQueries()
    {
        removeQueries();

        $('.liveT')
            .on('dblclick', allowEdit)
            .on('focus', liveFocusHandler)
            .on('blur', saveMe)
            .on('keydown', liveKeyDownHandler)
            .on('keypress', liveKeyPressHandler)
            .on('keyup', liveKeyUpHandler);

        $('.deleteMyFather').on('click', deleteBannerItem);

        $('.editLayer li > a').on('click', denseActionColors);

        $('.editLayer li.delete').on('click', denseImageDelete);

        $('.editLayer li.image').on('click', dropStarter);

        $('.dense.d32-32 img').on('click', dropStarter);

        $('.removeScript').on('click', removeScript);

        $('textarea.liveT, input.liveT').on('click', allowEdit);

        $('.deleteFraction').on('click', deleteFraction);
        
        $('.promoInit').on('click', promoInit);

        $('.canceller').on('click', promoCloser);

        $('.deleteImage').on('click', deleteImageAlbum);
        
        $('.deleteBlock').on('click', deleteBlocks);
        
        $('.netFlocos ul').each(netFlocosInit);
        
        $('.removeVideo').on('click', removeVideo);

        $('.removeAlbun').on('click', removeAlbun);

        $('.editAlbun').on('click', editAlbun);
        
        $('.galleryImage').smoothZoom({
            zoominSpeed  : '100',
            zoomoutSpeed : '100',
            closeButton  : true,
            showCaption  : false
        });
    }

    function removeQueries()
    {
        $('.liveT')
            .off('dblclick', allowEdit)
            .off('focus', liveFocusHandler)
            .off('blur', saveMe)
            .off('keydown', liveKeyDownHandler)
            .off('keypress', liveKeyPressHandler)
            .off('keyup', liveKeyUpHandler);

        $('.removeScript').off('click', removeScript);

        $('.deleteMyFather').off('click', deleteBannerItem);

        $('.editLayer li > a').off('click', denseActionColors);

        $('.editLayer li.delete').off('click', denseImageDelete);

        $('.editLayer li.image').off('click', dropStarter);

        $('.dense.d32-32 img').off('click', dropStarter);

        $('textarea.liveT, input.liveT').off('click', allowEdit);

        $('.deleteFraction').off('click', deleteFraction);
        
        $('.promoInit').off('click', promoInit);

        $('.canceller').off('click', promoCloser);

        $('.deleteImage').off('click', deleteImageAlbum);

        $('.deleteBlock').off('click', deleteBlocks);
        
        $('.removeVideo').off('click', removeVideo);

        $('.removeAlbun').off('click', removeAlbun);

        $('.editAlbun').off('click', editAlbun);
    }

    updateQueries();

});
