$(function () {
    // Подключаем кнопку наверх
    $('#buttonUp').fadeOut();
    $(window).scroll(function () {
        if ($(this).scrollTop() >= 1000) {
            $('#buttonUp').fadeIn();
        } else {
            $('#buttonUp').fadeOut();
        }
    });

    $('#buttonUp').click(function () {
        $('body,html').animate({ scrollTop: 0 }, 800);
    });

    //при фокусе добовяем класс оболочке поиска
    $('.search input').focus(function () {
        $('.search').addClass('focus');
    }).blur(function () {
        $('.search').removeClass('focus');
    });

    if ($('#aws-search-result-1').length){  
        $('.search input').on("input change keyup paste click", function(){
            if($('#aws-search-result-1').find('ul').length) {              
                $('#aws-search-result-1').css('border', '1px solid #ededed');  
            } else {
                $('#aws-search-result-1').css('border', 'none');
            }
        })
    }

    if ($('.subject-descr__item_value').length){
    	$('.subject-descr__item_value').each(function (index, item) {
            if ($(item).width() > 134) {
                $(this).parent().addClass('long-value');

                let arr = $(this).html().split(',');
                let newArr = [];

                // переберём массив arr
                $.each(arr, function (index, value) {
                    let arr = value.trim().replace(/\s+/g, '&nbsp;').replaceAll('-', '&#8209;')
                    newArr.push(arr);
                });

                let finishNewArr = newArr.join(', ');
                $(this).html(finishNewArr);
            }
    	});
    }

    //блокировка скрола
    const scrollController = {
        scrollPosition: 0,
        disabledScroll() {
            scrollController.scrollPosition = window.scrollY;
            document.body.style.cssText = `
                overflow: hidden;
                position: fixed;
                top: -${scrollController.scrollPosition}px;
                left: 0;
                height: 100vh;
                width: 100vw;
                padding-right: ${window.innerWidth - document.body.offsetWidth}px;
            `;
            document.documentElement.style.scrollBehavior = 'unset';
        },
        startScroll() {
            document.body.style.cssText = '';
            window.scroll({ top: scrollController.scrollPosition });
            document.documentElement.style.scrollBehavior = '';
        },
    }


    //ширина видимого блока
    $(document).on('click', '.select-input span', function () {
        if ($(this).parent().parent().attr('class') == 'category__sorting') {
            if (!$(this).hasClass('selected')) {
                // preloaderStart();
                attr = $(this).attr('data-for');
                text = $(this).text();
                $('.select-orderby-js').text(text);
                $(this).parent().find('span').removeClass('selected');
                $(this).addClass('selected');
                $('#select option').removeAttr('selected');
                $('#select option[value="' + attr + '"]').prop('selected', true);
                $('#select option[value="' + attr + '"]').attr('selected', 'selected');
                $('#select').trigger('change');
            }
        }
    });

    $(document).mouseup(function (e) { // событие клика по веб-документу
        var div = $(".select-orderby-js"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.removeClass('active');
            $('.select-input').removeClass('show');
        }
    });


    //аккардион 

    function akkardion() {
        const akkardionFunc = function (wrapperAkkardion, blockAkkardion) {
            wrapperAkkardion.find(blockAkkardion).on('click', function () {
                blockAkkardion.not(this).removeClass('active');
                $(this).addClass('active');
            });
        }
        // аккардион Footer
        const wrapperAkkardionFooter = $(".footer__body");
        const blockAkkardionFooter = $(".footer__akkardion");
        akkardionFunc(wrapperAkkardionFooter, blockAkkardionFooter);
    } akkardion();


    $(".nav__wrapper .arrow").on("click", function () {
        $(".nav__wrapper .arrow").not(this).parent().removeClass("active").next(".nav__blocks").slideUp(200);
        $(this).parent().toggleClass("active").next(".nav__blocks").slideToggle(200);
    });

    //аккардион
    const akkardionFuncParent = function (elWrapperAkkardion, windowWidth) {
        $(window).on('load resize', function () {
            if (document.documentElement.clientWidth <= windowWidth) {
                let accordions = document.querySelectorAll(elWrapperAkkardion);
                accordions.forEach(acco => {
                    accordions.forEach(subAcco => {
                        subAcco.parentNode.classList.remove('active');
                    });
                    acco.onclick = (event) => {
                        event.preventDefault();
                        accordions.forEach(subAcco => {
                            subAcco.parentNode.classList.remove('active');
                        });
                        acco.parentNode.classList.add('active');
                    }
                });
            }
            else {
                let accordions = document.querySelectorAll(elWrapperAkkardion);
                accordions.forEach(acco => {
                    acco.parentNode.classList.remove('active');
                });
            }
        });
    }

    const catalogWrapperAccordion = '.sidebar-filter__title';
    const windowWidthCatalog = 30000;
    akkardionFuncParent(catalogWrapperAccordion, windowWidthCatalog);

    //открытие-закрыти бургера

    // MatchMedia ------------------------------------
    function checkingMatchMedia(minScreenWidths = 991, trueFuncName, falseFuncName) {
        // const mediaQuery = window.matchMedia('(min-width: 991px)');
        const mediaQuery = window.matchMedia(`(min-width: ${minScreenWidths}px)`);
        function handleTabletChange(e) {
            // Проверить, что media query будет true
            if (e.matches) {
                trueFuncName();
            }
            // else {
            //     falseFuncName();
            // }
        }
        mediaQuery.addListener(handleTabletChange); // Слушать события
        handleTabletChange(mediaQuery); // Начальная проверка
    }

    // функция выезда блока справа
    const burgerFunc = function (btnBurger, burgerContainer, btnClose, position, size = "-100vw", sizeNull = "0") {
        const funcOpen = function () {
            burgerContainer.css(position, sizeNull);
            burgerContainer.addClass('open');
            $('body').addClass('stop-scrolling');
            $('#overlay').addClass('active');
            $('#overlay').css({
                zIndex: '199',
                display: 'block'
            });
        }
        const funcClose = function () {
            burgerContainer.css(position, size);
            burgerContainer.removeClass('open');
            $('body').removeClass('stop-scrolling');
            $('#overlay').removeAttr("style");
            setTimeout(function () {
                $('#overlay').removeClass('active');
            }, 100);
        }

        btnBurger.on("click", funcOpen);
        btnClose.on("click", funcClose);

        $('#overlay').on("click", function () {
            if ($(this).hasClass('active')) {
                funcClose();
            }
        });
        checkingMatchMedia(991, funcClose);
    }

    // // oткрытие попапа с фото
    const positionRight = "right";
    const positionLeft = "left";
    const positionBottom = "bottom";

    const btnBurger = $('.burger');
    const burgerContainer = $('.mobile-menu');
    const btnClose = $('.mobile-menu__close, .mobile-menu__nav');
    //.sidebar__mob_close
    burgerFunc(btnBurger, burgerContainer, btnClose, positionRight);

    //открытие-закрыти фильтра каталога
    const btnFilter = $('.btn-filter');
    // const filterContainer = $('.sidebar, .apply_filter, .sidebar__mob');
    const filterContainer = $('.sidebar, .sidebar__mob');
    const btnCloseFilter = $('.sidebar__mob_close');

    $(window).on('load resize', function () {
        if (document.documentElement.clientWidth < 575) {
            const filterContainer1 = $('.sidebar__mob');
            const sizeH = "-100vh";
            const sizeNull = "calc(100vh - 120px)";
            burgerFunc(btnFilter, filterContainer1, btnCloseFilter, positionBottom, sizeH, sizeNull);

            const sizeNull1 = "-64px";
            const filterContainer2 = $('.sidebar');
            burgerFunc(btnFilter, filterContainer2, btnCloseFilter, positionBottom, sizeH, sizeNull1);


            const filterContainer3 = $('.sidebar .apply_filter');
            // burgerFunc(btnFilter, filterContainer3, btnCloseFilter, positionBottom, sizeH);
            burgerFunc(btnFilter, filterContainer3, btnCloseFilter, positionBottom, sizeH);
        } else {
            burgerFunc(btnFilter, filterContainer, btnCloseFilter, positionLeft);
        }
    });

    const popupOpenFunc = function (btnOpenPopup, btnClosePopup, bodyPopup, overlay = $('#overlay')) {
        btnOpenPopup.on("click", function () {
            bodyPopup.fadeIn();
            $('body').addClass('stop-scrolling');
            overlay.fadeIn();

            var product_count = $('.subject__order_btn').find('input[type="number"]').val();
            var product_price = $('#quick-order').find('input[name="product-price"]').val();
            if (!product_count) {
                product_count = 1;
            }

            var product_price_total = product_price * product_count;
            var product_price_space = product_price_total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
            $('#quick-order').find('input[name="product-quantity"]').val(product_count);
            $('#quick-order').find('.popup__body_price').html(product_price_space + '&nbsp;₽');
            if (product_count > 1) {
                $('#quick-order').find('.popup__product_count').html(product_count + '&nbsp;шт.');
                $('#quick-order').find('.popup__product_count').removeClass('d-hide');
            }
            else {
                $('#quick-order').find('.popup__product_count').html(product_count + '&nbsp;шт.');
                $('#quick-order').find('.popup__product_count').addClass('d-hide');
            }
        });

        btnClosePopup.on("click", function () {
            bodyPopup.fadeOut();
            $('body').removeClass('stop-scrolling');
            overlay.fadeOut();
        });

        overlay.on("click", function () {
            bodyPopup.fadeOut();
            $('body').removeClass('stop-scrolling');
            overlay.fadeOut();
        });
    }


    // открытия || закрытия попапа --------------------------------
    const btnClosePopup = $('.btn-close, #overlay');
    const btnOpenPopup = $('#openModal');
    const overlayPopup = $('.overlay-popup');
    const popup = $('.popup');
    const popupVideo = $('.popup-video');

    popupOpenFunc(btnOpenPopup, btnClosePopup, popup, overlayPopup);


    // открытия || закрытия поиска --------------------------------
    const btnOpen = $('.btn-search');
    const btnClosePopupSearch = $('.search__form_btn');
    const overlaySearch = $(".search-overlay");
    const bodyPopup = $('.header__body .search');
    popupOpenFunc(btnOpen, btnClosePopupSearch, bodyPopup, overlaySearch);

    $(window).on('load resize', function () {
        if (document.documentElement.clientWidth <= 918) {
            $('.search').removeAttr('style');
        }
    });

    if ($('.subject__description').length > 0) {
        $('.subject__description').on('click', '.btn-text', function (e) {
            clickId = $(this).parent().prop('id');
            if ($(this).parent().hasClass('active')) {
                $('.btn-text').html('Показать польностью');
                $(this).parent().removeClass('active');
            } else {
                $(this).parent().addClass('active');
                $(this).html(`<a href='#${clickId}'>Скрыть</a>`);
            }
        });
    }


	$(window).on('load resize', function () {
		if ($('.work__descr_volume').length) {
			if (document.documentElement.clientWidth <= 480) {
				$('.work__descr').insertAfter('.work__slider');
				$('.work__descr_title').insertBefore('.work__slider');
			} else {
				$('.work__descr_title').insertBefore('.work__descr_volume');
				$('.work__descr').insertBefore('.work__slider');
			}
		}
		if ($('.work__descr_text').length) {
			if (document.documentElement.clientWidth <= 480) {
				$('.work__descr').insertAfter('.work__slider');
				$('.work__descr_title').insertBefore('.work__slider');
			} else {
				$('.work__descr_title').insertBefore('.work__descr_text');
				$('.work__descr').insertBefore('.work__slider');
			}
		}
	});

    //анимация на карточке показывается раз в неделю для пользователя
    function cookieDateAnimate() {
        if ($('.layout__body .card').length) {
            const cookieDate = localStorage.getItem('cookieDateAnimate');
            if (!cookieDate || (+cookieDate + 604800000) < Date.now()) {
                setTimeout(function () {
                    $(".card .card-swiper:first").prepend(`<div class="pointer-drag"></div>`);
                    $('.pointer-drag').fadeIn(1000);
                    setTimeout(function () {
                        $('.pointer-drag').fadeOut(1000);
                        setTimeout(function () {
                            $(".pointer-drag").remove();
                        }, 1000);
                    }, 5000);
                    localStorage.setItem('cookieDateAnimate', Date.now());
                }, 1000);
            }
        }
    } cookieDateAnimate();


});


