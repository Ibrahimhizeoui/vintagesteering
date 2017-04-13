var geocoder = new google.maps.Geocoder(),
    address = gmap.address, //Add your address here, all on one line.
    latitude,
    longitude,
    color = "#9bc8ce",
    styles = [],
    mapOptions,
    infowindow,
    styledMapType,
    map; //Set your tint color. Needs to be a hex value.

var mapTab = document.querySelector('[data-tab-location]');

var mapDiv = document.getElementById('googleMap');

function getGeocode() {
	geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
    		latitude = results[0].geometry.location.lat();
			longitude = results[0].geometry.location.lng();
			initGoogleMap();
    	}
	});
}

function initGoogleMap() {

	styles = [
        { stylers: [] }
    ];

    mapOptions = {
        mapTypeControlOptions: {
            mapTypeIds: ['Styled']
        },
        center: { lat: latitude, lng: longitude },
        zoom: 5,
        scrollwheel: false,
        navigationControl: false,
        mapTypeControl: false,
        zoomControl: true,
        disableDefaultUI: true,
        mapTypeId: 'Styled'
    };

	map = new google.maps.Map(mapDiv, mapOptions);

	marker = new google.maps.Marker({
	    map: map,
	    draggable: false,
	    animation: google.maps.Animation.DROP,
	    position: { lat: latitude, lng: longitude }
	});

	styledMapType = new google.maps.StyledMapType(styles, { name: 'Styled' });

	map.mapTypes.set('Styled', styledMapType);

    /**
     *  Re-centers the map when the location tab is clicked,
     *  solves problem where the map loads with a height of "0"
     *  meaning the pin/center is the top of the container meaning it's off
     *  center.
     *
     *  I created a "setTimeout" function because the tab does not set it's
     *  height immiedietely after clicking, theres a ms'ish delay.
     */
    mapTab.addEventListener('click', function(){
        setTimeout(function(){
            google.maps.event.trigger(map, 'resize');
            map.panTo( marker.getPosition() );
        }, 350)
    });
}
google.maps.event.addDomListener(window, 'load', getGeocode);
