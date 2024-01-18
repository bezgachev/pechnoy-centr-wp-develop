<?
//Скрытие меню навигации панели управления при просмотре сайта
// add_filter('show_admin_bar', '__return_false');
// function remove_admin_bar() {
// 	if (!current_user_can('administrator') && !is_admin()) {
// 		show_admin_bar(false);
// 	}
// }

//удаляем версию движка WP в конце файлов css/js
add_filter('style_loader_src', 'remove_cssjs_ver', 10,2);
//add_filter('script_loader_src', 'remove_cssjs_ver', 10,2);
function remove_cssjs_ver($src) {
	if(strpos($src,'?ver='))
		$src = remove_query_arg('ver', $src);
	return $src;
}

// Подключаем стили css в header
add_action( 'wp_enqueue_scripts', 'style_theme');
function style_theme() {
	wp_enqueue_style( 'utf', get_template_directory_uri() . '/assets/css/utf.css');
	$swiper = get_stylesheet_directory() . '/assets/css/swiper.min.css';
	wp_enqueue_style( 'swiper', get_stylesheet_directory_uri().'/assets/css/swiper.min.css?leave=1', null, filemtime($swiper));
	$main = get_stylesheet_directory() . '/assets/css/style.min.css';
	wp_enqueue_style( 'main', get_stylesheet_directory_uri().'/assets/css/style.min.css?leave=1', null, filemtime($main));

	$woocommerce = get_stylesheet_directory() . '/assets/css/woocommerce.css';
	wp_enqueue_style( 'woocommerce', get_stylesheet_directory_uri().'/assets/css/woocommerce.css?leave=1', null, filemtime($woocommerce) );
}

// Подключаем скрипты js footer
add_action( 'wp_enqueue_scripts', 'scripts_theme' );
function scripts_theme() {	
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri().'/assets/js/jquery-2.2.4.min.js', false, null, true );
	wp_enqueue_script( 'jquery' );
	$maskedinput = get_stylesheet_directory() . '/assets/js/maskedinput.js';
	wp_enqueue_script( 'maskinput', get_template_directory_uri().'/assets/js/maskedinput.js', array('jquery'), null, true);
	$swiper = get_stylesheet_directory() . '/assets/js/swiper.min.js';
	wp_enqueue_script( 'swiper', get_template_directory_uri().'/assets/js/swiper.min.js?leave=1', array('jquery'), filemtime($swiper), true);

	$main = get_stylesheet_directory() . '/assets/js/scripts.js';
	wp_enqueue_script( 'main', get_template_directory_uri().'/assets/js/scripts.js?leave=1', array('jquery'), filemtime($main), true);

	if ( is_product() || is_category(122)) {
		//wp_enqueue_script( 'youtube-widget-api', 'https://www.youtube.com/s/player/10df06bb/www-widgetapi.vflset/www-widgetapi.js', array('jquery'), null, true);
		wp_enqueue_script( 'youtube-player-api', 'https://www.youtube.com/player_api', array('jquery'), null, true);
		$video = get_stylesheet_directory() . '/assets/js/video.js';
		wp_enqueue_script( 'video', get_template_directory_uri().'/assets/js/video.js?leave=1', array('jquery'), filemtime($video), true);
	}


	if ( is_product() || is_page(14)) {
		wp_enqueue_script('map-api', get_template_directory_uri() . '/assets/js/ymaps-api.js', array('jquery'), null, true);
		//wp_enqueue_script('map-api', 'https://api-maps.yandex.ru/2.1/?lang=ru_RU', array('jquery'), null, true);
		//wp_enqueue_script('map', get_template_directory_uri() . '/assets/js/ymaps.js', array('jquery'), null, true);
		$map = get_stylesheet_directory() . '/assets/js/ymaps.js';
		wp_enqueue_script( 'map', get_template_directory_uri().'/assets/js/ymaps.js?leave=1', array('jquery'), filemtime($map), true);
	}	

	$quick_order = get_stylesheet_directory() . '/assets/js/quick_order.js';
	wp_enqueue_script( 'quick_order', get_template_directory_uri().'/assets/js/quick_order.js?leave=1', array('jquery'), filemtime($quick_order), true);

	// Задаем данные обьекта ajax
	wp_localize_script(
		'quick_order',
		'quick_order_object',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'quick_order-nonce' ),
		)
	);

	wp_enqueue_script( 'jquery-form' );
	$policy = get_stylesheet_directory() . '/assets/js/policy.js';
	wp_enqueue_script( 'policy', get_template_directory_uri().'/assets/js/policy.js?leave=1', array('jquery'), filemtime($policy), true);
	// Задаем данные обьекта ajax policy
	wp_localize_script(
		'policy',
		'policy_object',
		array(
			'url'   => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'policy-nonce' ),
		)
	);
}


// Регистрируем меню, виджеты, свои размеры для img
add_action( 'after_setup_theme', 'theme_register_nav_menu' );
function theme_register_nav_menu() {
	register_nav_menu( 'header-main-menu-nav', 'Главная навигация категорий, меню');
	register_nav_menu( 'products-main', 'Продукция на главной');
	register_nav_menu( 'products-about', 'Каталог продукции стр. О компании');
	register_nav_menu( 'header-nav', 'Навигация, шапка сайта');
	register_nav_menu( 'footer-nav', 'Навигация, подвал сайта');
	register_nav_menu( 'banya-i-sauna-nav', 'Навигация: Баня и сауна');

	register_nav_menu( 'drovyanye-pechi-nav', 'Навигация: Печи');
	register_nav_menu( 'kotly-nav', 'Навигация: Котлы');
	register_nav_menu( 'kaminy-nav', 'Навигация: Камины');
	register_nav_menu( 'dymohody-nav', 'Навигация: Дымоходы');
	register_nav_menu( 'pechnoe-lite-nav', 'Навигация: Печное литье');
	register_nav_menu( 'ventilyacziya-nav', 'Навигация: Вентиляция');
	register_nav_menu( 'materialy-dlya-teploizolyatsii-i-montazha-nav', 'Навигация: Материалы');
	register_nav_menu( 'aksessuary-nav', 'Навигация: Аксессуары');


		add_theme_support(
		'custom-logo',
		array(
			'width'       => 52,
			'height'      => 54,
			'flex-width'  => true,
			'flex-height' => true,
		));
		add_image_size( 'woo-thumbnail-product', 400, 400, true );
		add_image_size( 'woo-page-product', 800, 800, true );
		add_image_size( 'woo-large-size-product', 1200, 1080, true );
		add_image_size( 'woo-mini-catalog', 800, 800, true );
		add_theme_support( 'title-tag' );
}

//главное меню категорий в header
class header_main_menu_nav extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		$menu_class = $item->classes[0];
		if ($item->url && $item->url !== '') {
			if ( $depth === 0) {
				if ($menu_class === 'one-ul') {
					$output .= '<div class="nav__wrapper">';
					if ($args->show_carets) {
						$output .= '<span class="arrow"></span>';
					}
					$output .= '<a class="nav__title" href="' . $item->url . '">'. $item->title .'</a><div class="nav__blocks"><div class="nav__block"><ul class="nav__block_all-text">';
					// $output .= '<div class="nav__wrapper">';
					// $output .= '<a class="nav__title" href="' . $item->url . '">'. $item->title .'</a><div class="nav__blocks"><div class="nav__block"><ul class="nav__block_all-text">';
				}
				else {
					$output .= '<div class="nav__wrapper">';
					if ($args->show_carets) {
						$output .= '<span class="arrow"></span>';
					}
					$output .= '<a class="nav__title" href="' . $item->url . '">'. $item->title .'</a><div class="nav__blocks"><div class="nav__block">';
				}
			}
			else {
				if ($menu_class === 'ul') {
					$output .= '<ul><li><a href="' . $item->url . '">'. $item->title .'</a></li></ul>';
				}
				else if ($menu_class === 'accessories') {
					$output .= '<ul><li><a href="' . $item->url . '">'. $item->title .'</a></li>';
				}
				else if ($depth === 1) {
					if ($menu_class === 'no-ul') {
						$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
					}
					else {
						$output .= '<ul><li><a href="' . $item->url . '">'. $item->title .'</a></li>';
					}
				}
				else {
					$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
				}
			}
		}
		else {
			if ($menu_class === 'material') {
				$output .= '<ul>';
				$output .= '<li><span>'. $item->title .'</span></li>';
			}
			else if ($menu_class === 'brand') {
				$output .= '</ul></div>';
				$output .= '<div class="nav__block"><ul><li><span>'. $item->title .'</span></li>';
			}
			else if ( $depth === 1) {
				if ($menu_class === 'none') {
					$output .= '<ul class="nav__block_all-title">';
				}
			}
			else {
				$output .= '<ul>';
				$output .= '<li><span>'. $item->title .'</span></li>';
			}
		}
	}

	function start_lvl(&$output, $depth=0, $args=null) {}
	function end_lvl(&$output, $depth=0, $args=null) {}

	function end_el(&$output, $item, $depth=0, $args=null) { 
		$menu_class = $item->classes[0];
		if ($menu_class === 'material') {
			$output .= '</ul>';
		}
		if ($depth === 1) {
			if ($menu_class === 'no-ul') {
				$output .= '';
			}
			else {
				$output .= '</ul>';
			}
		}
		if ( $depth === 0) {
			$output .= '</div></div></div>';
		}
	}
}

// свой класс построения экрана продукции:
class products_main extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		$menu_class = $item->classes[0];
		if ($item->url && $item->url != '') {
			$output .= '';
		}
		if ($item->url && $item->url != '') {
			if ( $depth === 0) {
				$output .= '<div class="product '.$menu_class.'"><a href="' . $item->url . '" class="product__title">'. $item->title .'</a>';
			}
			else if ( $depth === 1) { 
				$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
			}
		}
	}
	function start_lvl(&$output, $depth=0, $args=null) {
		$output .= '<ul>';	
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '</ul>';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		if ( $depth === 0) {
			$output .= '</div>';
		}
		
	}
}

class header_nav extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		if ($item->url && $item->url != '') {
			if ( $depth === 0) {
			$output .= '<div class="nav__wrapper"><a href="' . $item->url . '" class="nav__title">'. $item->title .'</a>';
			}
			else if ( $depth === 1) {
				$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
			}
		}
		else {
			$output .= '<div class="nav__wrapper">';
			if ($args->show_carets) {
				$output .= '<span class="arrow"></span>';
			}
			$output .= '<span class="nav__title">'. $item->title .'</span>';
		}
	}
	function start_lvl(&$output, $depth=0, $args=null) {
		
		if ($args->show_carets) {
			$output .= '<div class="nav__blocks"><div class="nav__block"><ul class="nav__block_all-text">';
		}
		else {
			$output .= '<div class="nav__blocks"><div class="nav__block"><ul>';	
		}
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '</ul></div></div>';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		if ( $depth === 0) {
			$output .= '</div>';
		}
	}
}

// свой класс построения навигации в footer:
class footer_nav extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		if ($item->url && $item->url != '') {
			$output .= '';
		}
		if ($item->url && $item->url != '') {
			if ( $depth === 0) {
				$output .= '';
			}
			else if ( $depth === 1) { 
				$output .= '<li><a href="' . $item->url . '">'. $item->title .'</a></li>';
			}
		}
		else {
				$output .= '<div class="footer__akkardion">'. $item->title .'<ul>';
		}
	}
	function start_lvl(&$output, $depth=0, $args=null) {
		$output .= '';	
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		if ( $depth === 0) {
			$output .= '</ul></div>';
		}
	}
}

// каталог продукции на стр.О нас
class products_about extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		$menu_class = $item->classes[0];
		if ($item->url && $item->url != '') {
			$output .= '<a href="'.$item->url.'" class="about-page__product">
			<div class="about-page__product_img '.$menu_class.'"></div>
			<div class="about-page__product_title">'.$item->title.'</div>';
		}
	}
	function start_lvl(&$output, $depth=0, $args=null) {
		$output .= '';	
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		$output .= '</a>';
	}
}

// Регистрируем кастомайзер. Проивольные стандартные поля WP для основной информации на сайте. Находится это в Админка -> Внешний Вид -> Настроить -> Основная контактная информация
add_action( 'customize_register', 'customize_weblitex' );
function customize_weblitex( $wp_customize ) {

	//Почта
	$wp_customize->add_section(
		// ID
		'mail_custom',
		// Arguments array
		array(
			'title' => 'Настройки Почты',
			'capability' => 'edit_theme_options',
			'priority'  => 100,
			'description' => "Здесь Вы можете настроить SMTP сервер-обработчик почты.<br><br>Внимание! Если нужно изменить Административный E-mail для WordPress (Настройки - Общие - Административный E-mail), то временно отключите SMTP-сервер.<br><br>При смене Административной почты, необходимо продублировать её также в настройках: WooCommerce - Настройки - Email'ы - Адрес отправителя.<br><br>Если вдруг почта не отправляется, сверьте свои настройки для исходящей почты: <a href='https://yandex.ru/support/mail/mail-clients/others.html' target='_blank'>Яндекс </a>, <a href='https://developers.google.com/gmail/imap/imap-smtp' target='_blank'>Google</a>, <a href='https://help.mail.ru/mail/mailer/popsmtp' target='_blank'>Mail.ru</a> или перезапустите SMTP-сервер, если настройки верны.",
		)
	);

	$wp_customize->add_setting('enabled_mail_smtp', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'enabled_mail_smtp_control', array(
			'type'      => 'checkbox',
			'section' => 'mail_custom',
			'label'     => __('Запустить SMTP-сервер'),
			'settings'  => 'enabled_mail_smtp',		
		)
	);

	//email почты
	$wp_customize->add_setting(
		'mail_custom_SMTP_USER', array(
			'default' => '', 
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_USER_control', array(
			'type' => 'hidden',
			'section' => 'mail_custom',
			'label' => 'Сервер-обработчик: ' . get_option('admin_email'),
			'description' => "Для обработки писем используется Ваш Административный E-mail<br><br>",
			'settings' => 'mail_custom_SMTP_USER'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_PASS', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_PASS_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Пароль приложения',
			'description' => "Пароль приложения сервера почты. Пароль генерируется в аккаунте Вашей почты в настройках безопасности. Обычный пароль для входа не подойдёт, не рекомендуется в целях безопасности",
			'settings' => 'mail_custom_SMTP_PASS'
		)
	);
	
	$wp_customize->add_setting(
		'mail_custom_SMTP_HOST', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_HOST_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Хост почтового сервера',
			'description' => "Яндекс — smtp.yandex.ru, Google — smtp.gmail.com, Mail.ru — ssl://smtp.mail.ru. Скопируйте и вставьте значения, в соответствии с тем, какой сервис почты Вы используете.<br><br>Если письма не отправляются, добавьте приставку ssl://<br>Пример: ssl://smtp.yandex.ru",
			'settings' => 'mail_custom_SMTP_HOST'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_PORT', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_PORT_control', array(
			'type' => 'text',
			'section' => 'mail_custom',
			'label' => 'Порт почтового сервера',
			'description' => "Яндекс — 465, Google — 465, либо 587, Mail.ru — 465",
			'settings' => 'mail_custom_SMTP_PORT'
		)
	);

	$wp_customize->add_setting(
		'mail_custom_SMTP_SECURE', array(
			'default' => '',
			'type' => 'option',
		)
	);
	$wp_customize->add_control(
		'mail_custom_SMTP_SECURE_control', array(
			'type' => 'select',
			'section' => 'mail_custom',
			'label' => 'Метод защиты соединения, передачи данных',
			'description' => "Яндекс — SSL, Google — TLS, Mail.ru — SSL или TLS",
			'settings' => 'mail_custom_SMTP_SECURE',
			'choices' => array(
				'SSL' => 'SSL',
				'TLS' => 'TLS',
			),
		)
	);

	//Режим обслуживания
	$wp_customize->add_section(
		// ID
		'maintenance_mode',
		// Arguments array
		array(
			'title' => 'Техническое обслуживание',
			'capability' => 'edit_theme_options',
			'priority'  => 200,
			'description' => "Здесь Вы можете перевести свой сайт в режим технического обслуживания.<br><br>Эта возможность даёт программистам проводить технические работы, когда необходимо временно закрыть доступ к сайту для пользователей Вашего сайта и вывести пользователям об этом уведомление.<br><br>Для авторизованного администратора доступ к сайту доступен.",
		)
	);

	$wp_customize->add_setting('enabled_maintenance_mode', array(
		'default'    => 'true',
		'capability' => 'edit_theme_options',
		'type' => 'option',
	));
	$wp_customize->add_control(
		'enabled_maintenance_mode_control', array(
			'type'      => 'checkbox',
			'section' => 'maintenance_mode',
			'label'     => __('Включить режим обслуживания'),
			'settings'  => 'enabled_maintenance_mode',		
		)
	);

}

