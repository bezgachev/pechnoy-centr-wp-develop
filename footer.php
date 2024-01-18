<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package weblitex
 */

?>
<div id="overlay"></div>
</main>
<footer class="footer">
    <div class="container">
        <div class="footer__body">
            <div class="footer__descr">
                <a href="<?echo get_site_url();?>" class="footer__descr_tite"><?bloginfo('name');?></a>
                <?contacts_address('footer');?>
                <div class="footer__descr_duty"><?contacts_work_time();?></div>
            </div>
			<? wp_nav_menu(array(
				'theme_location'  => 'footer-nav',
				'menu_id'      => false,
				'container'       => null, 
				'container_class' => null, 
				'menu_class'      => false,
				'items_wrap'      => '%3$s',
				'order' => 'ASC',      
				'walker' => new footer_nav()   
			)); ?>   

            <div class="footer__contacts">
                <div class="footer__contacts_tel">
                    <?contacts_phone();?>
                </div>
                <?$email = get_option('admin_email');?>
                <a class="footer__contacts_mail" href="mailto:<?echo $email;?>"><?echo $email;?></a>
            </div>
            <div class="footer__social">
                <div class="social">
                    <?contacts_messeng_social();?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer__bottom">
        <div class="container">
            <p class="footer__bottom_law">
                <?$current_year = date('Y'); if ($current_year == '2022') {$year = $current_year;}else {$year = '2022 — '.$current_year;}?>
                © <?echo $year;?>, Интернет-магазин “<?bloginfo('name');?>”.<br>Все права защищены
            </p>
            <a class="footer__bottom_politics" href="<?get_site_url();?>/privacy/" target="_blank">Политика конфиденциальности</a>
            <p class="footer__bottom_offer">Информация на сайте не является публичной офертой</p>
            <div class="footer__bottom_weblitex">
                <a class="weblitex" target="_blank" href="https://weblitex.ru/?utm_source=clients&utm_medium=referal&utm_campaign=pechnoy-centr.ru">Разработка сайтов «Лайтекс»</a>
            </div>
        </div>
    </div>
</footer>