// Swiper Главный экран
if (document.body.contains(document.querySelector('.first-slide'))) {
    let firstSwiper = new Swiper('.first-slide', {
        slidesPerView: 1,
        effect: 'fade',
        grabCursor: true,
        nested: true,
        loop: true,
        grabCursor: true,
        speed: 800,
        // paginationClickable: true,
        parallax: true,
        mousewheelControl: 1,
        autoplay: {
            delay: 5000,
            // Отключить после ручного переключения
            disableOnInteraction: true
        },
        navigation: {
            nextEl: '.first-button-next',
            prevEl: '.first-button-prev'
        },
        pagination: {
            el: '.first-pagination',
            type: 'bullets',
            clickable: true,
        }

    });

}

// Swiper Популярные модели печей
if (document.body.contains(document.querySelector('.popular-swiper'))) {
    let myImageSlider = new Swiper('.popular-swiper', {
        slidesPerView: "auto",
        spaceBetween: 24,
        loop: true,
        navigation: {
            nextEl: '.popular-models-next',
            prevEl: '.popular-models-prev'
        },
        pagination: {
            el: '.popular-models-bullet',
            type: 'bullets',
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
            },
            400: {
                slidesPerView: 1,
            },
            690: {
                slidesPerView: "auto"
            }
        },
    });
    // Фракция
    let mySliderAllSlides = document.querySelector('.popular-models__total');
    let mySliderCurrentSlide = document.querySelector('.popular-models__current');

    mySliderAllSlides.innerHTML = myImageSlider.slides.length / 3;

    myImageSlider.on('slideChange', function () {
        let currentSlide = ++myImageSlider.realIndex;
        mySliderCurrentSlide.innerHTML = currentSlide;
    });

    window.addEventListener("resize", () => {
        myImageSlider.updateSize();
    });

}
// Swiper последние работы
if (document.body.contains(document.querySelector('.last-work-swiper'))) {
    new Swiper('.last-work-swiper', {
        slidesPerView: 4,
        spaceBetween: 30,
        nested: true,
        slideClass: 'card-work',
        navigation: {
            nextEl: '.last-work-next',
            prevEl: '.last-work-prev'
        },
        breakpoints: {
            300: {
                slidesPerView: 1.5,
                centeredSlides: true,
                spaceBetween: 23,
                allowTouchMove: false,
            },
            420: {
                slidesPerView: 2,
            },
            575: {
                slidesPerView: 2.5,
                allowTouchMove: true,
            },
            768: {
                slidesPerView: 3,
            },
            992: {
                slidesPerView: 4,
            },
        }
    });
}

