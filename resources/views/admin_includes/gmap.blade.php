<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps Javascript API v3 Example: Add Marker with open infowindow on map click</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

<!-- <script type="text/javascript" src="scripts/downloadxml.js"></script> -->
<style type="text/css">
html, body { height: 100%; }
</style>
<script type="text/javascript">
//<![CDATA[

     // global "map" variable
      var map = null;
      var marker = null;

var infowindow = new google.maps.InfoWindow(
  {
    size: new google.maps.Size(700,400)
  });

// A function to create the marker and set up the event window function
function createMarker(latlng, name, html) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString);
        infowindow.open(map,marker);
        });
    google.maps.event.trigger(marker, 'click');
    return marker;
}



function initialize() {
  // create the map
  var myOptions = {
    zoom: 17,
    center: new google.maps.LatLng(14.2366558,121.0400705),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map_canvas"),
                                myOptions);

  google.maps.event.addListener(map, 'click', function() {
        infowindow.close();
        });

  google.maps.event.addListener(map, 'click', function(event) {
	//call function to create marker
         if (marker) {
            marker.setMap(null);
            marker = null;
         }
      marker = createMarker(event.latLng, "name", "<b>Location</b><br>"+event.latLng);
      $('#long_lat').val($('#long_lat').val() + '-' + event.latLng.lat());
      console.log($('#long_lat').val());
  });

}


//]]>
</script>

  </head>
<body style="margin:0px; padding:0px;" onload="initialize()">

    <!-- you can use tables or divs for the overall layout -->
    <table border="1">
      <tr>
        <td>
           <div id="map_canvas" style="width: 700px; height: 400px"></div>
        </td>
        <td valign="top" style="width:150px; text-decoration: underline; color: #4444ff;">
           <div id="side_bar"></div>
        </td>
      </tr>
    </table>
    <noscript><p><b>JavaScript must be enabled in order for you to use Google Maps.</b>
      However, it seems JavaScript is either disabled or not supported by your browser.
      To view Google Maps, enable JavaScript by changing your browser options, and then
      try again.</p>
    </noscript>
  </body>
</html>
