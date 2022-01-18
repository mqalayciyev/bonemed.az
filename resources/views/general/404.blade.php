<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@lang('content.NotFound.Title')</title>
    <style> html, body {
            background-color: #fff;
            color: #636b6f;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 36px;
            padding: 20px;
        }

        .content > a {
            text-decoration: none;
            padding: 10px 25px;
            background: #e4007a;
            font-size: 20px;
            font-weight: bold;
            color: #fff;
            border-radius: 5px;
            text-transform: uppercase;
            font-family: Arial;
        }</style>
</head>
<body>
<div class="flex-center position-ref full-height">
    <div class="content">
        <img src="{{ asset('storage/images/logo.png') }}" alt="Felicita Baby" title="Felicita Baby">
        <div class="title">@lang('content.NotFound.Title')</div>
        <a href="{{route('home')}}">@lang('content.NotFound.Button')</a>
    </div>
</div>
</body>
</html>