// Режим технического обслуживания
$enabled_maintenance_mode = get_option('enabled_maintenance_mode');
if ($enabled_maintenance_mode === '1') {
	add_action('get_header', 'wp_maintenance_mode_on');
	function wp_maintenance_mode_on(){
		if(!current_user_can('administrator')){
			$current_url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$url = ''.get_site_url().'/';
			if ($current_url === $url.'?mode=maintenance') {
				require(WP_CONTENT_DIR. '/maintenance.php');
			exit();
			}
			else if ($current_url !== $url) {
				wp_redirect($url);
			exit();
			}
			else {
				$newval = 'maintenance';
				if(!count($_GET) ) {
				header('Location: ?mode=' . $newval);
				}
				if(!isset($_GET['mode'])) {
					$current_url .= '&mode='.$newval;
				}
				$_GET['mode'] = $newval;
				require(WP_CONTENT_DIR. '/maintenance.php');
			exit();
			}
		}
	}
	add_action('wp_dashboard_setup', 'maintenance_mode_widgets');
	function maintenance_mode_widgets() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget('maintenance_mode_widget', 'Режим обслуживания включён', 'custom_dashboard_maintenance_mode_widgets');
	}
	function custom_dashboard_maintenance_mode_widgets() {
		echo '<span style="color:red;font-size:14px;font-weight:500;">Внимание!</span><p style="margin-top:5px;">На Вашем сайте включён режим технического обслуживания. Это означает, что <b>пользователям не доступен Ваш сайт</b>.</p><p><a href="/wp-admin/customize.php">Чтобы отключить</a>:<br>Внешний вид - Настроить - Техническое обслуживание</p>';
	}
}
else {
	add_action('get_header', 'wp_maintenance_mode_off');
	function wp_maintenance_mode_off(){
		$current_url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url = ''.get_site_url().'/';
		if ($current_url === $url.'?mode=maintenance') {
			wp_redirect($url);
		}
	}
}

//СОГЛАШЕНИЕ COOKIE
add_action( 'wp_ajax_policy_action', 'ajax_action_policy' );
add_action( 'wp_ajax_nopriv_policy_action', 'ajax_action_policy' );
function ajax_action_policy() {
	if ( ! wp_verify_nonce( $_POST['nonce'], 'policy-nonce' ) ) {
		echo json_encode(array('message'=>__('POLICY-ERROR')));
		wp_die();
	}
	if ( $_POST['feedback'] === 'accept-policy') {
		echo json_encode(array('message'=>__('POLICY-OK')));

		if ( empty( $_COOKIE[ 'pcy_woo_policy' ] ) ) {
			$policy = 'true';
		} else {
			$policy = $_COOKIE[ 'pcy_woo_policy' ];
		}
		wc_setcookie( 'pcy_woo_policy', $policy, time() + (3600 * 24 * 30) );

	}
	else {
		echo json_encode(array('message'=>__('POLICY-ERROR')));
	}
	wp_die();
}

//ОТПРАВКА ПОЧТЫ
add_action( 'wp_ajax_quick_order_action', 'ajax_action_quick_order' );
add_action( 'wp_ajax_nopriv_quick_order_action', 'ajax_action_quick_order' );
function ajax_action_quick_order() {
	$clean_str_phone = mb_eregi_replace('[^0-9]', '', $_POST['form-phone']);
	// Массив ошибок
	$err_message = array();
	if (!wp_verify_nonce( $_POST['nonce'], 'quick_order-nonce')) {
		echo json_encode(array('message'=>__('SEND-ERROR')));
		die();
	}
	if ($_POST['feedback'] == 'quick-order') {
		if ($_POST['form-checkbox'] !== '1') {
			$err_message['checkbox'] = '';
		}
		if (empty($_POST['form-name']) || !isset($_POST['form-name'])) {
			$err_message['name'] = '';
		} else {
			$name = sanitize_text_field( $_POST['form-name'] );
		}
		if (empty($_POST['form-phone']) || !isset($_POST['form-phone'])) {
			$err_message['phone'] = '';
		} elseif (mb_strlen($clean_str_phone) !== 11 ) {
			$err_message['phone'] = '';
		} else {
			$phone = sanitize_text_field($_POST['form-phone']);
		}
	}
	else {
		echo json_encode(array('message'=>__('SEND-ERROR')));
		die();
	}
	if ( $err_message ) {
		wp_send_json_error( $err_message );
	} else {

		$email_to = get_option('admin_email');
		$company_name = get_bloginfo('name');
		$feedback_type = 'Поступил заказ в 1 клик';
		$art_subject = ''.$feedback_type.' | ' . $company_name .'';
		$website_addr = get_site_url();
		$product_id = sanitize_text_field($_POST['product-id']);
		$product = wc_get_product($product_id);

		$product_quantity = sanitize_text_field($_POST['product-quantity']);
		$product_price = sanitize_text_field($_POST['product-price']);
		$product_price_space = number_format((int)$product_price, 0, '', ' ');

		$product_price_total = $product_price * $product_quantity;
		$product_price_total_space = number_format((int)$product_price_total, 0, '', ' ');
		
		$product_name = $product->name;
		$url = $product->get_permalink();

		if ($product_quantity > 1) {
			$product_info = '<br><br>Цена: ' . $product_price_space . '&nbsp;₽<br>Кол-во: '.$product_quantity.'<br><br>Итого: '.$product_price_total_space.'&nbsp;₽';
		}
		else {
			$product_info = '<br><br>Цена: ' . $product_price_space . '&nbsp;₽<br>Кол-во: 1';
		}


		$message = '
			' . $feedback_type . ' с сайта <a href="' . $website_addr . '">' . $company_name . '</a>.<br><br>
			<table>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Имя:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $name . '</td>
				</tr>
					<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Тел.:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;">' . $phone . '</td>
				</tr>
				</tr>
				<tr style="background-color: #f8f8f8;">
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><b>Товар:</b></td>
					<td style="padding: 10px; border: #e9e9e9 1px solid;"><a href="'.$url.'">' . $product_name . '</a>'.$product_info.'</td>
				</tr>				
			</table>
		';

		$body = $message;
		$headers = 'From: ' . $company_name . ' <' . $email_to . '>' . "\r\n" . 'Reply-To: ' . $email_to;

		// Отправляем письмо
		$sent_message = wp_mail($email_to, $art_subject, $body, $headers );
  
		if ($sent_message) {

			$cart = WC()->instance()->cart;
			$cart_id = $cart->generate_cart_id($product_id);
			$cart_item_id = $cart->find_product_in_cart($cart_id);
			if($cart_item_id){
				$cart->set_quantity($cart_item_id, 0);
				echo json_encode(array('message'=>__('SEND-OK'), 'cart_item'=>__('REMOVE-OK')));
			}
			else {
				echo json_encode(array('message'=>__('SEND-OK')));
			}

			
		} else {
			echo json_encode(array('message'=>__('SEND-ERROR')));
		}
	}

	die();

}

$enabled_mail_smtp = get_option('enabled_mail_smtp');
if ($enabled_mail_smtp == '1') {
	add_action( 'phpmailer_init', 'my_phpmailer_example' );
	function my_phpmailer_example( $phpmailer ) {
		$phpmailer->isSMTP();
		$phpmailer->Host = get_option('mail_custom_SMTP_HOST');
		$phpmailer->SMTPAuth = true;
		$phpmailer->Port = get_option('mail_custom_SMTP_PORT');
		$phpmailer->Username = get_option('admin_email');
		$phpmailer->Password = get_option('mail_custom_SMTP_PASS');
		$phpmailer->SMTPSecure = get_option('mail_custom_SMTP_SECURE');
	}
}

add_filter( 'wp_mail_content_type', 'true_content_type' );
function true_content_type( $content_type ) {
	return 'text/html';
}

// Добавляем в DOM дереве в тег id.main-js атрибут data-dir путь сайта директории темы для использования в JS в дальнейшем
add_filter( 'script_loader_tag', 'dataUrlDirectory', 10, 2 );
function dataUrlDirectory( $tag, $handle ) {
    if ( 'main' !== $handle ) {
        return $tag;
    }
	$dataUrlDirectory = get_template_directory_uri();
    return str_replace( 'id', 'data-dir="'.$dataUrlDirectory.'"id', $tag );
}

// -------------------------- НАЧАЛО WOOCOMMERCE --------------------------

//отключение абсолютно все стили WooCommerce (не удаляет в админке стили woo)
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

//Когда активирован плагин WooCommerce подключаем стили WooCommerce + Поддержка для WooCommerce. ЭТО ОБЯЗАТЕЛЬНО
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	function mytheme_add_woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	add_action( 'after_setup_theme', 'mytheme_add_woocommerce_support' );
}

//Вызывается функция action add_product из JS по клику на .add-cart-js для добавления динамически товара в корзину
add_action('wp_ajax_add_product', 'add_product_cart');
add_action('wp_ajax_nopriv_add_product', 'add_product_cart');
function add_product_cart() {
	$product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
	$cart = WC()->instance()->cart;
	$cart_id = $cart->generate_cart_id($product_id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);
	if (!$cart_item_id) {
		WC()->cart->add_to_cart($product_id, $quantity);
		$cart_quantity = WC()->cart->get_cart();
		$cart_item_check_id = $cart->find_product_in_cart($cart_id);
		$cart_item_count = $cart_quantity[$cart_item_check_id]['quantity'];
		if ($cart_item_count === '1') {
			echo json_encode(array('add_cart_mess'=>__('ADD-OK')));
		}
		else {
			echo json_encode(array('add_cart_mess'=>__('ADD-ERROR')));
		}				
	}
	else {
		echo json_encode(array('add_cart_mess'=>__('ITEM-CART-HAVE')));
	}
die();
}

add_action('wp_ajax_change_item_from_cart', 'remove_product_cart');
add_action('wp_ajax_nopriv_change_item_from_cart', 'remove_product_cart');
function remove_product_cart() {
    $cart = WC()->instance()->cart;
    $product_id = $_POST['product_id'];
	$quantity = $_POST['quantity'];
    $cart_id = $cart->generate_cart_id($product_id);
    $cart_item_id = $cart->find_product_in_cart($cart_id);
	$cart_option = $_POST['option'];
    if($cart_item_id){
		if ($cart_option === 'one') {
			$cart->set_quantity($cart_item_id, 0);
			$cart_quantity = WC()->cart->get_cart();
			$cart_item_check_id = $cart->find_product_in_cart($cart_id);
			$cart_item_count = $cart_quantity[$cart_item_check_id]['quantity'];
			if (!$cart_item_count) {
				echo json_encode(array('add_cart_mess'=>__('REMOVE-OK')));
			}
			else {
				echo json_encode(array('add_cart_mess'=>__('REMOVE-ERROR')));
			}			
		}
		else if ($cart_option === 'set') {
			$cart->set_quantity($cart_item_id, $quantity);
			$cart_quantity = WC()->cart->get_cart();
			$cart_item_check_id = $cart->find_product_in_cart($cart_id);
			$cart_item_count = $cart_quantity[$cart_item_check_id]['quantity'];
			$cart_item_count_int = (int)$cart_item_count;
			if ($cart_item_count === $quantity) {
				echo json_encode(array('add_cart_mess'=>__('CHANGE-OK'), 'change_ok_count'=>__($cart_item_count_int)));
			}
			else {
				echo json_encode(array('add_cart_mess'=>__('CHANGE-ERROR'), 'change_error_count'=>__($cart_item_count_int)));
			}
			
		}
		//return true;
    } 
	die();
    //return false;
    }

//Динамически обновляем кол-во товаров и сумму корзины в header
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_reset_basket_header');
function woo_reset_basket_header($fragments){
    ob_start(); 
	$cart_count = WC()->cart->get_cart_contents_count();
	if (empty($_COOKIE['pechnoj_centr12_cart_count'])) {
		$basket_count = array();
	} else {
		$basket_count = $_COOKIE['pechnoj_centr12_cart_count'];
	}
	$basket_count = $cart_count;
	wc_setcookie('pechnoj_centr12_cart_count', $basket_count, time() + (3600 * 24 * 7));
		if (!empty($cart_count)){
			?>
				<a href="<?echo wc_get_checkout_url();?>" class="header__body_items header-card">
					<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M20.7522 21.8359C20.2414 21.8359 19.7421 21.9873 19.3174 22.271C18.8927 22.5548 18.5616 22.9581 18.3661 23.43C18.1706 23.9019 18.1194 24.4211 18.219 24.9221C18.3186 25.4231 18.5646 25.8833 18.9257 26.2445C19.2869 26.6057 19.747 26.8517 20.248 26.9514C20.749 27.051 21.2682 26.9999 21.7402 26.8045C22.2121 26.609 22.6154 26.278 22.8992 25.8533C23.183 25.4287 23.3345 24.9293 23.3345 24.4186C23.3345 24.0794 23.2678 23.7436 23.138 23.4303C23.0083 23.117 22.818 22.8323 22.5783 22.5924C22.3385 22.3526 22.0538 22.1624 21.7405 22.0326C21.4272 21.9028 21.0914 21.836 20.7522 21.8359Z" fill="#C7C6C6" />
						<path d="M28.1096 7.74815C28.0551 7.68108 27.986 7.62725 27.9077 7.59072C27.8293 7.55419 27.7437 7.5359 27.6572 7.53724H7.1402L6.77933 6.06918C6.62792 5.44711 6.27134 4.89419 5.76712 4.49964C5.26291 4.1051 4.64047 3.89194 4.00024 3.89456H2.59279C2.44064 3.89638 2.29535 3.95811 2.1884 4.06634C2.08146 4.17458 2.02148 4.32061 2.02148 4.47277C2.02148 4.62493 2.08146 4.77095 2.1884 4.87919C2.29535 4.98743 2.44064 5.04915 2.59279 5.05098H4.00024C4.38118 5.04797 4.75199 5.17366 5.05257 5.4077C5.35316 5.64174 5.56592 5.97042 5.65638 6.34048L8.46375 17.8051C8.61595 18.426 8.97316 18.9773 9.47759 19.3699C9.98202 19.7625 10.6042 19.9734 11.2433 19.9685H23.2519C23.8994 19.9737 24.5292 19.7572 25.0366 19.355C25.5441 18.9528 25.8986 18.3891 26.0414 17.7575L28.221 8.23054C28.2404 8.14697 28.2405 8.06005 28.2212 7.97643C28.2019 7.89282 28.1637 7.81473 28.1096 7.74815Z" fill="#C7C6C6" />
						<path d="M12.9312 21.8359C12.4204 21.8359 11.9211 21.9874 11.4964 22.2712C11.0717 22.5549 10.7407 22.9583 10.5452 23.4301C10.3498 23.902 10.2986 24.4213 10.3982 24.9223C10.4979 25.4232 10.7438 25.8834 11.105 26.2446C11.4662 26.6058 11.9263 26.8517 12.4273 26.9514C12.9282 27.051 13.4475 26.9999 13.9194 26.8045C14.3913 26.609 14.7947 26.278 15.0784 25.8533C15.3622 25.4286 15.5137 24.9293 15.5137 24.4186C15.5137 24.0794 15.447 23.7436 15.3172 23.4302C15.1874 23.1169 14.9972 22.8322 14.7574 22.5923C14.5176 22.3525 14.2329 22.1623 13.9195 22.0325C13.6062 21.9027 13.2704 21.8359 12.9312 21.8359Z" fill="#C7C6C6" /> </svg>
					<div class="header__body_items-name">Корзина</div>
					<span class="icon-count"><?echo $cart_count;?></span>
				</a>
			<?
		}
		else { ?>
			<a href="<?echo wc_get_checkout_url();?>" class="header__body_items header-card">
				<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M20.7522 21.8359C20.2414 21.8359 19.7421 21.9873 19.3174 22.271C18.8927 22.5548 18.5616 22.9581 18.3661 23.43C18.1706 23.9019 18.1194 24.4211 18.219 24.9221C18.3186 25.4231 18.5646 25.8833 18.9257 26.2445C19.2869 26.6057 19.747 26.8517 20.248 26.9514C20.749 27.051 21.2682 26.9999 21.7402 26.8045C22.2121 26.609 22.6154 26.278 22.8992 25.8533C23.183 25.4287 23.3345 24.9293 23.3345 24.4186C23.3345 24.0794 23.2678 23.7436 23.138 23.4303C23.0083 23.117 22.818 22.8323 22.5783 22.5924C22.3385 22.3526 22.0538 22.1624 21.7405 22.0326C21.4272 21.9028 21.0914 21.836 20.7522 21.8359Z" fill="#C7C6C6" />
					<path d="M28.1096 7.74815C28.0551 7.68108 27.986 7.62725 27.9077 7.59072C27.8293 7.55419 27.7437 7.5359 27.6572 7.53724H7.1402L6.77933 6.06918C6.62792 5.44711 6.27134 4.89419 5.76712 4.49964C5.26291 4.1051 4.64047 3.89194 4.00024 3.89456H2.59279C2.44064 3.89638 2.29535 3.95811 2.1884 4.06634C2.08146 4.17458 2.02148 4.32061 2.02148 4.47277C2.02148 4.62493 2.08146 4.77095 2.1884 4.87919C2.29535 4.98743 2.44064 5.04915 2.59279 5.05098H4.00024C4.38118 5.04797 4.75199 5.17366 5.05257 5.4077C5.35316 5.64174 5.56592 5.97042 5.65638 6.34048L8.46375 17.8051C8.61595 18.426 8.97316 18.9773 9.47759 19.3699C9.98202 19.7625 10.6042 19.9734 11.2433 19.9685H23.2519C23.8994 19.9737 24.5292 19.7572 25.0366 19.355C25.5441 18.9528 25.8986 18.3891 26.0414 17.7575L28.221 8.23054C28.2404 8.14697 28.2405 8.06005 28.2212 7.97643C28.2019 7.89282 28.1637 7.81473 28.1096 7.74815Z" fill="#C7C6C6" />
					<path d="M12.9312 21.8359C12.4204 21.8359 11.9211 21.9874 11.4964 22.2712C11.0717 22.5549 10.7407 22.9583 10.5452 23.4301C10.3498 23.902 10.2986 24.4213 10.3982 24.9223C10.4979 25.4232 10.7438 25.8834 11.105 26.2446C11.4662 26.6058 11.9263 26.8517 12.4273 26.9514C12.9282 27.051 13.4475 26.9999 13.9194 26.8045C14.3913 26.609 14.7947 26.278 15.0784 25.8533C15.3622 25.4286 15.5137 24.9293 15.5137 24.4186C15.5137 24.0794 15.447 23.7436 15.3172 23.4302C15.1874 23.1169 14.9972 22.8322 14.7574 22.5923C14.5176 22.3525 14.2329 22.1623 13.9195 22.0325C13.6062 21.9027 13.2704 21.8359 12.9312 21.8359Z" fill="#C7C6C6" /> </svg>
				<div class="header__body_items-name">Корзина</div>
			</a>
		<? }
        $fragments['.header__body_items.header-card'] = ob_get_clean();
    return $fragments;
}

