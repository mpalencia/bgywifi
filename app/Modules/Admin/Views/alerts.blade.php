@include('admin_includes/header')
<style type="text/css">
  .modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
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
                        <h1 class="page-header"><i class="fa fa-bell fa-fw"></i> Alerts</h1>
                    </div>
                    <div class="row">
                		<div class="col-lg-12">

							<div class="panel panel-danger">
								<div class="panel-heading">
									<i class="fa fa-question-circle"></i> Unidentified Alerts
								</div>
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="unidentified_alerts_ajax"></table>
									</div>
								</div>
							</div>

							<div class="panel panel-danger">
								<div class="panel-heading" style="height:55px;">
									<i class="fa fa-bell"></i> Emergencies
									<!-- <button class="btn btn-danger pull-right"><i class="fa fa-plus"></i> Add Emergency</button> -->
								</div>
								<div class="panel-body">
									<div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="emergencyAlertAjax"></table>
									</div>
								</div>
							</div>

		                 	<div class="panel panel-warning">
		                        <div class="panel-heading" style="height:55px;">
		                           	<i class="fa fa-exclamation-triangle"></i> Caution
		                           	<!-- <button class="btn btn-warning pull-right"><i class="fa fa-plus"></i> Add Caution</button> -->
		                        </div>
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
										<table class="table table-striped table-bordered table-hover" id="cautionAlertAjax"></table>
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
@include('admin_includes/modals/alerts')
@include('admin_includes/modals/event')
@include('admin_includes/footer')
<script type="text/javascript" src="http://www.datejs.com/build/date.js"></script>
<script type="text/javascript">

	$('.actionTakenFieldAlert').hide();
	function markasClick(unidentified)
	{
		$('.editMarkAsUpdateAlert').hide();
		$('.unidentified-title').html($(unidentified).attr('data-unidentified'));
		$('.unidentified-date').html($(unidentified).attr('data-date'));
		$('.unidentified-homeowner').html($(unidentified).attr('data-homeowner'));
		$('.home_owner_id').val($(unidentified).attr('data-home-owner-id'));
		$('.security_guard_id').val($(unidentified).attr('data-security-guard-id'));
		$('.unidentified_id').val($(unidentified).attr('data-unidentified-id'));

		if($(unidentified).attr('data-unidentified-status') != 1){
			$('#editunidentifiedActionTakenForm').show();
			$('#resolvedunidentifiedLabel').hide();
		}
		else{
			$('#editunidentifiedActionTakenForm').hide();
			$('#resolvedunidentifiedLabel').show();
		}
	}
	function unidentifiedClick(unidentified)
	{
		$('.actionTakenFieldAlert').hide();
		$('.unidentified-title').html($(unidentified).attr('data-unidentified'));
		$('.unidentified-date').html($(unidentified).attr('data-date'));
		$('.unidentified-homeowner').html($(unidentified).attr('data-homeowner'));
		$('.home_owner_id').val($(unidentified).attr('data-home-owner-id'));
		$('.security_guard_id').val($(unidentified).attr('data-security-guard-id'));
		$('.unidentified_id').val($(unidentified).attr('data-unidentified-id'));

		if($(unidentified).attr('data-unidentified-status') != 1){
			$('#editunidentifiedActionTakenForm').show();
			$('#resolvedunidentifiedLabel').hide();
		}
		else{
			$('#editunidentifiedActionTakenForm').hide();
			$('#resolvedunidentifiedLabel').show();
		}

		var nColNumber = -1;
		var unidentified_update_ajax = $('#unidentifiedUpdateAjax').DataTable({
			'ajax': 'getUnidentifiedUpdate/' + $(unidentified).attr('data-unidentified-id'),
			'columnDefs': [
				{ 'targets': [ ++nColNumber ], 'title':'Action Taken', 'name': 'action_taken_type', 'data': 'action_taken_type' },
				{ 'targets': [ ++nColNumber ], 'title':'Date', 'name': 'date', 'data': 'date' },
				{ 'targets': [ ++nColNumber ], 'title':'Time', 'name': 'time', 'data': 'time'},
				{ 'targets': [ ++nColNumber ], 'title':'Reported BY', 'name': 'reported_by', 'data': 'reported_by'}
			]
		});
		unidentified_update_ajax.destroy();
	}
	function emergencyClick(emergency)
	{
		$('.actionTakenFieldAlert').hide();
		$('.emergency-title').html($(emergency).attr('data-emergency'));
		$('.emergency-date').html($(emergency).attr('data-date'));
		$('.emergency-homeowner').html($(emergency).attr('data-homeowner'));
		$('.home_owner_id').val($(emergency).attr('data-home-owner-id'));
		$('.security_guard_id').val($(emergency).attr('data-security-guard-id'));
		$('.emergency_id').val($(emergency).attr('data-emergency-id'));

		if($(emergency).attr('data-emergency-status') != 1){
			$('#editEmergencyActionTakenForm').show();
			$('#resolvedEmergencyLabel').hide();
		}
		else{
			$('#editEmergencyActionTakenForm').hide();
			$('#resolvedEmergencyLabel').show();
		}

		var nColNumber = -1;
		var emergency_update_ajax = $('#emergencyUpdateAjax').DataTable({
			'ajax': 'getEmergencyUpdate/' + $(emergency).attr('data-emergency-id'),
			'columnDefs': [
				{ 'targets': [ ++nColNumber ], 'title':'Action Taken', 'name': 'action_taken_type', 'data': 'action_taken_type' },
				{ 'targets': [ ++nColNumber ], 'title':'Date', 'name': 'date', 'data': 'date' },
				{ 'targets': [ ++nColNumber ], 'title':'Time', 'name': 'time', 'data': 'time'},
				{ 'targets': [ ++nColNumber ], 'title':'Reported BY', 'name': 'reported_by', 'data': 'reported_by'}
			]
		});
		emergency_update_ajax.destroy();
	}
	function cautionClick(caution)
	{
		$('.actionTakenFieldAlert').hide();
		$('.caution-title').html($(caution).attr('data-caution'));
		$('.caution-date').html($(caution).attr('data-date'));
		$('.caution-homeowner').html($(caution).attr('data-homeowner'));
		$('.home_owner_id').val($(caution).attr('data-home-owner-id'));
		$('.security_guard_id').val($(caution).attr('data-security-guard-id'));
		$('.caution_id').val($(caution).attr('data-caution-id'));

		if($(caution).attr('data-caution-status') != 1){
			$('#editCautionActionTakenForm').show();
			$('#resolvedCautionLabel').hide();
		}
		else{
			$('#editCautionActionTakenForm').hide();
			$('#resolvedCautionLabel').show();
		}

		var nColNumber = -1;
		var caution_update_ajax = $('#cautionUpdateAjax').DataTable({
			'ajax': 'getCautionUpdate/' + $(caution).attr('data-caution-id'),
			'columnDefs': [
				{ 'targets': [ ++nColNumber ], 'title':'Action Taken', 'name': 'action_taken_type', 'data': 'action_taken_type' },
				{ 'targets': [ ++nColNumber ], 'title':'Date', 'name': 'date', 'data': 'date' },
				{ 'targets': [ ++nColNumber ], 'title':'Time', 'name': 'time', 'data': 'time'},
				{ 'targets': [ ++nColNumber ], 'title':'Reported BY', 'name': 'reported_by', 'data': 'reported_by'}
			]
		});
		caution_update_ajax.destroy();
	}


	/*$('.view-caution').click(function(){
		$('.actionTakenFieldAlert').hide();
		$('.caution-title').html($(this).attr('data-caution'));
		$('.caution-date').html($(this).attr('data-date'));
		$('.caution-homeowner').html($(this).attr('data-homeowner'));
		$('.home_owner_id').val($(this).attr('data-home-owner-id'));
		$('.security_guard_id').val($(this).attr('data-security-guard-id'));
		$('.caution_id').val($(this).attr('data-caution-id'));

		if($(this).attr('data-caution-status') != 1){
			$('#editCautionActionTakenForm').show();
			$('#resolvedCautionLabel').hide();
		}
		else{
			$('#editCautionActionTakenForm').hide();
			$('#resolvedCautionLabel').show();
		}

		var output = '<table class="table table-striped table-bordered table-hover"><thead><tr><th>Reported By</th><th>Action Taken</th><th>Date</th><th>Time</th></tr></thead><tbody>';

		var json_obj = $.parseJSON($(this).attr('data-action-taken'));


		for (var i in json_obj)
        {
        	var created_at = json_obj[i].created_at;
	    	var date = created_at.replace(/-/g,'/');
	    	date = new Date(date);

        	output+="<tr>";
            output+="<td>" + json_obj[i].security.first_name + " " + json_obj[i].security.last_name + "</td>";
            output+="<td>" + json_obj[i].action_taken_type.message+ "</td>";
            output+="<td>" + date.toString("MMMM dd, yyyy")+ "</td>";
            output+="<td>" + date.toString("hh:mm:ss tt") + "</td>";
            output+="</tr>";
        }
        output+='</tbody></table>';


        $('#caution-action-taken').html(output);
	});*/