// Swiper Работы карточка
if (document.body.contains(document.querySelector('.card-work__swiper'))) {

    let cardWork = new Swiper('.card-work__swiper', {
        slidesPerView: 1,
        effect: 'fade',
        grabCursor: true,
        pagination: {
            el: '.card-work__swiper_pagination',
            type: 'bullets',
            clickable: true,
        },
        nested: true,
    });

    $('.card-work__swiper').hover(function () {
        (this).swiper.params.autoplay.delay = 800;
        (this).swiper.autoplay.start();
    }, function () {
        (this).swiper.autoplay.stop();
    });


}

// Swiper Новости
if (document.body.contains(document.querySelector('.full-news__swiper'))) {
    new Swiper('.full-news__swiper', {
        slidesPerView: 1,
        effect: 'fade',
        grabCursor: true,
        pagination: {
            el: '.first-pagination',
            type: 'bullets',
            clickable: true,
        },
        navigation: {
            nextEl: '.first-button-next',
            prevEl: '.first-button-prev'
        },
        nested: true,
    });
}
// Swiper карточка товара
if (document.body.contains(document.querySelector('.card-swiper'))) {
    function swiperCard() {
        new Swiper('.card-swiper', {
            slidesPerView: 1,
            effect: 'fade',
            grabCursor: true,
            navigation: {
                nextEl: '.card-button-next',
                prevEl: '.card-button-prev'
            },
            nested: true,

            // Предзагрузка картинок
            preloadImages: true,
            // Lazy Loading
            // (подгрузка картинок)
            lazy: {
                // Подгружать на старте
                // переключения слайда
                loadOnTransitionStart: true,
                // Подгрузить предыдущую
                // и следующую картинки
                loadPrevNext: false,
            },
            // Слежка за видимыми слайдами
            watchSlidesProgress: true,
            // Добавление класса видимым слайдам
            watchSlidesVisibility: true,

        });
    }
    swiperCard();

}

