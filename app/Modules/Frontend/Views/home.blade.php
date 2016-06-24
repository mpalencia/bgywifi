@extends('master')

@section('modals')

	<div class="modal fade" id="modal-signup-group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Login</h4>
	      </div>
	      <div class="modal-body">
	      <div class="row">
	          
	      </div>
	       @if(session()->has('user_email'))

	       @else
	        <div class="row">
	            <div class="col-md-8 col-md-offset-2">
	                <p style="margin-bottom:0;margin-top:20px" id="wizard-title">Already Affiliated with Gabay?</p>
	               		<div id="form-ch-login">
	               			

							<div class="radio">
	                          <label>
	                            <input type="radio" name="haveAccount" value="true">
	                            Yes, I have Group ID
	                          </label>
	                        </div>
	                        <div class="radio">
	                          <label>
	                            <input type="radio" name="haveAccount" value="false">
	                            No, Please contact me
	                          </label>
	                        </div>

	                        
	                        <div id="send-email" style="display:none">
	                            <div class="form-group">
	                                <input type="email" class="form-control" id="" placeholder="Enter Email">
	                            </div>
	                        </div>
	                        <div id="login" style="display:none">
	                        	 <form method="post" action="">
		                    		<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
		                            <div class="form-group">
		                                <input type="text" class="form-control" name="code" placeholder="Enter Group ID">
		                            </div>
		                            <button class="btn btn-primary"  type="submit">Login</button>
	                            </form>
	              
	                        </div>
	               		</div>
	                        

	            </div>
	        </div>
	        @endif
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
	       
	      </div>
	    </div>
	  </div>
	</div>




	<div class="modal fade" id="modal-admin-login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Login</h4>
	      </div>
	      <div class="modal-body">
	      <div class="row">
	          
	      </div>
	       
	        <div class="row">
	            <div class="col-md-8 col-md-offset-2">
	            	<div id="login-error" class="alert alert-danger" style="display:none">
	            		
	            	</div>
	                <p style="margin-bottom:0;margin-top:20px" id="wizard-title">Please Login your Credentials</p>
	                <form method="POST" id="admin-login" action="login">
	                   <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
	                     <div class="form-group">
	                        <label for="exampleInputEmail1">Email address</label>
	                        <input type="email" class="form-control" name="email" placeholder="Email">
	                      </div>
	                      <div class="form-group">
	                        <label for="exampleInputPassword1">Password</label>
	                        <input type="password" class="form-control" name="password" placeholder="Password">
	                      </div>
	                      <button class="btn btn-primary" id="btn-login" type="submit">Login</button>
	                </form>

	            </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
	       
	      </div>
	    </div>
	  </div>
	</div>
	
	<div class="modal fade" id="modal-error" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-sm" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"> Login</h4>
	      </div>
	      <div class="modal-body">
	    
	     
	            @if($errors->any())
	                @foreach($errors->all() as $error)
	                    <div class="alert alert-danger">
	                        <p>{{ $error}}</p>
	                    </div>
	                @endforeach 
	            @endif
	            
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	       
	      </div>
	    </div>
	  </div>
	</div>
@stop

@section('nav')
	  <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top top-nav-collapse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">
                    GabayPH
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    
                    <li>
                        <a class="page-scroll" href="#" data-toggle="modal" data-target="#modal-signup-group" >Sign-Up My Group</a>
                    </li>
                    <li>
                        <a class="page-scroll" data-toggle="modal" data-target="#modal-admin-login"  href="#">Login</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

@stop

@section('content')
	  
    <section id="about" class="container">
        <div class="row" style="margin:0 auto;text-align:center;">
            <img src="http://gabaykristo.ph/public/images/GKsmall.png" />
        </div>
    </section>

@stop

@section('customScripts')
    <!-- Custom Theme JavaScript -->
    <script src="{{asset('js/frontend.js')}}"></script>
    <script>
   
    	 $(function(){

    	 	$('#admin-login').submit(function(e){
    	 		$('#btn-login').html('Please wait');
    	 		$('#btn-login').attr('disabled','disabled');
	             e.preventDefault();
	             var data = $(this).serialize();
	             $.ajax({
	              type: "POST",
	              url: "{{url('login')}}",
	              data: data,
	              dataType: 'json',
	              success: function(data){
	                
	                if(data.result == "success"){
	                	
	                    window.location.replace('{{url()}}/'+data.user);
	                }else if(data.result == "error"){
	                	$('#login-error').css('display','block');
	                	$('#login-error').html(data.dialog);
	                	$('#btn-login').html('Login');
    	 				$('#btn-login').removeAttr('disabled');
	                }
	              }
	            });
	        });     
    	 })</script>
@stop