function video_process(iframe, command) {
    if (iframe.length > 0) {
        iframe.each(function () {
            $(this)[0].contentWindow.postMessage(`{"event":"command","func":"${command}","args":""}`, '*');
        });
    }
}
function video_process_check(type_slider) {
    var loader_video;
    if (type_slider == 'product-video-active') {
        loader_video = setInterval(function () {
            if (($('.product-slider__wrapper').find('.product-video').length > 0) && ($('.product-slider__wrapper').find('.product-video').parent().parent().hasClass('swiper-slide-active'))) {
                if ($('.product-video').hasClass('pause')) {
                    clearInterval(loader_video);
                }
            }
            else {
                var iframe = $('.product-video').find('iframe');
                var command = 'pauseVideo';
                video_process(iframe, command);
                clearInterval(loader_video);
            }
        }, 0);
    }
    else if (type_slider == 'product-video-popup-active') {
        loader_video = setInterval(function () {
            if (($('.popup-img-wrapper').find('.product-video-popup').length > 0) && ($('.popup-img-wrapper').find('.product-video-popup').parent().hasClass('swiper-slide-active'))) {
                if ($('.product-video-popup').hasClass('pause')) {
                    clearInterval(loader_video);
                }
            }
            else {
                var iframe = $('.product-video-popup').find('iframe');
                var command = 'pauseVideo';
                video_process(iframe, command);
                clearInterval(loader_video);
            }
        }, 0);
    }



}
function object_video() {
    video_mini = $('.image-slider__image .product-video').find('.video');
    video_popup = $('.modal-img .product-video-popup').find('.video');
}


// Данная функция сработает при вызове initialize()
function updateTimerDisplay() {
    // Обновление текущего времени.
    //console.log(formatTime(player.getCurrentTime()));
    //console.log(player.getCurrentTime());
    var time_code_video = player.getCurrentTime();
    $('.product-video, .product-video-popup').attr('data-time', time_code_video);

    // var duration_video = player.getDuration();
    // $('.range-input').attr('max', duration_video);
}

// function formatTime(time) {
//     time = Math.round(time);
//     var minutes = Math.floor(time / 60),
//         seconds = time - minutes * 60;
//     seconds = seconds < 10 ? '0' + seconds : seconds;
//     return minutes + ":" + seconds;
// }

// $('#progress-bar').on('mouseup touchend', function (e) {

//     // Вычисление нового времени.
//     // новое время в секундах = общая время видео * ( значение поля / 100 )
//     var newTime = player.getDuration() * (e.target.value / 100);

//     // Воспроизведение видео с нового времени.
//     player.seekTo(newTime);

// });
// // Данная функция будет вызвана в initialize()
// function updateProgressBar() {
//     // Update the value of our progress bar accordingly.
//     $('#progress-bar').val((player.getCurrentTime() / player.getDuration()) * 100);
// }

