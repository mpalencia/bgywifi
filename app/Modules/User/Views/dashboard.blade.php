@extends('master')
@section('head')
	
	 	<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="">
	    <meta name="author" content="">

	    <title>GabayPH</title>

	    <!-- Bootstrap Core CSS -->
	    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- Plugins CSS -->
        <link href="{{asset('css/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/dataTables/dataTables.responsive.css')}}" rel="stylesheet">
        <link href="{{asset('css/dataTables/dataTables.tableTools.min.css')}}" rel="stylesheet">


	    <!-- Custom CSS -->
	    <link href="{{asset('css/frontend.css')}}" rel="stylesheet">

	    <!-- Custom Fonts -->
	    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
        <style>
            tr{
                cursor:pointer;
            }
        </style>
	  

	    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	    <!--[if lt IE 9]>
	        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	    <![endif]-->

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
                   
                    <li>
                        <a  href="{{url('/logout')}}">Logout</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

@stop

@section('content')

    <div class="container">
        <div class="row" style="padding:20px 0;">
            <div class="col-md-3"><h4>Some info about<br>the admin here</h4>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab in aut vitae tempore similique cupiditate, atque ad reiciendis asperiores maiores dolores necessitatibus accusamus, dicta quae eveniet. Tempore, asperiores. Totam, voluptates?
            </div>
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        
                        
                    <h3>Chapter Heads</h3>
                        <table id="heads" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th>Chapter</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Code</th>
                                    <th>Chapter</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>

                               
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>Sample@sample.com</td>
                                        <td>(codehere)</td>
                                        <td>Couples for Chirst</td>
                                        <td><button class="btn btn-sm btn-info"><i class="fa fa-edit"></i></button></td>
                                        
                                    </tr>
                               
                            </tbody>
                        </table>
                    
                    <h3>Members in CFC</h3>
                   
                         <table id="members" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                                 @foreach($members as $key => $value)
                                     <tr>
                                        <th>{{$value->mobile_number}}</th>
                                        <th>Action here</th>
                                       
                                    </tr>

                                  @endforeach
                     
                            <tfoot>
                                <tr>
                                    <th>Number</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
        </div>
    </div>
	  

    
@stop

@section('scripts')
	 <!-- jQuery -->
    <script src="{{asset('js/jquery.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>

    <!-- Plugin JavaScript -->
    <script src="{{asset('js/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('js/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.tableTools.min.js')}}"></script>
    


    <!-- Custom Theme JavaScript -->
    <script>
    $(function(){
        $('#heads').dataTable().on( 'click', 'tr', function () {
            alert('reload member using ajax');
            //ajax here
            //
            //sample data:
            var data = [["Trident","Internet Explorer 4.0"]]
            
            var members = $('#members').dataTable()
            members.fnClearTable();
            members.fnAddData(data,true);
        });
        
       
        

    })
    </script>
@stop