<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('admin.Control Panel')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('manage/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('manage/dist/css/AdminLTE.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        {{-- <b>@lang('admin.Control Panel')</b> --}}
        <b>Admin Girişi</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">@lang('admin.Sign in to start your session')</p>
        @include('common.errors.validate')
        <form action="{{ route('manage.login') }}" method="post" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" name="password" id="password" class="form-control" placeholder="@lang('admin.Password')" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            {{-- <div class="form-group has-feedback">
                <select name="type" class="form-control">
                    <option value="1">Admin</option>
                    <option value="2">İstifadəçi</option>
                </select>
            </div> --}}
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox">
                        <label><input type="checkbox" name="rememberme" value="1"> @lang('admin.Remember Me')</label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">@lang('admin.Sign In')</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
</body>
</html>