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
                        <h1 class="page-header"><i class="fa fa-comment-o"></i> Issues/Suggestions/Complaints</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">
                			<div class="panel panel-info">
		                        <div class="panel-heading">
		                           	<i class="fa fa-comment-o"></i> Issues/Suggestions/Complaints
		                        </div>
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="issue">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Homeowner Name</th>
		                                    		<th>Issue Type</th>
		                                    		<th>Message</th>
		                                    		<th>Date & Time</th>
		                                    		<th>Status</th>
		                                    		<th>Action</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>

		                                    	@foreach ($issues as $i => $v)

		                                        <tr data-toggle="collapse" data-target="#row_{{$v->id}}" class="odd gradeX accordion-toggle" >
		                                        	<td>{{$v->user->first_name}} {{$v->user->last_name}}</td>
		                                        	<td>
		                                        		@if($v->issue_type == "1")
		                                        			Suggestion
		                                        		@elseif($v->issue_type == "2")
		                                        			Complaint
		                                        		@else
		                                        			Issue
		                                        		@endif

		                                        	</td>
		                                        	<td>{{$v->message}}</td>
		                                        	<td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>

		                                        	@if($v->resolved == 0)
		                                        		<td><span class="label label-danger">On-going</span></td>
		                                        	@else
		                                        		<td><span class="label label-success">Resolved</span></td>
		                                        	@endif
													<td>
		                                        		<button type="button" class="btn btn-primary btn-circle view-issue" title="View" data-toggle="modal" data-target="#issueModal"
		                                        			data-message="{{$v->action_taken}}"
		                                        			data-homeowner="{{$v->user->first_name}} {{$v->user->last_name}}"
		                                        			data-date="{{date_format(date_create($v->created_at),'M d, Y h:i A')}}"
		                                        			data-action-taken="{{$v->issuesActionTaken}}"
		                                        			data-home-owner-id="{{$v->home_owner_id}}"
		                                        			data-security-guard-id="{{\Auth::user()->id}}"
		                                        			data-status="{{$v->resolved}}"
		                                        			data-issue-id="{{$v->id}}"
		                                        			data-issue-type="{{$v->issue_type}}">
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
<script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
<script type="text/javascript">

	$('.actionTakenFieldAlert').hide();

	$('.view-issue').click(function(){
		$('.actionTakenFieldAlert').hide();
		$('.issue-title').html($(this).attr('data-issue'));
		$('.issue-date').html($(this).attr('data-date'));
		$('.issue-homeowner').html($(this).attr('data-homeowner'));
		$('.home_owner_id').val($(this).attr('data-home-owner-id'));
		$('.security_guard_id').val($(this).attr('data-security-guard-id'));
		$('.issue_id').val($(this).attr('data-issue-id'));
		$('.issue_type').val($(this).attr('data-issue-type'));

		if($(this).attr('data-status') == 0){
			$('#markAsResolvedBtn').show();
			$('#editissueActionTakenForm').show();
			$('#resolvedLabel').hide();
		}
		else{
			$('#markAsResolvedBtn').hide();
			$('#editissueActionTakenForm').hide();
			$('#resolvedLabel').show();
		}
		var output = '<table class="table table-striped table-bordered table-hover"><thead><tr><th>Reported By</th><th>Action Taken</th><th>Date</th><th>Time</th></tr></thead><tbody>';

		var json_obj = $.parseJSON($(this).attr('data-action-taken'));


		for (var i in json_obj)
        {
        	var created_at = json_obj[i].created_at;
	    	var date = created_at.replace(/-/g,'/');
	    	date = new Date(date);

        	output+="<tr>";
            output+="<td>" + json_obj[i].admin.first_name + " " + json_obj[i].admin.last_name + "</td>";
            output+="<td>" + json_obj[i].action_taken+ "</td>";
            output+="<td>" + date.toString("MMMM dd, yyyy")+ "</td>";
            output+="<td>" + date.toString("hh:mm:ss tt") + "</td>";
            output+="</tr>";
        }
        output+='</tbody></table>';


        $('#issue-action-taken').html(output);
	});

	$(document).ready(function() {
	    $('#issue').DataTable({
	            responsive: true
	    });
	});

</script>
</html>
