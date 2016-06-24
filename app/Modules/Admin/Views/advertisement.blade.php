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
                        <h1 class="page-header"><i class="fa fa-image"></i> Advertisement</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                           	Upload Image
		                        </div>
		                        <div class="panel-body">
	                        	 	@if(Session::has('success'))

							          <div class="alert alert-success" role="alert">
							          	<i class="fa fa-check"></i> {!! Session::get('success') !!}
							          	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
							          </div>

							        @endif
							        @if(Session::has('error'))
							        <div class="alert alert-danger" role="alert">
										<i class="fa fa-exclamation-triangle"></i> {!! Session::get('error') !!}
							          	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
						          	</div>
						          	@endif

		                        	{!! Form::open(array('url'=>'admin/advertisement/upload','method'=>'POST', 'files'=>true)) !!}

		                        		{!! Form::file('image', ['id' => 'adImage', 'class'=>'hidden']) !!}

										<div class="input-group">
									      	<input type="text" id="tempFile" name="test" class="form-control" onclick="$('#adImage').click();" placeholder="Click here to upload photo for advertisement" readonly>
									      	<span class="input-group-btn">

										        <button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload</button>
										    </span>
									    </div>

								    {!! Form::close()!!}
								    <hr>
								     <label for="current_photo">Current Photo</label><br>
									<img src="{{asset('advertisement/advertisement.jpg')}}" alt="..." class="img-thumbnail" style="height: 244px;width: 244px">
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
	$('#adImage').change(function(){
     $('#tempFile').val($(this).val());
});

	/*$(document).ready(function() {
        $('#residentials').DataTable({
                responsive: true
        });
        $('#start').datetimepicker();
    });
*/
</script>
</html>
