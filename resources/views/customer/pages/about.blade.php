@extends('customer.layouts.master')
@section('title', __('footer.About Us'))
@section('content') <!-- BREADCRUMB -->
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">@lang('content.Home')</a></li>
            <li class="active">@lang('footer.About Us')</li>
        </ul>
    </div>
</div> <!-- /BREADCRUMB -->
<div class="section">
    <div class="container">
        <div class="col-md-12">
            {!! old('about', $about->about) !!}
        </div>
    </div>
</div>
@endsection