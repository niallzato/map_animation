@extends('welcome')


@section('content')
<?php
	$entries = \DB::table('conflict_geo')
        ->join('conflict', function($join)
        {
            $join->on('conflict.id', '=', 'conflict_geo.id')
            ->on('conflict.YEAR', '=', 'conflict_geo.year')
            ->where('conflict.Region', '=', '4')
            ->where('conflict_geo.year','>','2000');
        })
        ->orderBy('conflict_geo.year')
        ->get();

        //dd($entries);

	$conflicts = json_encode($entries);
	$entries = count($entries);
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



        var myLatLng = {lat: data[i]['lat'], lng: data[i]['long']};

        var infowindow = new google.maps.InfoWindow({
          content: data[i]['Location']+' '+data[i]['SideB']
        });

        var marker = new google.maps.Marker({
          position: myLatLng,
          animation: google.maps.Animation.DROP,
          map: map,
          title: data[i]['Location']
        });
        marker.addListener('click', function() {
          infowindow.open(map, marker);
        });

        var cityCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: myLatLng,
            radius: data[i]['radius']*1000
          });



        //console.log(data[i]['year'])

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