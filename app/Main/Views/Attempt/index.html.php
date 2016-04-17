<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 * @var App\Main\Models\Location $location
 */
$di = $this->getDI();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="shortcut icon" href="icon/favicon.ico">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/attempt.css">
</head>
<body>

<!--[if lt IE 8]>
<div class="browse-happy-wrapper">
	<p>
		Вы используете <strong>устаревший</strong> браузер. Пожалуйста, <a href="http://browsehappy.com/">обновите ваш
		браузер</a>, чтобы сайт отображался корректно.
	</p>
</div>
<![endif]-->


<section class="chance">
	<div class="chance-map">
		<div id="streetview"></div>
	</div>
	<header class="chance-header">
		<a class="header-logo" href="/"><img src="images/logo.png" alt=""/></a>
		<div class="header-chance-clock hidden-lg hidden-md"><i class="icon-setting"></i> <span class="js-countdown" data-seconds="120" data-format="%m2%m1:%s2%s1"></span></div>
		<div class="header-chance-time hidden-lg hidden-md js-toggle-menu">
			<i class="icon-setting"></i>
		</div>
		<div class="chance-time-wrapper hidden-xs hidden-sm">
			<div class="chance-time-items-wrapper">
				<div class="chance-time-item">
					<div>
						<p class="chance-bold">Франция, Париж</p>
						<p>Hôtel Imperial</p>
					</div>
					<div class="chance-bold">1 : 500</div>
				</div>
				<div class="chance-time-item">
					<div>
						<p>Стоимость шанса:</p>
						<p>Количество попыток:</p>
					</div>
					<div>
						<p class="highlight-green">500 <i class="icon-rub-bold"></i></p>
						<p class="highlight-green">4 / 5</p>
					</div>
				</div>
			</div>
			<div class="chance-time">
				<div class="chance-time-title">Осталось времени на ход:</div>
				<div class="chance-time-content js-countdown" data-seconds="120" data-format="<span>%m2</span><span>%m1</span> м. <span>%s2</span><span>%s1</span> с.">
				</div>
			</div>
			<a href="" class="btn btn-success">
				Купить <i class="icon-question"></i> <span class="chance-bold">1 мин.</span> за <span class="chance-bold">30</span> <i class="icon-rub-bold"></i>
			</a>
		</div>
	</header>
	<div class="chance-controls">
		<div class="chance-compass">
			<div class="needle"></div>
		</div>
		<div class="chance-start" href=""><i class="icon-question"></i></div>
		<div class="chance-pm">
			<div class="chance-p" href="">+</div>
			<div class="chance-m" href="">–</div>
		</div>
	</div>
	<div class="chance-minmap">
		<div class="chance-minmap-wrapper">
			<div id="miniMap"></div>
			<div class="chance-minmap-pm map-controls hidden-xs hidden-sm">
				<div class="map-control js-minimap-zoom-in" href="">+</div>
				<div class="map-control js-minimap-zoom-out" href="">–</div>
			</div>
			<div class="chance-minmap-scale map-controls hidden-xs hidden-sm">
				<div class="map-control" href=""><i class="icon-question"></i></div>
				<div class="map-control" href=""><i class="icon-question"></i></div>
			</div>
			<a href="" class="btn btn-back hidden-lg hidden-md js-minimap-hide"><i class="icon-question"></i> Назад</a>
		</div>
		<a href="" class="btn btn-default hidden-xs hidden-sm disabled js-minimap-make-guess">Указать место</a>
		<a href="" class="btn btn-success hidden-lg hidden-md js-minimap-show">Поставить метку</a>
	</div>
