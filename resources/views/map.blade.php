@extends('welcome')


@section('content')
<?php
	$conflicts = App\Models\Conflict::take(40)->get()->toJson();
	//dd($conflicts);
?>
 <div id="map" style="height:400px;"></div>
    <script>

      var data =  JSON.parse('{!!$conflicts!!}');
      var map;
      var flightPath;

      //init map object
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 1,
    center: {lat: 0, lng: -180},
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  var first = new google.maps.LatLng(data[0]['lat'], data[0]['long']);

  	//loop through conflicts add lines
	$( document ).ready(function() {
	    $.each(data, function(i, item) {


setTimeout(function(){ 

	    	if (i > 0 ) {
	    		
  	
 		var flightPlanCoordinates = [
        	first,
        	new google.maps.LatLng(data[i]['lat'], data[i]['long'])
        ];	 


    	var flightPath = new google.maps.Polyline({
            path:flightPlanCoordinates,
			strokeColor: '#FF0000',
            strokeOpacity:2,
            strokeWeight:5
            });
        	//apply lines
        	flightPath.setMap(map);
        }

	    }, 1000*(i+1));

		});
	});



}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCJ2QDtWbXyzJ0Qufu3pK2BGPgp2X9mq0&callback=initMap"
    async defer></script>
@endsection