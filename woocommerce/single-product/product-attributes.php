<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-attributes.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<?
echo '<ul class="subject__description_list subject-descr">';
foreach ( $product_attributes as $product_attribute_key => $product_attribute ) {
	echo '<li class="subject-descr__item">';
		echo '<p class="subject-descr__item_title">'.$product_attribute['label'].'</p><span class="subject-descr__item_span"></span>';
		$product_attributes = array();
		$product_attributes = explode(',',$product_attribute['value']);
		echo '<p class="subject-descr__item_value '.esc_attr( $product_attribute_key ).'">';
			foreach ( $product_attributes as $pa ) {
				$pa = strip_tags($pa);
				if (!next($product_attributes)) {
					$attr_pa = $pa;
				}
				else {
					$attr_pa = ''.$pa.',';
				}
				echo $attr_pa;
			}
		echo '</p>';
	echo '</li>';
}
echo '</ul>';
?>