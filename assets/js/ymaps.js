$(function () {
	if ($('#map').length > 0) {
		type_geo = [];
		aadr = [];
		geo = [];
		twogis = [];

		$(".contacts__map-address span").each(function (index) {
			count_map = index;
			type_geo.push($(this).attr('data-type-geo'));
			aadr.push($(this).attr('data-addr'));
			geo.push($(this).attr('data-geo'));
			twogis.push($(this).attr('data-2gis'));
		});
		geo_first = geo[0].split(',');
		// console.log('Кол-во адресов: ' + (count_map + 1));
		// console.log('Тип: ' + type_geo);
		// console.log('Адрес: ' + aadr);
		// console.log('Геопозиция: ' + geo);
		// console.log('Ссылка 2ГИС: ' + twogis);
		ymaps.ready(init);
		function init() {
			var myMap = new ymaps.Map('map', {
				center: geo_first,
				searchControlProvider: 'yandex#search',
				zoom: 14,
				controls: []
			}, {
				// zoomControlSize: 'medium',
				zoomControlPosition: {
					right: 40,
					top: 190
				},
				suppressMapOpenBlock: true,
			});

			//pointer = [[56.636744, 47.773847]];
			pointer = '';
			for (var i = 0; i <= count_map; i++) {
				pointer += geo[i].split(',');
				//i++;
			}

			//console.log(pointer);
			// $(".contacts__map-address").click(function () {
			// 	myMap.panTo([$(this).attr('geo').split(',')], {
			// 		flying: true
			// 	});
			// });
			var dataUrlDirectoryBlock = document.querySelector("#main-js");
			var dataUrlDirectory = dataUrlDirectoryBlock.getAttribute("data-dir");
			// Создадим пользовательский макет ползунка масштаба.
			ZoomLayout = ymaps.templateLayoutFactory.createClass("<div class='map-nav__wrapper'><div class='map-nav__block'>" + "<div id='zoom-in' data-title='Приблизить'><i class='map-nav__icon-plus'></i></div>" + "<div id='zoom-out' data-title='Отдалить'><i class='map-nav__icon-minus'></i></div>" + "</div></div>", {
				// Переопределяем методы макета, чтобы выполнять дополнительные действия
				// при построении и очистке макета.
				build: function () {
					// Вызываем родительский метод build.
					ZoomLayout.superclass.build.call(this);
					// Привязываем функции-обработчики к контексту и сохраняем ссылки
					// на них, чтобы потом отписаться от событий.
					this.zoomInCallback = ymaps.util.bind(this.zoomIn, this);
					this.zoomOutCallback = ymaps.util.bind(this.zoomOut, this);
					// Начинаем слушать клики на кнопках макета.
					$('#zoom-in').bind('click', this.zoomInCallback);
					$('#zoom-out').bind('click', this.zoomOutCallback);
				},
				clear: function () {
					// Снимаем обработчики кликов.
					$('#zoom-in').unbind('click', this.zoomInCallback);
					$('#zoom-out').unbind('click', this.zoomOutCallback);
					// Вызываем родительский метод clear.
					ZoomLayout.superclass.clear.call(this);
				},
				zoomIn: function () {
					var map = this.getData().control.getMap();
					map.setZoom(map.getZoom() + 1, {
						checkZoomRange: true
					});
				},
				zoomOut: function () {
					var map = this.getData().control.getMap();
					map.setZoom(map.getZoom() - 1, {
						checkZoomRange: true
					});
				}
			}),
				zoomControl = new ymaps.control.ZoomControl({
					options: {
						layout: ZoomLayout
					}
				}),

				// Создаём макет содержимого.
				//console.log(count_map);


				MyIconContentLayout = ymaps.templateLayoutFactory.createClass('<div class="map__title">$[properties.iconContent]</div>');
			for (i = 0; i <= count_map; i++) {

				balluns = new ymaps.Placemark(geo[i].split(','), {
					iconContent: '',
					balloonContent: '<div class="map__modal"><span class="map__modal_title">' + type_geo[i] + '</span><span class="map__modal_subtitle">' + aadr[i] + '</span><a href="' + twogis[i] + '" target="_blank">Как добраться?</a></div>',
					// balloonContent: 'Офис',

				}, {
					// Опции.
					// Необходимо указать данный тип макета.
					iconLayout: 'default#imageWithContent',
					// Своё изображение иконки метки.
					iconImageHref: '' + dataUrlDirectory + '/assets/img/icons/contacts-map.svg',
					// Размеры метки.
					iconImageSize: [35, 35],
					// Смещение левого верхнего угла иконки относительно
					// её "ножки" (точки привязки).
					iconImageOffset: [-14, -14],
					// Смещение слоя с содержимым относительно слоя с картинкой.
					iconContentOffset: [60, 5],
					// Макет содержимого.
					iconContentLayout: MyIconContentLayout,

				});
				myMap.controls.add(zoomControl);
				myMap.behaviors.disable('scrollZoom');
				myMap.behaviors.disable('multiTouch');
				myMap.geoObjects.add(balluns);
				myMap.geoObjects.events.add('click', function (e) {

					myMap.setZoom(17, {
						duration: 1000
					});
					var targetObject = e.get('target');
					myMap.setCenter(targetObject.geometry.getCoordinates());
				});
				//myMap.balloon.open();
			}
			myMap.events.add('click', function () {
				myMap.balloon.close();
			});
		}
		// ---------------------- КОНЕЦ ЯНДЕКС КАРТЫ ----------------------
	}
});