<? if(is_product()) {
    global $product;
    $product_id = $product->get_id();
    $product_name = $product->get_name();
    $price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
    $sale = get_post_meta( get_the_ID(), '_sale_price', true); 	//цена со скидкой
    $price_space = number_format((int)$price, 0, '', '&nbsp;');
    $sale_space = number_format((int)$sale, 0, '', '&nbsp;');
?>
    
    <div class="popup">
        <button class="btn-close">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.97711 0.916936C1.68421 0.624042 1.20934 0.624042 0.916447 0.916936C0.623554 1.20983 0.623554 1.6847 0.916447 1.9776L6.9391 8.00025L0.917085 14.0223C0.624192 14.3152 0.624192 14.79 0.917085 15.0829C1.20998 15.3758 1.68485 15.3758 1.97774 15.0829L7.99976 9.06091L14.0218 15.0829C14.3147 15.3758 14.7895 15.3758 15.0824 15.0829C15.3753 14.79 15.3753 14.3152 15.0824 14.0223L9.06042 8.00025L15.0831 1.9776C15.376 1.6847 15.376 1.20983 15.0831 0.916936C14.7902 0.624042 14.3153 0.624042 14.0224 0.916936L7.99976 6.93959L1.97711 0.916936Z" fill="#999999"></path>
            </svg>
        </button>
        <div class="popup__title">Быстрый заказ</div>
        <form method="POST" class="popup__form" id="quick-order">
            <div class="popup__field">
                <input type="text" name="form-name" placeholder="Имя*" title="Разрешено использовать русские буквы" pattern="^[А-Яа-яЁё\s]+$" autocomplete="on">
                <span class="error-mess">Это поле необходимо заполнить</span>
            </div>
            <div class="popup__field">
                <input type="tel" name="form-phone" placeholder="Телефон*" autocomplete="on" minlength="11" maxlength="11" inputmode="decimal">
                <span class="error-mess">Это поле необходимо заполнить</span>
            </div>

            <div class="popup__body">
                <div class="popup__body_title"><?echo $product_name;?></div>
                <?if (!empty($sale)){
                    echo '<div class="popup__body_price">'.$sale_space.'&nbsp;₽</div><input type="hidden" name="product-price" value="'.$sale.'">';
                } else {
                    echo '<div class="popup__body_price">'.$price_space.'&nbsp;₽</div><input type="hidden" name="product-price" value="'.$price.'">';
                }?>
            </div>
            <div class="popup__product_count d-hide"></div>
            <div class="popup__checkbox">
                <input type="checkbox" id="form-checkbox" name="form-checkbox">
                <label for="form-checkbox">Я согласен(-а) на обработку <br>
                    <a href="<?get_site_url();?>/privacy/" target="_blank">персональных данных</a>
                </label>
                <span class="error-mess">Необходимо согласие</span>
            </div>
            <input type="hidden" name="feedback" value="quick-order">
            <input type="hidden" name="product-id" value="<?echo $product_id;?>">
            <input type="hidden" name="product-quantity" value="1">
            <div class="btn-send">
                <span class="loader d-hide"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_826_10097)"><path d="M4.33826 18.99C5.63397 18.99 6.68434 17.9396 6.68434 16.6439C6.68434 15.3482 5.63397 14.2979 4.33826 14.2979C3.04256 14.2979 1.99219 15.3482 1.99219 16.6439C1.99219 17.9396 3.04256 18.99 4.33826 18.99Z" fill="white" fill-opacity="0.85"></path><path d="M19.4327 16.9093C20.5573 16.9093 21.4689 15.9977 21.4689 14.8731C21.4689 13.7486 20.5573 12.8369 19.4327 12.8369C18.3081 12.8369 17.3965 13.7486 17.3965 14.8731C17.3965 15.9977 18.3081 16.9093 19.4327 16.9093Z" fill="white" fill-opacity="0.7"></path><path d="M17.5737 6.64006C18.5027 6.64006 19.2558 5.88697 19.2558 4.95797C19.2558 4.02898 18.5027 3.27588 17.5737 3.27588C16.6447 3.27588 15.8916 4.02898 15.8916 4.95797C15.8916 5.88697 16.6447 6.64006 17.5737 6.64006Z" fill="white" fill-opacity="0.6"></path><path d="M2.48972 13.2633C3.86475 13.2633 4.97944 12.1758 4.97944 10.8343C4.97944 9.49279 3.86475 8.40527 2.48972 8.40527C1.11468 8.40527 0 9.49279 0 10.8343C0 12.1758 1.11468 13.2633 2.48972 13.2633Z" fill="white" fill-opacity="0.9"></path><path d="M9.64229 21.9999C10.8923 21.9999 11.9057 21.0125 11.9057 19.7944C11.9057 18.5763 10.8923 17.5889 9.64229 17.5889C8.39226 17.5889 7.37891 18.5763 7.37891 19.7944C7.37891 21.0125 8.39226 21.9999 9.64229 21.9999Z" fill="white" fill-opacity="0.8"></path><path d="M15.4588 21.0335C16.6463 21.0335 17.609 20.0961 17.609 18.9398C17.609 17.7835 16.6463 16.8462 15.4588 16.8462C14.2713 16.8462 13.3086 17.7835 13.3086 18.9398C13.3086 20.0961 14.2713 21.0335 15.4588 21.0335Z" fill="white" fill-opacity="0.75"></path><path d="M5.18294 7.62195C6.62046 7.62195 7.7858 6.48444 7.7858 5.08124C7.7858 3.67804 6.62046 2.54053 5.18294 2.54053C3.74542 2.54053 2.58008 3.67804 2.58008 5.08124C2.58008 6.48444 3.74542 7.62195 5.18294 7.62195Z" fill="white" fill-opacity="0.95"></path><path d="M20.0762 11.4707C21.1387 11.4707 22.0001 10.6253 22.0001 9.58253C22.0001 8.53971 21.1387 7.69434 20.0762 7.69434C19.0137 7.69434 18.1523 8.53971 18.1523 9.58253C18.1523 10.6253 19.0137 11.4707 20.0762 11.4707Z" fill="white" fill-opacity="0.65"></path><path d="M11.6419 5.48893C13.1577 5.48893 14.3864 4.26019 14.3864 2.74447C14.3864 1.22874 13.1577 0 11.6419 0C10.1262 0 8.89746 1.22874 8.89746 2.74447C8.89746 4.26019 10.1262 5.48893 11.6419 5.48893Z" fill="white"></path></g><defs><clipPath id="clip0_826_10097"><rect width="22" height="22" fill="white"></rect></clipPath></defs></svg></span>
                <input class="btn" type="submit" value="Отправить заявку">
            </div>
                
        </form>
    </div>
    <div class="popup-info">
        <div class="popup-info__icon-ok">
            <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M31.0679 19.2484V10.6767C31.0679 10.6688 31.0671 10.661 31.0668 10.6531C31.0666 10.6451 31.0662 10.6374 31.0658 10.6294C31.0617 10.5656 31.0495 10.5045 31.0304 10.4468C31.0296 10.4441 31.0292 10.4414 31.0283 10.4387C31.0275 10.4366 31.0264 10.4347 31.0257 10.4327C31.0152 10.4031 31.0031 10.3744 30.989 10.347C30.9874 10.3437 30.9855 10.3407 30.9837 10.3375C30.9708 10.3133 30.9565 10.2901 30.941 10.2679L30.9318 10.2545C30.915 10.2315 30.8967 10.2097 30.8771 10.1894C30.8729 10.1849 30.8685 10.1808 30.8641 10.1765C30.8457 10.1581 30.8263 10.1409 30.806 10.1251C30.8034 10.1231 30.8011 10.121 30.7985 10.1191C30.7757 10.102 30.7517 10.0869 30.7269 10.0732C30.7222 10.0705 30.7174 10.0681 30.7126 10.0657C30.6623 10.0396 30.6083 10.0208 30.5516 10.0103C30.5454 10.0091 30.5392 10.0081 30.533 10.0072C30.5049 10.003 30.4764 10 30.4472 10H0.620737C0.591521 10 0.56305 10.003 0.53491 10.0072C0.528702 10.0081 0.522496 10.0092 0.516288 10.0103C0.459594 10.0208 0.405631 10.0396 0.35531 10.0657C0.35051 10.0681 0.345709 10.0705 0.340991 10.0732C0.316162 10.0869 0.292161 10.1019 0.2694 10.1191C0.266835 10.121 0.264435 10.1232 0.261952 10.1251C0.241509 10.1409 0.222224 10.1581 0.203768 10.1765C0.199464 10.1808 0.194995 10.1848 0.190774 10.1894C0.171241 10.2097 0.153032 10.2315 0.136065 10.2545C0.132838 10.2588 0.129941 10.2634 0.126879 10.2679C0.111402 10.2901 0.0970832 10.3133 0.0841718 10.3375C0.0824338 10.3407 0.0805306 10.3437 0.0788753 10.347C0.0648052 10.3744 0.0528042 10.403 0.042293 10.4326C0.0415482 10.4347 0.0403896 10.4365 0.0396447 10.4387C0.0387343 10.4414 0.0384032 10.4441 0.0374928 10.4468C0.0183741 10.5046 0.00620745 10.5657 0.00215197 10.6295C0.00165538 10.6374 0.00132428 10.6452 0.00107599 10.6531C0.00082769 10.661 0 10.6688 0 10.6768V14.6483V17.6253V31.4438C0 31.4499 0.000661665 31.4556 0.000827195 31.4616C-0.00231787 31.5347 0.00529653 31.6093 0.0249118 31.6825C0.102297 31.9711 0.344964 32.1694 0.620737 32.1694H30.4472C30.7229 32.1694 30.9657 31.9711 31.043 31.6825C31.0626 31.6093 31.0701 31.5347 31.0671 31.4616C31.0672 31.4556 31.0679 31.4498 31.0679 31.4438V22.2255V19.2484ZM1.24147 12.1678V14.6483V17.6253V30.2578L12.2056 22.6239L1.24147 12.1678ZM29.8264 30.2578V22.2255V19.2484V12.1677L18.8624 22.6238L29.8264 30.2578ZM2.816 30.7672H28.2519L17.8892 23.5521L17.8681 23.5721C17.1593 24.2481 16.3464 24.5862 15.5339 24.5863C14.7212 24.5864 13.9087 24.2483 13.1998 23.5721L13.1787 23.552L2.816 30.7672ZM14.0173 22.5536C14.9528 23.4458 16.1152 23.4457 17.0507 22.5536L28.795 11.3533H2.27289L13.6364 22.1904L13.639 22.1928L14.0173 22.5536Z" fill="#999999" fill-opacity="0.8"></path>
                <g clip-path="url(#clip0_1491_28876)">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M35.9844 10.5C35.9844 7.4685 33.5311 5.01562 30.5 5.01562C27.4685 5.01562 25.0156 7.46889 25.0156 10.5C25.0156 13.5315 27.4689 15.9844 30.5 15.9844C33.5315 15.9844 35.9844 13.5311 35.9844 10.5Z" fill="#6F9F5E"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M30.5 17C34.0924 17 37 14.0929 37 10.5C37 6.90762 34.0929 4 30.5 4C26.9076 4 24 6.90713 24 10.5C24 14.0924 26.9071 17 30.5 17ZM30.5 5.01562C33.5311 5.01562 35.9844 7.4685 35.9844 10.5C35.9844 13.5311 33.5315 15.9844 30.5 15.9844C27.4689 15.9844 25.0156 13.5315 25.0156 10.5C25.0156 7.46889 27.4685 5.01562 30.5 5.01562Z" fill="#6F9F5E"></path>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M34.223 8.79961C34.48 8.54883 34.48 8.14212 34.223 7.89121C33.9661 7.64043 33.5495 7.64043 33.2924 7.89121L29.3437 11.7462L27.7076 10.1491C27.4507 9.8982 27.0341 9.8982 26.7772 10.1491C26.5202 10.3999 26.5202 10.8066 26.7772 11.0574L28.8785 13.1088C29.1355 13.3596 29.552 13.3596 29.809 13.1088L34.223 8.79961Z" fill="white"></path>
                </g>
                <defs>
                    <clipPath id="clip0_1491_28876">
                        <rect width="13" height="13" fill="white" transform="translate(24 4)"></rect>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <div class="popup-info__icon-err d-hide">
            <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M31.0679 19.2484V10.6767C31.0679 10.6688 31.0671 10.661 31.0668 10.6531C31.0666 10.6451 31.0662 10.6374 31.0658 10.6294C31.0617 10.5656 31.0495 10.5045 31.0304 10.4468C31.0296 10.4441 31.0292 10.4414 31.0283 10.4387C31.0275 10.4366 31.0264 10.4347 31.0257 10.4327C31.0152 10.4031 31.0031 10.3744 30.989 10.347C30.9874 10.3437 30.9855 10.3407 30.9837 10.3375C30.9708 10.3133 30.9565 10.2901 30.941 10.2679L30.9318 10.2545C30.915 10.2315 30.8967 10.2097 30.8771 10.1894C30.8729 10.1849 30.8685 10.1808 30.8641 10.1765C30.8457 10.1581 30.8263 10.1409 30.806 10.1251C30.8034 10.1231 30.8011 10.121 30.7985 10.1191C30.7757 10.102 30.7517 10.0869 30.7269 10.0732C30.7222 10.0705 30.7174 10.0681 30.7126 10.0657C30.6623 10.0396 30.6083 10.0208 30.5516 10.0103C30.5454 10.0091 30.5392 10.0081 30.533 10.0072C30.5049 10.003 30.4764 10 30.4472 10H0.620737C0.591521 10 0.56305 10.003 0.53491 10.0072C0.528702 10.0081 0.522496 10.0092 0.516288 10.0103C0.459594 10.0208 0.405631 10.0396 0.35531 10.0657C0.35051 10.0681 0.345709 10.0705 0.340991 10.0732C0.316162 10.0869 0.292161 10.1019 0.2694 10.1191C0.266835 10.121 0.264435 10.1232 0.261952 10.1251C0.241509 10.1409 0.222224 10.1581 0.203768 10.1765C0.199464 10.1808 0.194995 10.1848 0.190774 10.1894C0.171241 10.2097 0.153032 10.2315 0.136065 10.2545C0.132838 10.2588 0.129941 10.2634 0.126879 10.2679C0.111402 10.2901 0.0970832 10.3133 0.0841718 10.3375C0.0824338 10.3407 0.0805306 10.3437 0.0788753 10.347C0.0648052 10.3744 0.0528042 10.403 0.042293 10.4326C0.0415482 10.4347 0.0403896 10.4365 0.0396447 10.4387C0.0387343 10.4414 0.0384032 10.4441 0.0374928 10.4468C0.0183741 10.5046 0.00620745 10.5657 0.00215197 10.6295C0.00165538 10.6374 0.00132428 10.6452 0.00107599 10.6531C0.00082769 10.661 0 10.6688 0 10.6768V14.6483V17.6253V31.4438C0 31.4499 0.000661665 31.4556 0.000827195 31.4616C-0.00231787 31.5347 0.00529653 31.6093 0.0249118 31.6825C0.102297 31.9711 0.344964 32.1694 0.620737 32.1694H30.4472C30.7229 32.1694 30.9657 31.9711 31.043 31.6825C31.0626 31.6093 31.0701 31.5347 31.0671 31.4616C31.0672 31.4556 31.0679 31.4498 31.0679 31.4438V22.2255V19.2484ZM1.24147 12.1678V14.6483V17.6253V30.2578L12.2056 22.6239L1.24147 12.1678ZM29.8264 30.2578V22.2255V19.2484V12.1677L18.8624 22.6238L29.8264 30.2578ZM2.816 30.7672H28.2519L17.8892 23.5521L17.8681 23.5721C17.1593 24.2481 16.3464 24.5862 15.5339 24.5863C14.7212 24.5864 13.9087 24.2483 13.1998 23.5721L13.1787 23.552L2.816 30.7672ZM14.0173 22.5536C14.9528 23.4458 16.1152 23.4457 17.0507 22.5536L28.795 11.3533H2.27289L13.6364 22.1904L13.639 22.1928L14.0173 22.5536Z" fill="#999999" fill-opacity="0.8"></path>
                <path d="M30.5 4C26.9101 4 24 6.90996 24 10.5C24 14.0898 26.9101 17 30.5 17C34.09 17 37 14.0898 37 10.5C37 6.90996 34.09 4 30.5 4ZM31.6026 14.9439C31.6026 15.0498 31.5166 15.1358 31.4106 15.1358H29.5896C29.4836 15.1358 29.3976 15.0498 29.3976 14.9439V13.2599C29.3976 13.1538 29.4836 13.0678 29.5896 13.0678H31.4106C31.5166 13.0678 31.6026 13.1538 31.6026 13.2599V14.9439ZM31.6063 11.8982C31.6035 12.0023 31.5183 12.0849 31.4145 12.0849H29.5859C29.4819 12.0849 29.3967 12.0023 29.394 11.8985L29.2326 6.06145C29.2311 6.00964 29.2508 5.95947 29.2869 5.92229C29.3231 5.88511 29.3726 5.86406 29.4246 5.86406H31.5752C31.6271 5.86406 31.6766 5.88497 31.7128 5.92229C31.749 5.95934 31.7684 6.00964 31.7671 6.06145L31.6063 11.8982Z" fill="#E8645C"></path>
                <path d="M31.6063 11.8982C31.6035 12.0023 31.5183 12.0849 31.4145 12.0849H29.5859C29.4819 12.0849 29.3967 12.0023 29.394 11.8985L29.2326 6.06145C29.2311 6.00964 29.2508 5.95947 29.2869 5.92229C29.3231 5.88511 29.3726 5.86406 29.4246 5.86406H31.5752C31.6271 5.86406 31.6766 5.88497 31.7128 5.92229C31.749 5.95934 31.7684 6.00964 31.7671 6.06145L31.6063 11.8982Z" fill="white"></path>
                <path d="M31.6026 14.9439C31.6026 15.0498 31.5166 15.1358 31.4106 15.1358H29.5896C29.4836 15.1358 29.3976 15.0498 29.3976 14.9439V13.2599C29.3976 13.1538 29.4836 13.0678 29.5896 13.0678H31.4106C31.5166 13.0678 31.6026 13.1538 31.6026 13.2599V14.9439Z" fill="white"></path>
            </svg>
        </div>
        <div class="popup-info__title">Заявка успешно отправлена</div>
        <div class="popup-info__message">Совсем скоро мы свяжемся с&nbsp;Вами</div>
    </div>
