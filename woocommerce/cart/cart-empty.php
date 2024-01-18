<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;


if( is_order_received_page() ) {
	woocommerce_breadcrumb();?>
	<div class="order-receive">
		<section class="info__wrapper"><i class="fly"></i>
			<div class="info__title">
				<h1>Ваш заказ оформлен, спасибо!</h1>
				<p>Наш менеджер свяжется с вами в ближайшее время для уточнения деталей заказа и способа оплаты</p>
				<a href="<?echo get_site_url();?>" class="btn">Вернуться на главную</a>
			</div>
		</section>
	</div>
<?} else {
	/*
 * @hooked wc_empty_cart_message - 10
 */
do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
<? woocommerce_breadcrumb();?>
<div class="woo-cart info">
	<section class="info__wrapper"><i class="fly"></i>
		<div class="info__title">
			<h1>В корзине пусто</h1>
			<p>Вернитесь на главную или перейдите в интересующую Вас категорию для выбора нужного товара</p>
			<a href="<?echo get_site_url();?>" class="btn">Вернуться на главную</a>
		</div>
	</section>
</div>
<?php endif; 

}
?>





