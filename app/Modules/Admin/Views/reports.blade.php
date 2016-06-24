@include('admin_includes/header')
<style>

    .visitors_photo{
        height:100px;
        width:100px;
        background-size: cover;
        background-position:center center;
    }
</style>
<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
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
                        <h1 class="page-header"><i class="fa fa-file-excel-o fa-fw"></i> Reports</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Generate Reports
                                </div>
                                <div class="panel-body">
                                    <div class="alert alert-danger" id="report_warning" role="alert">All fields are required.</div>
                                    <!-- <form role="form" id="loginForm" method="post" action="/admin/reports/generate"> -->
                                    {!! Form::open(array('action' => "BrngyWiFi\Modules\Admin\Controllers\ReportsController@generateReport")) !!}
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label>Start Date:</label>
                                                <div class='input-group date' id='datetimePickerStartDate'>
                                                    <input type='text' class="form-control" name="start_date" placeholder="Start Date" id="report_start_date"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <label>End Date:</label>
                                                <div class='input-group date' id='datetimePickerEndDate'>
                                                    <input type='text' class="form-control" name="end_date" placeholder="End Date" id="report_end_date"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success btn-block" name="generateReport" id="generateReport">Generate Report</button>
                                    {!! Form::close()!!}
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

</html>
<script type="text/javascript">
    $('#report_warning').hide();
    $(function () {
        $('#datetimePickerStartDate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
        $('#datetimePickerEndDate').datetimepicker({
            useCurrent: false, //Important! See issue #1075
            format: 'YYYY-MM-DD'
        });
        $("#datetimePickerStartDate").on("dp.change", function (e) {
            $('#datetimePickerEndDate').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimePickerEndDate").on("dp.change", function (e) {
            $('#datetimePickerStartDate').data("DateTimePicker").maxDate(e.date);
        });
    });

    $('#generateReport').on('click', function(e){
        var report_start_date = $('#report_start_date').val();
        var report_end_date = $('#report_end_date').val();

        if(report_start_date == '' || report_end_date == '')
        {
            e.preventDefault();
            $('#report_warning').fadeIn();
        }
    });
</script>
