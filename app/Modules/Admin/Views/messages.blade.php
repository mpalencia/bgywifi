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
                        <h1 class="page-header"><i class="fa fa-envelope fa-fw"></i> Messages</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

		                    <div class="panel panel-default">
		                        <div class="panel-heading" style="height: 50px;">
		                           	Messages
		                            <a href="#" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#composeMsg"><i class="fa fa-envelope"></i> Compose</a>
		                            <br class="clear"/>
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="msgs">
		                                    <thead>
		                                    	<tr>
		                                    		<th>From</th>
		                                    		<th>To</th>
		                                            <th>Message</th>
		                                            <th>Date time </th>
		                                            <th>Actions</th>

		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($messages as $k => $v)

		                                        <tr class="odd gradeX">
		                                        	<td>{{$v->from_user->first_name}} {{$v->from_user->last_name}}</td>
		                                        	<td>{{$v->to_user->first_name}} {{$v->to_user->last_name}}</td>
		                                            <td>{{$v->message}}</td>
		                                            <td class="center">{{date('h:m A - M j, Y', strtotime($v->created_at))}}</td>
		                                            <td class="center">
		                                            	<button type="button" class="btn btn-danger btn-circle" title="Delete" onclick="brgy.deleteMessage({{$v->id}})"><i class="fa fa-remove"></i></button>
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

@include('admin_includes/modals/message')
@include('admin_includes/footer')

<script>
	$(document).ready(function() {
        $('#msgs').DataTable({
                responsive: true
        });
    });

</script>
</html>
