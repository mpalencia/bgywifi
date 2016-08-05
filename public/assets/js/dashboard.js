/*
var map;
$(document).ready(function(){
  var map = new GMaps({
    div: '#map',
    lat: 14.2366558,
    lng: 121.0400705,
    mapTypeControlOptions: {
    	mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
    },
    zoom: 16,
    markerClusterer: function(map) {
        options = {
          gridSize: 40,
          styles: [{
        	  height: 53,
        	  url: "/assets/images/m1.png",
        	  width: 53
  	  	  }]
        }

        return new MarkerClusterer(map, [], options);
      }

  });
  map.addMapType("osm", {
	getTileUrl: function(coord, zoom) {
    	return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
    },
    tileSize: new google.maps.Size(256, 256),
    name: "OpenStreetMap",
  	maxZoom: 20
  });
  map.setMapTypeId("osm");




	
});*/

var mapAlerts;

$(document).ready(function(){
  var mapAlerts = new GMaps({
    div: '#mapAlerts',
    lat: 14.2366558,
    lng: 121.0400705,
    mapTypeControlOptions: {
    	mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
    },
    zoom: 16,
    markerClusterer: function(mapAlerts) {
        options = {
          gridSize: 40,
          styles: [{
        	  height: 53,
        	  url: "{{asset('assets/images')}}/m10.png",
        	  width: 53
  	  	  }]
        }

        return new MarkerClusterer(mapAlerts, [], options);
      }

  });
  mapAlerts.addMapType("osm", {
	getTileUrl: function(coord, zoom) {
    	return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
    },
    tileSize: new google.maps.Size(256, 256),
    name: "OpenStreetMap",
  	maxZoom: 20
  });
  mapAlerts.setMapTypeId("osm");
  	var emergencyPastCount = 0;
  	var cautionPastCount = 0;
  	var issuePastCount = 0;

  	setInterval(function(){ 

  		$.get('getEventsLongLat', function(data){
		jQuery.each(data, function(index, item) {

			var pinColor = '';
			switch (item.category) {
		        case 2:
		            pinColor = "/assets/images/m3.png";
		            break;
		        case 3:
		            pinColor = "/assets/images/m4.png";
		            break;
		        case 4:
		            pinColor = "/assets/images/m5.png";
		            break;
		        case 5:
		            pinColor = "/assets/images/m1.png";
		            break;
		        case 6:
		            pinColor = "/assets/images/m7.png";
		            break;
		        default:
		            pinColor = "/assets/images/m2.png";
		            break;
		    }
		  var markers = [];
		  var marker = map.addMarker({
			lat: item.latitude,
			lng: item.longitude,
		    title: 'Home Owner Information',
		    icon: pinColor,
		    infoWindow: {
		      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
		    },
			mouseover: function(){
		        (this.infoWindow).open(this.map, this);
		    }

		  });
		  markers.push(marker);
		});
	});

		$.get('getEmergency', function(data){
			jQuery.each(data, function(index, item) {

			  	var markers = [];
		  		var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "/assets/images/m1.png",
				    infoWindow: {
				      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};
			  
			  	if(emergencyPastCount != data.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	emergencyPastCount++;
			  	}
			});
		});

		$.get('getCaution', function(data){
			jQuery.each(data, function(index, item) {
				
			  	var markers = [];
			  	var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "/assets/images/m2.png",
				    infoWindow: {
				      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			   	};

			    if(cautionPastCount != data.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	cautionPastCount++;
			  	}
			});
		});
		
	
		$.get('getIssues', function(data){
			jQuery.each(data, function(index, item) {

			  	var markers = [];

				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "/assets/images/11.png",
				    infoWindow: {
				      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	if(issuePastCount != data.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	issuePastCount++;
			  	}

			  	
			});
		});

		$.get('getAlertsCount', function(data){
			jQuery.each(data, function(index, item) {
				$('#emergencyCount').html(item.emergencyCount);
				$('#cautionCount').html(item.cautionCount);
				$('#issuesCount').html(item.issuesCount);
			});
		});

	}, 5000);
	
});




