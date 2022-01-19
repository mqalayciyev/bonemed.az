<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>@yield('title', __('admin.Control Panel'))</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="icon" href="{{ asset('img/' . $website_info->logo) }}" type="image/png">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/font-awesome/css/font-awesome.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/Ionicons/css/ionicons.min.css') }}">

<link rel="stylesheet" href="{{ asset('manager/dist/css/skins/_all-skins.min.css') }}">
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/morris.js/morris.css') }}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/jvectormap/jquery-jvectormap.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
<!-- bootstrap datepicker -->
<link rel="stylesheet"
      href="{{ asset('manager/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('manager/plugins/iCheck/all.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet"
      href="{{ asset('manager/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{ asset('manager/plugins/timepicker/bootstrap-timepicker.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('manager/bower_components/select2/dist/css/select2.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('manager/dist/css/AdminLTE.min.css') }}">
<link rel="stylesheet" href="{{ asset('manager/dist/css/imageuploadify.min.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('manage/dist/css/croppie.css') }}">
<link rel="stylesheet" href="{{ asset('manage/dist/js/croppie.min.js') }}"> --}}
<link rel="stylesheet" href="{{ asset('manager/dist/css/croppie.css') }}" />
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!-- Google Font -->

<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

<style>
    *, a, h1, h2, h3, h4, h5, h6, body, button {
        font-family: 'Roboto', sans-serif;
    }

    .jumbotron {
        background: #fff;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}">