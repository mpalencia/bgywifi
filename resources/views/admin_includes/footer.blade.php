<a href="#" id="subscribe-link"></a>
<script>

    function subscribe() {
        OneSignal.push(["registerForPushNotifications"]);
    }
    OneSignal.push(["setDefaultNotificationUrl", "http://bgywifi-uat.devhub.ph/public/admin/alerts"]);
    OneSignal.push(["deleteTag", "key"]);


</script>

<!-- jQuery -->
<script src="{{asset('assets/sbadmin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3"></script>
<script type="text/javascript" src="{{asset('assets/js/gmaps/markerclusterer.js')}}"></script>
<!-- <script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script> -->
<!-- Bootstrap Core JavaScript -->
<script src="{{asset('assets/sbadmin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{asset('assets/sbadmin/bower_components/metisMenu/dist/metisMenu.min.js')}}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{asset('assets/sbadmin/dist/js/sb-admin-2.js')}}"></script>

<script src="{{asset('assets/js/gmaps/gmaps.js')}}"></script>
<script src="{{asset('assets/js/blockui/jquery.blockUI.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/alertify/alertify.min.js')}}"></script>
<script src="{{asset('assets/js/brgy-admin.js')}}"></script>

<!-- DataTables JavaScript -->
<script src="{{asset('assets/sbadmin/bower_components/datatables/media/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/sbadmin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js')}}"></script>
