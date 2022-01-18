@extends('customer.layouts.master')
@section('title', __('footer.My Account'))
@section('content') <!-- BREADCRUMB -->
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">@lang('content.Home')</a></li>
            <li class="active">@lang('footer.My Account')</li>
        </ul>
    </div>
</div> <!-- /BREADCRUMB -->
<div class="section">
    <div class="container">
        <div class="myAccountPage myAccountStyle">
            <div class="section-title"><h3 class="title">Mənim Hesabım</h3></div>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 MyAccountMenu">

                    <div class="panel-group accountMenu" id="accordion-2" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-2" href="#collapseOne-2" aria-expanded="true"
                               aria-controls="collapseOne-2">
                               İstifadəçi Məlumatları
                                <i class="fa fa-angle-up" aria-hidden="true"></i>
                            </a>
                            <div id="collapseOne-2" class="panel-collapse collapse
                                    {{
                                        request()->is('orders') ||
                                        request()->is('*/orders/*') ||
                                        request()->is('membership') ||
                                        request()->is('account')
                                        ?
                                        'in' :
                                        ''
                                     }}
                                " role="tabpanel" aria-labelledby="headingOne">
                                <ul class="accountSubMenu">
                                    <li class="{{ request()->is('account') ? 'active' : '' }}">
                                        <a href="{{ route('user.my_account') }}">
                                            Hesabım
                                        </a>
                                    </li>
                                    <li class="{{ request()->is('orders') || request()->is('*/orders/*') ? 'active' : '' }}"><a
                                            href="{{ route('orders') }}">
                                            Siparişlerim
                                        </a></li>
                                    <li class="{{ request()->is('membership') ? 'active' : '' }}"><a
                                            href="{{ route('user.membership') }}">
                                            Üzvlük Məlumatlarım
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-12">
                    @yield('content.account')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
    @yield('script')
@endsection