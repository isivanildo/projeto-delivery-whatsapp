(function ($) {
    "use strict";

    $(window).on('load', function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
                lat: 40.730610,
                lng: -73.935242
            },
            zoom: 12,
            styles: [{
                    "featureType": "administrative",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": "-100"
                    }
                ]
            },
                {
                    "featureType": "administrative.province",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "off"
                    }
                ]
            },
                {
                    "featureType": "landscape",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": -100
                    },
                        {
                            "lightness": 65
                    },
                        {
                            "visibility": "on"
                    }
                ]
            },
                {
                    "featureType": "poi",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": -100
                    },
                        {
                            "lightness": "50"
                    },
                        {
                            "visibility": "simplified"
                    }
                ]
            },
                {
                    "featureType": "road",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": "-100"
                    }
                ]
            },
                {
                    "featureType": "road.highway",
                    "elementType": "all",
                    "stylers": [
                        {
                            "visibility": "simplified"
                    }
                ]
            },
                {
                    "featureType": "road.arterial",
                    "elementType": "all",
                    "stylers": [
                        {
                            "lightness": "30"
                    }
                ]
            },
                {
                    "featureType": "road.local",
                    "elementType": "all",
                    "stylers": [
                        {
                            "lightness": "40"
                    }
                ]
            },
                {
                    "featureType": "transit",
                    "elementType": "all",
                    "stylers": [
                        {
                            "saturation": -100
                    },
                        {
                            "visibility": "simplified"
                    }
                ]
            },
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "hue": "#ffff00"
                    },
                        {
                            "lightness": -25
                    },
                        {
                            "saturation": -97
                    }
                ]
            },
                {
                    "featureType": "water",
                    "elementType": "labels",
                    "stylers": [
                        {
                            "lightness": -25
                    },
                        {
                            "saturation": -100
                    }
                ]
            }
        ]
        });
        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(40.730610, -73.935242),
            map: map,
            icon: {
                url: 'assets/images/map-marker.png',
            },
            animation: google.maps.Animation.BOUNCE
        });
    });

}(jQuery));
