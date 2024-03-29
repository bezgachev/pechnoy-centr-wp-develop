<?php
/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;
?>


<?php
if ( $order ) :

do_action( 'woocommerce_before_thankyou', $order->get_id() );
?>
<? woocommerce_breadcrumb();?>
	<div class="order-receive">
		<section class="info__wrapper"><i class="fly"></i>
			<div class="info__title">
				<h1>Ваш заказ оформлен, спасибо!</h1>
				<p>Наш менеджер свяжется с вами в ближайшее время для уточнения деталей заказа и способа оплаты</p>
				<a href="<?echo home_url();?>" class="btn">Вернуться на главную</a>
			</div>
		</section>
	</div>
<?php endif; ?>
