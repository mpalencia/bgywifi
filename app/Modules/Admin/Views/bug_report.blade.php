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
                        <h1 class="page-header"><i class="fa fa-bug fa-fw"></i> Bug Report</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading" style="height:55px;">
                                   Report Bug

                                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="#bugReport">
                                        <i class="fa fa-plus"></i> Add Bug Report
                                    </button>
                                </div>
                                <div class="panel-body">
                                    <div class="dataTable_wrapper">
                                        <table class="table table-striped table-bordered table-hover" id="bugs">
                                            <thead>
                                                <tr>
                                                    <th>Bug</th>
                                                    <th>Status</th>
                                                    <th>Date Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bugs as $b => $v)

                                                <tr data-toggle="collapse" data-target="#row_{{$v->id}}" class="odd gradeX accordion-toggle" >
                                                    <td>{{$v->bug}}</td>
                                                    @if($v->status == 1)
                                                        <td><span class="label label-success">Fixed</span></td>
                                                    @else
                                                        <td><span class="label label-danger">On-Going</span></td>
                                                    @endif
                                                    <td>{{date_format(date_create($v->created_at),"M d, Y h:i A")}}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-circle view-bug-report" title="View" data-toggle="modal" data-target="#viewBugReport"
                                                            data-bugs="{{$v->bug}}"
                                                            data-status="{{$v->status}}">
                                                        <i class="glyphicon glyphicon-eye-open"></i>
                                                        </button>
                                                        @if($v->status == 0)
                                                        <button type="button" class="btn btn-info btn-circle edit-bug-report" title="View" data-toggle="modal" data-target="#editBugReport"
                                                            data-bug-id="{{$v->id}}"
                                                            data-bugs="{{$v->bug}}"
                                                            data-status="{{$v->status}}">
                                                        <i class="glyphicon glyphicon-pencil"></i>
                                                        </button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <footer class="text-right">Please let us know if you see an error or bug in this system by sending us a bug report.</footer>
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

@include('admin_includes/modals/bug_report')
@include('admin_includes/footer')

</html>
<script type="text/javascript">
$('.editBugReportAlert').hide();
$('.addBugReportAlert').hide();
    $('.view-bug-report').on('click', function(){console.log('test');
        $('#view_bug').html($(this).attr('data-bugs'));
    });

    $('.edit-bug-report').on('click', function(){console.log('test');
        $('.bug_id').val($(this).attr('data-bug-id'));
        $('.edit-text-bug').val($(this).attr('data-bugs'));
    });

    $('.sendBugReportAdd').on('click', function(){

        if($('.add-text-bug').val() == ''){
            $('.addBugReportAlert').show();
            return false;
        }

        $.ajax({
            url: 'bug-report',
            method: 'POST',
            data: {
                bug: $('.add-text-bug').val()
            },
            success: function(data)
            {
                $('#bugReport').modal('hide');
                brgy.showBlockUI('Saving, please wait...');
                if(data.msgCode == 1){

                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }
        })
    });

    $('.sendBugReportEdit').on('click', function(){

        if($('.edit-text-bug').val() == ''){
            $('.editBugReportAlert').show();
            return false;
        }

        $.ajax({
            url: 'bug-report/updateBugReport/'+$('#bug_id').val(),
            method: 'PUT',
            data: {
                id:$('#bug_id').val(),
                bug: $('.edit-text-bug').val()
            },
            success: function(data)
            {
                $('#editBugReport').modal('hide');
                brgy.showBlockUI('Updating, please wait...');
                if(data.msgCode == 1){

                    brgy.showAlertify('Success', data.msg);
                }else{
                    brgy.showAlertifyNoRefresh('Error', '<span class="red-bold">'+data.msg+'</span>');
                }
                $.unblockUI();
            }
        })
    });
</script>
