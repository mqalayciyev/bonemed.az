<!DOCTYPE html>
<html lang="{{config('app.locale')}}">

<head>
    @include('manage.layouts.partials.head')
    @yield('head')
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    @include('manage.layouts.partials.header')
    @include('manage.layouts.partials.sidebar')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('manage.layouts.partials.footer')
    @include('manage.layouts.partials.control_sidebar')
</div>
@include('manage.layouts.partials.script')
@yield('footer')
</body>
</html>