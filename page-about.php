<?
/*
Template Name: О компании
Template Post Type: page
*/
?>
<?get_header();?>
<?woocommerce_breadcrumb();?>
<section class="about-page">
	<div class="container">
		<h1 class="about-page__title">О компании</h1>
		<p class="about-page__text"><?echo get_field('about-us-descr'); ?></p>
		<h2 class="about-page__subtitle">
			Каталог продукции
		</h2>

		<? wp_nav_menu(array(
			'theme_location'  => 'products-about',
			'menu_id'      => false,
			'container'       => 'div', 
			'container_class' => 'about-page__wrapper', 
			'menu_class'      => false,
			'items_wrap'      => '%3$s',
			'order' => 'ASC',      
			'walker' => new products_about()   
		)); ?>   


	</div>
</section>
<section class="services">
	<div class="container">
		<div class="services__wrapper">
			<h2 class="services__title">Услуги, которые мы оказываем</h2>
			<div class="services__items content-three-col">
                <?services_stages();?>
			</div>
		</div>
	</div>
</section>

<?
$args = array(
	'numberposts' => 12,
	'orderby'     => 'date',
	'order'       => 'DESC',
	'include'     => array(),
	'exclude'     => array(),
	'meta_key'    => '',
	'meta_value'  => '',
	'post_type'   => 'portfolio',
	'suppress_filters' => true,
);
global $post;
$my_posts = get_posts($args);
if ($my_posts) { ?>

	<div class="container">
		<section class="about-last-job ">
			<h2 class="about-last-job__title">Наши последние работы</h2>
			<div class="about-all-job">
				<?
				foreach( $my_posts as $indexpost => $post ){
					setup_postdata($post); 
					$title = get_the_title();
					$volume = get_field('portfolio-volume');
					$location = get_field('portfolio-location');
					$size = get_field('portfolio-size-block');
                    $size_length = $size['portfolio-size-length'];
                    $size_width = $size['portfolio-size-width'];
                    $size_height = $size['portfolio-size-height'];
					$type = get_field('portfolio-type');
					$features = 'data-title="'.$title.'" data-volume="'.$volume.'" data-location="'.$location.'" data-length="'.$size_length.'" data-width="'.$size_width.'" data-height="'.$size_height.'" data-type="'.$type.'"';
					if ($indexpost === 0) {
						echo '<div class="about-all-job__img portfolio-js active" '.$features.'>';
					}
					else {
						echo '<div class="about-all-job__img portfolio-js" '.$features.'>';
					}
					$img_gallery = get_field('portfolio-imgs');
					foreach ($img_gallery as $index => $img) {
						if ($img) {
							if ($index === 0) {
								echo '<img src="'.$img_gallery[$index].'" ';
							}
							$img_count = ($index+1); 
							echo ' data-src-'.$img_count.'="'.$img.'"';
						}
					}
					echo ' alt="img-portfolio" data-count="'.$img_count.'"></div>';
				}
				wp_reset_postdata(); ?>

			</div>
		
			<div class="about-last-job__slider-wrapper">
				<div class="about-last-job__slider swiper">
					<div class="about-last-job__wrapper swiper-wrapper" id="portfolio-wrapper">

						<?
						$args_first = array(
							'numberposts' => 1,
							'orderby'     => 'date',
							'order'       => 'DESC',
							'include'     => array(),
							'exclude'     => array(),
							'meta_key'    => '',
							'meta_value'  => '',
							'post_type'   => 'portfolio',
							'suppress_filters' => true,
						);
						global $post;
						$my_posts = get_posts($args_first);
						foreach( $my_posts as $indexpost => $post ){
							setup_postdata($post);
							$img_gallery = get_field('portfolio-imgs');
								foreach ($img_gallery as $img) {
								?>
									<div class="about-last-job__slide swiper-slide">
										<div class="about-last-job__image">
											<img data-src="<?echo $img;?>" src="<?echo get_template_directory_uri();?>/assets/img/pixel.png" class="swiper-lazy"
												alt="img-portfolio">
											<div class="swiper-lazy-preloader"></div>
										</div>
									</div>
								<?}?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
				<div class="about-last-job__descr">
					<h3 class="work__descr_title"><?the_title();?></h3>
					<div class="work__descr_volume">
						<h4>Объём парной:</h4>
						<p><?echo get_field('portfolio-volume');?>&nbsp;м<sup>3</sup></p>
					</div>
					<div class="work__descr_location">
						<h4>Местоположение:</h4>
						<p><?echo get_field('portfolio-location');?></p>
					</div>
					<div class="work__descr_size">
						<h4>Габариты парной (Д×Ш×В):</h4>
						<?
							$size = get_field('portfolio-size-block');
							$size_length = $size['portfolio-size-length'];
							$size_width = $size['portfolio-size-width'];
							$size_height = $size['portfolio-size-height'];
							echo '<p>'.$size_length.'&nbsp;×&nbsp;'.$size_width.'&nbsp;×&nbsp;'.$size_height.'&nbsp;м</p>';
						?>
					</div>
					<div class="work__descr_bake">
						<h4>Печь:</h4>
						<p><?echo get_field('portfolio-type');?></p>
					</div>
				</div>
			</div>
			<?} wp_reset_postdata(); ?>
			<a href="<?echo get_permalink(532);?>" class="btn">Смотреть все работы</a>
		</section>
	</div>
<?}?>

<?get_footer();?>