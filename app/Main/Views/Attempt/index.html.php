<?php
/** @var App\Main\Models\Location $location */
?>
<div id="pano" style="width: 100%; height:500px;"></div>
<?= $this->getContent(); ?>
<script>
	var panorama;
	var sv;
	function processSVData(data, status) {
		if (status === google.maps.StreetViewStatus.OK) {
			panorama.setPano(data.location.pano);
			panorama.setPov({
				heading: 270,
				pitch: 0
			});
			panorama.setVisible(true);
		} else {
			console.error('Street View data not found for this location.');
		}
	}

	function initialize() {
		var fenway = {lat: <?= $location->latitude ?>, lng: <?= $location->longitude ?>};
		sv = new google.maps.StreetViewService();
		panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'));
		sv.getPanorama({location: fenway, radius: 50}, processSVData);
	}

</script>
<script async defer
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp4EyP7eXjNecIG7AH2bn_TN4Sut9c3Ps&signed_in=true&callback=initialize">
</script>