// -------------------------- НАЧАЛО КАТАЛОГА --------------------------

// навигация по категориям в хлебных крошках
class category_nav extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth=0, $args=[], $id=0) {
		if ($item->url && $item->url != '') {
			$thumbnail_icon_id = get_term_meta($item->object_id, 'thumbnail_id', true);
			$thumbnail_icon_url = wp_get_attachment_image_url( $thumbnail_icon_id, '', true);
			$output .= '<a href="'.$item->url.'" class="category"><img src="'.$thumbnail_icon_url.'" alt="'. $item->title .'"><h3>'. $item->title .'</h3>';
		}
	}
	function start_lvl(&$output, $depth=0, $args=null) {
		$output .= '';	
	}
	function end_lvl(&$output, $depth=0, $args=null) {
		$output .= '';
	}
	function end_el(&$output, $item, $depth=0, $args=null) { 
		$output .= '</a>';
	}
}

remove_action('woocommerce_before_shop_loop','woocommerce_output_all_notices',10);
//remove_action('woocommerce_before_shop_loop','woocommerce_result_count',20);
remove_action('woocommerce_before_shop_loop','woocommerce_catalog_ordering',30);

remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
add_action( 'woocommerce_before_main_content', 'container_before_layout', 25 );

function container_before_layout() {
			if (!is_product() ) {
					$term = get_queried_object();
					$cat_slug = $term->slug;
					$cat_id = $term->term_id;
					//echo 'Категория '.$cat_slug.', id: '.$cat_id.'<br><br>';
					if (in_array($cat_id, array(15,16,17,18,20,21,22,23))) {
						
						?>
						<section class="categories">
							<div class="container slider-container" data-mobile="false">
								<?
								wp_nav_menu(array(
									'theme_location'  => ''.$cat_slug.'-nav',
									'menu_id'      => false,
									'container'       => 'div', 
									'container_class' => 'categories__wrapper swiper-wrapper', 
									'menu_class'      => false,
									'items_wrap'      => '%3$s',
									'order' => 'ASC',      
									'walker' => new category_nav()   
								)); 

								?>
							</div>
							<div class="swiper-scrollbar"><span class="category__btn"></span></div>
						</section>
						<?
					}

					?>

<section class="layout">
	<div class="container">

	<?

		if ( is_plugin_active( 'woocommerce/woocommerce.php' ) && is_plugin_active( 'woocommerce-products-filter/index.php' )) {
			//$term = get_queried_object(); $slug = $term->slug;
			if( is_product_category() ) {
				$term = get_queried_object();
				$term_current = $term->term_id;
				$parent_cat_id = $term->parent;
				$tax_name = 'product_cat';
				$term_childs = get_term_children( $term_current, $tax_name );
				foreach ( $term_childs as $child ) {
					$term = get_term_by( 'id', $child, $tax_name );
					if (!next($term_childs)) {
						$term_cat = $term->term_id;
					}
					else {
						$term_cat = ''.$term->term_id.',';
					}
					$term_cat_array .= $term_cat;
				}
				
				$term_cat_echo;
				if (($parent_cat_id !== 0) || (!empty($parent_cat_id) && ($parent_cat_id !== 0))) {
					$term_cat_echo .= $parent_cat_id.',';
				}
				if (!empty($term_cat_array)) {
					$term_cat_echo .= $term_cat_array.',';
				}
				if (!empty($term_current)) {
					$term_cat_echo .= $term_current;
				}

				?>
				
				<nav class="layout__sidebar sidebar" data-cats-id="<?echo $term_cat_echo;?>">
					<?
			} else { ?><nav class="layout__sidebar sidebar"><?
			} 
			?>
					<div class="sidebar__mob">Фильтры
						<button class="reset_filter">Сбросить</button>
						<button class="sidebar__mob_close"></button>
					</div>
					<?echo do_shortcode('[woof]');?>
					<div class="apply_filter"><div class="btn">Применить</div></div>
				</nav>
		<?		
		}
		?>
		<div class="layout__body">
			<!-- <button class="sidebar__mob_close2">Отменить выбор</button>&emsp;
			<button class="apply_filter2">Сохранить</button>&emsp;
			<button class="reset_filter2">Очистить всё</button> -->

			<div class="layout__body_descr">
				<? if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1><? woocommerce_page_title(); ?></h1>
				<? endif; ?>
				<button class="btn-filter"></button>
				
				<? if ( apply_filters( 'woocommerce_catalog_ordering', true ) ) : ?>
					<? woocommerce_catalog_ordering(); ?>
					
				<? endif; ?>
			</div>
<?
}
}

//Создаем фильтрацию сортировки для акций
add_filter( 'woocommerce_get_catalog_ordering_args', 'woo_catalog_ordering_sale' );
function woo_catalog_ordering_sale( $args ) {
	$orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if ( 'sale' == $orderby_value ) {
		$args = [
			'orderby'  => 'meta_value_num',
			'meta_key' => '_sale_price',
			'order'    => 'ASC',
		];
	}
	return $args;
}

//Добавляем возможность фильтрации new, sale интеграцию в woof filter
add_filter('woof_order_catalog', function($args){
    $orderby_value = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
	if ( 'sale' == $orderby_value ) {
		$args = [
			'orderby'  => 'meta_value_num',
			'meta_key' => '_sale_price',
			'order'    => 'ASC',
		];
	}
    if ('price' == $orderby_value) {
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'ASC';
        $args['meta_key'] = '_price';
    }
    if ('price-desc' == $orderby_value) {
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
        $args['meta_key'] = '_price';
    }
	// if ('relevance' == $orderby_value) {
    //     $args['orderby'] = 'meta_value_num';
    //     $args['order'] = 'ASC';
    //     $args['meta_key'] = '_price';
    // }
	return $args;
});

add_filter( 'woocommerce_default_catalog_orderby_options', 'woocust_catalog_orderby' ); // выводим сортировку свою, лишнее удаляем
add_filter('woocommerce_catalog_orderby', 'woocust_catalog_orderby'); // выводим сортировку свою, лишнее удаляем
function woocust_catalog_orderby($sortby) {
	unset($sortby['menu_order']);
	unset($sortby['rating']);
	unset($sortby['date']);
	unset($sortby['popularity']);
	unset($sortby['price']);
	unset($sortby['price-desc']);
	//$sortby['relevance'] = 'по релевантности';
	$sortby['popularity'] = 'по популярности';
	$sortby['price'] = 'по возрастанию цены';
	$sortby['price-desc'] = 'по убыванию цены';
	$sortby['sale'] = 'по акции';
	return $sortby;
}

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_before_shop_loop_item', 'product_card', 15);
function product_card() {
	global $product;
	$attachment_ids = $product->get_gallery_attachment_ids();
	$img_thumb = get_the_post_thumbnail( $post->ID, 'woo-thumbnail-product', $attributes );
	$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('woo-thumbnail-product'));
	$price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
	$sale = get_post_meta( get_the_ID(), '_sale_price', true); 	//цена со скидкой
	$price_space = number_format((int)$price, 0, '', '&nbsp;');
	$sale_space = number_format((int)$sale, 0, '', '&nbsp;');
	$url = get_the_permalink();
	$title = get_the_title();
	$desc_content = get_the_content();
	$desc_content_text = mb_strimwidth( strip_tags($desc_content), 0, 229, '' );
	$id = $product->get_id();

	
	$cart = WC()->instance()->cart;
	$cart_id = $cart->generate_cart_id($id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);

	if (is_front_page()) {?>
		<div class="popular__slide swiper-slide">
			<div class="popular__descr">
				<div>
					<h3 class="popular__descr_title"><?echo $title;?></h3>
					<p class="popular__descr_text">
						<?echo $desc_content_text; echo '...';?>
					</p>
				</div>
				<div class="popular__descr_info">
					<div class="popular__descr_price">
						<?if (!empty($sale)){?>
							<div class="price_main"><?echo $sale_space;?>&nbsp;₽</div>
							<div class="price_sale dash"><?echo $price_space;?>&nbsp;₽</div>
						<?} else {?>
							<div class="price_main"><?echo $price_space;?>&nbsp;₽</div>
						<?}?>
					</div><a href="<?echo $url;?>" class="btn">Подробнее</a></div>
			</div>
			<div class="popular__main">
				<div class="card">
					<!-- start фото только для первого экрана -->
					<? /*
					<div class="card-swiper swiper">
						<?
						echo '<a class="swiper-wrapper" href="'.$url.'">';
						echo '<div class="swiper-slide card__img">';
						if (empty($img_thumb)) {
							echo $thumbnail;
						}
						else {
							$img_src = get_the_post_thumbnail_url( $post->ID, 'woo-mini-catalog', false ); //подключаем вывод превью изоображения товара
							echo '<img src="' . esc_url($img_src) . '">';
						}
						echo '</div></a>';
						?>
						<div class="card-button-prev"></div>
						<div class="card-button-next"></div>
					</div>

					*/?>

					

					<?
						echo '<a class="card__img" href="'.$url.'">';
						if (empty($img_thumb)) {
							echo $thumbnail;
						}
						else {
							$img_src = get_the_post_thumbnail_url( $post->ID, 'woo-mini-catalog', false ); //подключаем вывод превью изоображения товара
							echo '<img src="' . esc_url($img_src) . '">';
						}
						echo '</a>';
						?>

					<!-- end фото только для первого экрана-->
					<a class="card__descr_title" href="<?echo $url;?>"><?echo $title;?></a>
					<div class="card__descr_price">
						<div class="card__price">
							<?if (!empty($sale)){?>
								<div class="card__price_main"><?echo $sale_space;?>&nbsp;₽</div>
								<div class="card__price_sale dash"><?echo $price_space;?>&nbsp;₽</div>
							<?} else {?>
								<div class="card__price_main"><?echo $price_space;?>&nbsp;₽</div>
							<?}?>
						</div>
						<div class="card__nav">
							<div class="card__nav_tab">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M24.2716 7.06837C24.0987 6.81862 23.8548 6.62717 23.5717 6.51912C23.3864 6.43909 23.1867 6.39808 22.985 6.39862L9.01148 6.39844C8.80982 6.3979 8.61018 6.4389 8.42492 6.51893C8.14181 6.62697 7.89781 6.81842 7.72488 7.06818C7.55387 7.31086 7.46293 7.60131 7.46487 7.89864V25.1648C7.46296 25.4622 7.55389 25.7527 7.72488 25.9955C7.8978 26.2452 8.14181 26.4367 8.42492 26.5447C8.61019 26.6247 8.80983 26.6657 9.01148 26.6651C9.42343 26.6674 9.8202 26.509 10.1182 26.2232L15.9983 20.5434L21.8783 26.2233C22.1782 26.5043 22.5748 26.6578 22.9848 26.6516C23.2362 26.6551 23.4847 26.5972 23.7088 26.4828C23.933 26.3685 24.1261 26.2011 24.2717 25.9951C24.4426 25.7525 24.5335 25.4621 24.5315 25.1649V7.89883C24.5335 7.60152 24.4426 7.31106 24.2716 7.06837V7.06837Z" fill="#C7C6C6" /> </svg>
							</div>
							<div class="card__nav_basket">
								<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M22.1339 23.2891C21.5891 23.289 21.0564 23.4505 20.6034 23.7532C20.1503 24.0558 19.7972 24.486 19.5887 24.9894C19.3801 25.4927 19.3255 26.0466 19.4318 26.581C19.5381 27.1154 19.8004 27.6062 20.1856 27.9915C20.5708 28.3768 21.0617 28.6392 21.596 28.7455C22.1304 28.8518 22.6843 28.7973 23.1877 28.5888C23.691 28.3804 24.1213 28.0273 24.424 27.5743C24.7267 27.1213 24.8883 26.5887 24.8883 26.0439C24.8884 25.6821 24.8171 25.3239 24.6787 24.9897C24.5403 24.6555 24.3374 24.3518 24.0817 24.096C23.8259 23.8402 23.5222 23.6373 23.188 23.4988C22.8538 23.3604 22.4956 23.2891 22.1339 23.2891Z" fill="#C7C6C6" />
									<path d="M29.9836 8.26287C29.9254 8.19133 29.8517 8.13391 29.7682 8.09494C29.6846 8.05598 29.5933 8.03647 29.5011 8.0379H7.61622L7.23128 6.47197C7.06978 5.80842 6.68943 5.21864 6.1516 4.7978C5.61377 4.37695 4.94983 4.14957 4.26692 4.15237H2.76564C2.60335 4.15432 2.44837 4.22016 2.33429 4.33561C2.22022 4.45106 2.15625 4.60683 2.15625 4.76913C2.15625 4.93143 2.22022 5.08719 2.33429 5.20265C2.44837 5.3181 2.60335 5.38394 2.76564 5.38589H4.26692C4.67326 5.38267 5.06878 5.51675 5.38941 5.76639C5.71004 6.01604 5.93698 6.36662 6.03348 6.76135L9.028 18.9903C9.19034 19.6525 9.57137 20.2406 10.1094 20.6594C10.6475 21.0782 11.3111 21.3032 11.9929 21.298H24.802C25.4927 21.3035 26.1645 21.0725 26.7057 20.6435C27.247 20.2145 27.6252 19.6132 27.7775 18.9395L30.1024 8.77742C30.1231 8.68827 30.1232 8.59556 30.1026 8.50637C30.082 8.41719 30.0413 8.33389 29.9836 8.26287V8.26287Z" fill="#C7C6C6" />
									<path d="M13.7938 23.2891C13.249 23.2891 12.7164 23.4506 12.2634 23.7533C11.8104 24.056 11.4573 24.4862 11.2488 24.9895C11.0403 25.4929 10.9857 26.0468 11.092 26.5811C11.1983 27.1155 11.4606 27.6063 11.8459 27.9916C12.2311 28.3769 12.7219 28.6392 13.2563 28.7455C13.7906 28.8518 14.3445 28.7973 14.8479 28.5888C15.3512 28.3803 15.7815 28.0273 16.0842 27.5743C16.3869 27.1213 16.5485 26.5887 16.5485 26.0439C16.5485 25.6821 16.4773 25.3239 16.3389 24.9896C16.2004 24.6554 15.9975 24.3517 15.7417 24.0959C15.4859 23.8401 15.1822 23.6372 14.848 23.4987C14.5138 23.3603 14.1556 23.289 13.7938 23.2891V23.2891Z" fill="#C7C6C6" /> </svg>
							</div>
						</div>
					</div>
					<!-- start кнопка только для первого экрана -->
					<div class="card__btn"> <a href="<?echo $url;?>" class="btn">Подробнее</a> </div>
					<!-- end кнопка только для первого экрана-->
				</div>
			</div>
		</div>

	<?}
	else {
		echo '<div class="card-swiper swiper">';
			echo '<a class="swiper-wrapper" href="'.$url.'">';
			echo '<div class="swiper-slide card__img">';
			if (empty($img_thumb)) {
				echo $thumbnail;
			}
			else {
				$img_src = get_the_post_thumbnail_url( $post->ID, 'woo-mini-catalog', false ); //подключаем вывод превью изоображения товара
				echo '<img data-src="' . esc_url($img_src) . '" src="' . get_template_directory_uri() . '/assets/img/pixel.png" class="swiper-lazy"><div class="swiper-lazy-preloader"></div>';
			}
			echo '</div>';
			foreach( $attachment_ids as $attachment_id ) {
				echo '<div class="swiper-slide card__img">';
				$img_src = wp_get_attachment_image_src( $attachment_id, 'woo-mini-catalog', false );
				echo '<img width="' . $img_src[1] . '" height="' . $img_src[2] . '" data-src="' . $img_src[0] . '" src="' . get_template_directory_uri() . '/assets/img/pixel.png" class="swiper-lazy"><div class="swiper-lazy-preloader"></div>';
				echo '</div>';
			}
			echo '</a><div class="card-button-prev"></div><div class="card-button-next"></div></div>';
			echo '<a class="card__descr_title" href="'.$url.'">'.$title.'</a>';

			?>
			<div class="card__descr_price">
			<div class="card__price">
				<?if (!empty($sale)){?>
					<div class="card__price_main"><?echo $sale_space;?>&nbsp;₽</div>
					<div class="card__price_sale dash"><?echo $price_space;?>&nbsp;₽</div>
				<?} else {?>
					<div class="card__price_main"><?echo $price_space;?>&nbsp;₽</div>
				<?}?>
			</div>
			<div class="card__nav">
				
				<?
				if( empty( $_COOKIE[ 'pechnoj_centr12_likelist_product' ] ) ) {
					$like_products = array();
				} else {
					$like_products = (array) explode( ',', $_COOKIE[ 'pechnoj_centr12_likelist_product' ] );
				}
				if ( ! in_array( get_the_id(), $like_products ) ) {
					$like_products[] = $product_id_like;
					echo '<div class="card__nav_tab add-likelist-js" data-id="'.$id.'">';
				} else {
					if (is_page('zakladki')) {
						echo '<div class="card__nav_tab add-likelist-js active" data-id="'.$id.'" data-page="likelist">';
					}
					else {
						echo '<div class="card__nav_tab add-likelist-js active" data-id="'.$id.'">';
					}
				}
				?>

					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M24.2716 7.06837C24.0987 6.81862 23.8548 6.62717 23.5717 6.51912C23.3864 6.43909 23.1867 6.39808 22.985 6.39862L9.01148 6.39844C8.80982 6.3979 8.61018 6.4389 8.42492 6.51893C8.14181 6.62697 7.89781 6.81842 7.72488 7.06818C7.55387 7.31086 7.46293 7.60131 7.46487 7.89864V25.1648C7.46296 25.4622 7.55389 25.7527 7.72488 25.9955C7.8978 26.2452 8.14181 26.4367 8.42492 26.5447C8.61019 26.6247 8.80983 26.6657 9.01148 26.6651C9.42343 26.6674 9.8202 26.509 10.1182 26.2232L15.9983 20.5434L21.8783 26.2233C22.1782 26.5043 22.5748 26.6578 22.9848 26.6516C23.2362 26.6551 23.4847 26.5972 23.7088 26.4828C23.933 26.3685 24.1261 26.2011 24.2717 25.9951C24.4426 25.7525 24.5335 25.4621 24.5315 25.1649V7.89883C24.5335 7.60152 24.4426 7.31106 24.2716 7.06837V7.06837Z" fill="#C7C6C6" /></svg>
				</div>

					<?
					if($cart_item_id){
						echo '<div class="card__nav_basket add-cart-js active" data-id="'.$id.'" data-quantity="1" data-option="one" data-page="archive">';
					}
					else {
						echo '<div class="card__nav_basket add-cart-js" data-id="'.$id.'" data-quantity="1" data-option="one" data-page="archive">';
					}
					?>
					<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path
							d="M22.1339 23.2891C21.5891 23.289 21.0564 23.4505 20.6034 23.7532C20.1503 24.0558 19.7972 24.486 19.5887 24.9894C19.3801 25.4927 19.3255 26.0466 19.4318 26.581C19.5381 27.1154 19.8004 27.6062 20.1856 27.9915C20.5708 28.3768 21.0617 28.6392 21.596 28.7455C22.1304 28.8518 22.6843 28.7973 23.1877 28.5888C23.691 28.3804 24.1213 28.0273 24.424 27.5743C24.7267 27.1213 24.8883 26.5887 24.8883 26.0439C24.8884 25.6821 24.8171 25.3239 24.6787 24.9897C24.5403 24.6555 24.3374 24.3518 24.0817 24.096C23.8259 23.8402 23.5222 23.6373 23.188 23.4988C22.8538 23.3604 22.4956 23.2891 22.1339 23.2891Z"
							fill="#C7C6C6" />
						<path
							d="M29.9836 8.26287C29.9254 8.19133 29.8517 8.13391 29.7682 8.09494C29.6846 8.05598 29.5933 8.03647 29.5011 8.0379H7.61622L7.23128 6.47197C7.06978 5.80842 6.68943 5.21864 6.1516 4.7978C5.61377 4.37695 4.94983 4.14957 4.26692 4.15237H2.76564C2.60335 4.15432 2.44837 4.22016 2.33429 4.33561C2.22022 4.45106 2.15625 4.60683 2.15625 4.76913C2.15625 4.93143 2.22022 5.08719 2.33429 5.20265C2.44837 5.3181 2.60335 5.38394 2.76564 5.38589H4.26692C4.67326 5.38267 5.06878 5.51675 5.38941 5.76639C5.71004 6.01604 5.93698 6.36662 6.03348 6.76135L9.028 18.9903C9.19034 19.6525 9.57137 20.2406 10.1094 20.6594C10.6475 21.0782 11.3111 21.3032 11.9929 21.298H24.802C25.4927 21.3035 26.1645 21.0725 26.7057 20.6435C27.247 20.2145 27.6252 19.6132 27.7775 18.9395L30.1024 8.77742C30.1231 8.68827 30.1232 8.59556 30.1026 8.50637C30.082 8.41719 30.0413 8.33389 29.9836 8.26287V8.26287Z"
							fill="#C7C6C6" />
						<path
							d="M13.7938 23.2891C13.249 23.2891 12.7164 23.4506 12.2634 23.7533C11.8104 24.056 11.4573 24.4862 11.2488 24.9895C11.0403 25.4929 10.9857 26.0468 11.092 26.5811C11.1983 27.1155 11.4606 27.6063 11.8459 27.9916C12.2311 28.3769 12.7219 28.6392 13.2563 28.7455C13.7906 28.8518 14.3445 28.7973 14.8479 28.5888C15.3512 28.3803 15.7815 28.0273 16.0842 27.5743C16.3869 27.1213 16.5485 26.5887 16.5485 26.0439C16.5485 25.6821 16.4773 25.3239 16.3389 24.9896C16.2004 24.6554 15.9975 24.3517 15.7417 24.0959C15.4859 23.8401 15.1822 23.6372 14.848 23.4987C14.5138 23.3603 14.1556 23.289 13.7938 23.2891V23.2891Z"
							fill="#C7C6C6" />
					</svg>
				</div>
			</div>
		</div>

	<?}
}
// -------------------------- КОНЕЦ КАТАЛОГА --------------------------

