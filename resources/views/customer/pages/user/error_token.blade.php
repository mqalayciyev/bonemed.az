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
                    <div class="section">
                        <div class="container text-center">
                            <div class="row">
                                <div class="col-md-12">
                                    <h1>@lang('content.Error 404')</h1>
                                    <h2>@lang('content.Sorry, the page you are looking for could not be found!')</h2>
                                    <a href="{{ route('user.sign_in') }}" class="primary-btn">Giriş Səhifəsinə Get</a>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    
@endsection

