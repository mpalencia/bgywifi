@extends('master')
@section('head')
	
        <!-- Plugins CSS -->
        <link href="{{asset('css/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/dataTables/dataTables.responsive.css')}}" rel="stylesheet">
        <link href="{{asset('css/dataTables/dataTables.tableTools.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/fileinput/fileinput.min.css')}}" rel="stylesheet">



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
                   <li id="users-btn">
                        <a  href="{{url('/admin')}}">Users</a>
                    </li>
                    <li id="candidates-btn">
                        <a  href="{{url('/admin/candidates')}}">Candidates</a>
                    </li>
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
            
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        
                    <h3>Chapter Heads</h3>
                        <table id="heads" class="table table-striped table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10">#</th>
                                     <th>Name</th>
                                    <th>Email</th>
                                    <th>Organization</th>
                                    <th>Chapter</th>
                                    
                                    <th>Group</th>
                                    <th># of Members</th>
                                    <th>Code</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                <th width="10">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                     <th>Organization</th>
                                    <th>Chapter</th>
                                   
                                    <th>Group</th>
                                    <th># of Members</th>
                                    <th>Code</th>
                                    <th>Mobile</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                     
                            <tbody>
                                <?php $i = 1?>
                                @foreach ($users as $key => $value)
                                <tr class="clickable" data-id="{{$value->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->email}}</td>
                                    <td>{{$value->organization_name}}</td>
                                    <td>{{$value->chapter}}</td>
                                    
                                    <td>{{$value->group_name}}</td>
                                    <td>{{$value->number_of_members}}</td>
                                    <td>{{$value->code}}</td>
                                     <td>{{$value->mobile}}</td>
                                    
                                    <td><a onclick="return confirm('Are you sure you want to delete this Chapter head?')" href="{{url('admin/deleteUser/'.$value->id)}}" class="btn btn-block btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                                    
                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>

                        <div class="row">
                            <div class="col-md-7">
                                <form class="form-horizontal">
                                  
                                  <div id="errors" style="display:none" class="alert alert-danger">
                                    <strong>Error!</strong>
                                      <p></p>
                                  </div>
                                  <label class="control-label">Select File</label>
                                  <input accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="upload" type="file" class="file" name="upload" data-show-preview="false">
                                </form>
                            </div>
                        </div>
                        

                    <h3 style="padding-top:20px">Members in CFC</h3>
                   
                         <table id="members" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                   
                                </tr>
                            </thead>
                     
                            <tfoot>
                                <tr>
                                    <th>Number</th>
                                    
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

@section('customScripts')

    <script src="{{asset('js/dataTables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('js/dataTables/dataTables.tableTools.min.js')}}"></script>
    <script src="{{asset('js/fileinput/fileinput.min.js')}}"></script>
    


    <!-- Custom Theme JavaScript -->
    <script>
    $(function(){
        $("#users-btn").addClass('active');
        $('#heads').dataTable({
            "bSort" : false
        }).on( 'click', '.clickable', function () {
            
            $.post("{{url('admin/getChapterMembers')}}",{chapter_id:$(this).data('id')}, function( data ) {
                if(data.length == 0){
                    data = "0";
                }
                var members = $('#members').dataTable()
                members.fnClearTable();
                members.fnAddData(data,true);
            },'json');
            
        });
        
    })

    $('#upload').fileinput({
      allowedFileExtensions: ['xls','xlsx','csv'],
      removeClass: 'btn btn-danger',
      removeTitle: 'Remove',
      uploadClass: 'btn btn-info',
      uploadAsync: true,
      showCancel: false,
      uploadUrl: "{{url('admin/uploadUsers')}}", // your upload server url
      
      }).on('fileuploaded', function(event, data, previewId, index) {
          var form = data.form, files = data.files, extra = data.extra,
          response = data.response, reader = data.reader;
          //console.log(response);
          $('#errors p').html('');

          if(response.result == 'success'){
            alert(response.dialog);
            location.reload();
          }else if(response.result == 'error'){
            $('#errors').show();
            $('#errors p').html(response.dialog);
            console.log(response.dialog);
          }else if(response.result == 'errors'){
            $('#errors').show();
            var err = '';
            for (var i = response.dialog.length - 1; i >= 0; i--) {
                err += response.dialog[i];
            };
             $('#errors p').html(err);
          }
      
      });
    
   
    </script>
@stop