</section>
<script type="text/javascript" src="/js/jquery-2.2.2.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script>
	var panorama,
		miniMap,
		sv,
		marker,
		defaultLocation = {lat: <?= $location->latitude ?>, lng: <?= $location->longitude ?>};
	function processSVData(data, status) {
		if (status === google.maps.StreetViewStatus.OK) {
			panorama.setPano(data.location.pano);
			panorama.setVisible(true);
		} else {
			console.error('Street View data not found for this location.');
		}
	}

	function _getAngleFromPoint(e, t) {
		var n = {
			x: -t / 2,
			y: 0
		};
		dotProduct = e.x * n.x + e.y * n.y, lengthOfCursorVector = Math.sqrt(Math.pow(e.x, 2) + Math.pow(e.y, 2)), lengthOfNeedleVector = Math.sqrt(Math.pow(n.x, 2) + Math.pow(n.y, 2));
		var r = Math.acos(dotProduct / (lengthOfCursorVector * lengthOfNeedleVector));
		return e.y < 0 && (r *= -1), 180 * r / Math.PI - 90
	}

	function setMarkerPosition(lat, lng) {
		if (!marker) {
			$('.js-minimap-make-guess').removeClass('disabled');
			marker = new google.maps.Marker({
				position: {lat: lat, lng: lng},
				map: miniMap,
			});
		} else {
			marker.setPosition(new google.maps.LatLng(lat, lng));
		}
	}

	function povMoved(heading, pitch) {
		heading = 360 - heading;
		var $compass = $('.chance-compass'),
			style = "transform: rotate(" + heading + "deg)";
		$compass.find('.needle').attr('style', style);
	}

	function autofitMiniMap()
	{
		google.maps.event.trigger(miniMap, 'resize');
		var bounds = new google.maps.LatLngBounds();
		bounds.extend(new google.maps.LatLng("-85","-180"));
		bounds.extend(new google.maps.LatLng("85","180"));
		miniMap.fitBounds(bounds);
		miniMap.panToBounds(bounds);
	}

	function initialize() {
		sv = new google.maps.StreetViewService();
		panorama = new google.maps.StreetViewPanorama(document.getElementById('streetview'));
		panorama.setOptions({
			addressControl: false,
			enableCloseButton: false,
			fullscreenControl: false,
			imageDateControl: false,
			panControl: false,
			zoomControl: false,
		});
		sv.getPanorama({location: defaultLocation, radius: 50}, processSVData);

		miniMap = new google.maps.Map(document.getElementById('miniMap'), {
			disableDefaultUI: 1,
			noClear: 1,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			styles: {
				featureType: "poi",
				elementType: "labels",
				stylers: [{
					visibility: "off"
				}]
			},
			backgroundColor: "none",
			draggableCursor: "crosshair",
			signInControl: false
		});
		autofitMiniMap();
		bindEvents();
		povMoved(panorama.getPov().heading, panorama.getPov().pitch);
	}

	function bindEvents() {
		$(document).ready(function () {
			var compassMousedown = false;
			google.maps.event.addListener(panorama, "pov_changed", function () {
				povMoved(panorama.getPov().heading, panorama.getPov().pitch);
			});

			google.maps.event.addDomListener(miniMap, "click", function(t) {
				var e;
				e = !1, setTimeout(function() {
					e === !1 && setMarkerPosition(t.latLng.lat(), t.latLng.lng())
				}, 200), google.maps.event.addDomListener(miniMap, "dblclick", function(t) {
					e = !0
				})
			})
			$('.js-countdown').each(function () {
				var $countdown = $(this);
				var updateCountdown = function() {
					var format = $countdown.data('format'),
						seconds = $countdown.data('seconds');
					seconds--;
					$countdown.data('seconds', seconds);
					var s = Math.floor((seconds) % 60),
						m = Math.floor((seconds/60) % 60),
						html = format;
					html = html.replace(/%m2/g, Math.floor(m/10));
					html = html.replace(/%m1/g, m - Math.floor(m/10)*10);
					html = html.replace(/%s2/g, Math.floor(s/10));
					html = html.replace(/%s1/g, s - Math.floor(s/10)*10);
					$countdown.html(html);
					if(seconds<=0){
						clearInterval(timeinterval);
					}
				};
				updateCountdown();
				var timeinterval = setInterval(updateCountdown , 1000);

			})
			$('.chance')
				.on('rezise', function () {
					google.maps.event.trigger(miniMap, 'resize');
				})
				.on('click', '.js-minimap-make-guess', function () {
					if (!marker) {
						return;
					}
					var userLocation = marker.getPosition();
					$('#popup_attempt_result').data('startLocation', defaultLocation).data('userLocation', {lat: userLocation.lat(), lng: userLocation.lng()}).modal();
					return false;
				})
				.on('click', '.js-toggle-menu', function () {
					$('.chance-time-wrapper').toggleClass('hidden-xs hidden-sm');
					return false;
				})
				.on('click', '.js-minimap-show', function () {
					$('.chance-minmap-wrapper').addClass('show');
					$(this).addClass('hide');
					$('.js-minimap-make-guess').removeClass('hidden-xs hidden-sm');
					autofitMiniMap();
					return false;
				})
				.on('click', '.js-minimap-hide', function () {
					$('.chance-minmap-wrapper').removeClass('show');
					$('.js-minimap-show').removeClass('hide');
					$('.js-minimap-make-guess').addClass('hidden-xs hidden-sm');
					autofitMiniMap();
					return false;
				})
				.on('click', '.js-minimap-zoom-out', function () {
					miniMap.setZoom(miniMap.getZoom() - 1);
				})
				.on('click', '.js-minimap-zoom-in', function () {
					miniMap.setZoom(miniMap.getZoom() + 1);
				})
				.on('click', '.chance-p', function () {
					panorama.setZoom(panorama.getZoom() + 1);
				})
				.on('click', '.chance-m', function () {
					panorama.setZoom(panorama.getZoom() - 1);
				})
				.on('click', '.chance-start', function () {
					panorama.setPosition(new google.maps.LatLng(defaultLocation.lat, defaultLocation.lng));
				})
				.on('mousedown', '.chance-compass', function () {
					compassMousedown = true;
				})
				.on('mouseup', '.chance-compass', function () {
					compassMousedown = false;
				})
				.on('mousemove', '.chance-compass', function (e) {
					if (!compassMousedown) {
						return;
					}
					var $compass = $(this),
						width = $compass.width(),
						position = {
							x: e.pageX - $compass.offset().left - width / 2,
							y: width / 2 - (e.pageY - $compass.offset().top)
						},
						heading = _getAngleFromPoint(position, width);
					panorama.setPov({heading: heading, pitch: panorama.getPov().pitch});
				})
			;
		});
	}
</script>
<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp4EyP7eXjNecIG7AH2bn_TN4Sut9c3Ps&signed_in=true&callback=initialize&libraries=geometry">
</script>
<?= $di->popupManager->output() ?>
</body>
</html>