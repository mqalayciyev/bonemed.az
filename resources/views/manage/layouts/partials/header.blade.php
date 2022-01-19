<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('manage.homepage') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">@lang('admin.CP')</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">@lang('admin.Control Panel')</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('manager/dist/img/default-50x50.gif') }}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ auth('manage')->user()->first_name.' '. auth('manage')->user()->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ asset('manager/dist/img/default-50x50.gif') }}" class="img-circle" alt="User Image">

                            <p>
                                {{ auth('manage')->user()->first_name.' '. auth('manage')->user()->last_name }}
                                <small>@lang('admin.Member since') {{ auth('manage')->user()->created_at->format('M, Y') }} </small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="" class="btn btn-default btn-flat">@lang('admin.Profile')</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ route('manage.logout') }}" class="btn btn-default btn-flat">@lang('admin.Sign out')</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('homepage') }}" target="_blank"><i class="fa fa-eye"></i> @lang('admin.Go To Website')</a></li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>