$(function () {
    // ВИДЕО В АРХИВАХ
    if ($('.video').find('.four-cards').length > 0) {
        var overlay = $('#overlay');
        var player_error = $('.block__video-error');

        $(document).on('click', '.video-card.btn-play', function () {
            var th = $(this);
            var id_video = th.attr('data-id');
            var url_bgc = th.find('.video-card__video').attr('style');
            var player = $('.player__video');
            var player_loaded = player.attr('data-loaded');
            blockVideoError = $(`.block__video-error[data-i='${id_video}']`);

            if (id_video !== player_loaded || blockVideoError.hasClass('active')) {
                player.find('iframe').remove();
                if (!player.find('.video').length > 0) {
                    player.find('button').after(`<div class="video" id="${id_video}" data-params="loop=1&playlist=${id_video}&enablejsapi=1" data-id="${id_video}">`);
                    // &origin=http://example.com
                }
                else {
                    player.find('.video').attr('id', id_video);
                    player.find('.video').attr('data-id', id_video);
                }
                player.find('.video').attr('style', url_bgc);
                player.attr('data-loaded', id_video);
                player.find('.play__btn').attr('data-btn', id_video);
                player.find('.block__video-error').attr('data-i', id_video);
                player.find('.video').trigger('click');
            }
            else {
                var player_iframe = player.find('iframe');
                command = 'playVideo';
                video_process(player_iframe, command);
            }
            player.fadeIn();
            overlay.fadeIn();
        });






        // closeButton = $('.player__video .close-button');
        $(document).on('click', '.player__video .close-button', function () {
            var th = $(this);
            var popupIframe = th.parent().find('iframe');
            var command = 'pauseVideo';
            video_process(popupIframe, command);
            th.parent().fadeOut();
            overlay.fadeOut();
            // overlay.removeClass('active');
            if (player_error.hasClass('active')) {
                //player_error.removeClass('active');
                console.log('есть ошибка. актив');
                player_error.fadeOut();
                if (player_error.hasClass('no-network')) {
                    setTimeout(() => { player_error.removeClass('no-network'); }, 500);
                }
            }
            $('.player__video').removeAttr('style');
        });


        $(document).mouseup(function (e) {
            var div = $(".popup-video");
            if (!div.is(e.target) && div.has(e.target).length === 0) {
                div.find('.close-button').trigger('click');
                $('.player__video').removeAttr('style');
            }
        });


    }
    if (($('.video').find('.four-cards').length > 0) || ($('.product-slider').find('.video').length > 0)) {

        $(document).on('click', '.block__video-error .page-reload', function () {
            location.reload();
        });

        $(document).on('click', '.play__btn', function () {
            var iframeid;
            var command = 'playVideo';
            if ($(this).hasClass('play-btn-product-video') || $(this).hasClass('loading_video')) {
                if ($('.product-video iframe').length > 0) {

                    iframeid = $('iframe[player-point="product-video-active"]');
                    video_process(iframeid, command);
                }
                else {
                    $('.product-video .video').trigger('click');
                }

            }
            else if ($(this).hasClass('play-btn-product-video-popup')) {
                if ($('.product-video-popup iframe').length > 0) {
                    iframeid = $('iframe[player-point="product-video-popup-active"]');
                    video_process(iframeid, command);
                }
                else {
                    $('.product-video-popup .video').trigger('click');
                }
            }

            else if ($(this).hasClass('play-btn-popup-video')) {
                if ($('.popup-video iframe').length > 0) {
                    iframeid = $('iframe[player-point="popup-video-active"]');
                    video_process(iframeid, command);
                }
                else {
                    $('.popup-video .video').trigger('click');
                }
            }

        });

        $(document).on('click', '.player__video .video', function () {
            var th = $(this);
            var type_slider;
            if (th.parent().hasClass('product-video')) {
                type_slider = 'product-video-active';
                video_process_check(type_slider);
            }
            else if (th.parent().hasClass('product-video-popup')) {
                type_slider = 'product-video-popup-active';
                video_process_check(type_slider);
            }
            var video_from = th.parent();

            // Создаем iFrame и сразу начинаем проигрывать видео, т.е. атрибут autoplay у видео в значении 1
            var iframe = document.createElement("iframe");
            var data_id = this.getAttribute("id");
            var iframe_url = "https://www.youtube.com/embed/" + this.id + "?rel=0&modestbranding=1&playsinline=0&showinfo=0";
            if (this.getAttribute("data-params")) iframe_url += '&' + this.getAttribute("data-params");
            iframe.setAttribute("src", iframe_url);
            iframe.setAttribute("id", data_id);
            if (video_from.hasClass('product-video')) {
                iframe.setAttribute("player-point", 'product-video-active');
            }
            else if (video_from.hasClass('product-video-popup')) {
                iframe.setAttribute("player-point", 'product-video-popup-active');
            }
            else if (video_from.hasClass('popup-video')) {
                iframe.setAttribute("player-point", 'popup-video-active');
            }
            iframe.setAttribute("frameborder", '0');
            iframe.setAttribute("allowfullscreen", '');
            iframe.setAttribute('allow', 'autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
            // Высота и ширина iFrame будет как у элемента-родителя
            iframe.style.width = this.style.width;
            iframe.style.height = this.style.height;
            // Заменяем начальное изображение (постер) на iFrame
            this.parentNode.replaceChild(iframe, this);

            //var player;
            //Создаем свой плеер, со своими характеристиками
            function onYouTubePlayerAPIReady(event) {

                player = new YT.Player(data_id, {
                    events: {
                        'onReady': onReady,
                        'onError': onPlayerError,
                    }
                });
            }
            onYouTubePlayerAPIReady();
            //Привязываем скрипты API YouTube, чтобы наши функции заработали
            // var tag = document.createElement('script');
            // tag.src = "https://www.youtube.com/player_api";
            // var firstScriptTag = document.getElementsByTagName('script')[0];
            // firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            //Событие, когда слушается статус видео
            function onReady(event) {
                var time_code_video = $('.player__video').attr('data-time');
                if (time_code_video) {
                    event.target.seekTo(time_code_video);
                }
                event.target.setVolume(70);
                //event.target.getPlaybackQuality(hd720);
                event.target.playVideo();

                var id_player = event.target.getIframe().id;
                var class_player_iframe = $(event.target.getIframe()).attr('player-point');
                var class_player;
                if (class_player_iframe == 'product-video-active') {
                    class_player = 'play-btn-product-video';
                }
                else if (class_player_iframe == 'product-video-popup-active') {
                    class_player = 'play-btn-product-video-popup';
                }
                else if (class_player_iframe == 'popup-video-active') {
                    class_player = 'play-btn-popup-video';
                }
                var playId = $(`.play__btn.${class_player}[data-btn='${id_player}']`);
                var videoIframe = playId.parent().find('iframe');
                var blockVideoError = playId.parent().find('.block__video-error');
                //var blockVideoErrorIcon = blockVideoError.find('span');

                player.addEventListener('onStateChange', function (e) {
                    var statusVideo;
                    //Создаем свою переменную и указываем e.data обязательно для прослушивания статуса
                    statusVideo = e.data;
                    // console.log(statusVideo);
                    // var id_player = event.target.getIframe().id;
                    // var class_player_iframe = $(event.target.getIframe()).attr('player-point');
                    //var class_player_iframe = event.target.getIframe().className;
                    // var class_player;
                    // if (class_player_iframe == 'product-video-active') {
                    //     class_player = 'play-btn-product-video';
                    // }
                    // else if (class_player_iframe == 'product-video-popup-active') {
                    //     class_player = 'play-btn-product-video-popup';
                    // }
                    // else if (class_player_iframe == 'popup-video-active') {
                    //     class_player = 'play-btn-popup-video';
                    // }

                    // var playId = $(`.play__btn.${class_player}[data-btn='${id_player}']`);
                    //Событие, когда видео на паузе
                    if (statusVideo === 2) {
                        updateTimerDisplay();
                        //console.log('пауза');
                        playId.css({ "opacity": "1", "display": "block" });
                        playId.parent().removeClass('play');
                        playId.parent().addClass('pause');
                    }
                    //Событие, когда видео воспроизводится
                    else if (statusVideo === 1) {
                        //console.log('воспроизводится');
                        playId.css({ "opacity": "0", "display": "none" });
                        playId.parent().removeClass('pause');
                        playId.parent().addClass('play');
                        video_process_check(class_player_iframe);
                    }

                });

                //Событие, когда нет связи с Интернетом и показываем ошибку пользователю
                if (!window.navigator.onLine) {
                    playId.css({ "opacity": "0", "display": "none" });
                    videoIframe.fadeOut();
                    setTimeout(() => {
                        blockVideoError.addClass('no-network active');
                        blockVideoError.fadeIn();
                        //blockVideoErrorIcon.fadeIn();
                    }, 500);
                }






                // var videoIframeId = event.target.getIframe().id;
                // var playId = $(`.play__btn[data-btn='${videoIframeId}']`);
                // var videoIframe = $(`iframe[id='${videoIframeId}']`);
                // var blockVideoError = $(`.block__video-error[data-i='${videoIframeId}']`);
                // var blockVideoErrorIcon = $(`iframe[id='${videoIframeId}']`).parent().find('.loader-error span');
                // if (window.navigator.onLine) { } else {
                //     playId.css({ "opacity": "0", "display": "none" });
                //     videoIframe.fadeOut();
                //     setTimeout(() => {
                //         blockVideoError.addClass('active no-network');
                //         blockVideoError.fadeIn();
                //         blockVideoErrorIcon.fadeIn();
                //     }, 500);
                // }

            }


            //Событие, когда URL неверный или видео не доступно. По API это ошибка №5
            function onPlayerError(event) {
                var sError;
                // var videoIframeId = event.target.getIframe().id;
                // var playId = $(`.play__btn[data-btn='${videoIframeId}']`);
                // var videoIframe = $(`iframe[id='${videoIframeId}']`);
                // var blockVideoError = $(`.block__video-error[data-i='${videoIframeId}']`);
                // var blockVideoErrorIcon = $(`iframe[id='${videoIframeId}']`).parent().find('.loader-error span');

                var id_player = event.target.getIframe().id;
                var class_player_iframe = $(event.target.getIframe()).attr('player-point');


                var class_player;
                if (class_player_iframe == 'product-video-active') {
                    class_player = 'play-btn-product-video';
                }
                else if (class_player_iframe == 'product-video-popup-active') {
                    class_player = 'play-btn-product-video-popup';
                }
                else if (class_player_iframe == 'popup-video-active') {
                    class_player = 'play-btn-popup-video';
                }

                var playId = $(`.play__btn.${class_player}[data-btn='${id_player}']`);

                var videoIframe = playId.parent().find('iframe');
                var blockVideoError = playId.parent().find('.block__video-error');
                //sError = player.getPlayerState();
                sError = event.data;
                if (sError === 2 || 5 || 100 || 101 || 150) {
                    playId.css({ "opacity": "0", "display": "none" });
                    videoIframe.fadeOut();
                    setTimeout(() => {
                        blockVideoError.addClass('active');
                        blockVideoError.fadeIn();
                        //blockVideoErrorIcon.fadeIn();
                    }, 500);

                }
            }
            setTimeout(() => {
                $('.player__video').css('background', 'transparent');
            }, 2000);

        });



        $(document).on('click', '.image-slider__image', function () {
            object_video();
            if ($('.modal-img').is(':visible')) {
                var play_btn = $('.play-btn-product-video');
                // var video_mini = $('.image-slider__image .product-video').find('.video');
                if (video_mini.length > 0) {
                    video_mini.attr('data-blocked-id', video_mini.attr('id'));
                    video_mini.removeAttr('id');
                }
                else {
                    player.pauseVideo();
                    player.destroy();
                    var id_video = play_btn.attr('data-btn');
                    var img_url = play_btn.attr('data-url');
                    if (!video_mini.length > 0) {
                        $('.product-video').find('.block__video-error').before('<div class="video" data-blocked-id="' + id_video + '" data-params="loop=1&playlist=' + id_video + '&enablejsapi=1" style="background: url(' + img_url + ') center center / 100% auto no-repeat"></div>');
                        // &origin=http://example.com
                    }
                }
                // var video_popup = $('.modal-img .product-video-popup').find('.video');
                if (video_popup.length > 0) {
                    video_popup.attr('id', video_popup.attr('data-blocked-id'));
                    video_popup.removeAttr('data-blocked-id');
                }
                play_btn.removeAttr('style');
            }
        });
        $(document).on('click', '.modal-img .close-button', function () {
            object_video();
            var play_btn = $('.play-btn-product-video-popup');
            //play_btn.removeAttr('style');
            //var video_mini = $('.image-slider__image .product-video').find('.video');
            if (video_mini.length > 0) {
                video_mini.attr('id', video_mini.attr('data-blocked-id'));
                video_mini.removeAttr('data-blocked-id');
            }
            //var video_popup = $('.modal-img .product-video-popup').find('.video');
            if (video_popup.length > 0) {
                video_popup.attr('data-blocked-id', video_popup.attr('id'));
                video_popup.removeAttr('id');
            }
            else {
                player.pauseVideo();
                player.destroy();
                var id_video = play_btn.attr('data-btn');
                var img_url = play_btn.attr('data-url');
                if (!video_popup.length > 0) {
                    $('.product-video-popup').find('.block__video-error').before('<div class="video" data-blocked-id="' + id_video + '" data-params="loop=1&playlist=' + id_video + '&enablejsapi=1" style="background: url(' + img_url + ') center center / 100% auto no-repeat"></div>');
                    // &origin=http://example.com
                }
            }
            play_btn.removeAttr('style');
        });

    }
});