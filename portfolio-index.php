<?
/*
Template Name: Портфолио
*/
?>
<?get_header();?>
<div class="works">
	<?woocommerce_breadcrumb();?>
	<h1 class="works__title"><?wp_title(false);?></h1>
	<div class="container">
		<? if (have_posts()) { while (have_posts()) { the_post(); ?>
			<div class="four-cards">
				<?
				// параметры по умолчанию
				$args = array(
				'numberposts' => 6,
				'post_type'   => 'portfolio',
				'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
				);
				$posts = get_posts($args);
				foreach($posts as $post){ setup_postdata($post);?>
					<a href="<?the_permalink();?>" class="card-work">
						<div class="card-work__swiper swiper">
							<div class="card-work__swiper_wrapper swiper-wrapper">
								<?$img_gallery = get_field('portfolio-imgs');
								foreach ($img_gallery as $img) {
									if ($img) {
										echo '<div class="card-work__swiper_slide swiper-slide"><img src="'.$img.'" alt="img-portfolio"></div>';
									}
								}?>
							</div>
							<div class="card-work__swiper_pagination swiper-pagination"></div>
						</div>
						<h4 class="card-work__title"><?the_title();?></h4>
						<? /*
						<p class="card-work__text"><span>Объём парной:</span>&nbsp;<span><?echo get_field('portfolio-volume');?>&nbsp;м<sup>3</sup></span></p>
						<p class="card-work__text"><span>Местоположение:</span>&nbsp;<span><?echo get_field('portfolio-location');?></span></p>
						*/?>
					</a>
				<?
				}
				wp_reset_postdata(); // сброс
				?>
			</div>
			<? } // конец while ?>
		<? } // конец if ?>
	</div>
</div>
<?get_footer();?>