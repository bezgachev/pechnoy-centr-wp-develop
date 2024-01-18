$(function () {
    var popup = $('.popup'),
        overlay = $('.overlay-popup'),
        popup_info = $('.popup-info'),
        popup_ok = $('.popup-info__icon-ok'),
        popup_err = $('.popup-info__icon-err'),
        popup_title = $('.popup-info__title'),
        popup_subtitle = $('.popup-info__message'),
        title_ok = 'Заявка успешно отправлена',
        subtitle_ok = 'Совсем скоро мы свяжемся&nbsp;с Вами',
        title_er = 'Что-то пошло не так',
        subtitle_er = 'Не удалось отправить заявку.<br>Пожалуйста, попробуйте снова';

    function successDisplay() {
        setTimeout(() => { th_form.find('.btn-send .loader').addClass('d-hide'); }, 500);
        popup_ok.removeClass('d-hide');
        popup_err.addClass('d-hide');
        popup_title.html(title_ok);
        popup_subtitle.html(subtitle_ok);
        popup.fadeOut();
        popup_info.fadeIn();
        setTimeout(() => {
            popup_info.fadeOut();
            overlay.fadeOut();
            $('body').removeClass('stop-scrolling');
            th_form[0].reset();
        }, 3000);
        console.log('успешно отправлено');
    }
    function errorDisplay() {
        setTimeout(() => { th_form.find('.btn-send .loader').addClass('d-hide'); }, 500);
        popup_ok.addClass('d-hide');
        popup_err.removeClass('d-hide');
        popup_title.html(title_er);
        popup_subtitle.html(subtitle_er);
        popup.fadeOut();
        popup_info.fadeIn();
        setTimeout(() => {
            popup_info.fadeOut();
            popup.fadeIn();
        }, 3000);
    }

    $(document).on('click', 'input[name="form-checkbox"]', function () {
        var th = $(this);
        if (th.is(':checked')) {
            th.attr('value', '1');
            th.parent().removeClass('woocommerce-invalid woocommerce-invalid-required-field');
        } else {
            th.attr('value', '');
            th.parent().addClass('woocommerce-invalid woocommerce-invalid-required-field');
        }
    });


    var form_feedback = $('form#quick-order');

    form_feedback.on('click', 'input[type="submit"]', function () {
        th_form = $(this).parents('form');
        th_form_class = th_form.attr('class');
        console.log(th_form_class);
    });


    var options = {
        url: quick_order_object.url,
        data: {
            action: 'quick_order_action',
            nonce: quick_order_object.nonce
        },
        type: 'POST',
        dataType: 'json',
        beforeSubmit: function (xhr) {
            th_form.find('.btn-send .loader').removeClass('d-hide');
        },
        success: function (request, xhr, status, error) {
            if (request.success === true) { } else {
                $.each(request.data, function (key) {
                    console.log('key ' + key);
                    th_form.find('input[name="form-' + key + '"]').parent().addClass('woocommerce-invalid woocommerce-invalid-required-field');
                    th_form.find('.btn-send .loader').addClass('d-hide');
                });
            }
            if (request.message == 'SEND-OK') {
                console.log('хорошо от сервера');
                successDisplay();
            }
            if (request.cart_item == 'REMOVE-OK') {
                $(document.body).trigger('wc_fragment_refresh');
                if ($('.add-to-cart.add-cart-js').hasClass('active')) {
                    $('.add-to-cart.add-cart-js').removeClass('active d-hide');
                    $('.subject__order_btn').addClass('d-hide');
                    if ($('.number input[type="number"]').length > 0) {
                        $('.number input[type="number"]').val('1');
                    }
                    setTimeout(() => {
                        $('.add-to-cart').html('Добавить в корзину');
                    }, 800);
                }
                console.log('удалено из корзины');
            }
            else if (request.message == 'SEND-ERROR') {
                errorDisplay();
                console.log('ошибка от сервера');
            }
            // setTimeout(() => { th_form.find('.btn-send .loader').addClass('d-hide'); }, 500);
        },
        error: function (request, status, error) {
            errorDisplay();


        }
    };
    form_feedback.ajaxForm(options);

});