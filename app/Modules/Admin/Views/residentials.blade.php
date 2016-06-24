@include('admin_includes/header')
<style type="text/css">
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}

</style>
<body>
	<input type="hidden" name="baseUrl" id="baseUrl" value="{{url('/')}}"/>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('admin_includes/nav_header')
            @include('admin_includes/sidebar')
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header"><i class="fa fa-home"></i> Residents</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

		                    <div class="panel panel-default">
	                        <div class="panel-heading" style="height: 50px;">
	                            List of Homeowners
	                            <a href="" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addResidentials"><i class="fa fa-plus"></i> Add new</a>
	                            <br class="clear"/>
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                            <div class="dataTable_wrapper">
	                                <table class="table table-striped table-bordered table-hover" id="residentials">
	                                    <thead>
	                                    	<tr>
	                                            <!-- <th>ID</th> -->
	                                            <th>Name</th>
	                                            <th>Username</th>
                                              <th>Email</th>
                                                <th>Contact</th>
	                                            <th>Actions</th>

	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    	@foreach ($homeowners as $k => $v)

	                                        <tr class="odd gradeX">
	                                            <!-- <td>{{$v->user_id}}</td> -->
	                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
	                                            <td class="center">{{$v->username}}</td>
                                              <td class="center">{{$v->email}}</td>
                                                <td class="center">{{$v->contact_no}}</td>
	                                            <td class="center">
	                                            	<a href="{{url('/')}}/admin/events/events_by_residential/{{$v->user_id}}" class="btn btn-primary btn-circle" title="Event List"><i class="fa fa-calendar"></i></a>
	                                            	<button type="button" class="btn btn-info btn-circle" title="Edit" onclick="brgy.getUserById({{$v->user_id}},'#editResFrm','#editResidentials')"><i class="fa fa-edit"></i></button>
                                                <!-- <button type="button" class="btn btn-success btn-circle" title="Edit Address, Longitude & Latitude" onclick="brgy.getUserAddressById({{$v->user_id}},'#editResAddFrm','#editResidentialAddress')"><i class="fa fa-map-marker"></i></button> -->
                                                <a class="btn btn-success btn-circle" href="{{url('/')}}/residentials/addressList/{{$v->user_id}}" title="Edit Address, Longitude & Latitude"><i class="fa fa-map-marker"></i></a>
	                                            	<button type="button" class="btn btn-danger btn-circle" title="Delete" onclick="brgy.deleteUserById({{$v->user_id}})"><i class="fa fa-remove"></i></button>
	                                            </td>
	                                        </tr>
	                                        @endforeach
	                         			      </tbody>
	                               	</table>
	                          	</div>
	                      	</div>
		                 	</div>
		            	</div>
		            </div>
            	</div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    @include('admin_includes/modals/residentials')

</body>



@include('admin_includes/footer')

<script>
	$(document).ready(function() {
        $('#residentials').DataTable({
                responsive: true
        });
    });

    $('.remove-field').hide();
	//$('ol').append('<li id="input_address_'+$ctr+'"><br><input name="input_remove_'+$ctr+'" type="text" class="form-control" placeholder="Address"> <a href="#" class="removeAddress pull-right" id="remove_'+$ctr+'"> Remove</a></li>');
	$('.multi-field-wrapper').each(function() {
	    var $wrapper = $('.multi-fields', this);
	    $(".add-field").click(function(e) {
	        $('.multi-field:first-child', $wrapper).clone(true).appendTo($wrapper).find('input').val('').focus();
	        $('.remove-field').show();
	    });
	    $('.multi-field .remove-field', $wrapper).click(function() {
	        if ($('.multi-field', $wrapper).length > 1)
	            $(this).parent('.multi-field').remove();

	        if ($('.multi-field', $wrapper).length == 1)
	        	$('.remove-field').hide();
	    });
	});

$('#editResidentialAddress').on('hidden.bs.modal', function () {
  window.location.reload();
})
  $(".add-field-update").click(function(e) {
     $('#bleh').append('<input name="addressId[] "type="text" class="addressId form-control"><input name="address[]"type="text" class="userAddress form-control" placeholder="Address">&nbsp;&nbsp;<input data-toggle="modal"  href="#myModal2" name="long_lat[]" onclick="initialize(this)" id="long_lat" type="text" class="user-long-lat form-control" placeholder="Add Latitude and Longitude" readonly="readonly"><a href="#" class="pull-right remove-field"  style="color:red"><i class="fa fa-times"></i> Remove</a>');
    });


/*(document).on('show.bs.modal', '.modal', function (event) {*/
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        /*});*/
</script>
<script type="text/javascript">
//<![CDATA[

 // global "map" variable
  var map = null;
  var marker = null;

  var infowindow = new google.maps.InfoWindow({
    size: new google.maps.Size(865,550)
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



function initialize(e) {
  // create the map


  var myOptions = {
    zoom: 17,
    center: new google.maps.LatLng(14.236847353627496,121.03732109069824),
    mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
   $("#myModal2").on("shown.bs.modal", function () {
      google.maps.event.trigger(map, "resize");
  });
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
      $(e).val(event.latLng.lat() +',' + event.latLng.lng());
  });
}

//]]>
</script>
</html>
