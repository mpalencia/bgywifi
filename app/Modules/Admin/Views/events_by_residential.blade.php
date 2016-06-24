@include('admin_includes/header')
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
                        <h1 class="page-header">Greenlist/Events of {{$residential_name->name}}</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

		                    <div class="panel panel-default">
		                        <div class="panel-heading" style="height: 50px;">
		                           	Greenlist/Event List
		                            <!-- <a href="" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addEvent"><i class="fa fa-plus"></i> Add new</a> -->
		                            <br class="clear"/>
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="residentials">
		                                    <thead>
		                                    	<tr>
		                                    		<th>ID</th>
		                                            <th>Event Category</th>
		                                            <th>Event Name</th>
		                                            <th>Start Date</th>
		                                            <th>End Date</th>
		                                            <th>Actions</th>

		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($events as $k => $v)

		                                        <tr class="odd gradeX">
		                                        	<td>{{$v->eid}}</td>
		                                        	<td>{{$v->category_name}}</td>
		                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
		                                            <td class="center">{{date('M j, Y', strtotime($v->start))}}</td>
		                                            <td class="center">{{date('M j, Y', strtotime($v->end))}}</td>
		                                            <td class="center">
		                                            	<!-- <button type="button" class="btn btn-warning btn-circle" title="See guest list" onclick="brgy.getGuestList({{$v->eid}},'#editEvent')"><i class="fa fa-list-alt"></i></button>
		                                            	<button type="button" class="btn btn-info btn-circle" title="Edit" onclick="brgy.getUserById({{$v->eid}},'#editEventFrm','#editEvent')"><i class="fa fa-edit"></i></button> -->
		                                            	<button type="button" class="btn btn-danger btn-circle" title="Delete" onclick="brgy.deleteEventById({{$v->eid}})"><i class="fa fa-remove"></i></button>
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
</body>

@include('admin_includes/modals/event')
@include('admin_includes/footer')

<script>
	$(document).ready(function() {
        $('#residentials').DataTable({
                responsive: true
        });
    });

</script>
</html>