// Swiper single-work
if (document.querySelector('.work__slider')) {
    new Swiper('.work__slider', {
        spaceBetween: 14,
        observer: true,
        observeParents: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        noSwiping: true,
        watchOverflow: true,
        navigation: {
            nextEl: '.work-next',
            prevEl: '.work-prev'
        },
        breakpoints: {
            300: {
                slidesPerView: 'auto',
                allowTouchMove: true,
            },
            992: {
                slidesPerView: 3,
            },
        }
    });
}


// Swiper категории
if (document.body.contains(document.querySelector('.categories'))) {
    const slider = document.querySelector('.slider-container');

    let mySwiper;

    function mobileSlider() {
        if (window.innerWidth <= 992 && slider.dataset.mobile == 'false') {
            mySwiper = new Swiper(slider, {
                slidesPerView: 'auto',
                spaceBetween: 10,
                slideClass: 'category',
                scrollbar: {
                    el: '.swiper-scrollbar',
                    draggable: true
                },
                breakpoints: {
                    992: {
                        spaceBetween: 0,
                    },
                }
            });
            slider.dataset.mobile = 'true';
        }

        const mediaQuery = window.matchMedia('(min-width: 992px)');
        function handleTabletChange(e) {
            // Проверить, что media query будет true
            if (e.matches) {
                slider.dataset.mobile = 'false';
                if (slider.classList.contains('swiper-initialized')) {
                    mySwiper.destroy();
                }
            }
        }
        // Слушать события
        mediaQuery.addListener(handleTabletChange);
        // Начальная проверка
        handleTabletChange(mediaQuery);

    }

    mobileSlider();

    window.addEventListener('resize', () => {
        mobileSlider();
    });

}

