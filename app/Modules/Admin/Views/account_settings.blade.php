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
                        <h1 class="page-header"><i class="fa fa-gear"></i> User Settings</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">
                			<div class="panel panel-info">
		                        <div class="panel-heading">
		                           	Account Settings
		                        </div>
		                        <div class="panel-body">
		                        	@if(Session::has('success_flash_message'))
										<div class="alert alert-success">
										    {{ Session::get('success_flash_message') }}
										    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
										</div>
									@endif
									@if($errors->any())
									    <div class="alert alert-danger">
									    	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>

									        @foreach($errors->all() as $error)
									            <p>{{ $error }}</p>
									        @endforeach

									    </div>
									@endif
		                        	{!! Form::model($admin, ['method' => 'PUT','route' => ['admin.account_settings.update', $admin->id]]) !!}
									  	<div class="form-group">
										    {!! Form::label('username', 'Username:', ['class' => 'control-label']) !!}
										    {!! Form::text('username', null, ['class' => 'form-control']) !!}
										</div>

										<div class="form-group">
										    {!! Form::label('password', 'Password:', ['class' => 'control-label']) !!}

										    <input type="password" name="password" class="form-control"></input>
										</div>

										<div class="form-group">
										    {!! Form::label('password_confirmation', 'Confirm Password:', ['class' => 'control-label']) !!}
										    <input type="password" name="password_confirm" class="form-control"></input>
										</div>

										{!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
									{!! Form::close() !!}
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

@include('admin_includes/modals/issue')
@include('admin_includes/footer')

</html>