// ------------------------- НАЧАЛО СТРАНИЦЫ КАРТОЧКИ ТОВАРА -------------------------

remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 ); // удаляем вывод инфо после добавления товара в корзину
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 ); //удаляем показ распродажа
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 ); // удаляем стандартный вывод изоображений товара
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 ); // Удаление артикула и название категории
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 ); // удаление title
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );// удаление rating
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 ); //удаляем атрибуты
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 ); //удаляем описание
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); //удаляем похожие товары
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );


add_action( 'woocommerce_before_single_product_summary', 'product_title_sku', 5 );
function product_title_sku() {
	global $product;
	$product_name = $product->get_name();
	$product_id = $product->get_id();
	$product_article = $product->sku;
	?>
	<h1 class="h1">
		<?echo $product_name;?>
	</h1>
	<div class="subject__article">
		<? if ($product_article) {?>
			<span>Код: <?echo $product_article;?></span>
		<?}?>
		<?
			if( empty( $_COOKIE[ 'pechnoj_centr12_likelist_product' ] ) ) {
				$like_products = array();
			} else {
				$like_products = (array) explode( ',', $_COOKIE[ 'pechnoj_centr12_likelist_product' ] );
			}
			if (in_array( get_the_id(), $like_products ) ) {
				$like_products[] = $product_id_like;
				echo '<span class="subject__article_favourites active add-likelist-js" data-id="'.$product_id.'">В закладки</span>';
			} else {
				echo '<span class="subject__article_favourites add-likelist-js" data-id="'.$product_id.'">В закладки</span>';
			}
		?>
	</div>
<?}


add_action( 'woocommerce_before_single_product_summary', 'product_content_body', 30 );
function product_content_body() {?>
<div class="subject__body">
	<div class="subject__body_wrapper">
		<div class="product-slider">
			<div class="product-slider__wrapper-vertical">
				<div class="button-mini-prev"></div>
				<div class="image-mini-slider swiper">
					<div class="image-mini-slider__wrapper swiper-wrapper">
						<?
						global $product;
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

							echo '<div class="image-mini-slider__slide swiper-slide">
							<div class="image-mini-slider__image">
								<button class="play__btn play-btn-product-video" data-btn="'.$video_id.'" data-url="'.$url_bgc.'"></button><img src="'.get_template_directory_uri().'/assets/img/slider_product/video.jpg" alt="Воспроизведение видео"></div>
						</div>';
						}
						
						$attachment_ids = $product->get_gallery_attachment_ids();
						echo '<div class="image-mini-slider__slide swiper-slide"><div class="image-mini-slider__image">';

						$img_thumb = get_the_post_thumbnail( $post->ID, 'woo-thumbnail-product', $attributes );
						if (empty($img_thumb)) {
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('woo-thumbnail-product'));
							echo $thumbnail;
						}
						else {
							echo $img_thumb;
						}
						echo '</div></div>';
						foreach( $attachment_ids as $attachment_id ) {
							echo '<div class="image-mini-slider__slide swiper-slide"><div class="image-mini-slider__image">';
							echo wp_get_attachment_image( $attachment_id, 'woo-thumbnail-product', false );
							echo '</div></div>';  
						}
						?>

					</div>
				</div>
				<div class="button-mini-next"></div>
			</div>
			<div class="product-slider__wrapper">
				<div class="image-slider swiper">
					<div class="image-slider__wrapper swiper-wrapper">

						<?
						if ($video_id) {
							echo '<div class="image-slider__slide swiper-slide">
							<div class="image-slider__image">
								<div class="product-video player__video">
									<div class="video" id="'.$video_id.'" data-params="loop=1&playlist='.$video_id.'&enablejsapi=1" style="background: url('.$url_bgc.') center center / 100% auto no-repeat"></div>
									<div class="block__video-error loader-error" data-i="'.$video_id.'">
										<span>
											<svg width="50" height="45" viewBox="0 0 50 45" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1221_26932)"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.5607 44.5175C9.03165 40.1163 16.8458 37.5915 25.0001 37.5915C33.1544 37.5915 40.9686 40.1163 46.4396 44.5175C46.8438 44.8435 47.3292 45.0013 47.8112 45.0013C48.4495 45.0013 49.0836 44.7232 49.516 44.1873C50.274 43.2479 50.1253 41.8724 49.1844 41.1155C42.9504 36.1 34.1346 33.2227 25.0001 33.2227C15.8656 33.2227 7.04991 36.1 0.815826 41.1155C-0.125909 41.8724 -0.27375 43.2479 0.484253 44.1873C1.24226 45.1259 2.61982 45.2752 3.5607 44.5175Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M49.3588 0.639956C48.5051 -0.213319 47.1198 -0.213319 46.2653 0.639956L41.3216 5.57615L36.377 0.639956C35.5233 -0.213319 34.1381 -0.213319 33.2835 0.639956C32.4289 1.49237 32.4289 2.87553 33.2835 3.72881L38.2272 8.665L33.2835 13.602C32.4289 14.4544 32.4289 15.8376 33.2835 16.6909C34.1372 17.5442 35.5225 17.5442 36.377 16.6909L41.3216 11.7547L46.2653 16.6909C46.6926 17.1175 47.2523 17.3308 47.812 17.3308C48.3718 17.3308 48.9315 17.1175 49.3588 16.6909C50.2134 15.8376 50.2134 14.4544 49.3588 13.602L44.4151 8.665L49.3588 3.72881C50.2134 2.87553 50.2134 1.49237 49.3588 0.639956Z" fill="#EE523F"/><path fill-rule="evenodd" clip-rule="evenodd" d="M0.641415 16.6918C1.49513 17.5442 2.88039 17.5442 3.73496 16.6909L8.67864 11.7547L13.6223 16.6909C14.0496 17.1175 14.6094 17.3309 15.1691 17.3309C15.7289 17.3309 16.2895 17.1175 16.7159 16.6909C17.5705 15.8385 17.5705 14.4553 16.7167 13.6021L11.7731 8.66586L16.7167 3.72881C17.5705 2.87639 17.5705 1.49323 16.7159 0.639956C15.8622 -0.212465 14.4769 -0.213319 13.6223 0.639956L8.67864 5.57615L3.73496 0.639956C2.88039 -0.213319 1.49513 -0.213319 0.641415 0.639956C-0.213154 1.49323 -0.213154 2.87639 0.641415 3.72881L5.5851 8.66586L0.641415 13.6021C-0.213154 14.4553 -0.213154 15.8385 0.641415 16.6918Z" fill="#EE523F"/></g><defs><clipPath id="clip0_1221_26932"><rect width="50" height="45" fill="white"/></clipPath></defs></svg>
										</span>
										<div class="page-reload btn">Перезагрузить</div>
									</div>
									<div class="play__btn play-btn-product-video" data-btn="'.$video_id.'" data-url="'.$url_bgc.'"><span></span></div>

								</div>
							</div>
						</div>';

						// data-id="product-video-player" 
						}

						$attachment_ids = $product->get_gallery_attachment_ids();
						echo '<div class="image-slider__slide jsOpenPopup swiper-slide"><div class="image-slider__image">';
						//echo get_the_post_thumbnail( $post->ID, 'woo-page-product', false);
						$img_thumb = get_the_post_thumbnail( $post->ID, 'woo-page-product', $attributes );
						if (empty($img_thumb)) {
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image('woo-page-product'));
							echo $thumbnail;
						}
						else {
							echo $img_thumb;
						}


						echo '</div></div>';  
						foreach( $attachment_ids as $attachment_id ) {
							echo '<div class="image-slider__slide jsOpenPopup swiper-slide"><div class="image-slider__image">';
							echo wp_get_attachment_image( $attachment_id, 'woo-page-product', false );
							echo '</div></div>';  
						}

						?>
					</div>
					<button class="play__btn loading_video image-slider__play_btn">Видео</button>
				</div>
			</div>
		</div>
		<div class="subject__description-brief">
			<ul class="subject-descr">
				<?
				$terms = get_the_terms( $post->ID, 'product_cat' );
				$proizvoditel = $product->get_attribute('proizvoditel');
				$vysota = $product->get_attribute('vysota');
				$shirina = $product->get_attribute('shirina');
				$glubina = $product->get_attribute('glubina');
				$material = $product->get_attribute('material');
				foreach ($terms as $term) {
					//$product_cat_id = $term->term_id;
					$product_cat_name = $term->name;
					break;
				}
				?>
				<li class="subject-descr__item">
					<p class="subject-descr__item_title">Категория</p> <span class="subject-descr__item_span"></span>
					<p class="subject-descr__item_value"><?echo $product_cat_name;?></p>
				</li>
				<?
				if (!empty($proizvoditel)) { ?>
					<li class="subject-descr__item">
						<p class="subject-descr__item_title">Производитель</p> <span class="subject-descr__item_span"></span>
						<p class="subject-descr__item_value"><? echo $proizvoditel;?></p>
					</li>
				<?}
				if (!empty($vysota)) { ?>
					<li class="subject-descr__item">
						<p class="subject-descr__item_title">Высота, мм</p> <span class="subject-descr__item_span"></span>
						<p class="subject-descr__item_value"><? echo $vysota;?></p>
					</li>
				<?}
				if (!empty($shirina)) { ?>
					<li class="subject-descr__item">
						<p class="subject-descr__item_title">Ширина, мм</p> <span class="subject-descr__item_span"></span>
						<p class="subject-descr__item_value"><? echo $shirina;?></p>
					</li>
				<?}
				if (!empty($glubina)) { ?>
					<li class="subject-descr__item">
						<p class="subject-descr__item_title">Глубина, мм</p> <span class="subject-descr__item_span"></span>
						<p class="subject-descr__item_value"><? echo $glubina;?></p>
					</li>
				<?}
				if (!empty($material)) { ?>
					<li class="subject-descr__item">
						<p class="subject-descr__item_title">Материал</p> <span class="subject-descr__item_span"></span>
						<p class="subject-descr__item_value"><? echo $material;?></p>
					</li>
				<?}?>
			</ul>
			<a class="btn-text jsSmoothLink" href="#anchor-specif">Подробнее</a> </div>
			<div class="subject__order">
				<div class="subject__order_wrapper">
					<div class="subject__order_price price-order">
						<?
						$price = get_post_meta( get_the_ID(), '_regular_price', true); // основная цена товара
						$sale = get_post_meta( get_the_ID(), '_sale_price', true); 	//цена со скидкой
						$price_space = number_format((int)$price, 0, '', '&nbsp;');
						$sale_space = number_format((int)$sale, 0, '', '&nbsp;');
						?>
						<?if (!empty($sale)){?>
							<div class="price-order_main"><?echo $sale_space;?>&nbsp;₽</div>
							<div class="price-order_sale dash"><?echo $price_space;?>&nbsp;₽</div>
						<?} else {?>
							<div class="price-order_main"><?echo $price_space;?>&nbsp;₽</div>
						<?}?>
					</div>
					<p class="subject__order_text">*Цена товара на сайте может отличаться. Точную стоимость уточняйте у менеджеров</p>
				</div>
				<div class="subject__order_wrapper">
					<?$id = $product->get_id();
					$terms = get_the_terms($id, 'product_cat');
					if($terms) {
						foreach( $terms as $term ) {
							$term = get_term_by('id', $term->parent, 'product_cat');
							if ($term->parent > 0) {
								$term = get_term_by('id', $term->parent, 'product_cat');
							}
							$cat_obj = get_term($term->term_id, 'product_cat');
							$cat_id = $cat_obj->term_id;
						}
					}
					$cart = WC()->instance()->cart;
					$cart_id = $cart->generate_cart_id($id);
					$cart_item_id = $cart->find_product_in_cart($cart_id);

					$cart_quantity = WC()->cart->get_cart();
					$cart_item_count = $cart_quantity[$cart_item_id]['quantity'];

					$cat_num = (int)$cat_id;

					echo '<div class="btn add-to-cart add-cart-js';
					if($cart_item_id) {
						echo ' d-hide active"';
						//echo'"';
					}
					else {echo'"';}
					echo 'data-id="'.$id.'" data-quantity="1" data-page="product"';
					if (in_array($cat_num, array(20,21,22,23))) {
						echo 'data-option="set">';
					}else {
						echo 'data-option="one">';
					}

					echo 'Добавить в корзину</div>';

					if (in_array($cat_num, array(20,21,22,23))) {
						if($cart_item_id) {
							echo '<div class="subject__order_btn">
							<div class="number">';
							if ($cart_item_count > 1) {
								echo '<div class="number-minus btn-product"></div>';
							}
							else {
								echo '<div class="number-minus btn-product disabled"></div>';
							}
							echo '<input type="number"';
							if (empty($cart_item_count)) {
								echo 'value="1"';
							}
							else {
								echo 'value="'.$cart_item_count.'"';
							}
							echo 'step="1" min="0" max="999" data-max-count="999" inputmode="decimal" name="quantity" class="number-text btn-product" autocomplete="off" data-page="product"><div class="number-plus btn-product"></div></div>';
						}
						else {
							echo '<div class="subject__order_btn d-hide">
							<div class="number">
								<div class="number-minus btn-product disabled"></div>
								<input type="number" value="1" step="1" min="0" max="999" data-max-count="999" inputmode="decimal" name="quantity" class="number-text btn-product" autocomplete="off">
								<div class="number-plus btn-product"></div>
							</div>';
						}
						echo '<a href="'.wc_get_checkout_url().'" class="btn go-to-cart" title="Перейти в корзину">В корзину <span class="mess-descr d-hide">перейти</span></a></div>';
					}
					else {
						if($cart_item_id) {
							echo '<div class="subject__order_btn">';
							// echo '<div class="btn-text delete-item add-cart-js active" data-id="'.$id.'" data-quantity="1" data-page="product" data-option="one">Отменить выбор</div>';
						}
						else {
							echo '<div class="subject__order_btn d-hide">';
							
						}
						echo '<div class="btn-text delete-item add-cart-js">Отменить выбор</div>';
						echo '<a href="'.wc_get_checkout_url().'" class="btn go-to-cart" title="Перейти в корзину">В корзину <span class="mess-descr d-hide">перейти</span></a></div>';
					}

					?>
					<div class="btn-reverse" id="openModal">Заказ в 1 клик</div>
					
					</div>
				</div>
			</div>
		</div>
	<div>
		<div class="subject__description" id="anchor-specif">
			<h2 class="subject__description_title h2">Характеристики</h2>
				<?global $product; echo wc_display_product_attributes($product);?>
			<button class="btn-text">Показать польностью</button>
		</div>
		<?
		$desc_content = get_the_content();
		if (!empty($desc_content)) {
			echo '<div class="subject__description" id="anchor-descr"><h2 class="subject__description_title h2">Описание</h2><div class="subject__description_text">';
			echo the_content();
			//echo wp_trim_words( $desc_content, 100, '...' );
			echo '</div><button class="btn-text">Показать полностью</button></div>';
		}
		?>
	</div>
