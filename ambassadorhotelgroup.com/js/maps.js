$( document ).ready( function() {

	//Google Maps JS
	//Set Map
	var MY_MAPTYPE_ID = 'custom_style';
	function initialize() {
			var myLatlng = new google.maps.LatLng(10.7850948,106.684742);
			var imagePath = 'images/iconmaps.png'
			var featureOpts = [ { "stylers": [ { "saturation": -100 }, { "lightness": -5 } ] } ];
			var mapOptions = {
				zoom: 16,
				center: myLatlng,
				mapTypeId: MY_MAPTYPE_ID				
			}

		var map = new google.maps.Map(document.getElementById('map'), mapOptions);
		var customMapType = new google.maps.StyledMapType(featureOpts);
			map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

		

		//Add Marker
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: imagePath
		});

		//Resize Function
		google.maps.event.addDomListener(window, "resize", function() {
			var center = map.getCenter();
			google.maps.event.trigger(map, "resize");
			map.setCenter(center);
		});
	}

	google.maps.event.addDomListener(window, 'load', initialize);

});