$(document).ready(function() {

	var nColNumber = -1;
    var unidentified_alerts_ajax = $('#unidentified_alerts_ajax').DataTable({
		'ajax': 'getUnidentified',
		"order": [[ 2, "desc" ]],
		'columnDefs': [
			{ 'targets': [ ++nColNumber ], 'title':'Homeowner Name', 'name': 'homeowner_name', 'data': 'homeowner_name' },
			{ 'targets': [ ++nColNumber ], 'title':'Address', 'name': 'address', 'data': 'address' },
			{ 'targets': [ ++nColNumber ], 'title':'Date & Time', 'name': 'date_&_time', 'data': 'date_&_time'},
			{ 'targets': [ ++nColNumber ], 'title':'Action', 'name': 'action', 'data': 'action'},
			{ 'targets': [ ++nColNumber ], 'title':'Mark As', 'name': 'markButton', 'data': 'markButton'}]
    });

	var nColNumberE = -1;

	var emergency_alert_ajax = $('#emergencyAlertAjax').DataTable({
		'ajax': 'getEmergencies',
		"order": [[ 3, "desc" ]],
		'columnDefs': [
			{ 'targets': [ ++nColNumberE ], 'title':'Emergency', 'name': 'emergency_type', 'data': 'emergency_type' },
			{ 'targets': [ ++nColNumberE ], 'title':'Homeowner Name', 'name': 'homeowner_name', 'data': 'homeowner_name' },
			{ 'targets': [ ++nColNumberE ], 'title':'Address', 'name': 'address', 'data': 'address' },
			{ 'targets': [ ++nColNumberE ], 'title':'Date & Time', 'name': 'date_&_time', 'data': 'date_&_time'},
			{ 'targets': [ ++nColNumberE ], 'title':'Status', 'name': 'status', 'data': 'status'},
			{ 'targets': [ ++nColNumberE ], 'title':'Action', 'name': 'action', 'data': 'action'}]
	});

	var nColNumberC = -1;

	var caution_alert_ajax = $('#cautionAlertAjax').DataTable({
		'ajax': 'getCautions',
		"order": [[ 3, "desc" ]],
		'columnDefs': [
			{ 'targets': [ ++nColNumberC ], 'title':'Caution', 'name': 'caution_type', 'data': 'caution_type' },
			{ 'targets': [ ++nColNumberC ], 'title':'Homeowner Name', 'name': 'homeowner_name', 'data': 'homeowner_name' },
			{ 'targets': [ ++nColNumberC ], 'title':'Address', 'name': 'address', 'data': 'address' },
			{ 'targets': [ ++nColNumberC ], 'title':'Date & Time', 'name': 'date_&_time', 'data': 'date_&_time'},
			{ 'targets': [ ++nColNumberC ], 'title':'Status', 'name': 'status', 'data': 'status'},
			{ 'targets': [ ++nColNumberC ], 'title':'Action', 'name': 'action', 'data': 'action'}]
	});

	setInterval( function () {
 		unidentified_alerts_ajax.ajax.reload();
		emergency_alert_ajax.ajax.reload();
		caution_alert_ajax.ajax.reload();
	}, 20000 );

});

</script>
</html>