</div>

<?}


add_action( 'woocommerce_product_options_general_product_data', 'art_woo_add_custom_fields' );
function art_woo_add_custom_fields() {
	global $product, $post;
	echo '<div class="options_group">';
		woocommerce_wp_text_input( array(
			'id'                => '_text_field_videoid',
			'label'             => __( 'ID видео', 'woocommerce' ),
			//'placeholder'       => '',
			'description'       => __( 'Айдишник (id) видео берётся из ссылки YouTube', 'woocommerce' ),
			'type'              => 'text',
			'desc_tip'          => 'true',
			//'custom_attributes' => array( 'required' => 'required' ),
		));
	echo '</div>';
}

add_action( 'woocommerce_process_product_meta', 'art_woo_custom_fields_save', 10 );
function art_woo_custom_fields_save( $post_id ) {
	// Вызываем объект класса
	$product = wc_get_product( $post_id );
	//Сохранение текстового поля
	$text_field = isset( $_POST['_text_field_videoid'] ) ? sanitize_text_field( $_POST['_text_field_videoid'] ) : '';
	$product->update_meta_data( '_text_field_videoid', $text_field );
	//Сохраняем все значения
	$product->save();
}

function contact_maps() {
	$id_page = 14;
	?>
	<section class="add-contacts">
		<div class="container">
			<div class="add-contacts__wrapper">
				<div class="contacts__descr">
					<h2>Контакты</h2>
						<?contacts_address('contacts');?>
					<div class="contacts__descr_tel">
						<?contacts_phone();?>
					</div>
					<div class="contacts__descr_duty"><?contacts_work_time();?></div>
					<?$email = get_option('admin_email');?>
					<a class="contacts__descr_mail" href="mailto:<?echo $email;?>"><?echo $email;?></a>
					<div class="contacts__descr_social">
						<div class="social">
							<?contacts_messeng_social();?>
						</div>
					</div>
				</div>
				<div class="contacts__map-address d-hide">
					<span data-type-geo="Офис" data-addr="<?contacts_address('map', $id_page);?>" data-geo="<?echo get_field('contacts-geo', $id_page);?>" data-2gis="<?echo get_field('contacts-2gis', $id_page);?>"></span>
				</div>
				<div class="contacts__map">
					<div class="map" id="map"></div>
				</div>
			</div>
		</div>
	</section>
<?}
// ------------------------- КОНЕЦ СТРАНИЦЫ КАРТОЧКИ ТОВАРА -------------------------
// ------------------------- НАЧАЛО СТРАНИЦЫ КОРЗИНЫ -------------------------

remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 ); //удаление уведомлений в корзине при добавлении товара
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display'); //отключение вывода кросселов-товаров в корзине
add_filter( 'woocommerce_cart_item_removed_notice_type', '__return_false' ); //Отключение уведомления Товар [Название] удален из Корзины
// remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
// remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
// add_filter( 'wc_add_to_cart_message_html', '__return_null' );

// function customize_wc_errors( $error ) {
//     if ( strpos( $error, 'Billing ' ) !== false ) {
//         $error = '';
//     }
//     return $error;
// }
// add_filter( 'woocommerce_add_error', 'customize_wc_errors' );

// ------------------------- КОНЕЦ СТРАНИЦЫ КОРЗИНЫ -------------------------

// ------------------------- НАЧАЛО СТРАНИЦЫ ОФОРМЛЕНИЯ -------------------------
add_filter('woocommerce_add_message', '__return_false');
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10); 
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );

add_filter( 'woocommerce_default_address_fields' , 'wpbl_fileds_validation' );
function wpbl_fileds_validation( $array ) {
    
    // Имя
    //unset( $array['first_name']['required']);
    
    // Фамилия
    unset( $array['last_name']['required']);
    
    // Область / район
    unset( $array['state']['required']);
	unset( $array['billing_email']['required']);

    // Почтовый индекс
    unset( $array['postcode']['required']);
    
    // Населённый пункт
    unset( $array['city']['required']);
    
    // 1-ая строка адреса 
    unset( $array['address_1']['required']);
    
    // 2-ая строка адреса 
    unset( $array['address_2']['required']);

    
    // Возвращаем обработанный массив
    return $array;
}

add_filter( 'woocommerce_checkout_fields', 'wpbl_remove_some_fields', 9999 ); 
function wpbl_remove_some_fields( $array ) {
 
    //unset( $array['billing']['billing_first_name'] ); // Имя
    unset( $array['billing']['billing_last_name'] ); // Фамилия
    //unset( $array['billing']['billing_email'] ); // Email
    unset( $array['order']['order_comments'] ); // Примечание к заказу
 
    //unset( $array['billing']['billing_phone'] ); // Телефон
    unset( $array['billing']['billing_company'] ); // Компания
    //unset( $array['billing']['billing_country'] ); // Страна
    unset( $array['billing']['billing_address_1'] ); // 1-ая строка адреса 
    unset( $array['billing']['billing_address_2'] ); // 2-ая строка адреса 
    unset( $array['billing']['billing_city'] ); // Населённый пункт
    unset( $array['billing']['billing_state'] );

	
	unset( $array['shipping']['shipping_country'] ); // Область / район
    unset( $array['billing']['billing_postcode'] ); // Почтовый индекс

	unset($array['shipping_city']);
	unset($array['shipping_first_name']);
	unset($array['shipping_last_name']);
	unset($array['shipping_company']);
	unset($array['shipping_address_1']);
	unset($array['shipping_address_2']);
	unset($array['shipping_postcode']);
	unset($array['shipping_country']);
	unset($array['shipping_state']);
    // Возвращаем обработанный массив
    return $array;
}



add_filter( 'woocommerce_checkout_fields', 'wplb_email_first' );
function wplb_email_first( $array ) {
    
    // Меняем приоритет

	$array['billing']['billing_first_name']['priority'] = 10;
	$array['billing']['billing_first_name']['input_class'][0] = 'total__name';
	//$array['billing']['billing_first_name']['label'] = '';
	$array['billing']['billing_first_name']['placeholder'] = 'Имя*';
	$array['billing']['billing_first_name']['custom_attributes'] = array("autocomplete" => "on", "title" => "Разрешено использовать русские буквы", "pattern" => "^[А-Яа-яЁё\s]+$");

	$array['billing']['billing_phone']['priority'] = 30;
	//$array['billing']['billing_phone']['label'] = '';
	$array['billing']['billing_phone']['placeholder'] = 'Телефон*';
	$array['billing']['billing_phone']['input_class'][0] = 'total__tel';
	$array['billing']['billing_phone']['custom_attributes'] = array("inputmode" => "decimal", "minlength" => "11", "maxlength" => "11" );


	$array['billing']['billing_email']['priority'] = 20;
	//$array['billing']['billing_email']['label'] = '';
	$array['billing']['billing_email']['placeholder'] = 'E-mail';
	$array['billing']['billing_email']['input_class'][0] = 'total__email';

	$array['billing']['billing_country']['class'][0] = 'd-hide';

    // Возвращаем обработанный массив
    return $array;
}

add_filter( 'woocommerce_form_field_text', 'woo_form_field_billing', 10, 4 );
add_filter( 'woocommerce_form_field_tel', 'woo_form_field_billing', 10, 4 );
add_filter( 'woocommerce_form_field_email', 'woo_form_field_billing', 10, 4 );
function woo_form_field_billing( $field, $key, $args, $value ){

    if ( $args['required'] ) {
        //$args['class'][] = '';
        $required = ' <abbr class="required" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr>';
    } else {
        $required = '';
    }

    $args['maxlength'] = ( $args['maxlength'] ) ? 'maxlength="' . absint( $args['maxlength'] ) . '"' : '';

    $args['autocomplete'] = ( $args['autocomplete'] ) ? 'autocomplete="' . esc_attr( $args['autocomplete'] ) . '"' : '';

    if ( is_string( $args['label_class'] ) ) {
        $args['label_class'] = array( $args['label_class'] );
    }

    if ( is_null( $value ) ) {
        $value = $args['default'];
    }

    // Custom attribute handling
    $custom_attributes = array();

    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $args['custom_attributes'] ) && is_array( $args['custom_attributes'] ) ) {
        foreach ( $args['custom_attributes'] as $attribute => $attribute_value ) {
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $attribute_value ) . '"';
        }
    }

    $field = '';
    $label_id = $args['id'];
    $field_container = '<p class="total__item-field %1$s" id="%2$s">%3$s</p>';
	if ($args['type'] == 'email') {
		$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' autocomplete="on" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
    }
	else if ( $args['required'] ) {
		$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' autocomplete="on" value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' /><span class="error-mess">Необходимо заполнить поле</span>';
	}

    // if ( $args['required'] ) {
	// 	$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' /><span class="error-mess">Необходимо заполнить поле</span>';
    // } else {
	// 	$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '" ' . $args['maxlength'] . ' ' . $args['autocomplete'] . ' value="' . esc_attr( $value ) . '" ' . implode( ' ', $custom_attributes ) . ' />';
    // }

    if ( ! empty( $field ) ) {

        $field_html = '';
        
        // if ( $args['description'] ) {
        //     $field_html .= '<span class="description">' . esc_html( $args['description'] ) . '</span>';
        // }

        if ( $args['label'] && 'checkbox' != $args['type'] ) {
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="d-hide">' . $args['label'] . $required . '</label>';
        }
		
		$field_html .= $field;

        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';

        $after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
    }
    return $field;
}

add_action( 'woocommerce_review_order_after_order_total', 'woo_privacy_checkbox');
function woo_privacy_checkbox() {
	$domain_site = get_site_url();
	woocommerce_form_field('checkbox_total', array(
	'type' => 'checkbox',
	'label_class' => array('total__checkbox'),
	'required' => true,
	'label' => '<span class="total__checkbox_text">Я согласен(-а) на обработку<a href="'. $domain_site . '/privacy/" target="_blank"> персональных данных</a></span>',
	));
}

