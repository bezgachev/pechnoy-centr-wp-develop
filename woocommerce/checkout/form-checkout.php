<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<h2 class="basket__total_title">Оформление заказа</h2>
<form name="checkout" method="post" class="checkout woocommerce-checkout total" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>
		<?php do_action( 'woocommerce_before_checkout_billing_form'); ?>

				<?php do_action( 'woocommerce_checkout_billing' ); ?>
		

				<?php /*do_action( 'woocommerce_checkout_shipping' ); */?>


		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	

	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	<div class="total__item">
			<div class="total__price">
				<span class="total__price_descr">Итого:</span>
				<?
				$total_price = WC()->cart->get_cart_total();
				$notag_total_price = str_replace(' ', '', $total_price);
				$notag_total_price = strip_tags($notag_total_price);
				$total_price_space = number_format((int)$notag_total_price, 0, '', ' ');
				?>
				<span class="total__price_count cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>"><?echo $total_price_space;?><span>&nbsp;₽</span></span>

			</div>
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
