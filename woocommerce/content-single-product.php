<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<section class="subject">
	<div class="container">
		<div class="subject__wrapper">


	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	do_action( 'woocommerce_before_single_product_summary' );
	?>

	
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		do_action( 'woocommerce_single_product_summary' );
		?>
	

	<?php
	/**
	 * Hook: woocommerce_after_single_product_summary.
	 *
	 * @hooked woocommerce_output_product_data_tabs - 10
	 * @hooked woocommerce_upsell_display - 15
	 * @hooked woocommerce_output_related_products - 20
	 */
	do_action( 'woocommerce_after_single_product_summary' );
	?>
</div>
</div>
<div class="modal-img">
	<button class="close-button"></button>
    <div class="container">
        <div class="popup-btn-prev"></div>
        <div class="popup-btn-next"></div>
        <div class="popup-img swiper">
            <div class="popup-img-wrapper swiper-wrapper">
				<?
					global $product;
					
					$attachment_ids = $product->get_gallery_attachment_ids();

					echo '<div class="popup-img-slide swiper-slide">';	
					$img_src = get_the_post_thumbnail_url( $post->ID, 'woo-large-size-product', false );
					if (empty($img_src)) {
						$thumbnail_tag = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('woo-thumbnail-product'));
						preg_match_all('/<img[^>]+src="?\'?([^"\']+)"?\'?[^>]*>/i', $thumbnail_tag, $images, PREG_SET_ORDER);
						foreach ($images as $image) {
							echo '<img src="' .$image[1] . '" set-data="1">';
						}
					}
					else {
						echo '<img data-src="' . esc_url($img_src) . '" src="' . get_template_directory_uri() . '/assets/img/slider_product/pixel.png" class="swiper-lazy"><div class="swiper-lazy-preloader"></div>';
					}
					echo '</div>';
					foreach( $attachment_ids as $attachment_id ) {
						echo '<div class="popup-img-slide swiper-slide">';
						$img_src = wp_get_attachment_image_src( $attachment_id, 'woo-large-size-product', false );
						echo '<img data-src="' . $img_src[0] . '" src="' . get_template_directory_uri() . '/assets/img/slider_product/pixel.png" class="swiper-lazy"><div class="swiper-lazy-preloader"></div>';
						echo '</div>';
					}
					$video_id = $product->get_meta( '_text_field_videoid', true );
					if ($video_id) {
						$video_bgc_max = 'https://i.ytimg.com/vi/'.$video_id.'/maxresdefault.jpg';
						$video_bgc_sd = 'https://i.ytimg.com/vi/'.$video_id.'/sddefault.jpg';
						if (@getimagesize($video_bgc_max)) {
							$url_bgc = $video_bgc_max;
						}
						else if (@getimagesize($video_bgc_sd)) {
							$url_bgc = $video_bgc_sd;
						}
						else {
							$url_bgc = ''.get_template_directory_uri().'/assets/img/bg/preview-video.jpg';
						}
						echo '<div class="popup-img-slide swiper-slide">
							<div class="product-video-popup player__video">
								<div class="video" data-blocked-id="'.$video_id.'" data-params="loop=1&playlist='.$video_id.'&enablejsapi=1" style="background: url('.$url_bgc.') center center / 100% auto no-repeat"></div>
								<div class="block__video-error loader-error" data-i="'.$video_id.'">
									<span>
										<svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1221_26932)"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.5607 44.5175C9.03165 40.1163 16.8458 37.5915 25.0001 37.5915C33.1544 37.5915 40.9686 40.1163 46.4396 44.5175C46.8438 44.8435 47.3292 45.0013 47.8112 45.0013C48.4495 45.0013 49.0836 44.7232 49.516 44.1873C50.274 43.2479 50.1253 41.8724 49.1844 41.1155C42.9504 36.1 34.1346 33.2227 25.0001 33.2227C15.8656 33.2227 7.04991 36.1 0.815826 41.1155C-0.125909 41.8724 -0.27375 43.2479 0.484253 44.1873C1.24226 45.1259 2.61982 45.2752 3.5607 44.5175Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3588 0.639956C48.5051 -0.213319 47.1198 -0.213319 46.2653 0.639956L41.3216 5.57615L36.377 0.639956C35.5233 -0.213319 34.1381 -0.213319 33.2835 0.639956C32.4289 1.49237 32.4289 2.87553 33.2835 3.72881L38.2272 8.665L33.2835 13.602C32.4289 14.4544 32.4289 15.8376 33.2835 16.6909C34.1372 17.5442 35.5225 17.5442 36.377 16.6909L41.3216 11.7547L46.2653 16.6909C46.6926 17.1175 47.2523 17.3308 47.812 17.3308C48.3718 17.3308 48.9315 17.1175 49.3588 16.6909C50.2134 15.8376 50.2134 14.4544 49.3588 13.602L44.4151 8.665L49.3588 3.72881C50.2134 2.87553 50.2134 1.49237 49.3588 0.639956Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.641415 16.6918C1.49513 17.5442 2.88039 17.5442 3.73496 16.6909L8.67864 11.7547L13.6223 16.6909C14.0496 17.1175 14.6094 17.3309 15.1691 17.3309C15.7289 17.3309 16.2895 17.1175 16.7159 16.6909C17.5705 15.8385 17.5705 14.4553 16.7167 13.6021L11.7731 8.66586L16.7167 3.72881C17.5705 2.87639 17.5705 1.49323 16.7159 0.639956C15.8622 -0.212465 14.4769 -0.213319 13.6223 0.639956L8.67864 5.57615L3.73496 0.639956C2.88039 -0.213319 1.49513 -0.213319 0.641415 0.639956C-0.213154 1.49323 -0.213154 2.87639 0.641415 3.72881L5.5851 8.66586L0.641415 13.6021C-0.213154 14.4553 -0.213154 15.8385 0.641415 16.6918Z" fill="#EE523F"/></g><defs><clipPath id="clip0_1221_26932"><rect width="50" height="45" fill="white"/></clipPath></defs></svg>
									</span>
									<div class="page-reload btn">Перезагрузить</div>
								</div>
								<div class="play__btn play-btn-product-video-popup" data-btn="'.$video_id.'" data-url="'.$url_bgc.'"><span></span></div>
							</div>
						</div>';
					}
				?>
            </div>
        </div>
    </div>
</div>
<div class="overlay-popup"></div>
</section>
<?contact_maps();?>

<? do_action( 'woocommerce_after_single_product' ); ?>
