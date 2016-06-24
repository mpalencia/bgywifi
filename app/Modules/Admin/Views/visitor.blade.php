@include('admin_includes/header')
<style>

	.visitors_photo{
		height:100px;
		width:100px;
		background-size: cover;
		background-position:center center;
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
                        <h1 class="page-header"><i class="fa fa-users fa-fw"></i> Unexpected Visitors</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                           	List of Unexpected Visitors
		                            <!-- <a href="" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addEvent"><i class="fa fa-plus"></i> Add new</a> -->
		                            <br class="clear"/>
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="visitors">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Photo</th>
		                                    		<th>Purpose of Visit</th>
		                                            <th>Visitor Name</th>
		                                            <th>Plate Number</th>
		                                            <th>Car Description</th>
		                                            <th>Home Owner Name</th>
		                                            <th>Status</th>
		                                            <th>Date time </th>
		                                            <!-- <th>Actions</th> -->

		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($visitors as $k => $v)

		                                        <tr class="odd gradeX">
		                                        	<td>
		                                        		<div class="visitors_photo" style="background-image:url(http://bgywifi-uat.devhub.ph/public/visitors-images/{{$v->nid}}/{{$v->photo}});">
		                                        	</td>
		                                        	<td>{{$v->category_name}}</td>
		                                        	<td>{{$v->name}}</td>
		                                        	<td>{{$v->plate_number}}</td>
		                                        	<td>{{$v->car_description}}</td>
		                                        	<td>{{$v->fname}} {{$v->lname}}</td>
		                                        	<td>
		                                            	@if($v->status == 0)
		                                            		<span class="label label-warning">Waiting</span>
		                                            	@elseif($v->status == 1)
		                                            		<span class="label label-success">Accepted</span>
		                                            	@else
		                                            		<span class="label label-danger">Denied</span>
		                                            	@endif
		                                            </td>
		                                            <td class="center">{{date('M j, Y', strtotime($v->created_at))}}</td>
		                                            <!-- <td class="center">
		                                            	<button type="button" class="btn btn-warning btn-circle" title="See guest list" onclick="brgy.getGuestList({{$v->eid}},'#editEvent')"><i class="fa fa-list-alt"></i></button>
		                                            	<button type="button" class="btn btn-info btn-circle" title="Edit" onclick="brgy.getUserById({{$v->eid}},'#editEventFrm','#editEvent')"><i class="fa fa-edit"></i></button>
		                                            	<button type="button" class="btn btn-danger btn-circle" title="Delete" onclick="brgy.deleteEventById({{$v->eid}})"><i class="fa fa-remove"></i></button>
		                                            </td> -->
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
</body>

@include('admin_includes/modals/event')
@include('admin_includes/footer')

<script>
	$(document).ready(function() {
        $('#visitors').DataTable({
                responsive: true
        });
    });

</script>
</html>
