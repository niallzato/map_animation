@extends('welcome')


@section('content')
<?php
	//$entries = App\Models\Conflict::take(40)->groupBy('year','location')->orderBy('year')->get();
	//$entries = App\Models\Conflictgeo::where('year','>','2000')->groupBy('year','version')->orderBy('year')->get();

	$entries = \DB::table('conflict_geo')
        ->join('conflict', function($join)
        {
            $join->on('conflict.id', '=', 'conflict_geo.id')
            ->where('conflict.Region', '=', '4')
            ->where('conflict_geo.year','>','2000');
        })
        ->get();

    //    dd($entries[450]);
//
	//foreach ($entries as $key => $entry) {
	//	$entry = $entry->conflict;
	//}

	//$entries = $entries

	//dd($entries[1]->toArray());
	//$conflicts = $entries->toJson();
	$conflicts = json_encode($entries);
	//dd($conflicts);
	$entries = count($entries);
	//dd($entries->toArray());
?>
 <div id="map" style="height:400px;"></div>
    <script>

      var data =  JSON.parse({!!json_encode($conflicts)!!});
      var map;
      var flightPath;
      var steps = {{$entries}};
      var startColor = '#ffffff';
      var endColor = '#000000';

      //init map object

  var colors = gradient(startColor,endColor,steps);

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

	    if (i == 1 ) {
	 		var flightPlanCoordinates = [
	        	first,
	        	new google.maps.LatLng(data[i]['lat'], data[i]['long'])
	        ];	 


	    	var flightPath = new google.maps.Polyline({
	            path:flightPlanCoordinates,
				strokeColor: colors[i],
	            strokeOpacity:.5,
	            strokeWeight:2
	            });
	        	//apply lines
	        	flightPath.setMap(map);
        }

        else if(i > 1){
	 		var flightPlanCoordinates = [
	        	new google.maps.LatLng(data[i-1]['lat'], data[i-1]['long']),
	        	new google.maps.LatLng(data[i]['lat'], data[i]['long'])
	        ];	 


	    	var flightPath = new google.maps.Polyline({
	            path:flightPlanCoordinates,
				strokeColor: colors[i],
	            strokeOpacity:.5,
	            strokeWeight:2
	            });
	        	//apply lines
	        	flightPath.setMap(map);

	        	console.log(i);
        }
	    }, 100*(i+1));

		});
	});
}

	function gradient(startColor, endColor, steps){
             var start = {
                     'Hex'   : startColor,
                     'R'     : parseInt(startColor.slice(1,3), 16),
                     'G'     : parseInt(startColor.slice(3,5), 16),
                     'B'     : parseInt(startColor.slice(5,7), 16)
             }
             var end = {
                     'Hex'   : endColor,
                     'R'     : parseInt(endColor.slice(1,3), 16),
                     'G'     : parseInt(endColor.slice(3,5), 16),
                     'B'     : parseInt(endColor.slice(5,7), 16)
             }
             diffR = end['R'] - start['R'];
             diffG = end['G'] - start['G'];
             diffB = end['B'] - start['B'];

             stepsHex  = new Array();
             stepsR    = new Array();
             stepsG    = new Array();
             stepsB    = new Array();

             for(var i = 0; i <= steps; i++) {
                     stepsR[i] = start['R'] + ((diffR / steps) * i);
                     stepsG[i] = start['G'] + ((diffG / steps) * i);
                     stepsB[i] = start['B'] + ((diffB / steps) * i);
                     stepsHex[i] = '#' + Math.round(stepsR[i]).toString(16) + '' + Math.round(stepsG[i]).toString(16) + '' + Math.round(stepsB[i]).toString(16);
             }
             return stepsHex;

         }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCJ2QDtWbXyzJ0Qufu3pK2BGPgp2X9mq0&callback=initMap"
    async defer></script>
@endsection