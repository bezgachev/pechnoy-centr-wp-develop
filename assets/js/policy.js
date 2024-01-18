$(function () {
    $(document).on('click', '#policy .cookie__btn', function (e) {
        e.preventDefault();

        var th = $(this);
        var policy = th.parent();
        th.html('<span class=loader><svg fill=none height=22 viewBox="0 0 22 22"width=22 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_826_10097)><path d="M4.33826 18.99C5.63397 18.99 6.68434 17.9396 6.68434 16.6439C6.68434 15.3482 5.63397 14.2979 4.33826 14.2979C3.04256 14.2979 1.99219 15.3482 1.99219 16.6439C1.99219 17.9396 3.04256 18.99 4.33826 18.99Z"fill=white fill-opacity=0.85></path><path d="M19.4327 16.9093C20.5573 16.9093 21.4689 15.9977 21.4689 14.8731C21.4689 13.7486 20.5573 12.8369 19.4327 12.8369C18.3081 12.8369 17.3965 13.7486 17.3965 14.8731C17.3965 15.9977 18.3081 16.9093 19.4327 16.9093Z"fill=white fill-opacity=0.7></path><path d="M17.5737 6.64006C18.5027 6.64006 19.2558 5.88697 19.2558 4.95797C19.2558 4.02898 18.5027 3.27588 17.5737 3.27588C16.6447 3.27588 15.8916 4.02898 15.8916 4.95797C15.8916 5.88697 16.6447 6.64006 17.5737 6.64006Z"fill=white fill-opacity=0.6></path><path d="M2.48972 13.2633C3.86475 13.2633 4.97944 12.1758 4.97944 10.8343C4.97944 9.49279 3.86475 8.40527 2.48972 8.40527C1.11468 8.40527 0 9.49279 0 10.8343C0 12.1758 1.11468 13.2633 2.48972 13.2633Z"fill=white fill-opacity=0.9></path><path d="M9.64229 21.9999C10.8923 21.9999 11.9057 21.0125 11.9057 19.7944C11.9057 18.5763 10.8923 17.5889 9.64229 17.5889C8.39226 17.5889 7.37891 18.5763 7.37891 19.7944C7.37891 21.0125 8.39226 21.9999 9.64229 21.9999Z"fill=white fill-opacity=0.8></path><path d="M15.4588 21.0335C16.6463 21.0335 17.609 20.0961 17.609 18.9398C17.609 17.7835 16.6463 16.8462 15.4588 16.8462C14.2713 16.8462 13.3086 17.7835 13.3086 18.9398C13.3086 20.0961 14.2713 21.0335 15.4588 21.0335Z"fill=white fill-opacity=0.75></path><path d="M5.18294 7.62195C6.62046 7.62195 7.7858 6.48444 7.7858 5.08124C7.7858 3.67804 6.62046 2.54053 5.18294 2.54053C3.74542 2.54053 2.58008 3.67804 2.58008 5.08124C2.58008 6.48444 3.74542 7.62195 5.18294 7.62195Z"fill=white fill-opacity=0.95></path><path d="M20.0762 11.4707C21.1387 11.4707 22.0001 10.6253 22.0001 9.58253C22.0001 8.53971 21.1387 7.69434 20.0762 7.69434C19.0137 7.69434 18.1523 8.53971 18.1523 9.58253C18.1523 10.6253 19.0137 11.4707 20.0762 11.4707Z"fill=white fill-opacity=0.65></path><path d="M11.6419 5.48893C13.1577 5.48893 14.3864 4.26019 14.3864 2.74447C14.3864 1.22874 13.1577 0 11.6419 0C10.1262 0 8.89746 1.22874 8.89746 2.74447C8.89746 4.26019 10.1262 5.48893 11.6419 5.48893Z"fill=white></path></g><defs><clipPath id=clip0_826_10097><rect fill=white height=22 width=22></rect></clipPath></defs></svg></span>Принять');

        var error_mess = 'Произошла ошибка';
        var ajax_url = "/wp-admin/admin-ajax.php";
        var data = {
            action: 'policy_action',
            feedback: 'accept-policy',
            nonce: policy_object.nonce
        };
        $.ajax({
            type: 'POST',
            url: ajax_url,
            dataType: 'json',
            data: data,
            success: function (data) {
                th.html('Принять');
                if (data.message === 'POLICY-OK') {
                    policy.css('display', 'none');
                }
                else if (data.message === 'POLICY-ERROR') {

                    policy.css('display', 'none');
                    policy.addClass('error');
                    setTimeout(() => {
                        set_message(error_mess);
                    }, 200);
                }
                return true;
            },
            error: function () {
                th.html('Принять');
                policy.css('display', 'none');
                policy.addClass('error');
                setTimeout(() => {
                    set_message(error_mess);
                }, 200);
                return false;
            }
        });

    });

});