add_filter( 'woocommerce_form_field_checkbox', 'woo_form_field_checkbox', 10, 4 );
function woo_form_field_checkbox( $field, $key, $args, $value ){

    if ( $args['required'] ) {
        $required = ' <abbr class="required d-hide" title="' . esc_attr__( 'required', 'woocommerce'  ) . '">*</abbr></span><span class="error-mess">Необходимо соглашение</span>';
    } else {
        $required = '';
    }

    $field = '';
    $label_id = $args['id'];
    $field_container = '<p class="privacy_checkbox %1$s" id="%2$s">%3$s</p>';


	$field .= '<input type="' . esc_attr( $args['type'] ) . '" class="input-text ' . esc_attr( implode( ' ', $args['input_class'] ) ) .'" name="' . esc_attr( $key ) . '" id="' . esc_attr( $args['id'] ) . '" />';
    

    if ( ! empty( $field ) ) {
        $field_html = '';
        
        if ( $args['label'] != $args['type'] ) {
            $field_html .= '<label for="' . esc_attr( $label_id ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">'. $field . $args['label'] . $required . '</label>';
        }
		

        $container_class = 'form-row ' . esc_attr( implode( ' ', $args['class'] ) );
        $container_id = esc_attr( $args['id'] ) . '_field';

        $after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

        $field = sprintf( $field_container, $container_class, $container_id, $field_html ) . $after;
    }
    return $field;
}

add_action( 'woocommerce_checkout_update_order_meta', 'set_email_for_guest', 10, 2 );
function set_email_for_guest( $order_id, $data ) { // first param is an order/post ID
    if ( empty( $data['billing_email'] ) ) {
        update_post_meta( $order_id, '_billing_email', get_option('admin_email') );
    }
}

add_action( 'woocommerce_checkout_process', 'privacy_checkbox_error_message' );
function privacy_checkbox_error_message() {
	if ( ! (int) isset( $_POST['checkbox_total'] ) ) {
		wc_add_notice( __( 'Необходимо соглашение' ), 'error' );
	}
	$client_tel = $_POST['billing_phone'];
	$clean_str_tel = mb_eregi_replace('[^0-9]', '', $client_tel);
	if (mb_strlen($clean_str_tel) < 11 ) {
		wc_add_notice( __( '<span class="error_tel">error_tel</span>' ), 'error' );
	}
}

add_filter( 'woocommerce_billing_fields', 'filter_billing_fields', 20, 1 );
function filter_billing_fields( $billing_fields ) {
    if( ! is_checkout() ) return $billing_fields;
    $billing_fields['billing_email']['required'] = false;
    return $billing_fields;
}

// ------------------------- КОНЕЦ СТРАНИЦЫ ОФОРМЛЕНИЯ -------------------------

// ------------------------- НАЧАЛО СТРАНИЦЫ ЗАКЛАДКИ -------------------------

//создаем куки, записываем данные ID избранных товаров
add_action('wp_ajax_likelist', 'likelist');
add_action('wp_ajax_nopriv_likelist', 'likelist');
function likelist() {
	$product_id_like = $_POST['product_id'];
	if ( empty( $_COOKIE[ 'pechnoj_centr12_likelist_product' ] ) ) {
		$like_products = array();
	} else {
		$like_products = (array) explode( ',', $_COOKIE[ 'pechnoj_centr12_likelist_product' ] );
	}
	if ( ! in_array( $product_id_like, $like_products ) ) {
		$like_products[] = $product_id_like;
	} else {
		$remove_id = array_search($product_id_like, $like_products);
		unset($like_products[$remove_id]);
	}
	wc_setcookie( 'pechnoj_centr12_likelist_product', join( ',', $like_products ), time() + (3600 * 24 * 7) );
	$count_likelist = count($like_products);
	if ( empty( $_COOKIE[ 'pechnoj_centr12_likelist_count' ] ) ) {
		$likelist_count = array();
	} else {
		$likelist_count = $_COOKIE[ 'pechnoj_centr12_likelist_count' ];
	}
	$likelist_count = $count_likelist;
	wc_setcookie( 'pechnoj_centr12_likelist_count', $likelist_count, time() + (3600 * 24 * 7) );
	echo json_encode(array('count_likelist'=>__($count_likelist)));
	die();
}

//Вывод избранных товаров
function woo_echo_likelist() {
	if( empty( $_COOKIE[ 'pechnoj_centr12_likelist_product' ] ) ) {
		$like_products = array();
	} else {
		$like_products = (array) explode( ',', $_COOKIE[ 'pechnoj_centr12_likelist_product' ] );
	}
	if ( empty( $like_products ) ) {
		echo '<div class="favourites info">
		'.woocommerce_breadcrumb().'
		<section class="info__wrapper">
		<i class="fly"></i>
		<div class="info__title">
			<h1 data-likelist="false">В закладках пусто</h1>
			<p>Вернитесь на главную или перейдите в интересующую Вас категорию для добавления товаров в закладки</p>
			<a href="'.get_site_url().'" class="btn">Вернуться на главную</a>
		</div>
	</section></div>';
		return;
	}

	// надо ведь сначала отображать последние просмотренные
	$like_products = array_reverse( array_map( 'absint', $like_products ) );
	$args = [
		'post_type'      => 'product',
		'posts_per_page' => -1,
		'post__in' => $like_products
	];

	$query = new WP_Query( $args );

	// обрабатываем результат
	if ( $query->have_posts() ) :
	?>
		<div class="favourites">
		<? woocommerce_breadcrumb();?>
			<section class="layout">
				<div class="container">
					
					<nav class="layout__sidebar sidebar">
						
						<?echo do_shortcode('[woof]');?>
					</nav>
	
					<div class="layout__body">
						<div class="layout__body_descr">
							<h1>Закладки</h1>
						</div>
						<div class="layout__body_cards catalog">
							<?
							while ( $query->have_posts() ) {
								$query->the_post(); ?>
								<div class="card">
									<? product_card(); ?>
								</div>
							<? 
							} //endwhile ?> 
						</div>
					</div>
				</div>
			</section>
		</div>
	<? wp_reset_postdata(); endif; 
}

// ------------------------- КОНЕЦ СТРАНИЦЫ ЗАКЛАДКИ -------------------------

// -------------------------- КОНЕЦ WOOCOMMERCE --------------------------

// ------------------------- НАЧАЛО ГРУППЫ ПОЛЕЙ ACF -------------------------
function contacts_phone() {
	$id_page = 14;
	$tel_home = get_field('contacts-tel-home', $id_page);
	$tel_home1 = mb_substr($tel_home, 1, 4, 'UTF8');
	$tel_home2 = mb_substr($tel_home, 5, 2, 'UTF8');
	$tel_home3 = mb_substr($tel_home, 7, 2, 'UTF8');
	$tel_home4 = mb_substr($tel_home, 9, 2, 'UTF8');
	$tel_home_all = '+7 ('.$tel_home1.') '.$tel_home2.'-'.$tel_home3.'-'.$tel_home4;
	$tel_mobile = get_field('contacts-tel-mobile', $id_page); 
	$tel_mobile1 = mb_substr($tel_mobile, 1, 3, 'UTF8');
	$tel_mobile2 = mb_substr($tel_mobile, 4, 3, 'UTF8');
	$tel_mobile3 = mb_substr($tel_mobile, 7, 2, 'UTF8');
	$tel_mobile4 = mb_substr($tel_mobile, 9, 2, 'UTF8');
	$tel_mobile_all = '+7 ('.$tel_mobile1.') '.$tel_mobile2.'-'.$tel_mobile3.'-'.$tel_mobile4;
	echo '<a href="tel:+'.$tel_home.'">'.$tel_home_all.'</a>';
	echo '<a href="tel:+'.$tel_mobile.'">'.$tel_mobile_all.'</a>';
}
function contacts_address($param) {
	$id_page = 14;
	$address = get_field('contacts-address', $id_page);
	$address_2gis = get_field('contacts-2gis', $id_page);
	if ($param === 'contacts') {
		echo '<a href="'.$address_2gis.'" target="_blank" class="contacts__descr_address">'.$address.'</a>';
	}
	else if ($param === 'header') {
		echo '<a target="_blank" href="'.$address_2gis.'" class="header__menu_address"><span>'.$address.'</span></a>';
	}
	else if ($param === 'footer') {
		echo '<div class="footer__descr_address">'.$address.'</div>';
	}
	else if ($param === 'map') {
		echo $address;
	}
}
function contacts_messeng_social() {
	$id_page = 14;
	$socials = get_field('enable_display_social', $id_page);
	if ($socials) {
		if( $socials && in_array('whatsapp', $socials) ) {
			$whatsapp = get_field('whatsapp', $id_page);
			$whatsapp_cut = mb_substr($whatsapp, 1, 10, 'UTF8');
			echo '<a href="https://api.whatsapp.com/send?phone=+7'.$whatsapp_cut.'" class="whatsapp" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.9966 3.66797C11.2773 3.66862 9.59168 4.14426 8.1256 5.04241C6.65952 5.94055 5.47002 7.22629 4.68833 8.75776C3.90664 10.2892 3.56316 12.0069 3.69578 13.7212C3.82839 15.4356 4.43196 17.08 5.43987 18.473L4.27335 21.9403L7.8639 20.7923C9.07858 21.5936 10.4638 22.0998 11.9089 22.2703C13.354 22.4409 14.819 22.2711 16.1868 21.7745C17.5546 21.2779 18.7874 20.4683 19.7866 19.4103C20.7858 18.3523 21.5238 17.0754 21.9416 15.6813C22.3595 14.2873 22.4456 12.8148 22.193 11.3816C21.9405 9.94835 21.3564 8.59403 20.4873 7.4268C19.6181 6.25957 18.4882 5.31178 17.1875 4.65913C15.8869 4.00648 14.4517 3.66706 12.9966 3.66797ZM17.9566 16.8676L16.9628 17.8616C15.9176 18.907 13.1459 17.7566 10.6892 15.295C8.23252 12.8333 7.13133 10.0683 8.1252 9.03464L9.11908 8.04064C9.31154 7.86371 9.56341 7.76552 9.82482 7.76552C10.0862 7.76552 10.3381 7.86371 10.5306 8.04064L11.9957 9.5013C12.1152 9.61746 12.2028 9.76236 12.2502 9.92212C12.2977 10.0819 12.3033 10.2511 12.2665 10.4137C12.2297 10.5762 12.1518 10.7266 12.0403 10.8504C11.9287 10.9742 11.7873 11.0672 11.6294 11.1206C11.3966 11.195 11.2014 11.3564 11.0845 11.5711C10.9676 11.7858 10.938 12.0373 11.0018 12.2733C11.2631 13.37 12.6746 14.7303 13.7222 14.9916C13.9569 15.0409 14.2015 15.0038 14.411 14.8872C14.6206 14.7707 14.7811 14.5824 14.863 14.357C14.9158 14.1968 15.0093 14.0531 15.1342 13.9399C15.2591 13.8266 15.4112 13.7477 15.5758 13.7108C15.7403 13.6738 15.9115 13.6802 16.0729 13.7293C16.2342 13.7783 16.38 13.8684 16.4962 13.9906L17.959 15.456C18.1356 15.6487 18.2333 15.9008 18.2329 16.1623C18.2325 16.4237 18.1339 16.6754 17.9566 16.8676Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('viber', $socials) ) {
			$viber = get_field('viber', $id_page);
			$viber_cut = mb_substr($viber, 1, 10, 'UTF8');
			echo '<a href="viber://chat?number=+7'.$viber_cut.'" class="viber" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.0754 3.66797H10.9272C9.00195 3.66797 7.15553 4.4219 5.79416 5.7639C4.43278 7.1059 3.66797 8.92605 3.66797 10.8239V13.8908C3.66739 15.2454 4.0569 16.5725 4.79122 17.7175C5.52553 18.8626 6.57448 19.7787 7.81612 20.3592V23.7762C7.81735 23.8429 7.8383 23.9077 7.87639 23.9628C7.91449 24.0179 7.96806 24.0608 8.03055 24.0864C8.09304 24.1119 8.16172 24.1188 8.22817 24.1064C8.29463 24.094 8.35595 24.0627 8.40464 24.0164L11.4172 21.0467H15.0754C17.0007 21.0467 18.8471 20.2928 20.2084 18.9508C21.5698 17.6088 22.3346 15.7886 22.3346 13.8908V10.8239C22.3346 8.92605 21.5698 7.1059 20.2084 5.7639C18.8471 4.4219 17.0007 3.66797 15.0754 3.66797ZM17.7924 17.0803L16.7554 18.1026C15.6509 19.1683 12.768 17.9518 10.2272 15.3935C7.68649 12.8353 6.57167 9.96521 7.63464 8.89949L8.67167 7.87721C8.87492 7.69736 9.13918 7.59916 9.41229 7.602C9.6854 7.60484 9.9475 7.70851 10.1469 7.89254L11.6609 9.42596C11.7812 9.54828 11.8679 9.69874 11.9129 9.86319C11.9579 10.0276 11.9598 10.2007 11.9183 10.366C11.8768 10.5314 11.7934 10.6836 11.6758 10.8084C11.5582 10.9332 11.4103 11.0265 11.2461 11.0795C11.0027 11.1531 10.7974 11.3163 10.6728 11.5353C10.5483 11.7542 10.514 12.012 10.5772 12.2551C10.8365 13.3899 12.2987 14.8108 13.3876 15.0894C13.6331 15.1471 13.8915 15.1145 14.1144 14.9978C14.3372 14.8811 14.5093 14.6884 14.5983 14.4556C14.6559 14.2932 14.7548 14.1482 14.8856 14.0345C15.0165 13.9207 15.1748 13.8421 15.3454 13.8062C15.516 13.7702 15.6931 13.7782 15.8597 13.8292C16.0262 13.8803 16.1767 13.9728 16.2965 14.0978L17.808 15.6312C17.9895 15.831 18.0886 16.0905 18.0857 16.3587C18.0828 16.6269 17.9782 16.8843 17.7924 17.0803ZM13.945 8.5238C13.8419 8.52331 13.7388 8.52929 13.6365 8.54169C13.5914 8.54655 13.5457 8.54261 13.5022 8.53009C13.4586 8.51757 13.418 8.49671 13.3826 8.46871C13.3472 8.44071 13.3177 8.4061 13.2959 8.36688C13.2741 8.32766 13.2603 8.28458 13.2554 8.24012C13.2504 8.19565 13.2544 8.15065 13.2671 8.10771C13.2798 8.06476 13.301 8.0247 13.3294 7.98981C13.3578 7.95493 13.3929 7.9259 13.4327 7.90439C13.4725 7.88287 13.5162 7.86929 13.5613 7.86443C13.6887 7.84997 13.8168 7.84314 13.945 7.84398C14.8625 7.8433 15.7427 8.20177 16.3922 8.84058C17.0417 9.4794 17.4073 10.3463 17.4087 11.2507C17.4096 11.3771 17.4026 11.5034 17.388 11.629C17.383 11.6734 17.3693 11.7165 17.3474 11.7557C17.3256 11.795 17.2962 11.8296 17.2608 11.8576C17.2254 11.8856 17.1847 11.9064 17.1412 11.919C17.0976 11.9315 17.052 11.9354 17.0069 11.9305C16.9617 11.9257 16.918 11.9121 16.8783 11.8906C16.8385 11.8691 16.8034 11.84 16.775 11.8052C16.7466 11.7703 16.7254 11.7302 16.7127 11.6873C16.7 11.6443 16.696 11.5993 16.7009 11.5549C16.7122 11.4539 16.7183 11.3523 16.7191 11.2507C16.7177 10.5266 16.4247 9.83261 15.9046 9.32128C15.3844 8.80996 14.6796 8.52312 13.945 8.5238ZM16.0191 11.2507C16.0116 11.3361 15.9719 11.4156 15.9078 11.4736C15.8437 11.5315 15.7599 11.5636 15.673 11.5636C15.586 11.5636 15.5022 11.5315 15.4382 11.4736C15.3741 11.4156 15.3344 11.3361 15.3269 11.2507C15.3269 10.8895 15.1813 10.543 14.9221 10.2875C14.663 10.0321 14.3115 9.88854 13.945 9.88854C13.897 9.89264 13.8487 9.88686 13.8031 9.87157C13.7576 9.85629 13.7157 9.83183 13.6802 9.79975C13.6447 9.76767 13.6164 9.72866 13.597 9.68522C13.5776 9.64177 13.5676 9.59482 13.5676 9.54736C13.5676 9.49989 13.5776 9.45295 13.597 9.4095C13.6164 9.36605 13.6447 9.32704 13.6802 9.29496C13.7157 9.26288 13.7576 9.23842 13.8031 9.22314C13.8487 9.20785 13.897 9.20207 13.945 9.20617C14.4951 9.20617 15.0226 9.42158 15.4116 9.80501C15.8006 10.1884 16.0191 10.7085 16.0191 11.2507ZM18.6557 12.3573C18.6481 12.4038 18.6308 12.4482 18.6049 12.4878C18.5791 12.5274 18.5452 12.5613 18.5055 12.5874C18.4657 12.6135 18.421 12.6312 18.374 12.6395C18.3269 12.6478 18.2787 12.6464 18.2323 12.6355C18.1858 12.6246 18.1421 12.6043 18.104 12.576C18.0658 12.5477 18.034 12.512 18.0105 12.471C17.987 12.43 17.9723 12.3847 17.9673 12.3379C17.9624 12.2911 17.9672 12.2438 17.9817 12.1989C18.0565 11.89 18.094 11.5734 18.0932 11.2558C18.0932 10.1713 17.6561 9.13126 16.8782 8.3644C16.1003 7.59754 15.0452 7.16672 13.945 7.16672C13.8387 7.16672 13.7298 7.16672 13.6235 7.16672C13.5782 7.17008 13.5327 7.16461 13.4896 7.15063C13.4465 7.13665 13.4065 7.11443 13.3721 7.08524C13.3026 7.02628 13.2597 6.94252 13.2528 6.85237C13.2459 6.76222 13.2756 6.67307 13.3354 6.60453C13.3952 6.536 13.4802 6.49368 13.5717 6.48691C13.6961 6.47668 13.8206 6.47157 13.945 6.47157C15.2295 6.4736 16.4606 6.97802 17.3681 7.87406C18.2757 8.77011 18.7854 9.98454 18.7854 11.2507C18.7855 11.6233 18.742 11.9946 18.6557 12.3573Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('telegram', $socials) ) {
			$telegram = get_field('telegram', $id_page);
			echo '<a href="https://t.me/'.$telegram.'" class="telegram" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M2.15308 12.569L21.4364 5.13397C22.3314 4.81063 23.1131 5.3523 22.8231 6.70563L22.8247 6.70397L19.5414 22.1723C19.2981 23.269 18.6464 23.5356 17.7347 23.019L12.7347 19.334L10.3231 21.6573C10.0564 21.924 9.83141 22.149 9.31475 22.149L9.66975 17.0606L18.9364 8.68897C19.3397 8.33397 18.8464 8.13397 18.3147 8.4873L6.86308 15.6973L1.92641 14.1573C0.854747 13.8173 0.831414 13.0856 2.15308 12.569V12.569Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('instagram', $socials) ) {
			$instagram = get_field('instagram', $id_page);
			echo '<a href="https://www.instagram.com/'.$instagram.'" class="instagram" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M21.6832 16.9042C21.6832 18.1717 21.1797 19.3872 20.2835 20.2835C19.3872 21.1797 18.1717 21.6832 16.9042 21.6832H9.09371C7.82625 21.6832 6.61071 21.1797 5.71448 20.2835C4.81826 19.3872 4.31476 18.1717 4.31476 16.9042V9.09371C4.31476 7.82625 4.81826 6.61071 5.71448 5.71448C6.61071 4.81826 7.82625 4.31476 9.09371 4.31476H16.9042C18.1717 4.31476 19.3872 4.81826 20.2835 5.71448C21.1797 6.61071 21.6832 7.82625 21.6832 9.09371V16.9042ZM16.8385 9.19904L16.7885 9.14904L16.7464 9.10694C15.7514 8.11538 14.4038 7.55891 12.999 7.55957C12.2897 7.56439 11.5882 7.70893 10.9347 7.98494C10.2812 8.26094 9.68854 8.663 9.19049 9.16814C8.69243 9.67328 8.29879 10.2716 8.03205 10.9289C7.7653 11.5862 7.63069 12.2897 7.63589 12.999C7.63481 14.4387 8.20228 15.8204 9.21483 16.8438C9.7108 17.3458 10.3018 17.744 10.9533 18.0151C11.6049 18.2861 12.3039 18.4247 13.0096 18.4227C14.0681 18.4005 15.0973 18.0708 15.9716 17.4737C16.846 16.8766 17.5277 16.0381 17.9336 15.0602C18.3395 14.0824 18.4521 13.0075 18.2577 11.9668C18.0632 10.926 17.5701 9.96436 16.8385 9.19904ZM12.999 16.5675C12.2912 16.5774 11.5965 16.3766 11.0031 15.9905C10.4097 15.6045 9.94459 15.0507 9.66682 14.3996C9.38905 13.7485 9.31121 13.0295 9.4432 12.334C9.57519 11.6386 9.91105 10.9981 10.4081 10.494C10.9051 9.98994 11.5407 9.64508 12.2343 9.50329C12.9278 9.3615 13.6479 9.42919 14.3028 9.69774C14.9578 9.96629 15.5181 10.4236 15.9124 11.0114C16.3068 11.5993 16.5174 12.2912 16.5175 12.999C16.5209 13.4644 16.4327 13.9259 16.2577 14.3572C16.0827 14.7884 15.8245 15.181 15.4977 15.5124C15.171 15.8437 14.7821 16.1075 14.3534 16.2885C13.9246 16.4696 13.4644 16.5644 12.999 16.5675ZM19.861 7.80235C19.9244 7.64584 19.9563 7.47836 19.955 7.30949C19.9561 7.0106 19.8538 6.72051 19.6655 6.48844L19.6365 6.45686C19.602 6.41442 19.5632 6.37562 19.5207 6.34107L19.4944 6.31476C19.2663 6.12428 18.9785 6.01996 18.6813 6.02002C18.4273 6.0242 18.1802 6.10283 17.9705 6.24615C17.7609 6.38947 17.5979 6.59118 17.5018 6.82626C17.4056 7.06135 17.3807 7.31948 17.4299 7.56864C17.4791 7.8178 17.6004 8.04703 17.7786 8.22791C17.8963 8.34705 18.0364 8.44166 18.1909 8.50625C18.3454 8.57085 18.5112 8.60415 18.6786 8.60423C18.8475 8.6032 19.0145 8.56887 19.1701 8.50321C19.3257 8.43755 19.4668 8.34185 19.5853 8.22159C19.7039 8.10133 19.7976 7.95886 19.861 7.80235Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('vk', $socials) ) {
			$vk = get_field('vk', $id_page);
			echo '<a href="'.$vk.'" class="vk" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M24.7374 20.306L21.2874 20.3533C21.2874 20.3533 20.5453 20.5007 19.5716 19.827C18.2795 18.9401 17.0637 16.6375 16.1164 16.9322C15.169 17.2269 15.1848 19.3007 15.1848 19.3007C15.1879 19.5439 15.1132 19.7818 14.9717 19.9797C14.7726 20.1503 14.5269 20.2575 14.2665 20.2876H12.7375C12.7375 20.2876 9.31646 20.4902 6.32959 17.3691C3.04537 13.9797 0.153257 7.20857 0.153257 7.20857C0.153257 7.20857 -0.0170544 6.81583 0.169039 6.55068C0.329899 6.32146 0.726616 6.29685 0.926928 6.28755C1.79044 6.24716 4.38482 6.26388 4.38482 6.26388C4.60185 6.25849 4.74771 6.26989 5.01638 6.38755C5.24732 6.50169 5.42247 6.67169 5.53482 6.94544C5.93396 7.93935 6.39724 8.9063 6.9217 9.84021C8.4638 12.506 9.18224 13.0876 9.70591 12.8033C10.4665 12.3876 10.2322 9.03755 10.2322 9.03755C10.2322 9.03755 10.2322 7.81911 9.84802 7.27966C9.5588 6.94177 9.15092 6.72794 8.70857 6.68232C8.50068 6.65333 8.84279 6.17177 9.2849 5.95599C9.94802 5.62966 11.1218 5.62966 12.5059 5.62966C13.1151 5.60669 13.7244 5.66872 14.3165 5.81388C15.5901 6.12177 15.1586 7.30599 15.1586 10.1533C15.1586 11.0639 14.9928 12.3481 15.6507 12.7849C15.9349 12.9665 16.6243 12.8112 18.3559 9.87435C18.9083 8.90247 19.3877 7.89099 19.7901 6.84802C19.8676 6.68224 19.9852 6.53849 20.1322 6.42958C20.2877 6.35216 20.4625 6.322 20.6349 6.34271L24.5191 6.31638C24.5191 6.31638 25.6849 6.17693 25.8743 6.70583C26.0638 7.23482 25.4375 8.54794 23.8507 10.6532C21.2454 14.1268 20.9559 13.8111 23.1191 15.8084C25.1849 17.7268 25.6139 18.6611 25.6849 18.7768C26.5426 20.1929 24.7374 20.306 24.7374 20.306Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('facebook', $socials) ) {
			$facebook = get_field('facebook', $id_page);
			echo '<a href="'.$facebook.'" class="facebook" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.4842 14.3596H7.86844C7.45792 14.3596 7.31055 14.2096 7.31055 13.7965C7.31055 12.7316 7.31055 11.6675 7.31055 10.6044C7.31055 10.1939 7.46581 10.0386 7.87107 10.0386H10.4842V7.73596C10.4532 6.70165 10.7014 5.67807 11.2027 4.77281C11.7237 3.85888 12.5587 3.16507 13.5527 2.82018C14.1977 2.58548 14.8794 2.46784 15.5658 2.47281H18.1527C18.5237 2.47281 18.679 2.63596 18.679 2.99912V6.00175C18.679 6.37807 18.5211 6.52807 18.1527 6.52807C17.4448 6.52807 16.7369 6.52807 16.0316 6.55702C15.3263 6.58597 14.9421 6.90702 14.9421 7.64386C14.9263 8.43333 14.9421 9.20702 14.9421 10.0123H17.9816C18.4132 10.0123 18.5605 10.1596 18.5605 10.5939C18.5605 11.6465 18.5605 12.7044 18.5605 13.7675C18.5605 14.1965 18.4237 14.3307 17.9895 14.3333H14.9263V22.8965C14.9263 23.3544 14.7842 23.4991 14.3316 23.4991H11.0369C10.6395 23.4991 10.4842 23.3439 10.4842 22.9465V14.3596Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('ok', $socials) ) {
			$ok = get_field('ok', $id_page);
			echo '<a href="'.$ok.'" class="ok" target="_blank"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13 2.47266C11.9497 2.47266 10.9229 2.78411 10.0496 3.36764C9.1763 3.95117 8.49564 4.78056 8.0937 5.75093C7.69175 6.7213 7.58659 7.78907 7.7915 8.81922C7.9964 9.84936 8.50218 10.7956 9.24487 11.5383C9.98756 12.281 10.9338 12.7868 11.964 12.9917C12.9941 13.1966 14.0619 13.0914 15.0322 12.6895C16.0026 12.2875 16.832 11.6069 17.4155 10.7336C17.9991 9.86024 18.3105 8.83351 18.3105 7.78318C18.3109 7.0857 18.1737 6.39498 17.907 5.75052C17.6402 5.10607 17.2491 4.5205 16.7559 4.0273C16.2627 3.53411 15.6771 3.14295 15.0326 2.87619C14.3882 2.60944 13.6975 2.47231 13 2.47266V2.47266ZM13 10.4306C12.4764 10.4306 11.9645 10.2753 11.5292 9.98439C11.0938 9.69349 10.7545 9.28003 10.5541 8.79629C10.3538 8.31254 10.3013 7.78025 10.4035 7.26671C10.5056 6.75317 10.7578 6.28145 11.128 5.91121C11.4983 5.54097 11.97 5.28883 12.4835 5.18668C12.997 5.08453 13.5293 5.13696 14.0131 5.33733C14.4968 5.53771 14.9103 5.87703 15.2012 6.31238C15.4921 6.74774 15.6474 7.25958 15.6474 7.78318C15.6477 8.13094 15.5795 8.47535 15.4465 8.7967C15.3136 9.11805 15.1186 9.41003 14.8727 9.65593C14.6268 9.90183 14.3348 10.0968 14.0135 10.2297C13.6921 10.3627 13.3477 10.4309 13 10.4306Z" fill="#F1F1F1"></path><path d="M20.8275 13.9087C20.7118 13.7023 20.5566 13.5206 20.3707 13.3742C20.1849 13.2278 19.9719 13.1195 19.7441 13.0554C19.5163 12.9914 19.2781 12.9729 19.0432 13.001C18.8082 13.0291 18.5811 13.1033 18.3748 13.2193C14.759 15.2456 11.2433 15.2456 7.62747 13.2193C7.42011 13.1035 7.19199 13.0297 6.95612 13.0021C6.72025 12.9745 6.48125 12.9936 6.25277 13.0584C6.02429 13.1231 5.8108 13.2322 5.62449 13.3795C5.43819 13.5268 5.28271 13.7093 5.16694 13.9166C5.05117 14.124 4.97737 14.3521 4.94976 14.588C4.92215 14.8238 4.94127 15.0628 5.00603 15.2913C5.13681 15.7528 5.44554 16.1434 5.86431 16.3772C7.05051 17.0504 8.31776 17.5695 9.63536 17.9219L7.07746 20.4798C6.74144 20.8159 6.55267 21.2717 6.55267 21.7469C6.55267 22.2221 6.74144 22.6779 7.07746 23.014C7.41354 23.35 7.86933 23.5388 8.34457 23.5388C8.81981 23.5388 9.2756 23.35 9.61168 23.014L13.0011 19.6114L16.3906 23.0008C16.7267 23.3369 17.1825 23.5256 17.6577 23.5256C18.133 23.5256 18.5888 23.3369 18.9248 23.0008C19.2609 22.6648 19.4496 22.209 19.4496 21.7337C19.4496 21.2585 19.2609 20.8027 18.9248 20.4666L16.3669 17.9087C17.6845 17.5563 18.9518 17.0372 20.138 16.364C20.3448 16.2484 20.5267 16.0931 20.6734 15.907C20.82 15.7209 20.9285 15.5076 20.9925 15.2795C21.0566 15.0514 21.075 14.8129 21.0467 14.5777C21.0183 14.3424 20.9438 14.1151 20.8275 13.9087V13.9087Z" fill="#F1F1F1"></path></svg></a>';
		}
		if( $socials && in_array('youtube', $socials) ) {
			$youtube = get_field('youtube', $id_page);
			echo '<a class="youtube" target="_blank" href="'.$youtube.'"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.5437 5.47656H6.45424C5.93115 5.47656 5.41318 5.57964 4.92994 5.77989C4.4467 5.98015 4.00766 6.27367 3.6379 6.64367C3.26815 7.01367 2.97492 7.45291 2.77498 7.93628C2.57504 8.41965 2.47231 8.93768 2.47266 9.46077V16.5397C2.47231 17.0628 2.57504 17.5808 2.77498 18.0642C2.97492 18.5476 3.26815 18.9868 3.6379 19.3568C4.00766 19.7268 4.4467 20.0203 4.92994 20.2206C5.41318 20.4209 5.93115 20.5239 6.45424 20.5239H19.5437C20.0668 20.5239 20.5848 20.4209 21.068 20.2206C21.5512 20.0203 21.9903 19.7268 22.36 19.3568C22.7298 18.9868 23.023 18.5476 23.223 18.0642C23.4229 17.5808 23.5256 17.0628 23.5253 16.5397V9.46077C23.5256 8.93768 23.4229 8.41965 23.223 7.93628C23.023 7.45291 22.7298 7.01367 22.36 6.64367C21.9903 6.27367 21.5512 5.98015 21.068 5.77989C20.5848 5.57964 20.0668 5.47656 19.5437 5.47656V5.47656ZM10.2253 16.2266V9.77393L15.7727 13.0002L10.2253 16.2266Z" fill="#F1F1F1"></path></svg></a>';
		}
	}
}

function contacts_work_time() {
	$id_page = 14;
	if (get_field('contacts-work-time', $id_page)) {
		while (has_sub_field('contacts-work-time', $id_page)) {
			$work_time = get_row_layout();
			if($work_time === 'contacts-time-pn-pt') {
				echo 'Пн-Пт: ';
				the_sub_field('contacts-time-pn-pt_text');
			}
			if($work_time === 'contacts-time-sb-vs') {
				echo '<br>Сб-Вс: ';
				the_sub_field('contacts-time-sb-vs_text');
			}
			if($work_time === 'contacts-time-pn-vs') {
				echo 'Пн-Вс: ';
				the_sub_field('contacts-time-pn-vs_text');
			}
			if($work_time === 'contacts-time-sb') {
				echo '<br>Сб: ';
				the_sub_field('contacts-time-sb_text');
			}
			if($work_time === 'contacts-time-vs') {
				echo '<br>Вс: ';
				the_sub_field('contacts-time-vs_text');
			}
		}
	 }
}
function services_stages() {
	$id_page = 22;
    $stages = get_field('services', $id_page);
    if($stages) {
        $count = 1;
        foreach($stages as $stage) {
            $stage_title = $stage['services-title'];
            $stage_subtitle = $stage['services-subtitle'];
            echo '<div class="content__item"><div class="content__item_count">0'.$count.'</div><div><div class="content__item_title">'.$stage_title.'</div><div class="content__item_text">'.$stage_subtitle.'</div></div></div>';
            $count++;
        }
    }
}
// -------------------------- КОНЕЦ ГРУППЫ ПОЛЕЙ ACF --------------------------

// -------------------------- НАЧАЛО ПОРТФОЛИО --------------------------
add_action( 'init', 'register_post_types' );
function register_post_types(){
	register_post_type( 'portfolio', [
		'label'  => null,
		'labels' => [
			'name'               => 'Портфолио', // основное название для типа записи
			'singular_name'      => 'Наши работы', // название для одной записи этого типа
			'add_new'            => 'Добавить работу', // для добавления новой записи
			'add_new_item'       => 'Добавление работы', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование работы', // для редактирования типа записи
			'new_item'           => 'Новая работа', // текст новой записи
			'view_item'          => 'Смотреть работу', // для просмотра записи этого типа.
			'search_items'       => 'Искать работу в портфолио', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Портфолио', // название меню
		],
		'description'            => 'Это наши работы в портфолио',
		'public'                 => true,
		// 'publicly_queryable'  => null, // зависит от public
		// 'exclude_from_search' => null, // зависит от public
		// 'show_ui'             => null, // зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
		'show_in_menu'           => null, // показывать ли в меню админки
		// 'show_in_admin_bar'   => null, // зависит от show_in_menu
		'show_in_rest'        => null, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 4,
		'menu_icon'           => 'dashicons-grid-view',
		//'capability_type'   => 'post',
		//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
		//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => false,
		'rewrite'             => true,
		'query_var'           => true,
	] );
}
function portfolio_block(){ ?>
	<section class="last-works">
		<div class="container">
			<div class="last-works__descr">
				<h2 class="h1 last-works__descr_title">Фотогалерея последних работ</h2>
				<div class="last-works__descr_nav">
					<div class="swiper-button-prev last-work-prev"></div>
					<div class="swiper-button-next last-work-next"></div>
				</div>
			</div>
		</div>
		<div class="last-work">
			<div class="swiper last-work-swiper">
				<div class="last-work__wrapper swiper-wrapper">
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
					foreach( $my_posts as $post ){
						setup_postdata( $post ); ?>
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
								<p class="card-work__text"><span>Объём парной:</span>&nbsp;<span><?echo get_field('portfolio-volume');?>&nbsp;м<sup>3</sup></span></p>
								<p class="card-work__text"><span>Местоположение:</span>&nbsp;<span><?echo get_field('portfolio-location');?></span></p>
						</a> 
					<?
					}
					wp_reset_postdata(); // сброс ?>

				</div>
			</div>
		</div>
		<a href="<?echo get_permalink(532);?>" class="btn">Смотреть все работы</a>
	</section>
<?
}


// -------------------------- КОНЕЦ ПОРТФОЛИО --------------------------


//Сортировка категорий по всем/только родитель
/*
add_action( 'restrict_manage_posts', 'wcacd_category_dropdown', 15 );
function wcacd_category_dropdown() {
	// show the old dropdown category filter from WC 3.1.2
	wc_product_dropdown_categories( array( 'option_select_text' => __( 'Filter by category', 'woocommerce' ) ) );
	
	// hide the WC 3.2+ ajax category filter
	print '<style>.post-type-product .tablenav div .select2 {display:none;}</style>';
}

$taxonomy = 'product_cat';
add_action( "{$taxonomy}_add_form", function($taxonomy){
	ob_start();
} );

add_action( "after-{$taxonomy}-table", function($taxonomy){
	$html = ob_get_clean();

	$__preg_replace_callback = function( $match ){
		$val = @ $_GET['parent_only'];
		ob_start();
		?>
		<div class="alignleft actions">
			<select name="parent_only" onchange="window.add_param_to_URL(this)">
				<option value="">Все уровни...</option>
				<option value="yes" <? selected('yes', $val) ?> >Только родители</option>
			</select>
		</div>
		<script>
		window.add_param_to_URL = function(el){
			var href = window.location.href, sep = /[?]/.test(href) ? "&" : "?", name = el.name.replace(/[^a-z_-]/i,'');
			window.location = (new RegExp(name+'=?')).test(href) ? href.replace( (new RegExp('([?&]'+name+'=?)[^&]*')), (el.value ? "$1"+ el.value : '') ) : (href + sep + name + "="+ el.value);
		}
		</script>
		<?
		return $match[1] . ob_get_clean();
	};

	echo preg_replace_callback('~(id="doaction[^<]+</div>)~', $__preg_replace_callback, $html );
} );


add_filter('get_terms_args', 'my_terms_filter_handler');
function my_terms_filter_handler( $query ){
	if( empty($_GET['parent_only']) || ! is_admin() ) return $query;
	if( ! ( $query['fields'] == 'count' || isset($query['page'])  ) )
		 return $query;
	$query['parent'] = 0; // только родители
	return $query;
}

*/


//Скрываем пункты меню Advanced Custom Fields
//add_filter('acf/settings/show_admin', '__return_false');

add_filter( 'woocommerce_product_data_tabs', 'truemisha_new_tab' );
 
function truemisha_new_tab( $tabs ){
	unset($tabs['shipping']); // Доставка
	unset($tabs['advanced']); // Дополнительно
	unset($tabs['linked_product']);

	// $tabs['general']['priority'] = 10;
	// $tabs['general']['label'] = 'Цены';
	
	$tabs['attribute']['priority'] = 20;
	$tabs['attribute']['label'] = 'Характеристики';

	// $tabs['linked_product']['priority'] = 30;
	// $tabs['linked_product']['label'] = 'Предложить доп. товары';

	$tabs['inventory']['priority'] = 40;
	$tabs['inventory']['label'] = 'Артикул';

	return $tabs;
}


//Добавляет возможность добавления атрибутов из woo в меню wp
$show_in_nav_menus = apply_filters('woocommerce_attribute_show_in_nav_menus', false, $name);
add_filter('woocommerce_attribute_show_in_nav_menus', 'wc_reg_for_menus', 1, 2);
function wc_reg_for_menus( $register, $name = '' ) {
 if ( $name == 'pa_proizvoditel' ) $register = true;
 return $register;
}


//Удаляем category из УРЛа категорий
add_filter( 'category_link', function($a){
	return str_replace( 'category/', '', $a );
}, 99 );

add_action( 'wp_loaded', function(){
	$is_new = version_compare( $GLOBALS['wp_version'], '5.3.0', '>=' );
	if( $is_new )  add_filter( 'wp_date', 'russify_months', 11, 2 );   // WP 5.3
	else           add_filter( 'date_i18n', 'russify_months', 11, 2 ); // WP < 5.3
});

function russify_months( $date, $req_format ){
	// в формате есть "строковые" неделя или месяц. выходим, если в формате есть экранированные символы
	if( false !== strpos( $req_format, '\\') || ! preg_match('/[FMlS]/', $req_format ) || determine_locale() !== 'ru_RU'  )
		return $date;
	$date = strtr( $date, [
		'Январь'=>'января', 'Февраль'=>'февраля', 'Март'=>'марта', 'Апрель'=>'апреля', 'Май'=>'мая', 'Июнь'=>'июня', 'Июль'=>'июля', 'Август'=>'августа', 'Сентябрь'=>'сентября', 'Октябрь'=>'октября', 'Ноябрь'=>'ноября', 'Декабрь'=>'декабря',
		'Янв'=>'янв.', 'Фев'=>'фев.', 'Мар'=>'март', 'Апр'=>'апр.', 'Июн'=>'июнь', 'Июл'=>'июль', 'Авг'=>'авг.', 'Сен'=>'сен.', 'Окт'=>'окт.', 'Ноя'=>'ноя.', 'Дек'=>'дек.',
		'January'=>'января', 'February'=>'февраля', 'March'=>'марта', 'April'=>'апреля', 'May'=>'мая', 'June'=>'июня', 'July'=>'июля', 'August'=>'августа', 'September'=>'сентября', 'October'=>'октября', 'November'=>'ноября', 'December'=>'декабря',
		'Jan'=>'янв.', 'Feb'=>'фев.', 'Mar'=>'март.', 'Apr'=>'апр.', 'Jun'=>'июня', 'Jul'=>'июля', 'Aug'=>'авг.', 'Sep'=>'сен.', 'Oct'=>'окт.', 'Nov'=>'нояб.', 'Dec'=>'дек.',
		'Sunday'=>'воскресенье', 'Monday'=>'понедельник', 'Tuesday'=>'вторник', 'Wednesday'=>'среда', 'Thursday'=>'четверг', 'Friday'=>'пятница', 'Saturday'=>'суббота',
		'Sun'=>'вос.', 'Mon'=>'пон.', 'Tue'=>'вт.', 'Wed'=>'ср.', 'Thu'=>'чет.', 'Fri'=>'пят.', 'Sat'=>'суб.', 'th'=>'', 'st'=>'', 'nd'=>'', 'rd'=>'',
	] );
	return $date;
}



//Дубликат постов post wp
add_action( 'admin_action_true_duplicate_post_as_draft', 'true_duplicate_post_as_draft' );
function true_duplicate_post_as_draft(){
 
	if( empty( $_GET[ 'post' ] ) ) {
		wp_die( 'Нечего дублировать!' );
	}
 
	// проверка одноразовых чисел, куда без неё
	if ( ! isset( $_GET[ 'true_duplicate_nonce' ] ) || ! wp_verify_nonce( $_GET[ 'true_duplicate_nonce' ], basename( __FILE__ ) ) ) {
		return;
	}
 
	// получаем ID оригинального поста
	$post_id = absint( $_GET[ 'post' ] );
 
	// затем получили объект поста
	$post = get_post( $post_id );
 
	/*
	 * если вы не хотите, чтобы текущий автор был автором нового поста
	 * тогда замените следующие две строчки на: $new_post_author = $post->post_author;
	 * при замене этих строк автор будет копироваться из оригинального поста
	 */
	$current_user = wp_get_current_user();
	$new_post_author = $current_user->ID;
 
	/*
	 * если пост существует, создаем его дубликат
	 */
	if ( $post ) {
 
		// массив данных нового поста
		$args = array(
			'comment_status' => $post->comment_status,
			'ping_status'    => $post->ping_status,
			'post_author'    => $new_post_author,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_parent'    => $post->post_parent,
			'post_name'      => $post->post_name,
			'post_password'  => $post->post_password,
			'post_status'    => 'draft', // черновик, если хотите сразу публиковать - замените на publish
			'post_title'     => $post->post_title,
			'post_type'      => $post->post_type,
			'to_ping'        => $post->to_ping,
			'menu_order'     => $post->menu_order
		);
 
		// создаем пост при помощи функции wp_insert_post()
		$new_post_id = wp_insert_post( $args );
 
		// присваиваем новому посту все элементы таксономий (рубрики, метки и т.д.) старого
		$taxonomies = get_object_taxonomies( $post->post_type ); // возвращает массив названий таксономий, используемых для указанного типа поста, например array("category", "post_tag");
		foreach ( $taxonomies as $taxonomy ) {
			$post_terms = wp_get_object_terms( $post_id, $taxonomy, array( 'fields' => 'slugs' ) );
			wp_set_object_terms( $new_post_id, $post_terms, $taxonomy, false );
		}
 
		// дублируем все произвольные поля
		$post_meta = get_post_meta( $post_id );
		if( $post_meta ) {
			foreach ( $post_meta as $meta_key => $meta_values ) {
				if( '_wp_old_slug' == $meta_key ) { // это лучше не трогать
					continue;
				}
				foreach ( $meta_values as $meta_value ) {
					add_post_meta( $new_post_id, $meta_key, $meta_value );
				}
			}
		}
 
		// и наконец, перенаправляем пользователя на страницу редактирования нового поста
		wp_safe_redirect( add_query_arg( array( 'action' => 'edit', 'post' => $new_post_id ), admin_url( 'post.php' ) ) );
		exit;
	} else {
		wp_die( 'Ошибка создания поста, не могу найти оригинальный пост с ID=: ' . $post_id );
	}
}
 

 
// Добавляем ссылку дублирования поста для post_row_actions
add_filter( 'post_row_actions', 'true_duplicate_post_link', 10, 2 );
function true_duplicate_post_link( $actions, $post ) {
	if ( current_user_can( 'edit_posts' ) ) {
		$actions[ 'duplicate' ] = '<a href="' . wp_nonce_url( add_query_arg( array( 'action' => 'true_duplicate_post_as_draft', 'post' => $post->ID ), 'admin.php' ), basename(__FILE__), 'true_duplicate_nonce' ) . '">Дублировать</a>';
	}
	return $actions;
}


add_filter('single_template', 'my_single_template');
function my_single_template($single) {
	global $wp_query, $post;
	foreach((array)get_the_category() as $cat) {
		if(file_exists(get_template_directory() . '/single-' . $cat->slug . '.php')) {
			return get_template_directory() . '/single-' . $cat->slug . '.php';
		} elseif(file_exists('/single-' . $cat->term_id . '.php')) {
			return get_template_directory() . '/single-' . $cat->term_id . '.php';
		}
	}
	return $single;
}

add_filter( 'register_post_type_args', 'filter_function_name_8795', 10, 2 );
function filter_function_name_8795( $args, $post_type ){
	if ( 'post' == $post_type ) {
		$args['menu_icon'] = 'dashicons-megaphone'; //смена иконки
		$args['labels'] = [
			'name'                  => 'Посты',
			'singular_name'         => 'Пост',
			'add_new'               => 'Добавить пост',
			'add_new_item'          => 'Добавить пост',
			'edit_item'             => 'Редактировать пост',
			'new_item'              => 'Новый пост',
			'view_item'             => 'Просмотреть пост',
			'search_items'          => 'Поиск постов',
			'not_found'             => 'Постов не найдено.',
			'not_found_in_trash'    => 'Постов в корзине не найдено.',
			'parent_item_colon'     => '',
			'all_items'             => 'Все посты',
			'archives'              => 'Архивы постов',
			'insert_into_item'      => 'Вставить в пост',
			'uploaded_to_this_item' => 'Загруженные для этого поста',
			'featured_image'        => 'Миниатюра поста',
			'filter_items_list'     => 'Фильтровать список постов',
			'items_list_navigation' => 'Навигация по списку постов',
			'items_list'            => 'Список постов',
			'menu_name'             => 'Посты',
			'name_admin_bar'        => 'Пост', // пункте "добавить"
		];
	}

	return $args;
}

//Скрываем пункты меню в админке
add_action('admin_menu', 'remove_admin_menu');
function remove_admin_menu()
{
  remove_menu_page('edit-comments.php'); // Комментарии
  remove_menu_page('marketing'); // Комментарии
}


//Скрытые пункта меню маркетинг в woo
add_filter( 'woocommerce_admin_features', function( $features ) {
    return array_values(
        array_filter( $features, function($feature) {
            return $feature !== 'marketing';
        } ) 
    );
});

//Скрытие submenu
add_action('admin_menu', 'remove_submenus');
function remove_submenus() {
	global $submenu;
	unset($submenu['edit.php?post_type=product'][16]); //скрытие меток woo
	unset($submenu['edit.php?post_type=product'][18]); //отзывы woo
	unset($submenu['edit.php'][15]);
	unset($submenu['edit.php'][16]);

}


add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
 
function my_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	wp_add_dashboard_widget('custom_help_widget', 'Поддержка Вашего сайта', 'custom_dashboard_help');
}

