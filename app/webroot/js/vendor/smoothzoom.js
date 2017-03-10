(function($) {
	$.fn.extend({
		smoothZoom: function(options) {
			var defaults = {
				zoominSpeed: 800,
				zoomoutSpeed: 400,
				zoominEasing: 'easeOutExpo',
				zoomoutEasing: 'easeOutExpo',
				navigationButtons: 'true',
				closeButton: 'false',
				showCaption:'true'
			}

            var laHeight = $(window).height() - 190;
			var options = $.extend(defaults, options);

			$('img[data-smoothzoom]').click(function(event) {

				var link = $(this).attr('src'),
					largeImg = $(this).parent().attr('href'),
					kind = $(this).parent().data('kind'),
					groupName = $(this).data('smoothzoom'),
					target = $(this).parent().attr('target'),
					offset = $(this).offset(),
					width = $(this).width(),
					height = $(this).height(),
					amountScrolled = $(window).scrollTop(),
					viewportWidth = $(window).width(),
					viewportHeight = $(window).height(),
                    vimeo = '<iframe src="https://player.vimeo.com/video/' + largeImg + '?badge=0" width="853" height="480" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> ',
                    youtube = '<iframe width="853" height="480" src="https://www.youtube.com/embed/' + largeImg + '" frameborder="0" allowfullscreen></iframe>';

                $(this).attr('id', 'lightzoomed');

                if (kind == 'vimeo') {
                    $('body').append('<div class="sz-overlay"><a href="#" class="sz-zoomed">&nbsp;</a><div class="videoHolder">' + vimeo + '</div><div class="sz-ui"></div></div>');
                }

                if (kind == 'youtube') {
                    $('body').append('<div class="sz-overlay"><a href="#" class="sz-zoomed">&nbsp;</a><div class="videoHolder">' + youtube + '</div><div class="sz-ui"></div></div>');
                }

                if (kind == 'image') {
                    var group = '<div class="deslizer"><button data-function="prev"><i class="fa fa-chevron-left fa-2x customColor"></i></button><button data-function="next" class="right"><i class="fa fa-chevron-right fa-2x customColor"></i></button><ul id="thumbers" data-left="0">';

                    $('img[data-smoothzoom]').each(function(key, value){
                        var attr = $(this).parent().attr('href');
                        if($(this).data('smoothzoom') == groupName){
                            group += '<li style="background-image:url('+ attr +');" data-src="'+ attr +'"></li>';
                        }
                    });

                    group += '</ul></div>';

                    var thumbers = group;
                    $('body').append("<div class='sz-overlay'><a href='#' class='sz-zoomed' style='background:url(" + largeImg + ")'>&nbsp;</a><div class='sz-ui'></div></div>");
                    $('.sz-overlay').append(thumbers);
                    $('#thumbers li').eq(0).addClass('currentImage');

                    var groupName = $('#lightzoomed').data('smoothzoom'),
                        groupTotal = $('img[data-smoothzoom="' + groupName + '"]').length;

                    if (options.navigationButtons == 'true' && groupTotal > 1) {$('.sz-overlay').append("<a href='#' class='sz-left customBG'><i class='fa fa-chevron-left fa-2x'></i></a><a href='#' class='sz-right customBG'><i class='fa fa-chevron-right fa-2x'></i></a>");}



                    $('.deslizer ul#thumbers').each(function() {
                        var deslizer = $(this);
                        var itemWidth = deslizer.find('li').width() + 6;
                        var quanty = deslizer.find('li').length;
                        var windowW = $(window).width();
                        var nfWidth = quanty * itemWidth;

                        if(nfWidth < windowW){
                            deslizer.width(windowW);
                            $('.deslizer button').hide();
                        } else {
                            deslizer.width(nfWidth);
                        }
                    });

                    var netFlocos;
                    var intervalId = null;

                    $('.deslizer button').on('mouseover', function() {
                        var theFunction = $(this).data('function');
                        var parentWidth = $(this).parent().width();
                        netFlocos = $(this).parent().find('ul');
                        var left = netFlocos.data('left');
                        var nfWidth = netFlocos.width();
                        var diference = parentWidth - nfWidth;
                        animaMe();
                        intervalId = setInterval(animaMe, 20);
                        function animaMe() {
                            if(theFunction == 'prev' && left < 0) {
                                left += 10;
                                netFlocos.css({
                                    '-webkit-transform': 'translateX(' + left + 'px)',
                                    '-moz-transform': 'translateX(' + left + 'px)',
                                    '-ms-transform': 'translateX(' + left + 'px)',
                                    '-o-transform': 'translateX(' + left + 'px)',
                                    'transform': 'translateX(' + left + 'px)'
                                });
                                netFlocos.data('left', left);
                            }
                            if(theFunction == 'next' && left > diference) {
                                left -= 10;
                                netFlocos.css({
                                    '-webkit-transform': 'translateX(' + left + 'px)',
                                    '-moz-transform': 'translateX(' + left + 'px)',
                                    '-ms-transform': 'translateX(' + left + 'px)',
                                    '-o-transform': 'translateX(' + left + 'px)',
                                    'transform': 'translateX(' + left + 'px)'
                                });
                                netFlocos.data('left', left);
                            }
                        }
                    }).on('mouseleave', function() {
                        clearInterval(intervalId);
                    });
                }

                if (options.closeButton == 'true') {$('.sz-overlay').append("<a href='#' class='sz-close'>&#10006;</a>")}

                if (options.showCaption == 'true') {$('.sz-overlay').append("<div class='sz-caption'></div>");caption();}

                $('.sz-overlay, .sz-left, .sz-right').fadeIn('medium', function() {
                    $('.sz-overlay').css({
                        display: 'table'
                    });
                });

                $('.sz-zoomed').css({
                    width: width,
                    height: height,
                    top: (offset.top - amountScrolled),
                    left: offset.left
                });
                $('.sz-zoomed').animate({
                    width: '90%',
                    height: laHeight,
                    top: '70px',
                    left: '5%'
                }, options.zoominSpeed, options.zoominEasing);

                $('#thumbers li').click(function() {
                    var attr = $(this).data('src'),
                        eqw = $(this).eq(),
                        currentIndex = $('#lightzoomed').index('[data-smoothzoom="' + groupName + '"]'),
                        groupTotal = $('img[data-smoothzoom="' + groupName + '"]').length,
                        nextIndex = currentIndex + 1;

                    $('#thumbers li').removeClass('currentImage');
                    $(this).addClass('currentImage');

					$('.sz-caption').fadeOut();
					$('.sz-zoomed').animate({
						width: '90%',
                        height: laHeight,
						top: '70px',
						left: '10%',
						opacity:'0'
					}, function(){
						// find next image
						$('[data-smoothzoom="' + groupName + '"]:eq(' + eqw + ')').attr('id', 'lightzoomed');
						// set new background and initial CSS state
						$('.sz-zoomed').css({
							background: 'url(' + attr + ')',
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '10%',
							opacity:'0'
						});
						// animate back in
						$('.sz-zoomed').animate({
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '5%',
							opacity:'1'
						});
						caption();
					});
                });
				event.preventDefault();
			});


			$(document.body).on("click", ".sz-zoomed, .sz-close", function(event) {
				closeAll();
				event.preventDefault();
			});

			$(document.body).on("click", ".sz-right", function(event) {
				advanceGroup();
				event.preventDefault();
			});

			$(document.body).on("click", ".sz-left", function(event) {
				devanceGroup();
				event.preventDefault();
			});

			function caption(){
				if (options.showCaption == 'true') {
					var currentCap = $('#lightzoomed').attr('alt');
					if(currentCap) {
						$(".sz-caption").html("<span>" + currentCap+ "</span>").fadeIn();
					} else {
						$(".sz-caption").empty();
					}
				}
			}

			function closeAll() {
					var offset = $("#lightzoomed").offset(),
					originalWidth = $("#lightzoomed").width(),
					originalHeight = $("#lightzoomed").height(),
					amountScrolled = $(window).scrollTop();
				$('.sz-overlay, .sz-left, .sz-right').fadeOut();
				$('.sz-zoomed').animate({
					width: originalWidth,
					height: originalHeight,
					top: (offset.top - amountScrolled),
					left: offset.left
				}, options.zoomoutSpeed, options.zoomoutEasing, function() {
					$('.sz-zoomed, .sz-overlay, .sz-right, .sz-left, .sz-caption, .sz-close').remove();
					$('#lightzoomed').removeAttr('id');
				});
			}

			// Move forward in group
			function advanceGroup() {
				var groupName = $('#lightzoomed').data('smoothzoom'),
					currentIndex = $('#lightzoomed').index('[data-smoothzoom="' + groupName + '"]'),
					groupTotal = $('img[data-smoothzoom="' + groupName + '"]').length,
					nextIndex = currentIndex + 1;



				// if at end
				if (nextIndex >= groupTotal) {
					// do a little bounce
					$('.sz-zoomed').animate({
						width: '90%',
                        height: laHeight,
						top: '70px',
						left: '10%'
					},200, function(){
						$('.sz-zoomed').animate({
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '5%'
						},200);
					});
				} else {
                    $('#thumbers li').removeClass('currentImage');
                    $('#thumbers li').eq(nextIndex).addClass('currentImage');
					// fade out and remove current image
					$("#lightzoomed").removeAttr('id');
					$('.sz-caption').fadeOut();
					$('.sz-zoomed').animate({
						width: '90%',
                        height: laHeight,
						top: '70px',
						left: '15%',
						opacity:'0'
					}, function(){
						// find next image
						$('[data-smoothzoom="' + groupName + '"]:eq(' + nextIndex + ')').attr('id', 'lightzoomed');
						var newImg = $("#lightzoomed").parent().attr('href');
						// set new background and initial CSS state
						$('.sz-zoomed').css({
							background: 'url(' + newImg + ')',
							width: '90%',
							height: laHeight,
							top: '70px',
							left: '0',
							opacity:'0'
						});
						// animate back in
						$('.sz-zoomed').animate({
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '5%',
							opacity:'1'
						});
						caption();
					});
				}
			}

			// Go Back in Group
			function devanceGroup() {
				var groupName = $('#lightzoomed').data('smoothzoom'),
					currentIndex = $('#lightzoomed').index('[data-smoothzoom="' + groupName + '"]'),
					groupTotal = $('img[data-smoothzoom="' + groupName + '"]').length,
					nextIndex = currentIndex - 1;



				// if at end
				if (nextIndex <= -1) {
					// do a little bounce
					$('.sz-zoomed').animate({
						width: '90%',
                        height: laHeight,
						top: '70px',
						left: '0'
					},200, function(){
						$('.sz-zoomed').animate({
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '5%'
						},200);
					});
				} else {
                    $('#thumbers li').removeClass('currentImage');
                    $('#thumbers li').eq(nextIndex).addClass('currentImage');
					// fade out and remove current image
					$("#lightzoomed").removeAttr('id');
					$('.sz-caption').fadeOut();
					$('.sz-zoomed').animate({
						width: '90%',
						height: laHeight,
						top: '70px',
						left: '0',
						opacity:'0'
					}, function(){
						// find next image
						$('[data-smoothzoom="' + groupName + '"]:eq(' + nextIndex + ')').attr('id', 'lightzoomed');
						var newImg = $("#lightzoomed").parent().attr('href');
						// set new background and initial CSS state
						$('.sz-zoomed').css({
							background: 'url(' + newImg + ')',
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '15%',
							opacity:'0'
						});
						// animate back in
						$('.sz-zoomed').animate({
							width: '90%',
                            height: laHeight,
							top: '70px',
							left: '5%',
							opacity:'1'
						});
						caption();
					});
				}
			}

			// Keyboard shortcuts
			$(document).keydown(function(e) {
				switch (e.which) {
					case 37: // Left arrow
						if ($('.sz-overlay').length) {
							devanceGroup();
						}
						break;

					case 39: // Right arrow
						if ($('.sz-overlay').length) {
							advanceGroup();
						}
						break;

					case 27: // Escape key
						closeAll();
						break;

					case 40: // Down arrow
						closeAll();
						break;

					default:
						return; // exit this handler for other keys
				}
				e.preventDefault();
			});

		}
	});
})(jQuery);
