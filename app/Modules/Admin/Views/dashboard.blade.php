<?php
?>
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
                        <h1 class="page-header"><i class="fa fa-dashboard fa-fw"></i> Dashboard</h1>
                    </div>
                    <div class="row">
		                <div class="col-lg-3 col-md-6">
		                    <div class="panel panel-red">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-bell fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><span id="alertsTotalCount">{{$alerts}}</span></div>
		                                    <div>Alerts</div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="{{url('/')}}/admin/alerts">
		                            <div class="panel-footer">
		                                <span class="pull-left">Manage Alerts</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>

		                <div class="col-lg-3 col-md-6">
		                    <div class="panel panel-yellow">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-exclamation-triangle fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><span id="issuesTotalCount">{{$issues}}</span></div>
		                                    <div>Issues</div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="{{url('/')}}/admin/issues">
		                            <div class="panel-footer">
		                                <span class="pull-left">Manage Issues</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>

		                <div class="col-lg-3 col-md-6">
		                    <div class="panel panel-green">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-calendar fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><span id="eventsTotalCount">{{count($all_events)}}</span></div>
		                                    <div>Greenlist/Events</div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="{{url('/')}}/admin/events">
		                            <div class="panel-footer">
		                                <span class="pull-left">Manage Greenlist/Events</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>

		                <div class="col-lg-3 col-md-6">
		                    <div class="panel panel-primary">
		                        <div class="panel-heading">
		                            <div class="row">
		                                <div class="col-xs-3">
		                                    <i class="fa fa-users fa-5x"></i>
		                                </div>
		                                <div class="col-xs-9 text-right">
		                                    <div class="huge"><span id="unexpectedGuestsTotalCount">{{$unexpected_visitors_count}}</span></div>
		                                    <div>Unexpected Visitors</div>
		                                </div>
		                            </div>
		                        </div>
		                        <a href="{{url('/')}}/admin/visitors">
		                            <div class="panel-footer">
		                                <span class="pull-left">Manage Visitors</span>
		                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
		                                <div class="clearfix"></div>
		                            </div>
		                        </a>
		                    </div>
		                </div>

		            </div>

                    <div class="row">
                		<div class="col-lg-12">
		                 	<div class="panel panel-default">
		                        <div class="panel-heading">
		                        	<div class="btn-group" data-toggle="buttons">
									  <label class="btn btn-danger active" id="alertsRd">
									    <input type="radio" name="options" id="optionAlerts" autocomplete="off" checked><i class="fa fa-bell"></i> Alerts
									  </label>
									  <label class="btn btn-success" id="eventsRd">
									    <input type="radio" name="options" id="optionEvents" autocomplete="off"><i class="fa fa-calendar"></i> Events
									  </label>
									</div>
									<!-- <i class="fa fa-bell"></i> Alerts -->
		                        </div>
		                        <div class="panel-body mapAlerts">
		                        	<div class="map" id="mapAlerts" style="height:400px;"></div>
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="residentials">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Alerts</th>
		                                            <th>Count</th>
		                                            <th>Icon</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        <tr class="odd gradeX">
		                                        	<td>Emergency</td>
		                                            <td><span id="emergencyCount">Loading...</span></td>
		                                            <td><img src="{{asset('assets/images')}}/m6.png" width="20"/></td>
		                                        </tr>
		                                        <tr class="odd gradeX">
		                                        	<td>Caution</td>
		                                            <td><span id="cautionCount">Loading...</span></td>
		                                            <td><img src="{{asset('assets/images')}}/m2.png" width="20"/></td>
		                                        </tr>
		                                        <tr class="odd gradeX">
		                                        	<td>Issues</td>
		                                            <td><span id="issuesCount">Loading...</span></td>
		                                            <td><img src="{{asset('assets/images')}}/m1.png" width="20"/></td>
		                                        </tr>
		                                        <tr class="odd gradeX">
		                                        	<td>Unidentified</td>
		                                            <td><span id="unidentifiedAlertsCount">Loading...</span></td>
		                                            <td><img src="{{asset('assets/images')}}/m7.png" width="20"/></td>
		                                        </tr>
		                         			</tbody>
		                               	</table>
		                          	</div>
		                        </div>
		                        <div class="panel-body mapEvents">
		                          	<div class="map" id="map" style="height:400px;"></div>
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="residentials">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Greenlist/Events</th>
		                                            <th>Count</th>
		                                            <th>Icon</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody id="eventList">

		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
                		</div>

                		<div class="col-lg-12">

		                    <div class="panel panel-success">
		                        <div class="panel-heading">
		                            Latest Events
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="residentials">
		                                    <thead>
		                                    	<tr>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                            <th>Event Name</th>
		                                            <th>Start Date</th>
		                                            <th>End Date</th>

		                                        </tr>
		                                    </thead>
		                                    <tbody>

		                                    @foreach($events as $k => $v)
		                                        <tr class="odd gradeX">
		                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
		                                            <td>{{$v->address}}</td>
		                                            <td>{{$v->name}}</td>
		                                            <td class="center">{{ date('M j, Y', strtotime($v->start))}}</td>
		                                            <td class="center">{{ date('M j, Y', strtotime($v->end))}}</td>
		                                        </tr>
		                                    @endforeach
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
		            	</div>

                		<div class="col-lg-12">
		                 	<div class="panel panel-success">
		                        <div class="panel-heading">
		                            Latest Event Visitors
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="security">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Start Date</th>
		                                    		<th>Visitor Name</th>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                            <th>Arrived</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    @if(count($event_visitors) != 0)
			                                    @foreach($event_visitors as $k => $v)
			                                        <tr class="odd gradeX">
			                                        	<td>{{ date('M j, Y', strtotime($v->start))}}</td>
			                                        	<td>{{$v->guest_name}}</td>
			                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
			                                            <td>{{$v->address}}</td>
			                                            <td>
			                                            	@if($v->status == 1)
			                                            		<span class="label label-success">Yes</span>
			                                            	@else
			                                            		<span class="label label-danger">No</span>
			                                            	@endif
			                                            </td>
			                                        </tr>
			                                    @endforeach
		                                    @else
		                                    	<tr class="odd gradeX">
		                                            <td colspan="3">No record found</td>
		                                        </tr>
		                                    @endif
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
                		</div>

                		<div class="col-lg-12">
		                 	<div class="panel panel-primary">
		                        <div class="panel-heading">
		                            Latest Unexpected Visitors
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="security">
		                                    <thead>
		                                    	<tr>
		                                    		<th>Visitor Name</th>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    @if(count($unexpected_visitors) != 0)
			                                    @foreach($unexpected_visitors as $k => $v)
			                                        <tr class="odd gradeX">
			                                            <td>{{$v->name}}</td>
			                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
			                                            <td>{{$v->address}}</td>
			                                        </tr>
			                                    @endforeach
		                                    @else
		                                    	<tr class="odd gradeX">
		                                            <td colspan="3">No record found</td>
		                                        </tr>
		                                    @endif
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
                		</div>

                		<div class="col-lg-12">
		                 	<div class="panel panel-danger">
		                        <div class="panel-heading">
		                            Latest Emergency
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="security">
		                                    <thead>
		                                    	<tr>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                            <th>Description</th>
		                                            <th>Status</th>
		                                            <th>Date & Time</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    @if(count($emergency) != 0)
			                                    @foreach($emergency as $k => $v)
			                                        <tr class="odd gradeX">
			                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
			                                            <td>{{$v->address}}</td>
			                                            <td>{{$v->description}}</td>
			                                            <td>
			                                            	@if($v->status == 1)
			                                            		<span class="label label-success">Resolved</span>
			                                            	@else
			                                            		<span class="label label-danger">In-progress</span>
			                                            	@endif
			                                            </td>
			                                            <td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
			                                        </tr>
			                                    @endforeach
		                                    @else
		                                    	<tr class="odd gradeX">
		                                            <td colspan="3">No record found</td>
		                                        </tr>
		                                    @endif
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
                		</div>

                		<div class="col-lg-12">
		                 	<div class="panel panel-warning">
		                        <div class="panel-heading">
		                            Latest Caution
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="security">
		                                    <thead>
		                                    	<tr>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                            <th>Description</th>
		                                            <th>Status</th>
		                                            <th>Date & Time</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    @if(count($caution) != 0)
			                                    @foreach($caution as $k => $v)
			                                        <tr class="odd gradeX">
			                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
			                                            <td>{{$v->address}}</td>
			                                            <td>{{$v->description}}</td>
			                                            <td>
			                                            	@if($v->status == 1)
			                                            		<span class="label label-success">Resolved</span>
			                                            	@else
			                                            		<span class="label label-danger">In-progress</span>
			                                            	@endif
			                                            </td>
			                                            <td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
			                                        </tr>
			                                    @endforeach
		                                    @else
		                                    	<tr class="odd gradeX">
		                                            <td colspan="3">No record found</td>
		                                        </tr>
		                                    @endif
		                         			</tbody>
		                               	</table>
		                          	</div>
		                      	</div>
		                 	</div>
                		</div>

                		<div class="col-lg-12">
		                 	<div class="panel panel-info">
		                        <div class="panel-heading">
		                            Latest Issues
		                        </div>
		                        <!-- /.panel-heading -->
		                        <div class="panel-body">
		                            <div class="dataTable_wrapper">
		                                <table class="table table-striped table-bordered table-hover" id="security">
		                                    <thead>
		                                    	<tr>
		                                            <th>Home Owner Name</th>
		                                            <th>Home Owner Address</th>
		                                            <th>Message</th>
		                                            <th>Type</th>
		                                            <th>Status</th>
		                                            <th>Date & Time</th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                    @if(count($issue) != 0)
			                                    @foreach($issue as $k => $v)
			                                        <tr class="odd gradeX">
			                                            <td>{{$v->first_name}} {{$v->last_name}}</td>
			                                            <td>{{$v->address}}</td>
			                                            <td>{{$v->message}}</td>
			                                            <td>
			                                            	@if($v->issue_type == 1)
			                                            		Suggestion
			                                            	@elseif($v->issue_type == 2)
			                                            		Complaint
			                                            	@else
			                                            		Issue
			                                            	@endif
			                                            </td>
			                                            <td>
			                                            	@if($v->resolved == 1)
			                                            		<span class="label label-success">Resolved</span>
			                                            	@else
			                                            		<span class="label label-danger">In-progress</span>
			                                            	@endif
			                                            </td>
			                                            <td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
			                                        </tr>
			                                    @endforeach
		                                    @else
		                                    	<tr class="odd gradeX">
		                                            <td colspan="3">No record found</td>
		                                        </tr>
		                                    @endif
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

@include('admin_includes/footer')
@include('admin_includes/dashboard')

<?php
function getCoordinates($address)
{

    $address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern
    $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address";
    $response = file_get_contents($url);
    $json = json_decode($response, true); //generate array object from the response from the web

    $r = array('lat' => $json['results'][0]['geometry']['location']['lat'], 'lng' => $json['results'][0]['geometry']['location']['lng']);
    return $r;

}
?>
</html>
