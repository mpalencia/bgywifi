<script>

function showBlockUI(msg){

    if(typeof msg === 'undefined'){
        msg = '<img src="assets/img/loader.gif" width="100px;"/>';
    }

    $.blockUI({ css: {
        border: 'none',
        padding: '15px',
        backgroundColor: '#000',
        '-webkit-border-radius': '10px',
        '-moz-border-radius': '10px',
        opacity: .5,
        color: '#fff'

    }, message: msg });
}

showBlockUI('Loading map, please wait...');
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
	        	  url: "{{asset('assets/images')}}/m1.png",
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
          title: 'Cluster Title',
          gridSize: 40,
          styles: [{
        	  height: 53,
        	  url: "{{asset('assets/images')}}/m6.png",
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
  	var eventsPastCount = 0;
  	var emergencyPastCount = 0;
  	var cautionPastCount = 0;
  	var issuePastCount = 0;
  	var unidentifiedPastCount = 0;


  	$('#eventsRd').click(function(){
		$('.mapEvents').removeClass('hidden');
		$('.mapAlerts').addClass('hidden');

  	});
  	$('#alertsRd').click(function() {
		$('.mapAlerts').removeClass('hidden');
		$('.mapEvents').addClass('hidden');
  	});

  	setInterval(function(){

		/*$.get('getEmergency', function(data){
			jQuery.each(data, function(index, item) {

			  	var markers = [];
		  		var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m6.png",
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
				    icon: "{{asset('assets/images')}}/m2.png",
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
				    icon: "{{asset('assets/images')}}/m1.png",
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

		$.get('getUnidentifiedAlerts', function(data){
			jQuery.each(data, function(index, item) {

			  	var markers = [];

				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m7.png",
				    infoWindow: {
				      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	if(unidentifiedPastCount != data.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	unidentifiedPastCount++;
			  	}


			});
		});*/
		$.get('getEventsLongLat', function(data){
			jQuery.each(data, function(index, item) {

				var pinColor = '';
				switch (item.category) {
			        case 2:
			            pinColor = "{{asset('assets/images')}}/m2.png";
			            break;
			        case 3:
			            pinColor = "{{asset('assets/images')}}/m3.png";
			            break;
			        case 4:
			            pinColor = "{{asset('assets/images')}}/m4.png";
			            break;
			        case 5:
			            pinColor = "{{asset('assets/images')}}/m5.png";
			            break;
			        case 6:
			            pinColor = "{{asset('assets/images')}}/m7.png";
			            break;
			        default:
			            pinColor = "{{asset('assets/images')}}/m1.png";
			            break;
			    }
			  var markers = [];
			  var markerOptions = {
				lat: item.latitude,
				lng: item.longitude,
			    title: 'Home Owner Information',
			    icon: pinColor,
			    infoWindow: {
			      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
			    },

			  };

			  if(eventsPastCount != data.length) {
				  map.addMarker(markerOptions);
				  eventsPastCount++;
				}
			});
		});
		$.get('getAllAlertCount', function(data){
			mapAlerts.refresh();
			mapAlerts.removeMarkers();
			jQuery.each(data.emergency, function(index, item) {
				var markers = [];
				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m6.png",
				    infoWindow: {
				      content: '<p><h4>'+item.emergency_type+'</h4><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	//if(emergencyPastCount != data.emergency.length) {console.log('test');
				  	mapAlerts.addMarker(markerOptions);
				  	//emergencyPastCount++;
			  	//}
			});

			jQuery.each(data.caution, function(index, item) {
			  	var markers = [];
				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m2.png",
				    infoWindow: {
				      content: '<p><h4>'+item.caution_type+'</h4><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	//if(cautionPastCount != data.caution.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	//cautionPastCount++;
			  	//}
			});

			jQuery.each(data.issues, function(index, item) {
			  	var markers = [];
				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m1.png",
				    infoWindow: {
				      content: '<p><h4>'+item.issue_type+'</h4><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	//if(issuePastCount != data.issues.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	//issuePastCount++;
			  	//}
			});

			jQuery.each(data.unidentified, function(index, item) {
			  	var markers = [];
				var markerOptions = {
					lat: item.latitude,
					lng: item.longitude,
				    title: 'Home Owner Information',
				    icon: "{{asset('assets/images')}}/m7.png",
				    infoWindow: {
				      content: '<p><strong>'+item.homeowner_name+'</strong><br>'+item.homeowner_address+'</p>'
				    },
					mouseover: function(){
				        (this.infoWindow).open(this.mapAlerts, this);
				    }
			  	};

			  	//if(unidentifiedPastCount != data.unidentified.length) {
				  	mapAlerts.addMarker(markerOptions);
				  	//unidentifiedPastCount++;
			  	//}
			});
		});


		$.get('getTotalAlerts', function(data){
			$('#alertsTotalCount').html(data.alerts);
			$('#issuesTotalCount').html(data.issues);
			$('#eventsTotalCount').html(data.events);
			$('#unexpectedGuestsTotalCount').html(data.unexpected_guests);
		});

		$.get('getAlertsCount', function(data){
			jQuery.each(data, function(index, item) {
				$('#emergencyCount').html(item.emergencyCount);
				$('#cautionCount').html(item.cautionCount);
				$('#issuesCount').html(item.issuesCount);
				$('#unidentifiedAlertsCount').html(item.unidentifiedAlertsCount);
			});
		});

		$.get('getEventCount', function(data){
			var ctr = 1;
			var testingkolang = '';
			jQuery.each(data, function(index, item) {
				var icon = '<td><img src="'+"{{asset('assets/images')}}/m"+ctr+'.png" width="20"/></td>';
				testingkolang += '<tr class="odd gradeX"><td>' + item.category_name+ '</td><td>' + item.count+ '</td>'+icon+'</tr>';

				ctr++;
			});

			$('#eventList').html(testingkolang);
		});

	}, 20000);

	$.get('getEventCount', function(data){
		var ctr = 1;
		jQuery.each(data, function(index, item) {

			var icon = '<td><img src="'+"{{asset('assets/images')}}/m"+ctr+'.png" width="20"/></td>';
			$('#eventList').append('<tr class="odd gradeX"><td>' + item.category_name+ '</td>'+'<td>Loading...</td>'+icon+'</tr>');
			ctr++;
		});
	});
});

$(window).load(function(){
$.unblockUI();
$('.mapEvents').addClass('hidden');
})
</script>
