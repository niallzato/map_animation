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
<div class="row title text-center">
    <div class="col-xs-12 year">&nbsp</div>
    <div class="col-xs-12 conflict">&nbsp</div>
</div>
<div class="row">
  <div class="col-xs-3">
  <form method="post" name="controls" action="/data">

    <h1>Options</h1>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <input id="Africa" type="checkbox" name="site[]" value="4" />
    <label for="Africa">Africa</label>
    <br />
    <input id="Asia" type="checkbox" name="site[]" value="3" />
    <label for="Asia">East Asia</label>
    <br />
    <input id="ME" type="checkbox" name="site[]" value="2" />
    <label for="ME">Middle East</label>
    <br />
    <input id="South America" type="checkbox" name="site[]" value="5" />
    <label for="South America">Americas</label>
    <br />
    <input id="Europe" type="checkbox" name="site[]" value="1" />
    <label for="Europe">Europe</label>

    <br>
    <br>

    <input type="number" name="start" id="start" value='1984'>
    <label for="start">Start Date</label>

    <input type="number" name="end" id="end" value='2008'>
    <label for="end">End Date</label>

    <br>

    <button type="submit">Submit</button>
    
  </form>

  <button type="button">start</button>
  </div>
  <div class="col-xs-9" id="map" style="height:calc(100vh - 55px);">
    
  </div> 
</div>

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

  var first = new google.maps.LatLng(data[0]['lat'], data[0]['long']);

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 2,
    center: first,
    mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  

  	//loop through conflicts add lines
	$( document ).ready(function() {
	    $.each(data, function(i, item) {

        var stateactors = actors(data[i]['SideA'],data[i]['SideA2nd'],data[i]['SideB'],data[i]['Sideb2nd']);

      	setTimeout(function(){ 

        

        var myLatLng = {lat: data[i]['lat'], lng: data[i]['long']};

        var infowindow = new google.maps.InfoWindow({
          content: '<p>'+data[i]['year']+'</p>'+stateactors
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

        $('.year').html(data[i]['year']);
        $('.conflict').html(stateactors);
        //console.log(data[i]['year'])
	    }, 1000*(i+1));

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

  function actors(SideA, SideA2nd, SideB, SideB2nd){

    if (SideA2nd) {
      SideA = SideA+' & '+SideA2nd;
    }

    if (SideB2nd) {
      SideB = SideB+' & '+SideB2nd;
    }
    return SideA+" vs "+SideB;
  }         

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCJ2QDtWbXyzJ0Qufu3pK2BGPgp2X9mq0&callback=initMap"
    async defer></script>
@endsection