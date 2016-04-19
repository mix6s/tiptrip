<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 * @var \App\Main\Models\Trip $trip
 * @var \App\Main\Models\Attempt $attempt
 */
$di = $this->getDI();
$di->popupManager->addPopupToOutput('attempt/result');
$di->popupManager->addPopupToOutput('attempt/welcome', ['trip' => $trip]);
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
	<link rel="shortcut icon" href="/icon/favicon.ico">
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
		<a class="header-logo" href="/"><img src="/images/logo.png" alt=""/></a>
		<div class="header-chance-clock hidden-lg hidden-md"><i class="icon-setting"></i> <span class="js-countdown" data-active="<?= !empty($attempt) ? 1 : 0 ?>" data-seconds="<?= !empty($attempt) ? $attempt->secondsToExpire : 60 * 5 ?>" data-format="%m2%m1:%s2%s1"></span></div>
		<div class="header-chance-time hidden-lg hidden-md js-toggle-menu">
			<i class="icon-setting"></i>
		</div>
		<div class="chance-time-wrapper hidden-xs hidden-sm">
			<div class="chance-time-items-wrapper">
				<div class="chance-time-item">
					<div>
						<p class="chance-bold"><?= $trip->direction->title ?>, <?= $trip->title ?></p>
						<p><?= $trip->hotelTitle ?></p>
					</div>
					<div class="chance-bold">1 : <?= $trip->multiplicity ?></div>
				</div>
				<div class="chance-time-item">
					<div>
						<p>Стоимость шанса:</p>
						<p>Количество попыток:</p>
					</div>
					<div>
						<p class="highlight-green"><?= $di->tag->rub($trip->ticketPrice) ?></p>
						<p class="highlight-green"><?= !empty($attempt) ? $attempt->count : 1?> / 5</p>
					</div>
				</div>
			</div>
			<div class="chance-time">
				<div class="chance-time-title">Осталось времени на ход:</div>
				<div class="chance-time-content js-countdown" data-active="<?= !empty($attempt) ? 1 : 0 ?>" data-seconds="<?= !empty($attempt) ? $attempt->secondsToExpire : 60 * 5 ?>" data-format="<span>%m2</span><span>%m1</span> м. <span>%s2</span><span>%s1</span> с.">
				</div>
			</div>
			<a href="" class="btn btn-success js-buy-extra-time">
				Купить <i class="icon-map-add-time"></i> <span class="chance-bold">1 мин.</span> за <span class="chance-bold">30</span> <i class="icon-rub-bold"></i>
			</a>
		</div>
	</header>
	<div class="chance-controls">
		<div class="chance-compass">
			<div class="needle"></div>
		</div>
		<div class="chance-start" href=""><i class="icon-map-pointer"></i></div>
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
				<div class="map-control" href=""><i class="icon-map-arrow-up"></i></div>
				<div class="map-control" href=""><i class="icon-map-arrow-down"></i></div>
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
		defaultLocation = {lat: <?= !empty($attempt) ? $attempt->getSourceLocation()['lat'] : 0 ?>, lng: <?= !empty($attempt) ? $attempt->getSourceLocation()['lng'] : 0 ?>},
		isActive = <?= (int)!empty($attempt) ?>;

	$(document).ready(function () {
		initCountdown();
		if (!isActive) {
			var welcomePopup = new WelcomePopup({
				tripId: <?= $trip->id?>,
				onSuccess: function (response) {
					if (response.status) {
						defaultLocation = {lat: parseFloat(response.attempt.source_latitude), lng: parseFloat(response.attempt.source_longitude)};
						isActive = true;
						runCountdown();
						initialize();
						welcomePopup.close();
					}
				}
			});
			welcomePopup.show();
		} else {
			runCountdown();
			initialize();
		}
	});

	function initCountdown() {
		$('.js-countdown').each(function () {
			var $countdown = $(this);
			var format = $countdown.data('format'),
				seconds = $countdown.data('seconds');

			var s = Math.floor((seconds) % 60),
				m = Math.floor((seconds / 60) % 60),
				html = format;
			html = html.replace(/%m2/g, Math.floor(m / 10));
			html = html.replace(/%m1/g, m - Math.floor(m / 10) * 10);
			html = html.replace(/%s2/g, Math.floor(s / 10));
			html = html.replace(/%s1/g, s - Math.floor(s / 10) * 10);
			$countdown.html(html);
		});
	}

	function runCountdown() {
		$('.js-countdown').each(function () {
			var $countdown = $(this);
			var updateCountdown = function () {
				var format = $countdown.data('format'),
					seconds = $countdown.data('seconds');

				var s = Math.floor((seconds) % 60),
					m = Math.floor((seconds / 60) % 60),
					html = format;
				html = html.replace(/%m2/g, Math.floor(m / 10));
				html = html.replace(/%m1/g, m - Math.floor(m / 10) * 10);
				html = html.replace(/%s2/g, Math.floor(s / 10));
				html = html.replace(/%s1/g, s - Math.floor(s / 10) * 10);
				$countdown.html(html);
				seconds--;
				$countdown.data('seconds', seconds);
				if (seconds > 0 && isActive) {
					setTimeout(updateCountdown, 1000)
				}
			};
			updateCountdown();
		});
	}

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
		});
		$('.chance')
			.off()
			.on('rezise', function () {
				google.maps.event.trigger(miniMap, 'resize');
			})
			.on('click', '.js-minimap-make-guess', function () {
				if (!marker) {
					return;
				}
				var userLocation = marker.getPosition();
				$.ajax({
					url: '<?= $di->url->get(['for' => 'attemptMakeGuess', 'id' => $trip->id])?>',
					type: 'post',
					data: {location: {lat: userLocation.lat(), lng: userLocation.lng()}},
					success: function (response) {
						if (response.status) {
							var $popup = $('#popup_attempt_result');
							$popup
								.data('startLocation', {lat: parseFloat(response.attempt.source_latitude), lng: parseFloat(response.attempt.source_longitude)})
								.data('distance', response.attempt.distance)
								.data('userLocation', {lat: parseFloat(response.attempt.user_latitude), lng: parseFloat(response.attempt.user_longitude)})
								.modal();
							$popup.find('.js-new-attempt').off().on('click', function () {
								$.ajax({
									url: '<?= $di->url->get(['for' => 'attemptNew', 'id' => $trip->id]) ?>',
									success: function (response) {
										if (response.status) {
											defaultLocation = {lat: parseFloat(response.attempt.source_latitude), lng: parseFloat(response.attempt.source_longitude)};
											isActive = true;
											$('.js-countdown').each(function () {
												$(this).data('seconds', response.attempt.seconds_to_expire);
											});
											runCountdown();
											initialize();
											marker = undefined;
											$('.js-minimap-make-guess').addClass('disabled');
											$popup.modal('hide');
										}
									}
								})

							});
							isActive = false;
						}
					}
				});
				return false;
			})
			.on('click', '.js-buy-extra-time', function () {
				$.ajax({
					url: '<?= $di->url->get(['for' => 'attemptBuyExtraTime', 'id' => $trip->id])?>',
					success: function (response) {
						if (response.status) {
							$('.js-countdown').each(function () {
								$(this).data('seconds', response.attempt.seconds_to_expire);
							});
						}
					}
				});
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
	}
</script>
<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp4EyP7eXjNecIG7AH2bn_TN4Sut9c3Ps&signed_in=true">
</script>
<?= $di->popupManager->output() ?>
</body>
</html>