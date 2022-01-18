<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('manage/dist/img/default-50x50.gif') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ auth('manage')->user()->first_name.' '. auth('manage')->user()->last_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> @lang('admin.Online')</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="@lang('admin.Search')...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">@lang('admin.MAIN NAVIGATION')</li>
            <li class="{{ url()->current() == route('manage.homepage') ? 'active' : '' }}">
                <a href="{{ route('manage.homepage') }}">
                    <i class="fa fa-dashboard"></i> <span>@lang('admin.Dashboard')</span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.category') ? 'active' : '' }}">
                <a href="{{ route('manage.category') }}">
                    <i class="fa fa-files-o"></i>
                    <span>@lang('admin.Categories')</span>
                    <span class="pull-right-container">
              <small class="label bg-gray pull-right">{{ @$statistics['total_category'] ? $statistics['total_category'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.sell') ? 'active' : '' }}">
                <a href="{{ route('manage.sell') }}">
                    <i class="fa fa-shopping-bag"></i> <span>@lang('admin.Sell')</span>
                    <span class="pull-right-container">
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.product') ? 'active' : '' }}">
                <a href="{{ route('manage.product') }}">
                    <i class="fa fa-th"></i> <span>@lang('admin.Products')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ $statistics['total_product'] ? $statistics['total_product'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.supplier') ? 'active' : '' }}">
                <a href="{{ route('manage.supplier') }}">
                    <i class="fa fa-male"></i> <span>@lang('admin.Suppliers')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_supplier'] ? $statistics['total_supplier'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.brand') ? 'active' : '' }}">
                <a href="{{ route('manage.brand') }}">
                    <i class="fa fa-briefcase"></i> <span>@lang('admin.Brands')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_brand'] ? $statistics['total_brand'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.tag') ? 'active' : '' }}">
                <a href="{{ route('manage.tag') }}">
                    <i class="fa fa-tags"></i> <span>@lang('admin.Tags')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_tag'] ? $statistics['total_tag'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.user') ? 'active' : '' }}">
                <a href="{{ route('manage.user') }}">
                    <i class="fa fa-users"></i> <span>@lang('admin.Users')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_user'] ? $statistics['total_user'] : 0 }}</small>
            </span>
                </a>
            </li>
            @if (@$manage == 1)
            <!-- Big Admin -->
            <li class="{{ url()->current() == route('manage.admin') ? 'active' : '' }}">
                <a href="{{ route('manage.admin') }}">
                    <i class="fa fa-user-md"></i> <span>@lang('admin.Admins')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_admin'] ? $statistics['total_admin'] : 0 }}</small>
            </span>
                </a>
            </li>
            @elseif(@$manage == 2)
            <!-- Demo Admin -->
            @elseif(@$manage == 3) 
            <!-- User Admin -->
            @endif
            
            <li class="{{ url()->current() == route('manage.order') ? 'active' : '' }}">
                <a href="{{ route('manage.order') }}">
                    <i class="fa fa-shopping-cart"></i> <span>@lang('admin.Orders')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_order'] ? $statistics['total_order'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.customer') ? 'active' : '' }}">
                <a href="{{ route('manage.customer') }}">
                    <i class="fa fa-users"></i> <span>@lang('admin.Customers')</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-gray">{{ @$statistics['total_customer'] ? $statistics['total_customer'] : 0 }}</small>
            </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.slider') ? 'active' : '' }}">
                <a href="{{ route('manage.slider') }}">
                    <i class="fa fa-slideshare"></i> <span>@lang('admin.Sliders')</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-gray">{{ @$statistics['total_slider'] ? $statistics['total_slider'] : 0 }}</small>
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.banner') ? 'active' : '' }}">
                <a href="{{ route('manage.banner') }}">
                    <i class="fa fa-picture-o"></i></i> <span>@lang('admin.Banners')</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-gray">{{ @$statistics['total_banner'] ? $statistics['total_banner'] : 0 }}</small>
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.review') ? 'active' : '' }}">
                <a href="{{ route('manage.review') }}">
                    <i class="fa fa-comments"></i> <span>Rəylər</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-gray">{{ @$statistics['total_reviews'] ? $statistics['total_reviews'] : 0 }}</small>
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.envelope') ? 'active' : '' }}">
                <a href="{{ route('manage.envelope') }}">
                    <i class="fa fa-envelope"></i> <span>Mesajlar</span>
                    <span class="pull-right-container">
                        <small class="label pull-right bg-gray">{{ @$statistics['total_messages'] ? $statistics['total_messages'] : 0 }}</small>
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.info') ? 'active' : '' }}">
                <a href="{{ route('manage.info') }}">
                    <i class="fa fa-info-circle"></i> <span>Veb Sayt Info</span>
                    <span class="pull-right-container">
                        {{-- <small class="label pull-right bg-gray">{{ @$statistics['total_reviews'] ? $statistics['total_reviews'] : 0 }}</small> --}}
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.about') ? 'active' : '' }}">
                <a href="{{ route('manage.about') }}">
                    <i class="fa fa-globe"></i> <span>Haqqımızda</span>
                    <span class="pull-right-container">
                        {{-- <small class="label pull-right bg-gray">{{ @$statistics['total_reviews'] ? $statistics['total_reviews'] : 0 }}</small> --}}
                    </span>
                </a>
            </li>
            <li class="{{ url()->current() == route('manage.shipping_return') ? 'active' : '' }}">
                <a href="{{ route('manage.shipping_return') }}">
                    <i class="fa fa-truck"></i> <span>Göndərmə və Qaytarma</span>
                    <span class="pull-right-container">
                        {{-- <small class="label pull-right bg-gray">{{ @$statistics['total_reviews'] ? $statistics['total_reviews'] : 0 }}</small> --}}
                    </span>
                </a>
            </li>
            <li class="header">@lang('admin.ORDERS')</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> @lang('admin.Pending') <span
                            class="pull-right-container"> <small
                                class="label pull-right bg-red">{{ @$statistics['total_order_pending'] ? $statistics['total_order_pending'] : 0 }}</small></span></a>
            </li>
            <li><a href="#"><i class="fa fa-circle-o text-fuchsia"></i> @lang('admin.Payment approved') <span
                            class="pull-right-container"> <small
                                class="label pull-right bg-fuchsia">{{ @$statistics['total_payment_approved'] ? $statistics['total_payment_approved'] : 0 }}</small></span></a>
            </li>
            <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> @lang('admin.Cargoed') <span
                            class="pull-right-container"> <small
                                class="label pull-right bg-yellow">{{ @$statistics['total_order_cargoed'] ? $statistics['total_order_cargoed'] : 0 }}</small></span></a>
            </li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> @lang('admin.Received') <span
                            class="pull-right-container"> <small
                                class="label pull-right bg-blue">{{ @$statistics['total_order_yohbr'] ? $statistics['total_order_yohbr'] : 0 }}</small></span></a>
            </li>
            <li><a href="#"><i class="fa fa-circle-o text-green"></i> @lang('admin.Order completed') <span
                            class="pull-right-container"> <small
                                class="label pull-right bg-green">{{ @$statistics['total_order_completed'] ? $statistics['total_order_completed'] : 0 }}</small></span></a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>