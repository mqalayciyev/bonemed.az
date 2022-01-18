@extends('customer.layouts.master')
@section('title', __('footer.Shipping & Return'))
@section('content') <!-- BREADCRUMB -->
<div id="breadcrumb">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="/">@lang('content.Home')</a></li>
            <li class="active">@lang('footer.Shipping & Return')</li>
        </ul>
    </div>
</div> <!-- /BREADCRUMB -->
<div class="section">
    <div class="container">
        <div class="col-md-12">
            {!! old('shippingreturn', $shippingreturn->shipping_return) !!}
        </div>
    </div>
</div>
@endsection