@extends('customer.layouts.master')
@section('content')
    <div class="section">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-12">
                    <h1>@lang('content.Error 404')</h1>
                    <h2>@lang('content.Sorry, the page you are looking for could not be found!')</h2>
                    <a href="{{ route('homepage') }}" class="primary-btn">@lang('content.Go to Homepage')</a>
                </div>
            </div>
        </div>
    </div>
@endsection