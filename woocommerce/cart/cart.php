<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
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


do_action( 'woocommerce_before_cart' ); ?>
<? woocommerce_breadcrumb();?>
<section class="basket container">
	<h1 class="h1">Корзина</h1>
	<div class="basket__wrapper">
		<form class="woocommerce-cart-form basket__items" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<!-- <div class="basket__items"> -->
				<div class="basket__items_heading">
					<div class="basket__items_heading-number">Количество</div>
					<div class="basket__items_heading-cost">Стоимость</div>
				</div>
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
			<?php do_action( 'woocommerce_before_cart_contents' ); ?>


			<?
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
				<div class="basket__item woocommerce-cart-form__contents shopping-cart__body showcase cart_item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<? 
					$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('woo-thumbnail-product'), $cart_item, $cart_item_key );
					if ( ! $product_permalink ) {
						echo $thumbnail; // PHPCS: XSS ok.
					} else {
						printf( '<a href="%s" class="basket__item_img">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
					}
					
					
					if ( ! $product_permalink ) {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
					} else {
						echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="basket__item_title">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
					}

					do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
					
					if ( $_product->is_sold_individually() ) {
						$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
					} else {
						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							),
							$_product,
							false
						);
					}
					?>
					<div class="basket__item_number">
						<?
						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						$quantity_product = $cart_item['quantity'];
						if ($quantity_product > 1) {
							?>
							<span class="basket__item_number-cost">
							<?
								$item_quantity = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
								$item_quantity_text = str_replace(' ', '', $item_quantity);
								$item_quantity_text = strip_tags($item_quantity_text);
								$item_quantity_space = number_format((int)$item_quantity_text, 0, '', ' ');
								echo ''. $item_quantity_space .'&nbsp;<span>₽&nbsp;/&nbsp;шт.</span>';
							?>
							</span>
							<?
						}
						?>
					</div>

					<div class="basket__item_cost">
						<?
						$item_subtotal = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						$item_subtotal_text = str_replace(' ', '', $item_subtotal);
						$item_subtotal_text = strip_tags($item_subtotal_text);
						$item_subtota_space = number_format((int)$item_subtotal_text, 0, '', ' ');
						echo ''. $item_subtota_space .'<span>&nbsp;₽</span>';
						?>
					</div>
					<div class="product-remove">
						<?
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="basket__item_delete" aria-label="%s" data-product_id="%s" data-product_sku="%s"><span class="delete-button">
								<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd"
									d="M1.76664 1.06051C1.57138 0.865247 1.25479 0.865247 1.05953 1.06051C0.86427 1.25577 0.86427 1.57235 1.05953 1.76762L5.29306 6.00115L1.05998 10.2342C0.864713 10.4295 0.864713 10.7461 1.05998 10.9413C1.25524 11.1366 1.57182 11.1366 1.76708 10.9413L6.00017 6.70825L10.2333 10.9413C10.4285 11.1366 10.7451 11.1366 10.9404 10.9413C11.1356 10.7461 11.1356 10.4295 10.9404 10.2342L6.70728 6.00115L10.9408 1.76762C11.1361 1.57235 11.1361 1.25577 10.9408 1.06051C10.7455 0.865247 10.429 0.865247 10.2337 1.06051L6.00017 5.29404L1.76664 1.06051Z"
									fill="#3B3B3B" /></svg></span><span class="delete-word">Удалить</span></a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_html__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						?>
					</div>
				</div>

			<? }
			}?>


			
			<!-- </div> -->


			<?php do_action( 'woocommerce_cart_contents' ); ?>


			<div class="actions d-hide">	
				<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' );

				?>
			</div>

			<?php do_action( 'woocommerce_after_cart_contents' ); ?>

			<?php do_action( 'woocommerce_after_cart_table' ); ?>
		</form>

		<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

		<div class="basket__total">
			<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action( 'woocommerce_cart_collaterals' );
			?>
			<?php echo do_shortcode('[woocommerce_checkout]');?>

		</div>
	</div>
</section>
<?php do_action( 'woocommerce_after_cart' ); ?>