function custom_dashboard_help() {
	echo '<p>Добро пожаловать в админ-панель управления Вашим Интернет-магазином.<br>Сайт разработан студией <a href="https://weblitex.ru" target="_blank">ООО "Лайтекс"</a>. Нужна помощь, доработка функционала?<br> Свяжитесь с нами <a href="mailto:info@weblitex.ru">info@weblitex.ru</a></p>';
}

//Footer в админке
add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin () {
	echo 'Разработка Интернет-магазинов <a href="https://weblitex.ru" target="_blank">ООО "Лайтекс"</a> | E-mail: <a href="mailto:info@weblitex.ru">info@weblitex.ru</a> | Сайт разработан на основе WordPress.</p>
	<style>
		#category-adder.wp-hidden-children, #advanced-sortables, .inventory_sold_individually, #tagsdiv-product_tag, #woocommerce-product-data .product-data-wrapper, #postdivrich .wp-media-buttons {display:none !important;}
	</style>';
}


add_filter( 'manage_edit-product_columns', 'change_columns_woo',10, 1 );
function change_columns_woo($columns) {
	unset($columns['thumb']);
	unset($columns['name'] );
	unset($columns['sku'] );
	unset($columns['is_in_stock']);
	unset($columns['price']);
	unset($columns['product_cat'] );
	unset($columns['product_tag']);
	unset($columns['featured']);
	unset($columns['product_type']);
	unset($columns['date']);
	$columns['name'] = 'Имя товара';
	$columns['thumb'] = 'Превью';
	$columns['product_cat'] = 'Категория';
	$columns['price'] = 'Цена';
	$columns['sku'] = 'Артикул';
	//$columns['is_in_stock'] = 'Запасы';
	return $columns;
}