<?}?>

<button id="buttonUp"></button>
<div class="d-hide" id="message-wrapper"></div>
<?php 
    if(empty($_COOKIE['pcy_woo_policy'] === 'true')) {
        echo '
        <div class="cookie" id="policy">
            <div class="cookie__text">Мы используем cookie-файлы, чтобы пользоваться сайтом было удобнее.</div>
            <div class="cookie__btn">Принять</div>
            <a href="'.get_site_url().'/privacy/" target="_blank" class="cookie__link">Подробнее</a>
        </div>';
    }
?>

<? wp_footer(); ?>
</body>
<script>
    // ------------------------- НАЧАЛО ФУНКЦИИ -------------------------

    function set_message(text) {
        $('#message-wrapper .error-mess-list').removeClass('show');
        $('#buttonUp').css('display','none');
        $('#message-wrapper').removeClass('d-hide');
		var $item = $('<div class="error-mess-list"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><g opacity="0.8"><circle cx="8.99961" cy="8.99375" r="7.65" fill="white" /><path fill-rule="evenodd" clip-rule="evenodd" d="M6.40433 5.69332C6.20907 5.49806 5.89249 5.49806 5.69723 5.69332C5.50197 5.88858 5.50197 6.20517 5.69723 6.40043L8.29241 8.99561L5.69729 11.5907C5.50203 11.786 5.50203 12.1026 5.69729 12.2978C5.89255 12.4931 6.20914 12.4931 6.4044 12.2978L8.99951 9.70271L11.5946 12.2978C11.7899 12.4931 12.1065 12.4931 12.3017 12.2978C12.497 12.1026 12.497 11.786 12.3017 11.5907L9.70662 8.99561L12.3018 6.40043C12.4971 6.20517 12.4971 5.88858 12.3018 5.69332C12.1065 5.49806 11.79 5.49806 11.5947 5.69332L8.99951 8.2885L6.40433 5.69332Z" fill="#E8645C" /></g></svg>'+text+'</div>');
        $item.appendTo($('#message-wrapper'));
        $item.addClass('show');
        setTimeout(() => { $item.removeClass('show'); }, 15000);
        var policy = $('#policy');
        setTimeout(() => {
            $item.remove();
            $('#buttonUp').removeAttr('style');
            $('#message-wrapper').addClass('d-hide');
            if (policy.hasClass('error')) {
                policy.css('display', 'flex');
                policy.removeClass('error');
            }
        }, 15300);
	}

    function update_filter_after_ajax() {
        var check_open_container = $('.woof_container_inner h4');
        if (check_open_container.find('a').hasClass('woof_front_toggle_opened')) {
            check_open_container.find('a.woof_front_toggle_opened').each(function () {
                $(this).parent().addClass('open');
            });
        }

        var woof_loader = $('.woof_info_popup');
        if (woof_loader.length > 0) {
            woof_loader.find('.woof-loader').css('top', $(this).scrollTop());
            $(document).scroll(function() { 
                woof_loader.find('.woof-loader').css('top', $(this).scrollTop());
            });
        }


        if ($('.widget_price_filter').length > 0) {
            var price = $('.price_slider_amount');
            var price_min = price.find('input[name="min_price"]');
            var price_max = price.find('input[name="max_price"]');
            price.find('input').removeAttr('style');
            price.find('.price_label').remove();
            price_min.attr('data-initial', price_min.attr('value'));
            price_max.attr('data-initial', price_max.attr('value'));
            price_min.attr('placeholder', 'от');
            price_max.attr('placeholder', 'до');
        }
        //$('.woof_submit_search_form_container').css('display','block');
        var woof_reset = $('.woof_submit_search_form_container .woof_reset_search_form');
        var woow_result = $('.woocommerce-result-count');
        if (woof_reset.length > 0) {
            if (woow_result.length > 0) {
                woof_reset.parent().addClass('show');
                var result_text = woow_result.text();
                var result_count = result_text.toString().slice(-1);
                    var pr_text = '';
                    if (result_count == 1) {
                        pr_text = 'товар';
                    }
                    else if (result_count == 2 || result_count == 3 || result_count == 4) {
                        pr_text = 'товара';
                    }
                    else if ((result_count > 4) || ((result_count == 0) && (result_text !== 0))) {
                        pr_text = 'товаров';
                    }
                    woof_reset.before(`<div class="button woof_result_count">Показать ${result_text} ${pr_text}</div>`);
            }
        }

        $('.woof_redraw_zone').removeAttr('data-woof-ver');
        $('.woof .woof_redraw_zone').find('div[style="clear:both;"]').addClass('d-hide');
        $(".woof_container_inner h4").each(function(){
            $(this).html($(this).html().replace('м3', 'м<sup>3</sup>'));
            $(this).html($(this).html().replace('м2', 'м<sup>2</sup>'));
        });

        $('input.woof_checkbox_term').each(function(){
            var attr = $(this).attr('disabled');
            if (attr) {
                $(this).addClass('woof_checkbox_term_disabled');
                $(this).parent().children('label').addClass('woof_checkbox_label_disabled');
                $(this).parent().parent('ul').css({'display':'flex','flex-direction':'column'});
                $(this).parent().css('order','1');

            }
        });

        // woof_container_pa_kamenka 
        // woof_container_pa_bak
        $('.woof_container_checkbox ul').each(function(index){
            var count = $(this).find('li').length;
            //console.log(count);
            var $li = $(this);
                if($li.find('li input[disabled]').length == count) {
                    //console.log($li.find('li input[disabled]').length);
                    //$li.parents('.woof_container_checkbox').css('background','#eee');
                }
            // var attr = $(this).attr('disabled');
            // if (attr) {
            //     $(this).addClass('woof_checkbox_term_disabled');
            //     $(this).parent().children('label').addClass('woof_checkbox_label_disabled');
            //     $(this).parent().parent('ul').css({'display':'flex','flex-direction':'column'});
            //     $(this).parent().css('order','1');

            // }
        });
       //$('.woof_container_product_cat').removeAttr('style');

        // 


        // $('input[data-tax="product_cat"]').each(function(){
        //     var label_count = $(this).parent().children('label').find('.woof_checkbox_count');
        //     if (label_count.text() == '' || label_count.text() == '(0)') {
        //         //label_count.parent('label').parent('li').addClass('d-hide');
        //         //label_count.parent('label').parent('li').css('background', 'antiquewhite');
        //     }
        //     //console.log(label_count);

        // });



        if ($('.woof_container_product_cat').length > 0) {
            //var arr = [];
            var cats_id = $('.layout__sidebar').attr('data-cats-id');
            var arr = cats_id.split(',');
            $('input[data-tax="product_cat"]').parent().addClass('d-hide');
            for (i = 0; i < arr.length; i++) {
                $('input[data-tax="product_cat"][data-term-id="'+arr[i]+'"]').parent('li').removeClass('d-hide');
                $('input[data-tax="product_cat"][data-term-id="'+arr[i]+'"]').parent('li').find('ul li').removeClass('d-hide');
                $('.woof_term_'+arr[i]+'').removeClass('d-hide');
            }
            $('.woof_container_product_cat li.woof_childs_list_li').each(function(){
                var label_count = $(this).children('label').find('.woof_checkbox_count');
                if (label_count.text() === '(0)') {
                    $(this).addClass('d-hide');
                }
            });
        }

        var apply_filter = $('.apply_filter .btn');
        if (apply_filter.find('.loader').length > 0) {
            apply_filter.parent().html('<div class="btn">Применить</div>');
            //setTimeout(() => {

                $('.sidebar__mob .sidebar__mob_close').trigger('click');
            //}, 600);
        }
        if (apply_filter.parent().hasClass('show')) {
            apply_filter.parent().removeClass('show');
        }
        
        // var apply_filter = $('.apply_filter');
        //     if (apply_filter.hasClass('show')) {
        //         apply_filter.removeClass('show');
        //     }
        woof_loader.removeAttr('style');
    }

    function mess_descr_go_to_cart(th) {
        var mess_descr = th.parent().find('.mess-descr');
        if (!mess_descr.hasClass('show')) {
            mess_descr.removeClass('d-hide');
            setTimeout(() => {
                mess_descr.addClass('show');
            }, 600);
            setTimeout(() => {
                mess_descr.removeClass('show');
            }, 5000);
            setTimeout(() => {
                if (!mess_descr.hasClass('d-hide')) {
                    mess_descr.addClass('d-hide');
                }
            }, 6000);

        }
    }

    function submit_search(when) {
        var submit_search = $('.woof_submit_search_form');
        if (when === 'later') {
            setTimeout(function () {
                submit_search.trigger('click');
            }, 500);
        }
        else {
            if (document.documentElement.clientWidth > 991) {
                submit_search.trigger('click');
            } 
        }
		
	}
    function price_slider_amount() {
        price_min = $('.price_slider_amount').find('input#min_price');
        price_max = $('.price_slider_amount').find('input#max_price');
    }

    $(document).ready(function(){
        var keyboard_layout = {
            "q":"й","w":"ц","e":"у","r":"к","t":"е","y":"н","u":"г","i":"ш","o":"щ","p":"з","[":"х","]":"ъ","a":"ф","s":"ы","d":"в","f":"а","g":"п","h":"р","j":"о","k":"л","l":"д",";":"ж","\'":"э","z":"я","x":"ч","c":"с","v":"м","b":"и","n":"т","m":"ь",",":"б",".":"ю","Q":"Й","W":"Ц","E":"У","R":"К","T":"Е","Y":"Н","U":"Г","I":"Ш","O":"Щ","P":"З","{":"Х","}":"Ъ","A":"Ф","S":"Ы","D":"В","F":"А","G":"П","H":"Р","J":"О","K":"Л","L":"Д",":":"Ж","\"":"Э","Z":"Я","X":"Ч","C":"С","V":"М","B":"И","N":"Т","M":"Ь","<":"Б",">":"Ю",
        };
        var search_input = document.querySelector('#search-js input.aws-search-field');
        search_input.addEventListener('input',function(){
            var val = '';
            var ss = this.selectionStart;
            for(var i = 0; i < this.value.length;i++) {
                if(keyboard_layout[this.value[i]]) {
                    val+=keyboard_layout[this.value[i]];
                }
                else {
                    val+=this.value[i];
                }
            }
            this.value = val;
            this.selectionStart = ss;
            this.selectionEnd = ss;
        });

    });

