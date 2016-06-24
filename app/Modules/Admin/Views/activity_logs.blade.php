@include('admin_includes/header')
<style>

	.visitors_photo{
		height:100px;
		width:100px;
		background-size: cover;
		background-position:center center;
	}
	#visitors td{
		 vertical-align:middle;
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
                        <h1 class="page-header"><i class="fa fa-history fa-fw"></i> Activity Logs</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">
                			<div class="panel panel-danger">
		                        <div class="panel-heading">
		                           	<i class="fa fa-exclamation-circle"></i> Emergencies
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="emergency">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Emergency</th>
		                                    		<th>Homeowner</th>
		                                    		<th>Address</th>
		                                    		<th>Date & Time</th>
		                                    		<th>View</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($emergency as $e => $v)

		                                        <tr data-toggle="collapse" data-target="#row_{{$v->id}}" class="odd gradeX accordion-toggle" >
		                                        	<td>{{$v->emergencyType->description}}</td>
		                                        	<td>{{$v->user->first_name}} {{$v->user->last_name}}</td>
		                                        	<td>{{$v->homeownerAddress->address}}</td>
		                                        	<td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
		                                        	<td>
		                                        		<button type="button" class="btn btn-info btn-circle view-emergency" title="View" data-toggle="modal" data-target="#emergencyModal"
		                                        			data-emergency="{{$v->emergencyType->description}}"
		                                        			data-homeowner="{{$v->user->first_name}} {{$v->user->last_name}}"
		                                        			data-date="{{date_format(date_create($v->created_at),"M d, Y h:i A")}}"
		                                        			data-action-taken="{{$v->actionTaken}}">
		                                        		<i class="glyphicon glyphicon-eye-open"></i>
		                                        		</button>
	                                        		</td>
		                                        </tr>

		                                        @endforeach
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
		                 	<div class="panel panel-warning">
		                        <div class="panel-heading">
		                           	<i class="fa fa-exclamation-triangle"></i> Caution
		                        </div>
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="caution">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Caution</th>
		                                    		<th>Homeowner</th>
		                                    		<th>Message</th>
		                                    		<th>Address</th>
		                                    		<th>Date & Time</th>
		                                    		<th>View</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($caution as $c => $v)

		                                        <tr data-toggle="collapse" data-target="#row_{{$v->id}}" class="odd gradeX accordion-toggle" >
		                                        	<td>{{$v->cautionType->description}}</td>
		                                        	<td>{{$v->user->first_name}} {{$v->user->last_name}}</td>
		                                        	<td>{{$v->message}}</td>
		                                        	<td>{{$v->homeownerAddress->address}}</td>
		                                        	<td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
		                                        	<td>
		                                        		<button type="button" class="btn btn-info btn-circle view-caution" title="View" data-toggle="modal" data-target="#cautionModal"
		                                        			data-caution="{{$v->cautionType->description}}"
		                                        			data-homeowner="{{$v->user->first_name}} {{$v->user->last_name}}"
		                                        			data-date="{{date_format(date_create($v->created_at),'M d, Y h:i A')}}"
		                                        			data-action-taken="{{$v->actionTaken}}">
		                                        		<i class="glyphicon glyphicon-eye-open"></i>
		                                        		</button>
	                                        		</td>
		                                        </tr>

		                                        @endforeach
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                           <i class="fa fa-users"></i>	Visitors
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="visitors">
		                                    <thead>
		                                    	<tr>
		                                    		<th width="10%">Photo</th>
		                                            <th>Visitor Name</th>
		                                            <th>Car Description</th>
		                                            <th>Plate No</th>
		                                            <th>Homeowner Name</th>
		                                            <th>Date Visited </th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($visitors as $k => $v)

		                                        <tr class="odd gradeX" >
		                                        	<td>
		                                        		<div class="visitors_photo" style="background-image:url(http://bgywifi.devhub.ph/public/visitors-images/{{$v->visitors_id}}/{{$v->photo}});">
		                                        	</td>
		                                        	<td>{{$v->name}}</td>
		                                            <td>{{$v->car_description}}</td>
		                                            <td>{{$v->plate_number}}</td>
		                                            <td>{{$v->fhname}} {{$v->lhname}}</td>
		                                            <td class="center">{{date('M j, Y', strtotime($v->created_at))}}</td>
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
    <div class="modal fade" id="emergencyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><span id="emergency-homeowner"></span></h4>
	        <h5 class="modal-title" id="myModalLabel"><span id="emergency-date"></span></h5>
	      </div>
	      <div class="modal-body">
	      <span id="emergency-action-taken"></span>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="modal fade" id="cautionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><span id="caution-homeowner"></span></h4>
	        <h5 class="modal-title" id="myModalLabel"><span id="caution-date"></span></h5>
	      </div>
	      <div class="modal-body">
	      <span id="caution-action-taken"></span>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
	      </div>
	    </div>
	  </div>
	</div>
</body>

@include('admin_includes/modals/event')
@include('admin_includes/footer')
<script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
<script type="text/javascript">
	$('.view-emergency').click(function(){
		$('#emergency-title').html($(this).attr('data-emergency'));
		$('#emergency-date').html($(this).attr('data-date'));
		$('#emergency-homeowner').html($(this).attr('data-homeowner'));

		var output = '<table class="table table-striped table-bordered table-hover"><thead><tr><th>Security Guard</th><th>Action Taken</th><th>Date</th><th>Time</th></tr></thead><tbody>';

		var json_obj = $.parseJSON($(this).attr('data-action-taken'));


		for (var i in json_obj)
        {
        	var created_at = json_obj[i].created_at;
	    	var date = created_at.replace(/-/g,'/');
	    	date = new Date(date);

        	output+="<tr>";
            output+="<td>" + json_obj[i].security.first_name + " " + json_obj[i].security.last_name + "</td>";
            output+="<td>" + json_obj[i].action_taken_type.message+ "</td>";
            output+="<td>" + date.toString("MMMM dd, yyyy")+ "</td>";
            output+="<td>" + date.toString("hh:mm:ss tt") + "</td>";
            output+="</tr>";
        }
        output+='</tbody></table>';
        $('#emergency-action-taken').html(output);
	});

$('.view-caution').click(function(){
	$('#caution-title').html($(this).attr('data-caution'));
	$('#caution-date').html($(this).attr('data-date'));
	$('#caution-homeowner').html($(this).attr('data-homeowner'));

	var output = '<table class="table table-striped table-bordered table-hover"><thead><tr><th>Security Guard</th><th>Action Taken</th><th>Date</th><th>Time</th></tr></thead><tbody>';
	var json_obj = $.parseJSON($(this).attr('data-action-taken'));


	for (var i in json_obj)
    {
    	var created_at = json_obj[i].created_at;
    	var date = created_at.replace(/-/g,'/');
    	date = new Date(date);


    	output+="<tr>";
        output+="<td>" + json_obj[i].security.first_name + " " + json_obj[i].security.last_name + "</td>";
        output+="<td>" + json_obj[i].action_taken_type.message+ "</td>";
        output+="<td>" + date.toString("MMMM dd, yyyy")+ "</td>";
        output+="<td>" + date.toString("hh:mm:ss tt") + "</td>";
        output+="</tr>";
    }
    output+='</tbody></table>';

    $('#caution-action-taken').html(output);
});

$(document).ready(function() {
    $('#visitors').DataTable({
            responsive: true
    });
    $('#emergency').DataTable({
            responsive: true
    });
    $('#caution').DataTable({
            responsive: true
    });
});

</script>
</html>