add_filter( 'manage_posts_columns', 'change_columns_wp', 10, 2 );
function change_columns_wp($columns, $post_type) {
	if ( 'post' === $post_type ) {
		unset($columns['author']);
		unset($columns['tags']);
		unset($columns['comments']);
		$columns['title'] = 'Название поста';
		$columns['categories'] = 'Категория';
	}
	return $columns;
}
//Функция просмотра подпунктов меню
// add_action('admin_menu', 'remove_submenus');
// function remove_submenus() {
// 	global $submenu;
// 	echo '<pre style="margin-left:200px;">';
// 	var_dump($submenu);
// 	echo '</pre>';
// }
  

add_action( 'init', 'true_remove_woo_image_sizes', 999 ); // отключение ненужных размеров img WP (это все нужно в конце func.php!)
function true_remove_woo_image_sizes() {
	remove_image_size( 'woocommerce_single' );
	remove_image_size( 'shop_single' );
	remove_image_size( '1536x1536' );
	remove_image_size( '2048x2048' );
	remove_image_size( 'woocommerce_thumbnail' );
	remove_image_size( 'shop_catalog' );
 	remove_image_size( 'woocommerce_gallery_thumbnail' );
	remove_image_size( 'shop_thumbnail' );
	remove_image_size( 'large' );
	remove_image_size( 'thumbnail' );
	remove_image_size( 'medium' );
	remove_image_size( 'medium_large' );
}

add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' ); // удаляем все неиспользуемые размеры img WP (это все нужно в конце func.php!)
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'thumbnail',
		'medium',
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// ------------------ НАЧАЛО ПОИСК ------------------
//Заменяем иконку svg от плагина на своё
add_filter('aws_searchbox_markup', 'replace_svg_markup', 10, 2 );
function replace_svg_markup($markup, $params) {
	$pattern = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
    $new_icon = '<svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
	<path d="M26.8501 25.6413L22.2363 21.0275C23.1383 19.8689 23.6804 18.4187 23.6804 16.8403C23.6804 13.0687 20.6117 10 16.8401 10C13.0685 10 9.99976 13.0687 9.99976 16.8403C9.99976 20.6119 13.0685 23.6807 16.8401 23.6807C18.4185 23.6807 19.8686 23.1386 21.0272 22.2374L25.641 26.8512C25.8078 27.017 26.0267 27.1008 26.2455 27.1008C26.4644 27.1008 26.6833 27.017 26.8501 26.8503C27.1844 26.516 27.1844 25.9756 26.8501 25.6413ZM11.7098 16.8403C11.7098 14.011 14.0108 11.7101 16.8401 11.7101C19.6694 11.7101 21.9703 14.011 21.9703 16.8403C21.9703 19.6697 19.6694 21.9706 16.8401 21.9706C14.0108 21.9706 11.7098 19.6697 11.7098 16.8403Z" fill="#999999"></path></svg>';
	$markup = str_replace($pattern, $new_icon, $markup);
    return $markup;
}

//Указываем свой класс куда выводить результат поиска
add_action( 'wp_enqueue_scripts', 'aws_wp_enqueue_scripts', 999 );
function aws_wp_enqueue_scripts() {
    $script = "
        function aws_results_append_to( container, options  ) {
            return '.search';
        }
        AwsHooks.add_filter( 'aws_results_append_to', aws_results_append_to );
    ";
    wp_add_inline_script( 'aws-script', $script);
    wp_add_inline_script( 'aws-pro-script', $script);
}

// ------------------ КОНЕЦ ПОИСК ------------------

// ------------------------- НАЧАЛО ДОПОЛНИТЕЛЬНЫЕ НУЖНЫЕ ИЗМЕНЕНИЯ, КОТОРЫЕ ДОЛЖНЫ НАХОДИТЬСЯ В КОНЦЕ ФАЙЛА -------------------------

//Удаляем уведомление об обновлении WordPress для всех кроме админа
add_action( 'admin_head', function () {
	if ( ! current_user_can( 'manage_options' ) ) {
		remove_action( 'admin_notices', 'update_nag', 3 );
		remove_action( 'admin_notices', 'maintenance_nag', 10 );
	}
} );

//удаляем мета-тег версии движка с DOM дерева
add_filter('the_generator', 'remove_wpversion');
function remove_wpversion() {
	return '';
}

//удаление ненужных текстов в DOM дереве(type для css)
add_filter('style_loader_tag', 'clean_style_tag');
function clean_style_tag($src) {
    return str_replace("type='text/css'", '', $src);
}

// //удаление ненужных текстов в DOM дереве(type для js)
add_filter('script_loader_tag', 'clean_script_tag');
function clean_script_tag($src) {
    return str_replace("type='text/javascript'", '', $src);
}

//Удалить ссылки на RSS ленты
function fb_disable_feed(){wp_redirect(get_option('siteurl'));}
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
add_action( 'do_feed', 'fb_disable_feed', 1 );
add_action( 'do_feed_rdf', 'fb_disable_feed', 1 );
add_action( 'do_feed_rss', 'fb_disable_feed', 1 );
add_action( 'do_feed_rss2', 'fb_disable_feed', 1 );
add_action( 'do_feed_atom', 'fb_disable_feed', 1 );

//Отключаем Emoji
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

//Отменяем srcset
add_filter('wp_calculate_image_srcset_meta', '__return_null' );
add_filter('wp_calculate_image_sizes', '__return_false', 99 );
remove_filter('the_content', 'wp_make_content_images_responsive' );

//Отключаем Gutenberg
add_filter('use_block_editor_for_post_type', '__return_false', 100);
add_action('admin_init', function() {
    remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
    add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']); 
});
function gut_style_disable() { wp_dequeue_style('wp-block-library'); }
add_action('wp_enqueue_scripts', 'gut_style_disable', 100);

//Отключение XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

//Отключение dns-prefetch
remove_action( 'wp_head', 'wp_resource_hints', 2 );

//Отключение rel shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

add_filter( 'product_type_options', function( $options ) {
	// remove "Virtual" checkbox
	if( isset( $options[ 'virtual' ] ) ) {
		unset( $options[ 'virtual' ] );
	}
	// remove "Downloadable" checkbox
	if( isset( $options[ 'downloadable' ] ) ) {
		unset( $options[ 'downloadable' ] );
	}
	return $options;
});

//Отключение виртуальный, скачиваемый товары
add_filter( 'woocommerce_products_admin_list_table_filters', function( $filters ) {
	if( isset( $filters[ 'product_type' ] ) ) {
		$filters[ 'product_type' ] = 'misha_product_type_callback';
	}
	return $filters;
});

//Отключение виртуальный, скачиваемый товары в админке фильтрации
function misha_product_type_callback(){
	$current_product_type = isset( $_REQUEST['product_type'] ) ? wc_clean( wp_unslash( $_REQUEST['product_type'] ) ) : false;
	$output = '<select name="product_type" id="dropdown_product_type"><option value="">Filter by product type</option>';
	foreach ( wc_get_product_types() as $value => $label ) {
		$output .= '<option value="' . esc_attr( $value ) . '" ';
		$output .= selected( $value, $current_product_type, false );
		$output .= '>' . esc_html( $label ) . '</option>';
	}
	$output .= '</select>';
	echo $output;
}

//Что-то отключает лишнее в Gutenberg, но хрен знай что именно
add_action('wp_footer','wooexperts_remove_block_data',0);
add_action('admin_enqueue_scripts','wooexperts_remove_block_data',0);
function wooexperts_remove_block_data(){ 
    remove_filter('wp_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
    remove_filter('admin_print_footer_scripts',array('Automattic\WooCommerce\Blocks\Assets','print_script_block_data'),1);
}

// ------------------------- КОНЕЦ ДОПОЛНИТЕЛЬНЫЕ НУЖНЫЕ ИЗМЕНЕНИЯ, КОТОРЫЕ ДОЛЖНЫ НАХОДИТЬСЯ В КОНЦЕ ФАЙЛА -------------------------