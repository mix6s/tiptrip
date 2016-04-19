<?php
/**
 * @var \Phalcon\Mvc\View $this
 * @var App\Main\Components\DI $di
 */
$di = $this->getDI();
?>
<div class="modal fade" id="popup_attempt_result" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg ">
		<div class="modal-content">
			<div class="modal-header">
				<a href="<?= $di->url->get(['for' => 'trips']) ?>" class="close"><span aria-hidden="true">&times;</span></a>
				<h4 class="modal-title">Молодец, хочешь еще?</h4>
			</div>
			<div id="resultMap" style="width:100%; min-height: 100px">

			</div>
			<div class="modal-body text-center">
				<div class="row">
					<div class="col-md-12">
						Ваше предложение было <span class="distance"></span> км. от правильного расположения.
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success js-new-attempt">Хочу еще!</button>
						<a href="<?= $di->url->get(['for' => 'trips']) ?>" class="btn btn-default">Все туры</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		var $popup = $('#popup_attempt_result');
		var $resultMap = $('#resultMap');
		$popup
			.on('show.bs.modal', function (e) {
				$resultMap.html('');
			})
			.on('shown.bs.modal', function (e) {
				var height = $resultMap.width()/1.5;
				if (height > $(window).height() - 200) {
					height = $(window).height() - 200;
				}
				$resultMap.height(height);
				var startLocation = $popup.data('startLocation'),
					userLocation = $popup.data('userLocation'),
					distance = $popup.data('distance'),
					resultMap = new google.maps.Map(document.getElementById('resultMap'), {
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

				var bounds = new google.maps.LatLngBounds();
				bounds.extend(new google.maps.LatLng(startLocation.lat, startLocation.lng));
				bounds.extend(new google.maps.LatLng(userLocation.lat, userLocation.lng));
				resultMap.fitBounds(bounds);
				resultMap.panToBounds(bounds);
				var startLocationMarker = new google.maps.Marker({
						position: {lat: startLocation.lat, lng: startLocation.lng},
						map: resultMap
					}),
					userLocationMarker = new google.maps.Marker({
						position: {lat: userLocation.lat, lng: userLocation.lng},
						map: resultMap
					}),
					flightPath = new google.maps.Polyline({
						path: [startLocation, userLocation],
						map: resultMap,
						strokeColor: '#FF0000',
						strokeOpacity: 1.0,
						strokeWeight: 2
					});
				$popup.find('.distance').text(distance);
			})
		;
	});
</script>