// ------------------------- КОНЕЦ ФУНКЦИИ -------------------------
    $(function(){
        var loader_svg = '<span class=loader><svg fill=none height=22 viewBox="0 0 22 22"width=22 xmlns=http://www.w3.org/2000/svg><g clip-path=url(#clip0_826_10097)><path d="M4.33826 18.99C5.63397 18.99 6.68434 17.9396 6.68434 16.6439C6.68434 15.3482 5.63397 14.2979 4.33826 14.2979C3.04256 14.2979 1.99219 15.3482 1.99219 16.6439C1.99219 17.9396 3.04256 18.99 4.33826 18.99Z"fill=white fill-opacity=0.85></path><path d="M19.4327 16.9093C20.5573 16.9093 21.4689 15.9977 21.4689 14.8731C21.4689 13.7486 20.5573 12.8369 19.4327 12.8369C18.3081 12.8369 17.3965 13.7486 17.3965 14.8731C17.3965 15.9977 18.3081 16.9093 19.4327 16.9093Z"fill=white fill-opacity=0.7></path><path d="M17.5737 6.64006C18.5027 6.64006 19.2558 5.88697 19.2558 4.95797C19.2558 4.02898 18.5027 3.27588 17.5737 3.27588C16.6447 3.27588 15.8916 4.02898 15.8916 4.95797C15.8916 5.88697 16.6447 6.64006 17.5737 6.64006Z"fill=white fill-opacity=0.6></path><path d="M2.48972 13.2633C3.86475 13.2633 4.97944 12.1758 4.97944 10.8343C4.97944 9.49279 3.86475 8.40527 2.48972 8.40527C1.11468 8.40527 0 9.49279 0 10.8343C0 12.1758 1.11468 13.2633 2.48972 13.2633Z"fill=white fill-opacity=0.9></path><path d="M9.64229 21.9999C10.8923 21.9999 11.9057 21.0125 11.9057 19.7944C11.9057 18.5763 10.8923 17.5889 9.64229 17.5889C8.39226 17.5889 7.37891 18.5763 7.37891 19.7944C7.37891 21.0125 8.39226 21.9999 9.64229 21.9999Z"fill=white fill-opacity=0.8></path><path d="M15.4588 21.0335C16.6463 21.0335 17.609 20.0961 17.609 18.9398C17.609 17.7835 16.6463 16.8462 15.4588 16.8462C14.2713 16.8462 13.3086 17.7835 13.3086 18.9398C13.3086 20.0961 14.2713 21.0335 15.4588 21.0335Z"fill=white fill-opacity=0.75></path><path d="M5.18294 7.62195C6.62046 7.62195 7.7858 6.48444 7.7858 5.08124C7.7858 3.67804 6.62046 2.54053 5.18294 2.54053C3.74542 2.54053 2.58008 3.67804 2.58008 5.08124C2.58008 6.48444 3.74542 7.62195 5.18294 7.62195Z"fill=white fill-opacity=0.95></path><path d="M20.0762 11.4707C21.1387 11.4707 22.0001 10.6253 22.0001 9.58253C22.0001 8.53971 21.1387 7.69434 20.0762 7.69434C19.0137 7.69434 18.1523 8.53971 18.1523 9.58253C18.1523 10.6253 19.0137 11.4707 20.0762 11.4707Z"fill=white fill-opacity=0.65></path><path d="M11.6419 5.48893C13.1577 5.48893 14.3864 4.26019 14.3864 2.74447C14.3864 1.22874 13.1577 0 11.6419 0C10.1262 0 8.89746 1.22874 8.89746 2.74447C8.89746 4.26019 10.1262 5.48893 11.6419 5.48893Z"fill=white></path></g><defs><clipPath id=clip0_826_10097><rect fill=white height=22 width=22></rect></clipPath></defs></svg></span>';
        update_filter_after_ajax();
        var error_mess = 'Произошла ошибка';
        setInterval(function() {
            const cookie = Cookies.get('pechnoj_centr12_likelist_product');
            if (cookie) {
                var cookies = cookie.split(',');
                $('.add-likelist-js').removeClass('active');
                for(var i=0; i<cookies.length; i++) {
                    var btn = $('.add-likelist-js[data-id="'+cookies[i]+'"]');
                    if (!btn.hasClass('active')) {
                        btn.addClass('active');
                    }
                } 
            }
            else {
                $('.add-likelist-js').removeClass('active');
            }
            const likelist_count_product = Cookies.get('pechnoj_centr12_likelist_count');
            if (likelist_count_product) {
                var count_like_desktop = $('#likelist-count-js');
                if (likelist_count_product == '' || likelist_count_product == '0' || !likelist_count_product) {
                    count_like_desktop.addClass('d-hide');

                }
                else {
                    count_like_desktop.text(likelist_count_product);
                    count_like_desktop.removeClass('d-hide');
                }
            }



            

        }, 0);

        //Закрыть уведомление пользователю по клику на блок уведомления
        $(document).on('click', '#message-wrapper', function () {
            var item = $('#message-wrapper .error-mess-list');
            item.removeClass('show');
            setTimeout(() => {
                item.remove();
            }, 500);
            setTimeout(() => {
                $('#buttonUp').removeAttr('style');
            }, 15300);
            var policy = $('#policy');
            if (policy.hasClass('error')) {
                policy.css('display', 'flex');
                policy.removeClass('error');
            }
        });

        $('input[type="tel"]').mask("+7 (999) 999-99-99", {
            autoclear: false
        });

        $(document).on('input', '.total__email', function(){
            this.value = this.value.replace(/[^a-z@\-_.0-9\s]/gi, '');
        });

        $('input#billing_first_name, input[name="form-name"]').keyup(function(evt){
		    var txt = $(this).val();
		    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
	    });

        var text_sorting = $('#select').find('option[selected=selected]').text();
	    var val_sorting = $('#select').find('option[selected=selected]').val();
	    $('.select-orderby-js').parent('').find('.select-input span[data-for="' + val_sorting +'"]').addClass('selected');
	    $('.select-orderby-js').text(text_sorting);
        $(document).on('click', '.select-orderby-js', function () {
            $(this).parent().find('.select-input').toggleClass('show');
            $(this).toggleClass('active');
        });
    
	//Функция добавления товара в корзину (динамически без перезагрузки)
	$(document).on('click', '.add-cart-js', function (e) {

        e.preventDefault();
        if ($('#message-wrapper').find('.error-mess-list').hasClass('show')) {
            $('#message-wrapper').trigger('click');
        }
        
        var th = $(this);
        if (th.hasClass('delete-item')) {
            var product_quantity = $('.add-to-cart').attr('data-quantity');
            var input_quantity = $('.add-to-cart').parent().find('input[name="quantity"]').val();
            var product_id = $('.add-to-cart').attr('data-id');
            var page = $('.add-to-cart').attr('data-page');
            var option = $('.add-to-cart').attr('data-option');
        }
        else {
            var product_quantity = th.attr('data-quantity');
            var input_quantity = th.parent().find('input[name="quantity"]').val();
            var product_id = th.attr('data-id');
            var page = th.attr('data-page');
            var option = th.attr('data-option');
        }

        if (page === 'archive') {
            th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').css('display','none');
            th.parent('.card__nav').find('.card__nav_tab').before('<div class="moving-loader"><span class="loader-circles"></span></div>');

            if (th.hasClass('active')) {
                var data = {
                    action: 'change_item_from_cart',
                    product_id: product_id,
                    option: option,
                };
            }
            else if (!th.hasClass('active')) {
                var data = {
                    action: 'add_product',
                    product_id: product_id,
                    quantity: product_quantity,
                    option: option,
                };
            }

        }
        else if (page === 'product') {
            if (th.hasClass('delete-item')) {
                var data = {
                    action: 'change_item_from_cart',
                    product_id: product_id,
                    option: option,
                };
            }
            else {

                if (th.hasClass('active')) {

                    if (option === 'one') {
                        var data = {
                            action: 'change_item_from_cart',
                            product_id: product_id,
                            quantity: product_quantity,
                            option: option,
                        };
                    }

                    else if (option === 'set') {
                        if (!$('.subject__order_wrapper').find('.moving-loader-count').length > 0) {
                            th.parent('.subject__order_wrapper').find('.subject__order_btn .number .number-minus').before('<div class="moving-loader-count"><span class="loader-circles-count"></span></div>');
                        }                    
                        var data = {
                            action: 'change_item_from_cart',
                            product_id: product_id,
                            quantity: input_quantity,
                            option: option,
                        };
                    }
                }
                else if (!th.hasClass('active')) {
                    th.parent().find('.add-to-cart').html(''+loader_svg+'Добавить в корзину');
                    if (option === 'one') {
                        var data = {
                            action: 'add_product',
                            product_id: product_id,
                            quantity: product_quantity,
                        };
                    }
                    else if (option === 'set') {
                        var data = {
                            action: 'add_product',
                            product_id: product_id,
                            quantity: product_quantity,
                        };
                    }
                }
            }
        }
        ajax_url = "/wp-admin/admin-ajax.php";
            $.ajax ({
                type:'POST',
                url: ajax_url,
                dataType: 'json',
                data: data,
                success:function(data) {
                    var mess = data.add_cart_mess;                 
                    console.log(mess);
                    $(document.body).trigger('wc_fragment_refresh');
                    if (page === 'archive') {
                        if (mess === 'ADD-OK') {
                            th.addClass('active');
                        }
                        else if (mess === 'ITEM-CART-HAVE') {
                            if (!th.hasClass('active')) {
                                th.addClass('active');
                            }
                        }   
                        else if (mess === 'REMOVE-OK') {
                            if (th.hasClass('active')) {
                                th.removeClass('active');
                            }
                        }   
                        else if (mess === 'ADD-ERROR') {
                            set_message(error_mess);
                            if (th.hasClass('active')) {
                                th.removeClass('active');
                            }
                        }
                        setTimeout(() => {
                            th.parent('.card__nav').find('.moving-loader').remove();
                            th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').removeAttr('style');
                        }, 500);
                    }
                    else if (page === 'product') {
                        if (th.hasClass('delete-item')) {
                            if (mess === 'REMOVE-OK') {
                               $('.subject__order_btn').addClass('d-hide');
                               $('.add-to-cart').removeClass('active d-hide');
                            }
                            else if (mess === 'REMOVE-ERROR') {
                                set_message(error_mess);
                            }
                            setTimeout(() => {
                                if (!th.hasClass('active')) {
                                    th.parents('.subject__order_wrapper').find('.add-to-cart').html('Добавить в корзину');
                                }
                            }, 800);
                        }
                        else {
                            if (option === 'one') {
                                if (mess === 'ADD-OK') {
                                    th.addClass('active d-hide');
                                    th.parent().find('.subject__order_btn').removeClass('d-hide');
                                    mess_descr_go_to_cart(th);
                                }
                                else if (mess === 'REMOVE-OK') {
                                    th.removeClass('active d-hide');
                                    th.parent().find('.subject__order_btn').addClass('d-hide');
                                }
                                else if (mess === 'ADD-ERROR') {
                                    set_message(error_mess);
                                }
                                setTimeout(() => {
                                    if (!th.hasClass('active')) {
                                        th.parent().find('.add-to-cart').html('Добавить в корзину');
                                    }
                                }, 800);
                            }
                            else if (option === 'set') {
                                if (mess === 'ADD-OK') {
                                    th.addClass('active d-hide');
                                    th.parent().find('.subject__order_btn').removeClass('d-hide');
                                    mess_descr_go_to_cart(th);                                   
                                }
                                else if (mess === 'ADD-ERROR') {
                                    set_message(error_mess);
                                }
                                else if (mess === 'CHANGE-OK') {
                                    var change_ok_count = data.change_ok_count;
                                    if (change_ok_count === 0) {
                                        th.removeClass('active d-hide');
                                        th.parent().find('.subject__order_btn').addClass('d-hide');
                                        th.parent().find('input[name="quantity"]').val('1');
                                    }
                                }
                                else if (mess === 'CHANGE-ERROR') {
                                    var change_error_count = data.change_error_count;
                                    set_message(error_mess);
                                    th.parent().find('input[name="quantity"]').val(change_error_count);
                                    console.log(change_error_count);
                                }
                                setTimeout(() => {
                                    $('.subject__order_wrapper .moving-loader-count').remove();
                                    if (!th.hasClass('active')) {
                                        th.parent().find('.add-to-cart').html('Добавить в корзину');
                                    }
                                }, 800);
                            }  
                        }
                    }
                    return true;
                },
                error: function () {
                    set_message(error_mess);
                    if (page === 'archive') {
                        setTimeout(() => {
                            th.parent('.card__nav').find('.moving-loader').remove();
                            th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').removeAttr('style');
                        }, 500);
                    }
                    else if (page === 'product') {
                        $('.subject__order_wrapper .moving-loader-count').remove();
                        if (!th.hasClass('active')) {
                            th.parent().find('.add-to-cart').html('Добавить в корзину');
                        }
                    }
                    return false;
                }
            });
            //e.preventDefault();
	});


    $('.go-to-cart').hover(function(){
        var mess_descr = $(this).find('.mess-descr');
        if (mess_descr.hasClass('show')) {
            setTimeout(() => {
                mess_descr.removeClass('show');
            }, 5000);
            setTimeout(() => {
                mess_descr.addClass('d-hide');
            }, 6000);
        }
    });

    if (!$('.subject__body .subject__order_wrapper .subject__order_btn').hasClass('d-hide') && $('.subject__body .subject__order_wrapper .add-cart-js').hasClass('active')) {
        var th = $('.add-cart-js[data-page="product"]');
        mess_descr_go_to_cart(th);
    }

    $(".subject-descr__item p, .subject__description_text p").each(function(){
        $(this).html($(this).html().replace('м3', 'м<sup>3</sup>'));
        $(this).html($(this).html().replace('м2', 'м<sup>2</sup>'));
    });

    $(document).on('click', '.number .number-minus', function() {
        var th = $(this);
        var input = th.parent().find('.number-text');
        var count = parseInt(input.val()) - 1;
        //console.log(count);
        if (th.hasClass('btn-product')) {
            if (count == 0) {
                count = 0;
            }
            else if (count > 0) {
                count = count < 1 ? 1 : count;
            }
            input.val(count);
            input.trigger('change');
        }
        else {
            count = count < 1 ? 1 : count;
            input.val(count);
            input.trigger('change');
        }
    });

    // Прибавляем кол-во по клику
    $(document).on('click', '.number .number-plus', function() {
        var th = $(this);
        var input = th.parent().find('.number-text');
        var count = parseInt(input.val()) + 1;
        count = count > parseInt(input.data('max-count')) ? parseInt(input.data('max-count')) : count;
        input.val(parseInt(count));
        input.trigger('change');
     });



	//При клике на инпут телефона, при блюре проверяем значения
	$(document).on('click', 'input[type="tel"]', function () {
		$('input[type="tel"]').on("blur", function() {
			var minlength = $(this).attr('minlength');
			var maxlength = $(this).attr('maxlength');
			var phone_val = $(this).val();
			var clean_str_phone = phone_val.replace(/[^0-9]/g, '');
			if (clean_str_phone.length >= maxlength && clean_str_phone.length <= minlength) {
				$(this).parent().find('span').text('Необходимо заполнить поле');
				$(this).parent().removeClass('woocommerce-invalid woocommerce-invalid-required-field');
			} else{
				$(this).parent().find('span').text('Введите полностью телефон');
				$(this).parent().addClass('woocommerce-invalid woocommerce-invalid-required-field');
			}
		});
	});

    // Убираем все лишнее и невозможное при изменении поля
    $('.number .number-text').bind("change keyup input click", function () {

        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9]/g, '');
        }
        if (this.value == "") {
            this.value = 1;
            
            
        }
        if (this.value > parseInt($(this).data('max-count'))) {
            this.value = parseInt($(this).data('max-count'));
        }
    });

    $(document).on('change', 'input.number-text.btn-product', function() {
        setTimeout(() => {
            $('.add-cart-js').trigger('click');
        }, 500);
    });


    //При изменении ввода своего числа кол-во товаров в input обновляем корзину (срабатывает, когда убрали фокус с input)
    $(document).on('change', '.basket__item_number .number input', function() {
		setTimeout(function () {
			$('.actions button[name="update_cart"]').removeAttr("disabled").trigger("click");
		}, 200);
	});

    //Убрать фокус с input, когда нажали enter, или на ios готово, чтобы обновить корзину
	$(document).on('keydown', '.number input', function (event) {
        
		if (event.keyCode == 13) {
            if ($(this).hasClass('btn-product')) {
                $('.add-cart-js').trigger('click');
            }
			input_keydown = $(this).parents('.number').find('.number-text');
			if (input_keydown.val() !== '') {
				input_keydown.blur();               
			}
		}
	});
    
    $(document).on('click', '.actions button[name="update_cart"], a.basket__item_delete', function () {
        var loader_cart = setInterval(function() {
            if($('form.woocommerce-cart-form').find('.blockUI.blockOverlay').length > 0) {
                if(!$('.basket__items').find('.moving-loader').length > 0) {
                    $('form.woocommerce-cart-form.basket__items').find('.basket__items_heading').before('<div class="moving-loader"><span class="loader-circles"></span></div>'); 
                    }
            }
            else {
                setTimeout(() => {
                    clearInterval(loader_cart);
                }, 1000);
            }
        }, 0);
    });

	$(document).on('click', '#place_order', function () {
        $(this).css('pointer-events','none');
        var loader_checkout = setInterval(function() {
            if ($('.woocommerce-error li span').hasClass('error_tel')) {
                $('#billing_phone_field').addClass('woocommerce-invalid woocommerce-invalid-required-field');
            }
            if($('form.checkout').find('.blockUI.blockOverlay').length > 0) {
                if(!$('#payment').find('.loader').length > 0) {
                    $('#payment').find('#place_order').before(loader_svg);
                    }
            }
            else {
                setTimeout(() => {
                    $('#payment').find('.loader').remove();
                    $('#place_order').removeAttr('style');
                    clearInterval(loader_checkout);
                }, 1000);
            }
        }, 0);
    });

	$(document).on('click', '.add-likelist-js', function (e) {
		e.preventDefault();
		th = $(this);
            th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').css('display','none');
            th.parent('.card__nav').find('.card__nav_tab').before('<div class="moving-loader"><span class="loader-circles"></span></div>');
        product_id = th.data('id');
		ajax_url = "/wp-admin/admin-ajax.php";
		$.ajax ({
			type:'POST',
			url: ajax_url,
			dataType: 'json',
			data:'action=likelist&product_id=' + product_id + '',
			success:function(data) {
                var count_likelist = data.count_likelist;
				if (th.data('page') === 'likelist') {
					th.parents('.card').remove();
					if (count_likelist === 0) {
						location.reload();
					}
				}
                else {
                    if (!th.hasClass('active')) {
                        th.addClass('active');
                    }
                    else {
                        th.removeClass('active');
                    }
                    setTimeout(() => {
                        th.parent('.card__nav').find('.moving-loader').remove();
                        th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').removeAttr('style');
                    }, 500);

                }
			},
			error: function () {
				set_message(error_mess);
                setTimeout(() => {
                    th.parent('.card__nav').find('.moving-loader').remove();
                    th.parent('.card__nav').find('.card__nav_tab,.card__nav_basket').removeAttr('style');
                }, 500);
			}
		});
	});


    if ($('.about-last-job').length > 0) {
        $(document).on('click', '.portfolio-js', function () {
            var th = $(this);
            if (!th.hasClass('active')) {
                var portfolio_descr = $('.about-last-job__descr');
                var title = th.attr('data-title');
                var volume = th.attr('data-volume');
                var location = th.attr('data-location');
                var length = th.attr('data-length');
                var width = th.attr('data-width');
                var height = th.attr('data-height');
                var size_block = ''+length+'&nbsp;×&nbsp;'+width+'&nbsp;×&nbsp;'+height+'&nbsp;м';
                var type = th.attr('data-type');
                var img_count = th.find('img').attr('data-count');
                var dir = $('#main-js').attr('data-dir');
                th.addClass('active');
                $('.portfolio-js').not(this).removeClass('active');
                portfolio_descr.css('overflow','hidden');
                portfolio_descr.find('.work__descr_title').css({'transition':'all 0.2s ease','opacity':'0'});
                portfolio_descr.find('p').css({'transform':'translateX(40px)','transition':'all 0.5s ease','opacity':'0'});
                $('.about-last-job__slider').css({'transform':'translateX(40px)','transition':'all 0.6s ease','opacity':'0'});
                setTimeout(() => {
                    portfolio_descr.find('p').css({'transform':'translateX(200px)','transition':'all 0.8s ease'});
                }, 600);
                setTimeout(() => {
                    portfolio_descr.find('.work__descr_title').html(title);
                    portfolio_descr.find('.work__descr_volume p').html(volume+'&nbsp;м<sup>3</sup>');
                    portfolio_descr.find('.work__descr_location p').html(location);
                    portfolio_descr.find('.work__descr_size p').html(size_block);
                    portfolio_descr.find('.work__descr_bake p').html(type);
                    portfolio_descr.find('.work__descr_title').css({'transition':'all 0.2s ease','opacity':'1'});
                    portfolio_descr.find('p').css({'transform':'translateX(-10px)','transition':'all 0s ease'});
                }, 610);
                setTimeout(() => {
                    portfolio_descr.find('p').css({'transform':'translateX(0px)','transition':'all 0.5s ease','opacity':'1'});
                }, 630);
                setTimeout(() => {
                    aboutSlider.destroy();
                    $('#portfolio-wrapper').find('div').remove();
                    for (var i=1; i <= img_count; i++) {
                        var imgs = th.find('img').attr('data-src-'+i+'');
                        var block_slide = '<div class="about-last-job__slide swiper-slide"><div class="about-last-job__image"><img data-src="'+imgs+'" src="'+dir+'/assets/img/pixel.png" class="swiper-lazy"alt="img-portfolio"><div class="swiper-lazy-preloader"></div></div></div>'
                        $('#portfolio-wrapper').append(block_slide);
                        start_about_last_job();
                    }
                }, 640);
                setTimeout(() => {
                    $('.about-last-job__slider').css({'transform':'translateX(0px)','transition':'all 0.6s ease','opacity':'1'});
                }, 660);
                
                setTimeout(() => {
                    portfolio_descr.removeAttr('style');
                    portfolio_descr.find('p').removeAttr('style');
                    portfolio_descr.find('.work__descr_title').removeAttr('style');
                    $('.about-last-job__slider-wrapper').removeAttr('style');
                }, 900);
            }
        });
    }

    // ФИЛЬТР
    if ($('.woof').length > 0) {
        $(document).on('click', '.woof_container_inner h4', function () {
            var th = $(this);
            if (th.find('a').length > 0) {
                th.find('a').trigger('click');
                if (th.find('a').hasClass('woof_front_toggle_opened')) {
                    th.addClass('open');
                }
                else {
                    th.removeClass('open');
                }
            }
        });

        $(document).on('click', '.sidebar__mob .reset_filter', function () {
            $('.woof_reset_search_form').trigger('click');
            $('.apply_filter').removeClass('show');
            
        });
        $(document).on('click', '.apply_filter .btn', function () {
            submit_search('later');
            $(this).html('<div class="btn">Применить'+loader_svg+'</div>');
        });
        $(document).on('change', '.woof input', function () {
            submit_search();
            var apply_filter = $('.apply_filter');
            if (!apply_filter.hasClass('show')) {
                apply_filter.addClass('show');
            }
            
        });

        $(document).on('click', '.sidebar__mob_close', function () {
            var checkbox_label = $('.woof_container .woof_checkbox_label');
            checkbox_label.each(function(){
                var input = $(this).parent('li').children('.woof_checkbox_term');
                var label = $(this);
                if ((input.is(':checked')) && (!label.hasClass('woof_checkbox_label_selected'))){
                    input.attr('checked', false);
                    input.prop('checked', false);
                    input.trigger('change');
                }
                else if ((!input.is(':checked')) && (label.hasClass('woof_checkbox_label_selected'))){
                    input.attr('checked', true);
                    input.prop('checked', true);
                    input.trigger('change');
                }
            });
            if ($('.widget_price_filter').length > 0) {
                var price_min = $('.price_slider_amount').find('input#min_price').attr('data-initial');
                var price_max = $('.price_slider_amount').find('input#max_price').attr('data-initial');
                $('#min_price').val(price_min);
                $('#max_price').val(price_max);
                $( ".woof_price_search_container .ui-slider" ).slider( "values", [ price_min, price_max ] );
            }

            var range_slider = $('.woof_taxrange_slider');
            range_slider.each(function(){
                var RangeSlider = $(this).data("ionRangeSlider");
                RangeSlider.reset();
            });
            $('.apply_filter').removeClass('show');
 
        });


        //Обновление фильтра при измненении цены в input-тах
        $(document).on('change', '.price_slider_amount input', function() {
            price_slider_amount();
            // var price_min = $('.price_slider_amount').find('input#min_price');
            // var price_max = $('.price_slider_amount').find('input#max_price');
            if (price_min.val() == '') {
                $('#min_price').val(price_min.attr('value'));
            }
            if (price_max.val() == '') {
                $('#max_price').val(price_max.attr('value'));
            }
            if (price_min.val() == '0') {
                $('#min_price').val(price_min.attr('data-initial'));
            }
            if (price_max.val() == '0') {
                $('#max_price').val(price_max.attr('data-initial'));
            }
            $( ".woof_price_search_container .ui-slider" ).slider( "values", [ price_min.val(), price_max.val() ] );
        });

        $(document).on('click', '.price_slider_amount input', function() {
            price_slider_amount();
            // var price_min = $('.price_slider_amount').find('input#min_price');
            // var price_max = $('.price_slider_amount').find('input#max_price');
            $(this).val('');
        });

        $('.price_slider_amount input').focusout(function () {
            var th = $(this);
            if (th.val() == '' || th.val() == '0') {
                th.val(th.attr('data-initial'));
            }
        });
    }


    $(document).on('click', '#input-search-js', function (e) {
        e.preventDefault();
        var search_text = $(this).find('span').text();
        var input = $('form.aws-search-form input[type="search"]');
        input.val(search_text);
        input.keyup();
        input.focus();
    });


    var orderby_relevance = $('.category__sorting .select-input span[data-for="relevance"]');
    if (orderby_relevance.length > 0) {
        var relevance_text = 'по релевантности';
        orderby_relevance.text(relevance_text);
        if (orderby_relevance.hasClass('selected')) {
            $('.select-orderby-js').text(relevance_text);
        }
    }

    $(document.body).on('click', 'a.page-numbers, #reset_filter, .woof_result_count', function(e) {
		setTimeout(function () {
			$('html').animate({scrollTop: $(".layout").offset().top}, 200);
		}, 200);
	});


});

</script>
</html>
