<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package weblitex
 */

?>


<!doctype html>
<html lang="ru">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<? wp_head(); ?>
</head>
<body>
<header>
	<div class="header">
		<div class="header__menu">
			<div class="container header__menu_wrapper">
				<!-- <a target="_blank" href="https://2gis.ru/yoshkarola/inside/9852259840041705/firm/70000001018398834?m=47.773098%2C56.636808%2F17.62" class="header__menu_address"> <span>Республика Марий Эл,&nbsp;</span> <span>пгт. Медведево, ул. Чехова, д. 16Б</span> </a> -->
				<?contacts_address('header');?>
                <? wp_nav_menu(array(
                    'theme_location'  => 'header-nav',
                    'menu_id'      => false,
                    'container'       => 'div', 
                    'container_class' => 'header__menu_nav menu test', 
                    'menu_class'      => false,
                    'items_wrap'      => '%3$s',
                    'order' => 'ASC',      
                    'walker' => new header_nav()   
			    )); ?>   
                
			</div>
		</div>
		<div class="header__body">
			<div class="container">
				<div class="header__body_wrapper">
				<a href="<?echo get_site_url();?>" class="header__logo">
						<img src="<? $custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' )); echo $custom_logo__url[0];  ?>" alt="pechnoy-centr-logo">
                        <span><?bloginfo('name');?></span>
                    </a>
					
					<div class="search-overlay"></div>
					<div class="search" id="search-js">
					
					<?aws_get_search_form(true);
					$relevant_array = get_field('relevant-search-array',27);
					$relevant_text = (array) explode( ', ', $relevant_array);
					$relevant_rand = array_rand($relevant_text);
					?>
						<div class="search__link" id="input-search-js">Например: <span><?echo $relevant_text[$relevant_rand];?></span></div>
					</div>
					<button class="btn-search">
						<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M26.8503 25.6413L22.2365 21.0275C23.1386 19.8689 23.6807 18.4187 23.6807 16.8403C23.6807 13.0687 20.6119 10 16.8403 10C13.0687 10 10 13.0687 10 16.8403C10 20.6119 13.0687 23.6807 16.8403 23.6807C18.4187 23.6807 19.8689 23.1386 21.0275 22.2374L25.6413 26.8512C25.808 27.017 26.0269 27.1008 26.2458 27.1008C26.4647 27.1008 26.6836 27.017 26.8503 26.8503C27.1846 26.516 27.1846 25.9756 26.8503 25.6413V25.6413ZM11.7101 16.8403C11.7101 14.011 14.011 11.7101 16.8403 11.7101C19.6697 11.7101 21.9706 14.011 21.9706 16.8403C21.9706 19.6697 19.6697 21.9706 16.8403 21.9706C14.011 21.9706 11.7101 19.6697 11.7101 16.8403Z" fill="#999999" fill-opacity="0.7" /> </svg>
					</button>
					<a href="<?echo get_permalink(313);?>" class="header__body_items header-tab">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M22.7564 6.62806C22.5943 6.39392 22.3656 6.21444 22.1002 6.11314C21.9264 6.03811 21.7392 5.99966 21.5501 6.00017L8.44997 6.00001C8.26091 5.99949 8.07376 6.03794 7.90007 6.11296C7.63466 6.21425 7.4059 6.39374 7.24378 6.62789C7.08346 6.8554 6.99821 7.12769 7.00003 7.40644V23.5935C6.99823 23.8723 7.08348 24.1446 7.24378 24.3722C7.40589 24.6064 7.63465 24.7859 7.90007 24.8871C8.07377 24.9621 8.26092 25.0005 8.44997 25C8.83618 25.0021 9.20814 24.8536 9.48751 24.5857L15.0001 19.2609L20.5126 24.5858C20.7938 24.8493 21.1655 24.9932 21.55 24.9873C21.7857 24.9906 22.0186 24.9363 22.2287 24.8291C22.4389 24.7219 22.62 24.565 22.7564 24.3719C22.9167 24.1445 23.0019 23.8722 23 23.5935V7.40662C23.0018 7.12789 22.9166 6.85559 22.7564 6.62806Z" fill="#C7C6C6" /> </svg>
						<div class="header__body_items-name">Закладки</div>
						<?
						if( empty( $_COOKIE[ 'pechnoj_centr12_likelist_product' ] ) ) {
							$like_products = array();
							echo '<span class="icon-count d-hide" id="likelist-count-js"></span>';
						} else {
							$like_products = (array) explode( '|', $_COOKIE[ 'pechnoj_centr12_likelist_product' ] );
							$count_likelist = count($like_products);
							echo '<span class="icon-count" id="likelist-count-js">' . $count_likelist . '</span>';
						}
						?>
					</a>
					<a href="<?echo wc_get_checkout_url();?>" class="header__body_items header-card">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M20.7522 21.8359C20.2414 21.8359 19.7421 21.9873 19.3174 22.271C18.8927 22.5548 18.5616 22.9581 18.3661 23.43C18.1706 23.9019 18.1194 24.4211 18.219 24.9221C18.3186 25.4231 18.5646 25.8833 18.9257 26.2445C19.2869 26.6057 19.747 26.8517 20.248 26.9514C20.749 27.051 21.2682 26.9999 21.7402 26.8045C22.2121 26.609 22.6154 26.278 22.8992 25.8533C23.183 25.4287 23.3345 24.9293 23.3345 24.4186C23.3345 24.0794 23.2678 23.7436 23.138 23.4303C23.0083 23.117 22.818 22.8323 22.5783 22.5924C22.3385 22.3526 22.0538 22.1624 21.7405 22.0326C21.4272 21.9028 21.0914 21.836 20.7522 21.8359Z" fill="#C7C6C6" />
							<path d="M28.1096 7.74815C28.0551 7.68108 27.986 7.62725 27.9077 7.59072C27.8293 7.55419 27.7437 7.5359 27.6572 7.53724H7.1402L6.77933 6.06918C6.62792 5.44711 6.27134 4.89419 5.76712 4.49964C5.26291 4.1051 4.64047 3.89194 4.00024 3.89456H2.59279C2.44064 3.89638 2.29535 3.95811 2.1884 4.06634C2.08146 4.17458 2.02148 4.32061 2.02148 4.47277C2.02148 4.62493 2.08146 4.77095 2.1884 4.87919C2.29535 4.98743 2.44064 5.04915 2.59279 5.05098H4.00024C4.38118 5.04797 4.75199 5.17366 5.05257 5.4077C5.35316 5.64174 5.56592 5.97042 5.65638 6.34048L8.46375 17.8051C8.61595 18.426 8.97316 18.9773 9.47759 19.3699C9.98202 19.7625 10.6042 19.9734 11.2433 19.9685H23.2519C23.8994 19.9737 24.5292 19.7572 25.0366 19.355C25.5441 18.9528 25.8986 18.3891 26.0414 17.7575L28.221 8.23054C28.2404 8.14697 28.2405 8.06005 28.2212 7.97643C28.2019 7.89282 28.1637 7.81473 28.1096 7.74815Z" fill="#C7C6C6" />
							<path d="M12.9312 21.8359C12.4204 21.8359 11.9211 21.9874 11.4964 22.2712C11.0717 22.5549 10.7407 22.9583 10.5452 23.4301C10.3498 23.902 10.2986 24.4213 10.3982 24.9223C10.4979 25.4232 10.7438 25.8834 11.105 26.2446C11.4662 26.6058 11.9263 26.8517 12.4273 26.9514C12.9282 27.051 13.4475 26.9999 13.9194 26.8045C14.3913 26.609 14.7947 26.278 15.0784 25.8533C15.3622 25.4286 15.5137 24.9293 15.5137 24.4186C15.5137 24.0794 15.447 23.7436 15.3172 23.4302C15.1874 23.1169 14.9972 22.8322 14.7574 22.5923C14.5176 22.3525 14.2329 22.1623 13.9195 22.0325C13.6062 21.9027 13.2704 21.8359 12.9312 21.8359Z" fill="#C7C6C6" /> </svg>
						<div class="header__body_items-name">Корзина</div>
					</a>
					<div class="header__contacts">
						<?contacts_phone();?>
						<span><?contacts_work_time();?></span>
					</div>
					<button class="burger">
						<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
							<rect x="3" y="8" width="25" height="1.8" rx="0.9" fill="#C7C6C6" />
							<rect x="3" y="14.5" width="25" height="1.8" rx="0.9" fill="#C7C6C6" />
							<rect x="3" y="21" width="25" height="1.8" rx="0.9" fill="#C7C6C6" /> </svg>
					</button>
				</div>
			</div>
		</div>
		<div class="header__nav">
			<div class="container">
                <? wp_nav_menu(array(
					'theme_location'  => 'header-main-menu-nav',
					'menu_id'      => false,
					'container'       => 'nav', 
					'container_class' => 'header__nav_wrapper nav', 
					'menu_class'      => false,
					'items_wrap'      => '%3$s',
					'order' => 'ASC',      
					'walker' => new header_main_menu_nav()   
				)); ?>   
			</div>
		</div>
	</div>
	<nav class="mobile-menu">
		<div class="mobile-menu__nav">
			<a href="<? echo get_site_url();?>" class="header__logo"><img src="<? $custom_logo__url = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' )); echo $custom_logo__url[0];  ?>" alt="pechnoy-centr-logo"><span><? bloginfo('name');?></span></a>
			<button class="btn-search">
				<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M26.8503 25.6413L22.2365 21.0275C23.1386 19.8689 23.6807 18.4187 23.6807 16.8403C23.6807 13.0687 20.6119 10 16.8403 10C13.0687 10 10 13.0687 10 16.8403C10 20.6119 13.0687 23.6807 16.8403 23.6807C18.4187 23.6807 19.8689 23.1386 21.0275 22.2374L25.6413 26.8512C25.808 27.017 26.0269 27.1008 26.2458 27.1008C26.4647 27.1008 26.6836 27.017 26.8503 26.8503C27.1846 26.516 27.1846 25.9756 26.8503 25.6413V25.6413ZM11.7101 16.8403C11.7101 14.011 14.011 11.7101 16.8403 11.7101C19.6697 11.7101 21.9706 14.011 21.9706 16.8403C21.9706 19.6697 19.6697 21.9706 16.8403 21.9706C14.011 21.9706 11.7101 19.6697 11.7101 16.8403Z" fill="#999999" fill-opacity="0.7" /></svg>
			</button>
			<button class="mobile-menu__close"></button>
		</div>
		<div class="header__menu">
			<div class="container header__menu_wrapper">
				<div class="header__menu_duty"><?contacts_work_time();?></div>
				<?contacts_address('header');?>
			</div>
		</div>
		<div class="header__nav">
			<div class="container">
				<nav class="header__nav_wrapper nav">

					<? wp_nav_menu(array(
						'theme_location'  => 'header-main-menu-nav',
						'menu_id'      => false,
						'container'       => false, 
						'container_class' => false, 
						'menu_class'      => false,
						'items_wrap'      => '%3$s',
						'order' => 'ASC',
						'show_carets' => true,
						'walker' => new header_main_menu_nav()   
					)); ?>
					<? wp_nav_menu(array(
						'theme_location'  => 'header-nav',
						'menu_id'      => false,
						'container'       => false, 
						'container_class' => false, 
						'menu_class'      => false,
						'items_wrap'      => '%3$s',
						'order' => 'ASC',
						'show_carets' => true, 
						'walker' => new header_nav()   
					)); ?>   
				</nav> 
					<!-- <div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Баня и сауна</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul>
									<li><a href="catalog.html">Дровяные</a></li>
								</ul>
								<ul>
									<li><a href="catalog.html">Электрические</a></li>
								</ul>
								<ul>
									<li><a href="catalog.html">Газовые и газодровяные</a></li>
								</ul>
								<ul>
									<li><span>По материалу</span></li>
									<li><a href="catalog.html">Чугунные</a></li>
									<li><a href="catalog.html">Стальные</a></li>
									<li><a href="catalog.html">Кирпичные</a></li>
								</ul>
								<ul>
									<li><a href="catalog.html">Аксессуары</a></li>
									<li><a href="catalog.html">Порталы</a></li>
									<li><a href="catalog.html">Печное литье</a></li>
									<li><a href="catalog.html">Камни</a></li>
									<li><a href="catalog.html">Баки</a></li>
									<li><a href="catalog.html">Теплообменники</a></li>
									<li><a href="catalog.html">Обливные устройства</a></li>
									<li><a href="catalog.html">Дымоходы </a></li>
								</ul>
							</div>
							<div class="nav__block">
								<ul>
									<li><span>По брендам</span></li>
									<li><a href="catalog.html">КДМ</a></li>
									<li><a href="catalog.html">Везувий</a></li>
									<li><a href="catalog.html">Grill'D</a></li>
									<li><a href="catalog.html">Инжкомцентр ВВД</a></li>
									<li><a href="catalog.html">Изистим</a></li>
									<li><a href="catalog.html">ПроМеталл</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Печи</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul>
									<li><a href="catalog.html">Дровянные печи</a></li>
									<li><a href="catalog.html">Отопительные</a></li>
									<li><a href="catalog.html">Печи-камины</a></li>
									<li><a href="catalog.html">Банные</a></li>
									<li><a href="catalog.html">Теплоемкие</a></li>
									<li><a href="catalog.html">Печи под казан</a></li>
									<li><a href="catalog.html">Костровые чаши</a></li>
								</ul>
								<ul>
									<li><span>По материалу</span></li>
									<li><a href="catalog.html">Чугунные</a></li>
									<li><a href="catalog.html">Стальные</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Котлы</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul>
									<li><a href="catalog.html">Твердотопливные</a></li>
									<li><a href="catalog.html">Пиролизные</a></li>
									<li><a href="catalog.html">Пеллетные</a></li>
									<li><a href="catalog.html">Длительного горения</a></li>
								</ul>
							</div>
							<div class="nav__block">
								<ul>
									<li><span>По брендам</span></li>
									<li><a href="catalog.html">Stropuva</a></li>
									<li><a href="catalog.html">Троян</a></li>
									<li><a href="catalog.html">Везувий</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Камины</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul>
									<li><a href="catalog.html">Дровяные камины</a></li>
									<li><a href="catalog.html">Печи-камины</a></li>
									<li><a href="catalog.html">Топки</a></li>
								</ul>
								<ul>
									<li><a href="catalog.html">Электрические камины</a></li>
								</ul>
								<ul>
									<li><a href="catalog.html">Аксессуары (каминные)</a></li>
									<li><a href="catalog.html">Облицовка</a></li>
									<li><a href="catalog.html">Решетки</a></li>
									<li><a href="catalog.html">Наборы</a></li>
									<li><a href="catalog.html">Дверцы</a></li>
									<li><a href="catalog.html">Экраны</a></li>
								</ul>
							</div>
							<div class="nav__block">
								<ul>
									<li><span>По брендам</span></li>
									<li><a href="catalog.html">Везувий</a></li>
									<li><a href="catalog.html">Мета</a></li>
									<li><a href="catalog.html">Kratki</a></li>
									<li><a href="catalog.html">Экокамин</a></li>
									<li><a href="catalog.html">Изистим</a></li>
									<li><a href="catalog.html">INVICTA</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Дымоходы</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul class="nav__block_all-text">
									<li><a href="catalog.html">Одноконтурные</a></li>
									<li><a href="catalog.html">Изолированные</a></li>
									<li><a href="catalog.html">Коаксиальные</a></li>
									<li><a href="catalog.html">С воздушным охлаждением</a></li>
									<li><a href="catalog.html">Комплектующие к дымоходам</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Печное литье</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul>
									<li><a href="catalog.html">Печные дверки</a></li>
									<li><a href="catalog.html">Топочные</a></li>
									<li><a href="catalog.html">Поддувальные</a></li>
									<li><a href="catalog.html">Прочистные</a></li>
								</ul>
								<ul class="nav__block_all-title">
									<li><a href="catalog.html">Задвижки</a></li>
									<li><a href="catalog.html">Заслонки</a></li>
									<li><a href="catalog.html">Решетки колосниковые</a></li>
									<li><a href="catalog.html">Решетки гриль</a></li>
									<li><a href="catalog.html">Печные плиты</a></li>
									<li><a href="catalog.html">Конфорки</a></li>
									<li><a href="catalog.html">Духовки</a></li>
									<li><a href="catalog.html">Казаны</a></li>
									<li><a href="catalog.html">Притопочный лист</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Вентиляция</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul class="nav__block_all-text">
									<li><a href="catalog.html">Одноконтурная</a></li>
									<li><a href="catalog.html">Изолированная</a></li>
									<li><a href="catalog.html">Пластиковая</a></li>
									<li><a href="catalog.html">Приточные клапана</a></li>
									<li><a href="catalog.html">Дефлектора и турбодефлектора</a></li>
									<li><a href="catalog.html">Искрагасители</a></li>
									<li><a href="catalog.html">Искрагасители</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Материалы</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul class="nav__block_all-text">
									<li><a href="catalog.html">Изоляция</a></li>
									<li><a href="catalog.html">Герметики</a></li>
									<li><a href="catalog.html">Мастики</a></li>
									<li><a href="catalog.html">Кладочные смеси</a></li>
									<li><a href="catalog.html">Пропитки</a></li>
									<li><a href="catalog.html">Лакокрасочные</a></li>
									<li><a href="catalog.html">Декоративная плитка</a></li>
									<li><a href="catalog.html">Химсредства</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Аксессуары</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul class="nav__block_all-text">
									<li><a href="catalog.html">Каминные наборы </a></li>
									<li><a href="catalog.html">Каминные дверцы </a></li>
									<li><a href="catalog.html">Решетки каминные </a></li>
									<li><a href="catalog.html">Решетки гриль </a></li>
									<li><a href="catalog.html">Казаны </a></li>
									<li><a href="catalog.html">Каминные экраны </a></li>
									<li><a href="catalog.html">Обливные устройства </a></li>
									<li><a href="catalog.html">Дровницы</a></li>
									<li><a href="catalog.html">Сетка для камней</a></li>
									<li><a href="catalog.html">Запарники</a></li>
									<li><a href="catalog.html">Совки</a></li>
									<li><a href="catalog.html">Кочерги</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <span class="arrow"></span> <a class="nav__title" href="catalog.html">Клиентам</a>
						<div class="nav__blocks">
							<div class="nav__block">
								<ul class="nav__block_all-text">
									<li><a href="page-about.html">О нас</a></li>
									<li><a href="page-fabricator.html">Производители</a></li>
									<li><a href="page-news-archive.html">Новости</a></li>
									<li><a href="page-paper-archive.html">Статьи</a></li>
									<li><a href="page-video-archive.html">Видео</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="nav__wrapper"> <a class="nav__title" href="page-work-archive.html">Наши работы</a> </div>
					<div class="nav__wrapper"> <a class="nav__title" href="page-mounting.html">Монтаж</a> </div>
					<div class="nav__wrapper"> <a class="nav__title" href="delivery-payment.html">Доставка и оплата</a> </div>
					<div class="nav__wrapper"> <a class="nav__title" href="catalog.html">Акции</a> </div>
					<div class="nav__wrapper"> <a class="nav__title" href="сontacts.html">Контакты</a> </div> -->



				<!-- </nav> -->
			</div>
		</div>
	</nav>
</header>
<main>

