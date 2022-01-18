@extends('customer.layouts.master')
@section('title', __('content.Sign in'))
@section('content')
    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h2 class="title">@lang('content.Sign in')</h2>
                        <div class="pull-right">
                            <div class="product-slick-dots-2 custom-dots">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    @include('common.errors.validate')
                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                    <form action="{{ route('user.sign_in') }}" method="post">
                        {{ csrf_field() }}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="input" type="email" name="email" value="{{ old('email') }}"
                                       placeholder="@lang('content.Enter your email')">
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('content.Password')</label>
                                <input class="input" type="password" name="password" placeholder="@lang('content.Enter your password')">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="col-md-6" style="padding-left: 0px">
                                    <label for="remember_me" style="vertical-align: middle;">@lang('content.Remember me')</label>
                                    <input type="checkbox" class="input-checkbox" name="remember_me" checked id="remember_me"> <a href="/user/reset-password" style="float: right;">Şifrəmi unutdum</a><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="primary-btn">@lang('content.Sign in')</button>
                                <a href="{{ route('user.sign_up') }}" class="main-btn">@lang('content.Sign up')</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