// Swiper карточка about-last-job__slider
if (document.body.contains(document.querySelector('.about-last-job__slider'))) {
    function start_about_last_job() {

        aboutSlider = new Swiper('.about-last-job__slider', {
            slidesPerView: 1,
            effect: 'fade',
            grabCursor: true,
            nested: true,
            pagination: {
                el: '.swiper-pagination',
            },

            // Предзагрузка картинок
            preloadImages: true,
            // Lazy Loading
            // (подгрузка картинок)
            lazy: {
                // Подгружать на старте
                // переключения слайда
                loadOnTransitionStart: true,
                // Подгрузить предыдущую
                // и следующую картинки
                loadPrevNext: false,
            },
            // Слежка за видимыми слайдами
            watchSlidesProgress: true,
            // Добавление класса видимым слайдам
            watchSlidesVisibility: true,

        });

    }
    start_about_last_job();
}

if ($('.popup-img').length) {
    // Swiper Карточка товара
    // !Слайдер товаров ======================================
    let myImageSliderProducts = new Swiper('.image-slider', {
        navigation: {
            nextEl: '.button-next',
            prevEl: '.button-prev',
        },
        // Навигация
        // Буллеты, текущее положение, прогрессбар
        pagination: {
            el: '.image-slider-pagination',
            type: 'fraction',
        },

        // grabCursor: true,
        // Управление клавиатурой
        keyboard: {
            enabled: true,
            onlyInViewport: true,
            pageUpDown: true,
        },
        slidesPerView: 1,
        // Стартовый слайд.
        initialSlide: 1,
        // Отключение функционала если слайдов меньше чем нужно
        watchOverflow: true,
        // Количество пролистываемых слайдов
        slidesPerGroup: 1,

        // Эффекты переключения слайдов. Листание
        effect: 'fade',

        // Миниатюры (превью)
        thumbs: {
            // Свайпер с мениатюрами и его настройки
            swiper: {
                el: '.image-mini-slider',
                slidesPerView: 5,
                // Отступ между слайдами
                spaceBetween: 8,
                // Стартовый слайд.
                initialSlide: 1,
                // Вертикальный слайдер
                direction: 'vertical',
                navigation: {
                    nextEl: '.button-mini-next',
                    prevEl: '.button-mini-prev',
                },
            }

        },
    });

    const elemPlayBtnVideo = document.querySelector('.image-slider__play_btn');

    elemPlayBtnVideo.onclick = function () {
        myImageSliderProducts.slideTo(0, 1000, true);
    };

    $('.image-mini-slider__wrapper .image-mini-slider__slide').on('mouseover', function () {
        myImageSliderProducts.slideTo($(this).index());
    });


    if ($('.image-slider__image').find('.player__video').length > 0) {
        myImageSliderProducts.slideTo(1, 1000, true);
    } else {
        myImageSliderProducts.slideTo(0, 1000, true);
        $('.image-slider__play_btn').css("display", "none");
    }



    // !Слайдер popup ======================================
    btnPopupOpen = $('.jsOpenPopup');
    btnCloseModalImg = $('.close-button');

    btnPopupOpen.on("click", function () {
        $('.modal-img').fadeIn(300);
        var slideId = myImageSliderProducts.activeIndex
        if ($('.image-slider__image').find('.player__video').length > 0) {
            openFullscreenSwiper(slideId - 1);
        } else {
            openFullscreenSwiper(slideId);
        }

        
        // wrapperBlurred.addClass(blurred);
        // stopScroll();
    });
    btnCloseModalImg.click(function () {
        $('.modal-img').fadeOut(300);
        // wrapperBlurred.removeClass(blurred);
        // startScroll();
    });
    // закрыть попап Escape
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            btnCloseModalImg.click();
            // startScroll();
        }
    });

    // !Слайдер popup ======================================
    function openFullscreenSwiper(initialSlideNumber) {
        const swiperPopup = new Swiper('.popup-img', {
            initialSlide: initialSlideNumber,
            navigation: {
                nextEl: '.popup-btn-next',
                prevEl: '.popup-btn-prev',
            },
            grabCursor: true,
            keyboard: {
                enabled: true,
                onlyInViewport: true,
                pageUpDown: true,
            },

            slidesPerView: 1,
            watchOverflow: true,
            slidesPerGroup: 1,
            effect: 'fade',
            observer: true,
            observeParents: true,
            observeSlideChildren: true,
            preloadImages: false,
            lazy: {
                loadOnTransitionStart: true,
                loadPrevNext: true,
            },
            watchSlidesProgress: true,
            watchSlidesVisibility: true,
        });
    }
}

function flyBlock() {
    let bg = document.querySelector('.fly');
    window.addEventListener('mousemove', function (e) {
        let x = e.clientX / window.innerWidth;
        let y = e.clientY / window.innerHeight;
        bg.style.transform = 'translate(-' + x * 50 + 'px, -' + y * 50 + 'px)';
    });
}


if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    // код для мобильных устройств
} else {
    if (document.querySelectorAll(".fly").length) {
        flyBlock();
    }
}

//плавный скрол до элимента
const smoothLinks = document.querySelectorAll('.jsSmoothLink');
smoothLinks.forEach(smoothLink => {
    smoothLink.addEventListener('click', (Event) => {
        Event.preventDefault();
        const id = smoothLink.getAttribute('href');
        document.querySelector(id).scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
});