<? get_header();?>
<section class="first">
	<div class="swiper first-slide">
		<div class="swiper-wrapper">
			<?
			$main_sliders = get_field('main-slider');
			foreach($main_sliders as $main_slider) {
				$slide_h1 = $main_slider['main-title'];
				$slide_descr = $main_slider['main-subtitle'];
				$slide_img = $main_slider['main-img'];
				$slide_link = $main_slider['main-link'];
				$slide_btn_text = $main_slider['main-btn-text'];
				echo '
					<div class="swiper-slide first-slide_img" style="background-image:url('.$slide_img.');">
						<div class="container" data-swiper-parallax-x="20%">
							<h1 class="first-slide_title">'.$slide_h1.'</h1>
							<p class="first-slide_text">'.$slide_descr.'</p>
							<a href="'.$slide_link.'" class="btn">'.$slide_btn_text.'</a>
						</div>
					</div>';
			}
			?>
		</div>
		<div class="container">
			<div class="first__nav">
				<div class="first-button-prev"></div>
				<div class="first-pagination"></div>
				<div class="first-button-next"></div>
			</div>
		</div>
	</div>
</section>



<section class="products">
	<div class="container">
		<h2 class="products__title">
			Продукция
		</h2>
		<!-- <div class="products__wrapper"> -->

			<? wp_nav_menu(array(
				'theme_location'  => 'products-main',
				'menu_id'      => false,
				'container'       => 'div', 
				'container_class' => 'products__wrapper', 
				'menu_class'      => false,
				'items_wrap'      => '%3$s',
				'order' => 'ASC',      
				'walker' => new products_main()   
			)); ?>   

	</div>
</section>
<section class="popular-models">
	<div class="container">
		<h2 class="h1 popular-models__title">Популярные модели печей</h2>
		<div class="popular-models__nav">
			<div class="swiper-button-prev popular-models-prev "></div>
			<div class="popular-models-fraction ">
				<div class="popular-models__current">1</div>
				<div class="popular-models__sepparator"> / </div>
				<div class="popular-models__total"></div>
			</div>
			<div class="swiper-button-next popular-models-next"></div>
		</div>
	</div>
	<div class="popular">
		<div class="swiper popular-swiper">
			<div class="popular__wrapper swiper-wrapper">
				<?
					//ЭТО ВЫКЛЮЧИТЬ, КОГДА БУДУТ ПРОДАЖИ
					$products_hits = [
						'post_type' => 'product',
						'post_status' => 'publish',
						'posts_per_page' => 8
					];
					//НАЧАЛО ВЫВОДА ТОВАРЫ ПОПУЛЯРНЫЕ
					$query_hits = new WP_Query( $products_hits );
					// обрабатываем результат
					if ( $query_hits->have_posts() ) :
						while ( $query_hits->have_posts() ) {
							$query_hits->the_post();
							product_card();
						} //endwhile 
					wp_reset_postdata(); endif;  
				?>
			</div>
		</div>
	</div>
	<div class="swiper-pagination popular-models-bullet"></div>
</section>
<section class="working-us">
	<div class="container">
		<h2 class="h1 working-us__title">Особенности работы с нами</h2>
		<div class="working-us__items">
			<div class="working-us__item">
				<h3 class="working-us__item_title">Индивидуальная консультация</h3>
				<p class="working-us__item_text">Подкрепляем свою компетентность документально. Гарантия на
					продукцию и монтажные работы до 2 лет
				</p>
			</div>
			<div class="working-us__item">
				<h3 class="working-us__item_title">Проектирование и расчёт</h3>
				<p class="working-us__item_text">Подготовим проект с расчётами, согласуем детали и точную
					стоимость
					оборудования</p>
			</div>
			<div class="working-us__item">
				<h3 class="working-us__item_title">Гарантийные качества</h3>
				<p class="working-us__item_text">Подкрепляем свою компетентность документально. Гарантия на
					продукцию и монтажные работы до 2 лет
				</p>
			</div>
			<div class="working-us__item">
				<h3 class="working-us__item_title">Выезд на объект</h3>
				<p class="working-us__item_text">Анализируем места установки, подбираем оптимальный способ
					монтажа
				</p>
			</div>
			<div class="working-us__item">
				<h3 class="working-us__item_title">Доставка и монтаж</h3>
				<p class="working-us__item_text">Доставим оборудование выполнив монтажные работы согласно
					требованиям проекта</p>
			</div>
			<div class="working-us__item">
				<h3 class="working-us__item_title">Обслуживание</h3>
				<p class="working-us__item_text">Подкрепляем свою компетентность документально. Гарантия на
					продукцию и монтажные работы до 2 лет
				</p>
			</div>
		</div>
	</div>
</section>
<?portfolio_block();?>
<? get_footer();?>