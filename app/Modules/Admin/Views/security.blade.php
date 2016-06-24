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
                        <h1 class="page-header"><i class="fa fa-shield"></i> Security Guards</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

		                    <div class="panel panel-default">
		                        <div class="panel-heading" style="height: 50px;">
		                            List of Security Guards
		                            <a href="" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#addSecurity"><i class="fa fa-plus"></i> Add new</a>
		                            <br class="clear"/>
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="residentials">
		                                    <thead>
		                                    	<tr>
		                                            <th>ID</th>
		                                            <th>Name</th>
		                                            <th>Username</th>
		                                            <th>Actions</th>

		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    	@foreach ($securities as $k => $v)

		                                        <tr class="odd gradeX">
		                                            <td>{{$v->user_id}}</td>
		                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
		                                            <td class="center">{{$v->username}}</td>
		                                            <td class="center">
		                                            	<button type="button" class="btn btn-info btn-circle" title="Edit" onclick="brgy.getUserById({{$v->user_id}},'#editSecFrm','#editSecurity')"><i class="fa fa-edit"></i></button>
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
</body>

@include('admin_includes/modals/security')
@include('admin_includes/footer')

<script>
	$(document).ready(function() {
        $('#residentials').DataTable({
                responsive: true
        });
    });

</script>
</html>
