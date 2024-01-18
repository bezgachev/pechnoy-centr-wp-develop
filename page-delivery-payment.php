<?
/*
Template Name: Доставка и оплата
Template Post Type: page
*/
?>
<?get_header();?>
<?woocommerce_breadcrumb();?>
<div class="container delivery-payment">
    <h1>Доставка и оплата</h1>
    <div class="delivery-payment__container">
        <div class="delivery">
            <div class="delivery__container">
                <div class="delivery__items pickup">
                    <h2>Самовывоз</h2>
                    <p><?echo get_field('delivery-pickup');?></p>
                </div>
                <div class="delivery__items delivery-city">
                    <h2>Доставка по Йошкар-Оле и&nbsp;Марий Эл</h2>
                    <p><?echo get_field('delivery-city');?></p>
                </div>
            </div>
            <div class="delivery__items delivery-country">
                <h2>Доставка по России</h2>
                <p><?echo get_field('delivery-country');?></p>
            </div>
        </div>
        <div class="payment">
            <h2>Способы оплаты товара:</h2>
            <p class="payment__cash">Наличный расчет</p>
            <p class="payment__by-card">Оплата банковской картой</p>
            <p class="payment__translation">Банковский перевод на расчетный счет компании</p>
        </div>
    </div>
</div>
<?get_footer();?>