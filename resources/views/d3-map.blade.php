<html>
<head>
  <title>A D3 map</title>
  <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  <script src="/neighborhoods.js"></script>
</head>
<body>

  <script>

var width = 700,
    height = 580;

var svg = d3.select( "body" )
  .append( "svg" )
  .attr( "width", width )
  .attr( "height", height );

var g = svg.append( "g" );

//basic projection
var albersProjection = d3.geo.albers()
  .scale( 190000 )
  .rotate( [71.057,0] )
  .center( [0, 42.313] )
  .translate( [width/2,height/2] );

var geoPath = d3.geo.path().projection( albersProjection );
  // grab lat/lon coordinates from geojson feature
  // do some crazy magic to turn them into screen coordinates
  // return SVG path string

//path generator for lat and long
g.selectAll( "path" )
  .data( neighborhoods_json.features )
  .enter()
  .append( "path" )
  .attr( "fill", "#ccc" )
  .attr( "d", geoPath );



  </script>
</body>
</html>
	