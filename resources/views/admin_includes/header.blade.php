<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ayala WestGrove Heights - Administration</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/sbadmin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css">


    <!-- MetisMenu CSS -->
    <link href="{{asset('assets/sbadmin/bower_components/metisMenu/dist/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{asset('assets/sbadmin/dist/css/sb-admin-2.css')}}" rel="stylesheet">

	<!-- DataTables CSS -->
    <link href="{{asset('assets/sbadmin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/sbadmin/bower_components/datatables-responsive/css/dataTables.responsive.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{asset('assets/sbadmin/bower_components/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

	<!-- Alertify -->
	<link rel="stylesheet" href="{{asset('assets/js/alertify/css/alertify.min.css')}}" />
	<link rel="stylesheet" href="//cdn.jsdelivr.net/alertifyjs/1.4.1/css/themes/default.min.css"/>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- OneSignal -->
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
    <script>
    var OneSignal = OneSignal || [];
    OneSignal.push([
        "init", {
            appId: "71f1f939-b1a5-44e7-bac8-872f9ab48d0c",
            autoRegister: true,
            subdomainName: 'https://brgywifi.onesignal.com',
            notifyButton: {
                enable: true, // Required to use the notify button
                prenotify: true, // Show an icon with 1 unread message for first-time site visitors
                showCredit: true, // Hide the OneSignal logo
                modalPrompt: true
            },
            webhooks: {
                cors: false
          }
        }

    ]);
  </script>

</head>
