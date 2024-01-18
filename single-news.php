<?get_header();?>
<?woocommerce_breadcrumb();?>
<div class="container full-news">
	<div class="full-news__descr"><span><?echo date_i18n('j F Y', false);?></span>
		<h1><?the_title();?></h1>
        <?the_content();?>
	</div>
    <div class="full-news__swiper swiper">
        <div class="swiper-wrapper">
            <?$img_gallery = get_field('post-news-imgs');
            foreach ($img_gallery as $img) {
                if ($img) {
                    echo '<div class="swiper-slide"><img src="'.$img.'" alt="img-news"></div>';
                }
            }?>
        </div>
        <div class="first__nav">
            <div class="first-button-prev"></div>
            <div class="first-pagination"></div>
            <div class="first-button-next"></div>
        </div>
    </div>
</div>
<?get_footer();?>