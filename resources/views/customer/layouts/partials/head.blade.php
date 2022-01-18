<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

<!-- Google font -->
<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

<!-- Bootstrap -->
<link type="text/css" rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"/>

<!-- Slick -->
<link type="text/css" rel="stylesheet" href="{{ asset('css/slick.css') }}"/>
<link type="text/css" rel="stylesheet" href="{{ asset('css/slick-theme.css') }}"/>
<link rel="icon" href="{{ asset('img/' . $website_info->logo) }}" type="image/png">
<!-- nouislider -->
<link type="text/css" rel="stylesheet" href="{{ asset('css/nouislider.min.css') }}"/>

<!-- Font Awesome Icon -->
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<!-- Custom stlylesheet -->
<link type="text/css" rel="stylesheet" href="{{ asset('css/style.css') }}"/>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<meta name="csrf-token" content="{{ csrf_token() }}">