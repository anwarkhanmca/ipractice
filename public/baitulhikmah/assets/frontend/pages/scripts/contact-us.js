var ContactUs = function () {

    return {
        //main function to initiate the module
        init: function () {
			var map;
			$(document).ready(function(){
			  map = new GMaps({
				div: '#map',
	            lat: 24.394570,
				lng: 88.069966,
			  });
			   var marker = map.addMarker({
		            lat: 24.394570,
					lng: 88.069966,
		            title: 'Loop, Inc.',
		            infoWindow: {
		                content: "<b>Nowda.</b> Mirjapur, Raghunathganj<br>West Bengal, India"
		            }
		        });

			   marker.infoWindow.open(map, marker);
			});
        }
    };

}();